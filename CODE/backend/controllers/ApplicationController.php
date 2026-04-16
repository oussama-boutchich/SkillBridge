<?php
/**
 * SkillBridge — ApplicationController
 */
declare(strict_types=1);

class ApplicationController
{
    private ApplicationModel  $model;
    private PostModel         $postModel;
    private NotificationModel $notifModel;
    private FeedModel         $feedModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/ApplicationModel.php';
        require_once __DIR__ . '/../models/PostModel.php';
        require_once __DIR__ . '/../models/NotificationModel.php';
        require_once __DIR__ . '/../models/FeedModel.php';
        $this->model      = new ApplicationModel();
        $this->postModel  = new PostModel();
        $this->notifModel = new NotificationModel();
        $this->feedModel  = new FeedModel();
    }

    /** POST /api/applications */
    public function store(): void
    {
        $input     = json_decode(file_get_contents('php://input') ?: '{}', true) ?? [];
        $studentId = (int) $_SESSION['user_id'];

        $v = new Validator();
        $v->required('post_id', $input['post_id'] ?? '');
        if (!$v->passes()) Response::error($v->getErrors(), 400);

        $postId = (int) $input['post_id'];
        $post   = $this->postModel->getById($postId);
        if (!$post)                           Response::error('Post not found.', 404);
        if ($post['status'] !== 'active')     Response::error('This post is no longer accepting applications.', 400);
        if ($this->model->exists($studentId, $postId)) Response::error('You have already applied to this post.', 409);

        $id = $this->model->create($studentId, $postId, $input['cover_letter'] ?? null);

        // Notify company
        $this->notifModel->create(
            (int) $post['company_id'],
            'New Application Received',
            "{$_SESSION['full_name']} has applied to your post: {$post['title']}.",
            AppConstants::NOTIF_NEW_APP,
            $id
        );

        // Feed
        $this->feedModel->create(
            $studentId,
            AppConstants::FEED_APP_SUBMITTED,
            "{$_SESSION['full_name']} applied to {$post['title']} at {$post['company_name']}",
            $id
        );

        Response::success(['id' => $id, 'message' => 'Application submitted.'], 201);
    }

    /** GET /api/applications/my */
    public function myApps(): void
    {
        Response::success($this->model->getByStudent((int) $_SESSION['user_id']));
    }

    /** GET /api/applications/post/{post_id} */
    public function forPost(string $post_id): void
    {
        $post = $this->postModel->getById((int) $post_id);
        if (!$post) Response::error('Post not found.', 404);
        if ((int)$post['company_id'] !== (int)$_SESSION['user_id']) Response::error('Forbidden.', 403);
        Response::success($this->model->getByPost((int) $post_id));
    }

    /** PATCH /api/applications/{id}/status */
    public function updateStatus(string $id): void
    {
        $appId     = (int) $id;
        $companyId = (int) $_SESSION['user_id'];
        $input     = json_decode(file_get_contents('php://input') ?: '{}', true) ?? [];

        $v = new Validator();
        $v->required('status', $input['status'] ?? '')
          ->inList('status', $input['status'] ?? '', ['accepted', 'rejected']);
        if (!$v->passes()) Response::error($v->getErrors(), 400);

        $app  = $this->model->getById($appId);
        if (!$app) Response::error('Application not found.', 404);

        $post = $this->postModel->getById((int)$app['post_id']);
        if (!$post || (int)$post['company_id'] !== $companyId) Response::error('Forbidden.', 403);

        $this->model->updateStatus($appId, $input['status']);

        // Notify student
        $type  = $input['status'] === 'accepted'
            ? AppConstants::NOTIF_APP_ACCEPTED
            : AppConstants::NOTIF_APP_REJECTED;
        $msg   = $input['status'] === 'accepted'
            ? "Congratulations! Your application to {$post['title']} has been accepted."
            : "Your application to {$post['title']} was not selected this time.";

        $this->notifModel->create((int)$app['student_id'], 'Application Update', $msg, $type, $appId);

        Response::success(['message' => 'Application status updated.']);
    }
}

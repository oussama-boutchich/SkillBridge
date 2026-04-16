<?php
/**
 * SkillBridge — PostController
 */
declare(strict_types=1);

class PostController
{
    private PostModel  $model;
    private FeedModel  $feedModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/PostModel.php';
        require_once __DIR__ . '/../models/FeedModel.php';
        require_once __DIR__ . '/../models/CompanyProfileModel.php';
        $this->model     = new PostModel();
        $this->feedModel = new FeedModel();
    }

    /** GET /api/posts */
    public function index(): void
    {
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $filters = [];
        if (!empty($_GET['type']))   $filters['type']   = $_GET['type'];
        if (!empty($_GET['search'])) $filters['search'] = $_GET['search'];

        $total = $this->model->countAll($filters);
        $posts = $this->model->getAll($filters, $limit, $offset);
        Response::paginated($posts, $page, $total, $limit);
    }

    /** GET /api/posts/{id} */
    public function show(string $id): void
    {
        $studentId = $_SESSION['role'] === 'student' ? (int)$_SESSION['user_id'] : null;
        $post = $this->model->getById((int) $id, $studentId);
        if (!$post) Response::error('Post not found.', 404);
        Response::success($post);
    }

    /** GET /api/posts/my */
    public function myPosts(): void
    {
        $posts = $this->model->getByCompany((int) $_SESSION['user_id']);
        Response::success($posts);
    }

    /** POST /api/posts */
    public function store(): void
    {
        $input     = json_decode(file_get_contents('php://input') ?: '{}', true) ?? [];
        $companyId = (int) $_SESSION['user_id'];

        $v = new Validator();
        $v->required('title',       $input['title']       ?? '')
          ->required('description', $input['description'] ?? '')
          ->required('type',        $input['type']        ?? '')
          ->inList('type', $input['type'] ?? '', ['internship','job','challenge']);
        if (!empty($input['deadline'])) $v->futureDate('deadline', $input['deadline']);
        if (!$v->passes()) Response::error($v->getErrors(), 400);

        $id = $this->model->create($companyId, $input);

        // Feed
        $cpModel = new CompanyProfileModel();
        $cp      = $cpModel->getByUserId($companyId);
        $name    = $cp['company_name'] ?? $_SESSION['full_name'];
        $this->feedModel->create(
            $companyId,
            AppConstants::FEED_POST_CREATED,
            "$name published a new {$input['type']}: " . Sanitizer::string($input['title']),
            $id
        );

        Response::success(['id' => $id, 'message' => 'Post created.'], 201);
    }

    /** PUT /api/posts/{id} */
    public function update(string $id): void
    {
        $postId    = (int) $id;
        $companyId = (int) $_SESSION['user_id'];
        $input     = json_decode(file_get_contents('php://input') ?: '{}', true) ?? [];

        $post = $this->model->getById($postId);
        if (!$post) Response::error('Post not found.', 404);
        if ((int)$post['company_id'] !== $companyId) Response::error('Forbidden.', 403);

        $this->model->update($postId, $input);
        Response::success(['message' => 'Post updated.']);
    }

    /** DELETE /api/posts/{id} */
    public function destroy(string $id): void
    {
        $postId    = (int) $id;
        $companyId = (int) $_SESSION['user_id'];

        $post = $this->model->getById($postId);
        if (!$post) Response::error('Post not found.', 404);
        if ((int)$post['company_id'] !== $companyId) Response::error('Forbidden.', 403);

        $this->model->delete($postId);
        Response::success(['message' => 'Post deleted.']);
    }
}

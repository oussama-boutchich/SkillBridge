<?php
/**
 * SkillBridge — CertificateController
 */
declare(strict_types=1);

class CertificateController
{
    private CertificateModel $model;
    private FeedModel $feedModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/CertificateModel.php';
        require_once __DIR__ . '/../models/FeedModel.php';
        $this->model     = new CertificateModel();
        $this->feedModel = new FeedModel();
    }

    /** GET /api/certificates */
    public function index(): void
    {
        $userId = (int) $_SESSION['user_id'];
        Response::success($this->model->getByUserId($userId));
    }

    /** POST /api/certificates */
    public function store(): void
    {
        $input  = json_decode(file_get_contents('php://input') ?: '{}', true) ?? [];
        $userId = (int) $_SESSION['user_id'];

        $v = new Validator();
        $v->required('title',      $input['title']      ?? '')
          ->required('issuer',     $input['issuer']      ?? '')
          ->required('issue_date', $input['issue_date']  ?? '')
          ->date('issue_date', $input['issue_date'] ?? '');
        if (!empty($input['credential_url'])) $v->url('credential_url', $input['credential_url']);
        if (!$v->passes()) Response::error($v->getErrors(), 400);

        $id = $this->model->create($userId, [
            'title'          => Sanitizer::string($input['title']),
            'issuer'         => Sanitizer::string($input['issuer']),
            'issue_date'     => $input['issue_date'],
            'credential_url' => !empty($input['credential_url']) ? Sanitizer::url($input['credential_url']) : null,
            'description'    => !empty($input['description'])    ? Sanitizer::string($input['description']) : null,
        ]);

        // Log to feed
        $this->feedModel->create(
            $userId,
            AppConstants::FEED_CERT_ADDED,
            "{$_SESSION['full_name']} added a new certificate: " . Sanitizer::string($input['title']),
            $id
        );

        Response::success(['id' => $id, 'message' => 'Certificate added.'], 201);
    }

    /** DELETE /api/certificates/{id} */
    public function destroy(string $id): void
    {
        $certId = (int) $id;
        $userId = (int) $_SESSION['user_id'];

        $cert = $this->model->getById($certId);
        if (!$cert) Response::error('Certificate not found.', 404);
        if ((int)$cert['user_id'] !== $userId) Response::error('Forbidden.', 403);

        $this->model->delete($certId);
        Response::success(['message' => 'Certificate deleted.']);
    }
}

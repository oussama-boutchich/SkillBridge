<?php
/**
 * SkillBridge — FeedController
 */
declare(strict_types=1);

class FeedController
{
    private FeedModel $model;

    public function __construct()
    {
        require_once __DIR__ . '/../models/FeedModel.php';
        $this->model = new FeedModel();
    }

    /** GET /api/feed */
    public function index(): void
    {
        $userId = (int) $_SESSION['user_id'];
        $items  = $this->model->getByUserId($userId, 20);
        Response::success($items);
    }
}

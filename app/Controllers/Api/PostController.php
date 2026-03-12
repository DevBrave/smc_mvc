<?php




namespace App\Controllers\Api;

use App\Model\Post;

class PostController extends ApiController
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        SystemController::setCorsHeaders();
        $posts = $this->post->all();
        return $this->json($posts, 200);
    }

    public function store()
    {

        SystemController::setCorsHeaders();

        $uid = $GLOBALS['auth_user_id'] ?? null; // comes from the jwt middleware


        $in = json_decode(file_get_contents('php://input'), true) ?? [];
        if (!isset($in['title'], $in['body'])) return $this->error('VALIDATION', 'title & body required', 422);
        $p = $this->post->create(['user_id' => $uid, 'title' => trim($in['title']), 'body' => trim($in['body'])]);
        return $this->json($p, 201);
    }

    private function toRes($p)
    {
        return [
            'id' => (int)$p['id'],
            'title' => $p['title'],
            'body' => $p['body'],
            'user' => ['id' => (int)$p['user_id'], 'username' => $p['username'] ?? null],
            'created_at' => $p['created_at'],
            'updated_at' => $p['updated_at'],
        ];
    }
}

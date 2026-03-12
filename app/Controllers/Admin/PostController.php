<?php


namespace App\Controllers\Admin;

use App\Model\Post;

class PostController
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $posts = $this->post->all();
        view('admin/posts/index.view.php', [
            'posts' => $posts,
            'post_model' => $this->post,
        ]);
    }
}

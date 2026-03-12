<?php


namespace App\Controllers\Admin;

use App\Model\Post;

class PostController
{


    public function __construct(
        protected Post $post
    ) {}

    public function index()
    {
        $posts = $this->post->all();
        view('admin/posts/index.view.php', [
            'posts' => $posts,
            'post_model' => $this->post,
        ]);
    }
}

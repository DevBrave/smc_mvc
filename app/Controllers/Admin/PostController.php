<?php


namespace Admin;

use app\Model\Post;

class PostController
{
    
    public function index()
    {
        $posts = Post::all();
        view('admin/posts/index.view.php',[
            'posts' => $posts,
        ]);
    }



}
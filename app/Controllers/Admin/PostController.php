<?php


namespace App\Controllers\Admin;

use App\Model\Post;

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
<?php


namespace App\Controllers\Admin;

use App\Model\Comment;
use Core\Request;

class CommentController
{
    
    public function index()
    {
        $comments = Comment::all();
        view('admin/comments/index.view.php',[
            'comments' => $comments,
        ]);
    }

    public function update(){

        $attributes = Request::all();
        Comment::updateStatus($attributes);
        redirect("/admin/comments");
    }



}
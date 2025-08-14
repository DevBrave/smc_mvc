<?php


namespace Admin;

use app\Model\Comment;
use app\Model\Post;
use Core\Request;
use Core\Validator;

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
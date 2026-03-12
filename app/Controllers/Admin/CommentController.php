<?php


namespace App\Controllers\Admin;

use App\Model\Comment;
use Core\Request;

class CommentController
{
    protected Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function index()
    {
        $comments = $this->comment->all();
        view('admin/comments/index.view.php', [
            'comments' => $comments,
            'commentModel' => $this->comment,
        ]);
    }

    public function update()
    {

        $attributes = Request::all();
        $this->comment->updateStatus($attributes);
        redirect("/admin/comments");
    }
}

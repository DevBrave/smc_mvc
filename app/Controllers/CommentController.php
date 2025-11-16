<?php

namespace App\Controllers;


use App\Model\Comment;
use App\Model\Notification;
use App\Model\NotificationRecipient;
use App\Model\NotificationService;
use App\Model\Post;
use Core\Request;
use Core\Validator;

class CommentController
{


    public function store()
    {
        $attributes = Request::all();
        $post_owner = Post::find($attributes['post_id']);
        // this is for checking csrf
//        if (!Validator::check_csrf($attributes['csrf_token'])) {
//            dd('here');
//        }
        if ($attributes['user_id'] == null) {
            $_SESSION['flash_errors']['not_logged_in'] = 'You should log in';
            redirect(previousurl());
        }
        unset($_SESSION['csrf_token']);

        Validator::validate([
            'body' => $attributes['body'],
        ], [
            'body' => 'required|max:500',
        ]);

        $comment_id = Comment::create($attributes);

        $recipient_ids = [$post_owner['user_id']];
        $context_id = null;
        $context_type = null;
        if (!is_null($attributes['parent_id'])) {
            $parent_comment_id = Comment::findById($attributes['parent_id']);
            $recipient_ids[] = $parent_comment_id;
            $context_id = $attributes['post_id'];
            $context_type = 'post';
        }

        if ($attributes['user_id'] != $post_owner['user_id']) {
            $notif_id = NotificationService::createOrBump('comment_post', [$recipient_ids], $attributes['user_id']
                , 'comment', $comment_id, $context_type, $context_id);
        }



        unset($_SESSION['flash_errors']);
        redirect(previousurl());

    }

    public function destroy($id)
    {
        Comment::delete($id);
        redirect(previousurl());

    }


    public function edit($id)
    {
        $post = Post::find($id);

        view('posts/edit.view.php', [
            'post' => $post,
        ]);

    }


    public function update()
    {
        $attributes = Request::all();

        // this is for checking csrf
//        if (!Validator::check_csrf($attributes['csrf_token'])) {
//            dd('here');
//        }


//        unset($_SESSION['csrf_token']);


        Validator::validate([
            'title' => $attributes['title'],
            'body' => $attributes['body'],
        ], [
            'title' => 'required|min:5|max:100',
            'body' => 'required',
        ]);

        if (!empty($_SESSION['flash_errors'])) {
            redirect(previousurl());
        }

        Post::update($attributes);
        redirect("/post/{$attributes['post_id']}");


    }
}
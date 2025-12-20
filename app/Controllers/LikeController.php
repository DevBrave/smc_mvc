<?php


namespace App\Controllers;


use App\Model\Comment;
use App\Model\LikeComment;
use App\Model\LikePost;
use App\Model\Notification;
use App\Model\NotificationRecipient;
use App\Model\NotificationService;
use App\Model\Post;
use App\Model\User;
use Core\Request;

class LikeController
{
    public function like_post()
    {
        $attributes = Request::all();
        $post_owner = Post::find($attributes['post_id']);

        // this is for checking csrf
//     if (!Validator::check_csrf($attributes['csrf_token'])){
//         dd('here');
//     }

        if ($attributes['user_id'] == null) {
            $_SESSION['flash_errors']['not_logged_in'] = 'You should log in';
            redirect(previousurl());
        }

        unset($_SESSION['csrf_token']);


        if (User::find($attributes['user_id']) !== null && $post_owner !== null) {


            $status = LikePost::create($attributes);
            if ($status && $attributes['user_id'] != $post_owner['user_id']) {
                NotificationService::createOrBump('like_post',[$post_owner['user_id']], $attributes['user_id'], 'post', $attributes['post_id']);
            }


            redirect(previousurl());

        }

        $_SESSION['flash_errors']['like'] = 'The like feature did not work';
        redirect(previousurl());


    }

    public function like_comment()
    {
        $attributes = Request::all();
        $comment_owner = Comment::findById($attributes['comment_id']);
        // csrf is checked with middle csrfMiddleware

        // is checked with authMiddleware
//        if ($attributes['user_id'] == null ){
//            $_SESSION['flash_errors']['not_logged_in'] = 'You should log in';
//            redirect(previousurl());
//        }
        if (User::find($attributes['user_id']) !== null && $comment_owner !== null) {

           $status =  LikeComment::create($attributes);


            if ($status && $attributes['user_id'] != $post_owner['user_id']) {
                $context_id = $comment_owner['post_id'];

                if (!is_null($comment_owner['parent_id'])) {
                    $context_id = $comment_owner['parent_id'];
                }
                    $recipients_id = [
                        $comment_owner['user_id'],
                        $comment_owner['post_id']
                    ];
                $notif_id = NotificationService::createOrBump('like_comment', $recipients_id,
                    $attributes['user_id'],'comment',$attributes['comment_id'],'post',$context_id);

            }


            redirect(previousurl());

        }

        $_SESSION['flash_errors']['like'] = 'The like feature did not work';
        redirect(previousurl());


    }


}
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


    public function __construct(
        protected Post $post,
        protected User $user,
        protected LikePost $likePost,
        protected Comment $comment,
        protected NotificationService $notifService,
    ) {}

    public function like_post()
    {
        $attributes = Request::all();
        $post_owner = $this->post->find($attributes['post_id']);

        if ($attributes['user_id'] == null) {
            $_SESSION['flash_errors']['not_logged_in'] = 'You should log in';
            redirect(previousurl());
        }

        unset($_SESSION['csrf_token']);


        if ($this->user->find($attributes['user_id']) !== null && $post_owner !== null) {


            $status = $this->likePost->create($attributes);
            if ($status && $attributes['user_id'] != $post_owner['user_id']) {
                $this->notifService->createOrBump('like_post', [$post_owner['user_id']], $attributes['user_id'], 'post', $attributes['post_id']);
            }


            redirect(previousurl());
        }

        $_SESSION['flash_errors']['like'] = 'The like feature did not work';
        redirect(previousurl());
    }

    public function like_comment()
    {
        $attributes = Request::all();
        $liked_comment = $this->comment->findById($attributes['comment_id']);
        $post_owner = $this->post->find($attributes['post_id']);
        if ($this->user->find($attributes['user_id']) !== null && $liked_comment !== null) {

            $status =  $this->likePost->create($attributes);


            if ($status && $attributes['user_id'] != $post_owner['user_id']) {
                $context_id = $liked_comment['post_id'];

                if (!is_null($liked_comment['parent_id'])) {
                    $context_id = $liked_comment['parent_id'];
                }
                $recipients_id = [
                    $liked_comment['user_id'],
                    $liked_comment['post_id']
                ];
                $notif_id = $this->notifService->createOrBump(
                    'like_comment',
                    $recipients_id,
                    $attributes['user_id'],
                    'comment',
                    $attributes['comment_id'],
                    'post',
                    $context_id
                );
            }


            redirect(previousurl());
        }

        $_SESSION['flash_errors']['like'] = 'The like feature did not work';
        redirect(previousurl());
    }
}

<?php


namespace App\Controllers;



use App\Model\Comment;
use App\Model\LikeComment;
use App\Model\LikePost;
use App\Model\Post;
use App\Model\User;
use Core\Request;

class LikeController
{
  public function like_post(){
      $attributes = Request::all();

      // this is for checking csrf

//     if (!Validator::check_csrf($attributes['csrf_token'])){
//         dd('here');
//     }
      if ($attributes['user_id'] == null ){
          $_SESSION['flash_errors']['not_logged_in'] = 'You should log in';
          redirect(previousurl());
      }
      unset($_SESSION['csrf_token']);

      if (User::find($attributes['user_id']) !== null && Post::find($attributes['post_id']) !== null){

            LikePost::create($attributes);
            redirect(previousurl());

      }

      $_SESSION['flash_errors']['like'] = 'The like feature did not work';
      redirect(previousurl());




  }

    public function like_comment(){
        $attributes = Request::all();
        // csrf is checked with middle csrfMiddleware

        // is checked with authMiddleware
//        if ($attributes['user_id'] == null ){
//            $_SESSION['flash_errors']['not_logged_in'] = 'You should log in';
//            redirect(previousurl());
//        }

        if (User::find($attributes['user_id']) !== null && Comment::findById($attributes['comment_id']) !== null){

            LikeComment::create($attributes);
            redirect(previousurl());

        }

        $_SESSION['flash_errors']['like'] = 'The like feature did not work';
        redirect(previousurl());




    }


}
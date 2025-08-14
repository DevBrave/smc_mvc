<?php


use app\Model\Comment;
use app\Model\Post;
use app\Model\User;
use Core\App;
use Core\Database;
use Core\Request;
use Core\Validator;

class CommentController
{


    public function store()
    {
        $attributes = Request::all();
        // this is for checking csrf
//        if (!Validator::check_csrf($attributes['csrf_token'])) {
//            dd('here');
//        }
        if ($attributes['user_id'] == null ){
            $_SESSION['flash_errors']['not_logged_in'] = 'You should log in';
            redirect(previousurl());
        }
        unset($_SESSION['csrf_token']);

        Validator::validate([
            'body' => $attributes['body'],
        ],[
            'body' => 'required|max:500',
        ]);

        Comment::create($attributes);
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
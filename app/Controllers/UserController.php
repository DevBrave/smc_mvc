<?php


namespace App\Controllers;


use App\Model\Follow;
use App\Model\Post;
use App\Model\User;
use Core\FileUploader;
use Core\Request;
use Core\Validator;

class UserController
{
    public function profile($username)
    {
        $user = User::findByUsername($username);
        $post_count = Post::post_count($user['id']);
        $follower_count = Follow::follower_count($user['id']);
        $following_count = Follow::following_count($user['id']);
        view('users/profile.view.php', [
            'user' => $user,
            'post_count' => $post_count,
            'follower_count' => $follower_count,
            'following_count' => $following_count,
        ]);
    }

    public function edit($username)
    {
        $user = User::findByUsername($username);
        view('users/edit.view.php', [
            'user' => $user
        ]);
    }


    public function update()
    {
        $attributes = Request::all();
        $user = User::find($attributes['id']);

//        if (!Validator::check_csrf($attributes['csrf_token'])) {
//            dd('here');
//        }


//        unset($_SESSION['csrf_token']);



        $validationFields = [
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'status' => $attributes['status'],
            'bio' => $attributes['bio']
        ];

        $validationRules = [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:2',
            'bio' => 'max:100'
        ];

        if ($user['username'] != $attributes['username']) {
            $validationFields['username'] = $attributes['username'];
            $validationRules['username'] = 'unique:users';
        }

        Validator::validate($validationFields, $validationRules);
        $attributes['avatar'] = $user['avatar'];

        // check if we have new avatar
        if (isset($_FILES['avatar']) && is_uploaded_file($_FILES['avatar']['tmp_name'])) {

            FileUploader::validate($_FILES['avatar'],'avatar');


            $path = FileUploader::upload($_FILES['avatar'],'avatar');


            $attributes['avatar'] = $path;
        }

        User::update($attributes);
        unset($_SESSION['flash_errors']);
        redirect('/user/' . $attributes['username']);

    }


    public function show_posts($username)
    {

        $user_id = (User::findByUsername($username))['id'];
        $posts = Post::user_post($user_id);
        view('users/show_user_posts.view.php', [
            'posts' => $posts,
        ]);

    }

    public function followers($username)
    {

        $followers = Follow::followers(\username($username)['id']);
        $ids = array_column($followers,'follower_id');

        view('users/show_followers.view.php', [
            'follows' => $ids,
            'title' => 'Followers'
        ]);

    }

    public function followings($username)
    {

        $followings = Follow::following(\username($username)['id']);
        $ids = array_column($followings,'following_id');
        view('users/show_followers.view.php', [
            'follows' => $ids,
            'title' => 'Followings'
        ]);

    }


}
<?php


namespace App\Controllers;


use App\Model\Follow;
use App\Model\NotificationRecipient;
use App\Model\Post;
use App\Model\User;
use Core\FileUploader;
use Core\Request;
use Core\Validator;

class UserController
{



    public function __construct(
        protected User $user,
        protected Post $post,
        protected Follow $follow,
        protected NotificationRecipient $notifRecepientModel,
        protected Validator $validator,
        protected FileUploader $fileUploder,
    ) {}

    public function profile($username)
    {
        $user = $this->user->findByUsername($username);
        $post_count = $this->post->post_count($user['id']);
        $follower_count = $this->follow->follower_count($user['id']);
        $following_count = $this->follow->following_count($user['id']);
        $notif_count = $this->notifRecepientModel->unreadCount($user['id']);
        view('users/profile.view.php', [
            'user' => $user,
            'post_count' => $post_count,
            'follower_count' => $follower_count,
            'following_count' => $following_count,
            'notif_count' => $notif_count
        ]);
    }

    public function edit($username)
    {
        $user = $this->user->findByUsername($username);
        view('users/edit.view.php', [
            'user' => $user
        ]);
    }


    public function update()
    {
        $attributes = Request::all();
        $user = $this->user->find($attributes['id']);

        //        if (!$this->validator->check_csrf($attributes['csrf_token'])) {
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

        $this->validator->validate($validationFields, $validationRules);
        $attributes['avatar'] = $user['avatar'];

        // check if we have new avatar
        if (isset($_FILES['avatar']) && is_uploaded_file($_FILES['avatar']['tmp_name'])) {

            $this->fileUploder->validate($_FILES['avatar'], 'avatar');


            $path = $this->fileUploder->upload($_FILES['avatar'], 'avatar');


            $attributes['avatar'] = $path;
        }

        $this->user->update($attributes);
        unset($_SESSION['flash_errors']);
        redirect('/user/' . $attributes['username']);
    }


    public function show_posts($username)
    {

        $user_id = ($this->user->findByUsername($username))['id'];
        $posts = $this->post->user_post($user_id);
        view('users/show_user_posts.view.php', [
            'posts' => $posts,
        ]);
    }

    public function followers($username)
    {

        $ids = $this->follow->followers($this->user->findByUsername($username)['id']);

        view('users/show_followers.view.php', [
            'follows' => $ids,
            'title' => 'Followers'
        ]);
    }


    public function show_notifications($username)
    {

        $notifs = $this->notifRecepientModel->userNotifications($this->user->findByUsername($username)['id']);
        view('users/show_notifications.view.php', [
            'notifs' => $notifs,
            'title' => 'Notifications'
        ]);
    }

    public function followings($username)
    {

        $followings = $this->follow->following($this->user->findByUsername($username)['id']);
        $ids = array_column($followings, 'following_id');
        view('users/show_followers.view.php', [
            'follows' => $ids,
            'title' => 'Followings'
        ]);
    }
}

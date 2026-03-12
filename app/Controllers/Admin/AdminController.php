<?php


namespace App\Controllers\Admin;

use App\Model\Auth;
use App\Model\Comment;
use App\Model\LikePost;
use App\Model\User;

class AdminController
{

    protected Auth $auth;
    protected User $user;
    protected Comment $commentModel;
    protected LikePost $likePostModel;

    public function __construct(Auth $auth, User $user, Comment $commentModel, LikePost $likePostModel)
    {
        $this->auth = $auth;
        $this->user = $user;
        $this->commentModel = $commentModel;
        $this->likePostModel = $likePostModel;
    }

    public function dashboard()
    {

        view('admin/dashboard.view.php', [
            'user' => $this->auth->user(),
            'total_users' => $this->user->how_many_user(),
            'total_comments' => $this->commentModel->how_many_comments(),
            'total_likes' => $this->likePostModel->how_many_likes(),
        ]);
    }
}

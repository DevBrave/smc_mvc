<?php


namespace App\Controllers\Admin;

use App\Model\Auth;
use App\Model\Comment;
use App\Model\LikePost;
use App\Model\User;

class AdminController
{



    public function __construct(
        protected Auth $auth,
        protected User $user,
        protected Comment $commentModel,
        protected LikePost $likePostModel
    ) {}

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

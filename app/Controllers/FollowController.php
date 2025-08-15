<?php


use app\Model\Follow;
use app\Model\User;
use Core\App;
use Core\Config;
use Core\Database;
use Core\FileUploader;
use Core\Request;
use Core\Validator;

class FollowController
{
    public function follow($id)
    {
        $follower_id = user()['id'];
        $followed_id = $id;


        // has the follower_id followed the followed_id
        if (Follow::has_followed($follower_id,$followed_id)){
            // an error
           redirect(previousurl());
        }

        // if is not -> insert
        Follow::follow($follower_id,$followed_id);


        redirect(previousurl());
    }

    public function unfollow($id)
    {
        $follower_id = user()['id'];
        $followed_id = $id;


        // has the follower_id followed the followed_id
        if (Follow::has_followed($follower_id,$followed_id)){
            // if is not -> insert
            Follow::unfollow($follower_id,$followed_id);
        }


        // an error
        redirect(previousurl());

    }


}


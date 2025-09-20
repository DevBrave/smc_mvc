<?php

namespace App\Controllers;

use App\Model\Follow;

class FollowController
{
    public function follow($id)
    {
        $follower_id = username()['id'];
        $followed_id = $id;


        // has the follower_id followed the followed_id
        if (Follow::has_followed($follower_id,$followed_id)){
            // an error
           redirect(previousurl());
        }



        // if is not -> insert


        // check the status of the profile

        if(user($followed_id)['status'] == 'private'){

            Follow::follow($follower_id,$followed_id,'pending');
            redirect(previousurl());
        }




        Follow::follow($follower_id,$followed_id,'accepted');


        redirect(previousurl());
    }

    public function unfollow($id)
    {
        $follower_id = username()['id'];
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


<?php

namespace App\Controllers;

use App\Model\Follow;
use App\Model\Notification;
use App\Model\NotificationRecipient;

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



//        if ($status && $attributes['user_id'] != $post_owner['user_id']) {
//
//
//
//        }

        // check the status of the profile

        if(user($followed_id)['status'] == 'private'){

            Follow::follow($follower_id,$followed_id,'pending');
            $notif_id = Notification::create($follower_id, 'follow_requested', 'user',$followed_id);
            // notify just one user which is the owner of post
            NotificationRecipient::notify($notif_id,[$followed_id]);
            redirect(previousurl());
        }




        Follow::follow($follower_id,$followed_id,'accepted');
        $notif_id = Notification::create($follower_id, 'followed_user', 'user',$followed_id);
        // notify just one user which is the owner of post
        NotificationRecipient::notify($notif_id,[$followed_id]);

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


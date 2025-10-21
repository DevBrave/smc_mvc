<?php

namespace App\Model;

use Core\App;
use Core\Database;

class NotificationRecipient
{

    protected $connection = [];
    protected $table = 'comments';
    private $types = [
        'post_created','follow_requested','follow_accepted',
        'like_post','like_comment','comment_post','comment_comment',
        'admin_verify','followed_user',
    ];

    protected $messages = [
        'like_post' => "liked your post",
        'like_comment' => "liked your comment",
        'comment_post' => "commented on your post",
        'comment_comment' => "commented on your comment",
        'post_created' => "just create a post",
        'follow_requested' => "just requested to follow you",
        'follow_accepted' => "accept your follow request",
        'admin_verify' => "You have been achieved to ADMIN role",
        'followed_user' => "followed you"

    ];


    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }


    public static function notify($notif_id, $user_id)
    {
        foreach ($user_id as $uid) {

            App::resolve(Database::class)->query("INSERT INTO notification_recipients
            (notification_id, user_id) VALUES (:notification_id,:user_id)", [
                'notification_id' => $notif_id,
                'user_id' => $uid
            ]);
        }

    }

    public static function notif_count($user_id)
    {

        return App::resolve(Database::class)->query("select count(*) from notification_recipients where user_id=:user_id ", [
            'user_id' => $user_id,
        ])->fetchCol();


    }


    public static function hisNotifs($user_id)
    {
        $instantiate = new static();
        $notifications = [];
        $msgs = [];
        $notification_ids = array_column(
            App::resolve(Database::class)
                ->query("select notification_id
            from notification_recipients
            where user_id=:user_id order by created_at desc",
                    [
                        'user_id' => $user_id
                    ]
                )->fetchAll(), 'notification_id');


        foreach ($notification_ids as $notif_id) {
            $notifications[] = array_merge(...App::resolve(Database::class)->query("select * from notifications where id=:id", [
                'id' => $notif_id
            ])->fetchAll());
        }
        foreach ($notifications as $notif) {
            if (array_key_exists($notif['type'], $instantiate->messages)) {
                $msgs[] = User::find($notif['actor_id'])['username'].' '.$instantiate->messages[$notif['type']];
            }
        }
        return $msgs;
    }


}
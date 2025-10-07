<?php

namespace App\Model;

use Core\App;
use Core\Database;

class NotificationRecipient
{

    protected $connection = [];
    protected $table = 'comments';
    protected $messages = [
        'like_post' => "user_id liked your post",
        'comment_post' => "user_id commented on your post",
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
        $notifications = null;
        $msgs =[];
        $notification_ids = array_column(
            App::resolve(Database::class)
                ->query("select notification_id
            from notification_recipients
            where user_id=:user_id",
                    [
                        'user_id' => $user_id
                    ]
                )->fetchAll(),'notification_id');

        foreach ($notification_ids as $notif_id){
            $notifications = App::resolve(Database::class)->query("select * from notifications where id=:id",[
               'id' => $notif_id
            ])->fetchAll();
        }

        $types = array_column($notifications,'type');
        foreach ($types as $type){
            if (array_key_exists($type,$instantiate->messages)){
               $msgs[] = $instantiate->messages[$type];
            }
        }

        return $msgs;

    }


}
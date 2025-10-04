<?php

namespace App\Model;

use Core\App;
use Core\Database;

class NotificationRecipient
{

    protected $connection = [];
    protected $table = 'comments';

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }


    public static function notify($notif_id, $user_id){
        foreach ($user_id as $uid) {

            App::resolve(Database::class)->query("INSERT INTO notification_recipients
            (notification_id, user_id) VALUES (:notification_id,:user_id)",[
                'notification_id' => $notif_id,
                'user_id' => $uid
            ]);
        }

    }

    public static function notif_count($user_id){

        return App::resolve(Database::class)->query("select count(*) from notification_recipients where user_id=:user_id ",[
            'user_id' => $user_id,
        ])->fetchCol();


    }



}
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


    public static function insertAsUnread($notificationId, $userId, $groupKey)
    {

        $sql = "INSERT INTO notification_recipients (notification_id, user_id, group_key, read_at, created_at)
                VALUES (:nid, :uid, :gk, NULL, NOW())
                ON DUPLICATE KEY UPDATE read_at = NULL";
        return App::resolve(Database::class)->query($sql,
            [
                'nid' => $notificationId,
                'uid' => $userId,
                'gk' => $groupKey
            ]);
    }


}
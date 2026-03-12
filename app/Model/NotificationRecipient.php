<?php

namespace App\Model;

use Core\App;
use Core\Database;

class NotificationRecipient
{


    protected $table = 'comments';


    public function __construct(
        protected Database $db
    ) {}


    public function insertAsUnread($notificationId, $userId, $groupKey)
    {

        $sql = "INSERT INTO notification_recipients (notification_id, user_id, group_key, read_at, created_at)
                VALUES (:nid, :uid, :gk, NULL, NOW())
                ON DUPLICATE KEY UPDATE read_at = NULL";
        return $this->db->query(
            $sql,
            [
                'nid' => $notificationId,
                'uid' => $userId,
                'gk' => $groupKey
            ]
        );
    }

    public function unreadCount($user_id)
    {
        return $this->db->query("select COUNT(*) from notification_recipients where user_id=:uid and read_at is null", [
            'uid' => $user_id
        ])->fetchCol();
    }
}

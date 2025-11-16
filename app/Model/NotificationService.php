<?php

namespace App\Model;

use Core\App;
use Core\Database;

class NotificationService
{


    protected $connection;

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }

    public static function createOrBump($type, $recipientIds, $actor_id, $object_type, $object_id, $context_type = null, $context_id = null)
    {
        $notification_id = null;
        if ($recipientIds == null)
            return null;
        $group_key = $type . ':' . $object_type;
        // check that if group key is existed

        try {

            $db_instant = App::resolve(Database::class);
            $db_instant->beginTransaction();
            // TODO : I need to use a strict and integrated instance of database and not both of them


            $existence = Notification::findGroupKeyIfExists($group_key, $object_id);


            if (!$existence) {


                // create notification row if the group key is not existed
                $notification_id = Notification::create([
                    'type' => $type,
                    'actor_id' => $actor_id,
                    'last_actor_id' => $actor_id,
                    'object_type' => $object_type,
                    'object_id' => $object_id,
                    'context_type' => $context_type,
                    'context_id' => $context_id,
                    'group_key' => $group_key,
                    'cnt' => 1,
                ]);

            } else {
                // update cnt and last update
                Notification::bump($existence['id'], $actor_id);

            }

            foreach ($recipientIds as $rec_id) {
                if ($actor_id == $rec_id) {
                    continue;
                }
                NotificationRecipient::insertAsUnread($notification_id, $rec_id, $group_key);
            }


            $db_instant->commit();


        } catch (\Throwable $e) {
            $db_instant->rollBack();
        }
    }


}
<?php

namespace App\Model;

use Core\App;
use Core\Database;

class Notification
{

    protected $connection = [];
    protected $table = 'notificaitons';

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }

    public static function create($actor_id,$type,$object_type,$object_id,$context_id = null)
    {
        return App::resolve(Database::class)->query("insert into notifications 
        (actor_id,type,object_type,object_id,context_id,group_key) values
        (:actor_id,:type,:object_type,:object_id,:context_id,:group_key)",[

            'actor_id' => $actor_id,
            'type' => $type,
            'object_type' => $object_type,
            'object_id' => $object_id,
            'context_id' => $context_id,
            'group_key' => $type . ':' . $object_id


        ])->lastId();
    }


}
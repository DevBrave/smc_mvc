<?php

namespace App\Model;

use Core\App;
use Core\Database;

class Notification
{

    protected $connection = [];
    protected $table = 'notificaitons';
    public  $credentials = [
        'type',
        'actor_id',
        'last_actor_id',
        'object_type',
        'object_id',
        'context_type',
        'context_id',
        'group_key',
        'cnt',
    ];

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }

    public static function create(array $data): int
    {
         return App::resolve(Database::class)->query("INSERT INTO notifications 
                (type,actor_id,last_actor_id,object_type,object_id,context_type,context_id,group_key,cnt)
                VALUES
                 (:type,:a_id,:last_a_id,:obj_type,:obj_id,:context_type,:context_id,:group_key,:cnt);", [
            'type' => $data['type'],
            'a_id' => $data['actor_id'],
            'last_a_id' => $data['last_actor_id'],
            'obj_type' => $data['object_type'],
            'obj_id' => $data['object_id'],
            'context_type' => $data['context_type'],
            'context_id' => $data['context_id'],
            'group_key' => $data['group_key'],
            'cnt' => $data['cnt'],
        ])->lastId();
    }

    public static function bump(int $id, int $actorId): void
    {

        App::resolve(Database::class)->query("UPDATE notifications SET cnt = cnt + 1,last_actor_id = :actorId,updated_at = NOW() WHERE id = :id", [
            'actorId' => $actorId,
            'id' => $id
        ]);
    }

    public function decrement(int $id): void
    {
        App::resolve(Database::class)->query("UPDATE notifications SET cnt = cnt - 1 WHERE id = :id", [
            'id' => $id
        ]);
    }

    public static function findGroupKeyIfExists($group_key, $object_id)
    {
        return App::resolve(Database::class)->query("SELECT id, cnt, last_actor_id, updated_at
                FROM notifications
                WHERE group_key = :gk AND object_id = :obj
                LIMIT 1", [
            'gk' => $group_key,
            'obj' => $object_id
        ])->fetch();

    }


}
<?php

namespace App\Model;

use Core\App;
use Core\Database;

class LikeComment
{

    protected $connection = [];
    protected $table = 'comment_likes';

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }

    public static function create($attribute)
    {
        $instantiate = new static();

        if (LikeComment::hasLiked($attribute['comment_id'], $attribute['user_id'])) {
            LikeComment::remove($attribute);

        } else {
            $query = "insert into  {$instantiate->table} (user_id,comment_id)
            values(:user_id,:comment_id)";
            $instantiate->connection->query($query, [
                'user_id' => $attribute['user_id'],
                'comment_id' => $attribute['comment_id'],
            ]);

        }


    }


    public static function remove($attributes)
    {
        $instantiate = new static();
        $query = "delete from {$instantiate->table} where comment_id=:comment_id and  user_id=:user_id";

        $instantiate->connection->query($query, [
            'comment_id' => $attributes['comment_id'],
            'user_id' => $attributes['user_id'],
        ]);
    }


    public static function like_count($comment_id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from  {$instantiate->table}
                where comment_id=:comment_id group by comment_id", [
            'comment_id' => $comment_id,
        ])->fetchCol();

    }

    public static function hasLiked($comment_id, $user_id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select * from  {$instantiate->table}
                where comment_id=:comment_id and user_id=:user_id group by user_id",
                [
                    'comment_id' => $comment_id,
                    'user_id' => $user_id,
                ])->fetchCol() > 0;


    }

    public static function find($comment_id, $user_id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select * from  {$instantiate->table}
                where comment_id=:comment_id and user_id=:user_id group by user_id",
            [
                'comment_id' => $comment_id,
                'user_id' => $user_id,
            ])->fetchCol();
    }


}
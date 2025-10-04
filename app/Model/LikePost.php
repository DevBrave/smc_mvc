<?php

namespace App\Model;

use Core\App;
use Core\Database;

class LikePost
{

    protected $connection = [];
    protected $table = 'likes';

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }

    public static function create($attribute)
    {

        $instantiate = new static();

        if (LikePost::hasLiked($attribute['post_id'], $attribute['user_id'])) {
            LikePost::remove(LikePost::find($attribute['post_id'], $attribute['user_id']));
            return false;

        } else {
            $query = "insert into  {$instantiate->table} (user_id,post_id)
            values(:user_id,:post_id)";
            $instantiate->connection->query($query, [
                'user_id' => $attribute['user_id'],
                'post_id' => $attribute['post_id'],
            ]);

            return true;

        }


    }


    public static function remove($id)
    {
        $instantiate = new static();
        $query = "delete from {$instantiate->table} where id=:id";

        $instantiate->connection->query($query, [
            'id' => $id,
        ]);
    }


    public static function like_count($post_id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from  {$instantiate->table}
                where post_id=:post_id group by post_id", [
            'post_id' => $post_id,
        ])->fetchCol();

    }

    public static function hasLiked($post_id, $user_id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select id from  {$instantiate->table}
                where post_id=:post_id and user_id=:user_id group by user_id",
                [
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                ])->fetchCol() > 0;


    }

    public static function find($post_id, $user_id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select id from  {$instantiate->table}
                where post_id=:post_id and user_id=:user_id group by user_id",
            [
                'post_id' => $post_id,
                'user_id' => $user_id,
            ])->fetchCol();
    }


    public static function how_many_likes()
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from  {$instantiate->table}")->fetchCol();
    }


}
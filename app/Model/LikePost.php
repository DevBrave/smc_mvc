<?php

namespace App\Model;

use Core\Database;

class LikePost
{

    protected $connection;
    protected $table = 'like_posts';

    public function __construct(Database $connection)
    {
        $this->connection = $connection;
    }

    public function create($attribute)
    {
        if ($this->hasLiked($attribute['post_id'], $attribute['user_id'])) {
            $this->remove($this->find($attribute['post_id'], $attribute['user_id']));
            return false;
        } else {
            $query = "insert into  {$this->table} (user_id,post_id)
            values(:user_id,:post_id)";
            $this->connection->query($query, [
                'user_id' => $attribute['user_id'],
                'post_id' => $attribute['post_id'],
            ]);

            return true;
        }
    }


    public function remove($id)
    {
        $query = "delete from {$this->table} where id=:id";

        $this->connection->query($query, [
            'id' => $id,
        ]);
    }


    public function like_count($post_id)
    {
        return $this->connection->query("select count(*) from  {$this->table}
                where post_id=:post_id group by post_id", [
            'post_id' => $post_id,
        ])->fetchCol();
    }

    public function hasLiked($post_id, $user_id)
    {
        return $this->connection->query(
            "select id from  {$this->table}
                where post_id=:post_id and user_id=:user_id group by user_id",
            [
                'post_id' => $post_id,
                'user_id' => $user_id,
            ]
        )->fetchCol() > 0;
    }

    public function find($post_id, $user_id)
    {
        return $this->connection->query(
            "select id from  {$this->table}
                where post_id=:post_id and user_id=:user_id group by user_id",
            [
                'post_id' => $post_id,
                'user_id' => $user_id,
            ]
        )->fetchCol();
    }


    public function how_many_likes()
    {
        return $this->connection->query("select count(*) from  {$this->table}")->fetchCol();
    }
}

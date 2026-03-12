<?php

namespace App\Model;

use Core\Database;

class LikeComment
{

    protected $connection;
    protected $table = 'like_comments';

    public function __construct(Database $connection)
    {
        $this->connection = $connection;
    }

    public function create($attribute)
    {
        if ($this->hasLiked($attribute['comment_id'], $attribute['user_id'])) {
            $this->remove($attribute);
            return false;
        } else {
            $query = "insert into  {$this->table} (user_id,comment_id)
            values(:user_id,:comment_id)";
            $this->connection->query($query, [
                'user_id' => $attribute['user_id'],
                'comment_id' => $attribute['comment_id'],
            ]);
            return true;
        }
    }


    public function remove($attributes)
    {
        $query = "delete from {$this->table} where comment_id=:comment_id and  user_id=:user_id";

        $this->connection->query($query, [
            'comment_id' => $attributes['comment_id'],
            'user_id' => $attributes['user_id'],
        ]);
    }


    public function like_count($comment_id)
    {
        return $this->connection->query("select count(*) from  {$this->table}
                where comment_id=:comment_id group by comment_id", [
            'comment_id' => $comment_id,
        ])->fetchCol();
    }

    public function hasLiked($comment_id, $user_id)
    {
        return $this->connection->query(
            "select * from  {$this->table}
                where comment_id=:comment_id and user_id=:user_id group by user_id",
            [
                'comment_id' => $comment_id,
                'user_id' => $user_id,
            ]
        )->fetchCol() > 0;
    }

    public function find($comment_id, $user_id)
    {
        return $this->connection->query(
            "select * from  {$this->table}
                where comment_id=:comment_id and user_id=:user_id group by user_id",
            [
                'comment_id' => $comment_id,
                'user_id' => $user_id,
            ]
        )->fetchCol();
    }
}

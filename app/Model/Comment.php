<?php

namespace App\Model;

use Core\Database;

class Comment
{


    protected $table = 'comments';
    // this code is dedicated to my idol HadiKhan
    public function __construct(
        protected Database $db,
        protected User $user,
    ) {}

    public function comment_count($post_id)
    {
        return $this->db->query("select count(*) from  {$this->table}
                where post_id=:post_id and parent_id is null group by post_id", [
            'post_id' => $post_id,
        ])->fetchCol();
    }


    public function create($attribute)
    {
        $query = "insert into  {$this->table} (user_id,post_id,body,parent_id)
            values(:user_id,:post_id,:body,:parent_id)";

        $this->db->query($query, [
            'user_id' => $attribute['user_id'],
            'post_id' => $attribute['post_id'],
            'body' => $attribute['body'],
            'parent_id' => $attribute['parent_id'] != null ? $attribute['parent_id'] : null,
        ])->lastId();
    }

    public function update($attribute)
    {
        $query = "update  {$this->table}  set body=:body where id=:id";

        $this->db->query($query, [
            'id' => $attribute['id'],
            'body' => $attribute['body'],
        ]);
    }

    public function updateStatus($attributes)
    {
        $query = "update  {$this->table}  set status=:status where id=:id";

        $this->db->query($query, [
            'id' => $attributes['id'],
            'status' => $attributes['status'],
        ]);
    }


    public function delete($id)
    {
        $query = "delete from {$this->table} where id=:id";

        $this->db->query($query, [
            'id' => $id,
        ]);
    }


    public function findByPostId($id)
    {
        return $this->db->query("select * from  {$this->table} where post_id=:post_id and status =:status", [
            'post_id' => $id,
            'status' => 1
        ])->fetchAll();
    }

    public function findById($id)
    {
        return $this->db->query("select * from  {$this->table} where id=:id", [
            'id' => $id,
        ])->fetch();
    }

    public function all()
    {
        $query = "select * from {$this->table}";

        return $this->db->query($query)->fetchAll();
    }

    public function how_many_comments()
    {
        return $this->db->query("select count(*) from  {$this->table} ")->fetchCol();
    }

    public function getAuthorUsername($user_id)
    {
        return $this->user->find($user_id)['username'];
    }
}

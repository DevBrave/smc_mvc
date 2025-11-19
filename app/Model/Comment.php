<?php

namespace App\Model;

use Core\App;
use Core\Database;

class Comment
{

    protected $connection = [];
    protected $table = 'comments';

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }

    public static function comment_count($post_id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from  {$instantiate->table}
                where post_id=:post_id and parent_id is null group by post_id", [
            'post_id' => $post_id,
        ])->fetchColumn();

    }


    public static function create($attribute)
    {
        $instantiate = new static();
        $query = "insert into  {$instantiate->table} (user_id,post_id,body,parent_id)
            values(:user_id,:post_id,:body,:parent_id)";

        $instantiate->connection->query($query, [
            'user_id' => $attribute['user_id'],
            'post_id' => $attribute['post_id'],
            'body' => $attribute['body'],
            'parent_id' => $attribute['parent_id'] != null ? $attribute['parent_id'] : null,
        ])->lastId();


    }

    public static function update($attribute)
    {
        $instantiate = new static();
        $query = "update  {$instantiate->table}  set body=:body where id=:id";

        $instantiate->connection->query($query, [
            'id' => $attribute['id'],
            'body' => $attribute['body'],
        ]);


    }

    public static function updateStatus($attributes)
    {
        $instantiate = new static();
        $query = "update  {$instantiate->table}  set status=:status where id=:id";

        $instantiate->connection->query($query, [
            'id' => $attributes['id'],
            'status' => $attributes['status'],
        ]);
    }


    public static function delete($id)
    {
        $instantiate = new static();
        $query = "delete from {$instantiate->table} where id=:id";

        $instantiate->connection->query($query, [
            'id' => $id,
        ]);
    }


    public static function findByPostId($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select * from  {$instantiate->table} where post_id=:post_id and status =:status", [
            'post_id' => $id,
            'status' => 1
        ])->fetchAll();
    }

    public static function findById($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select * from  {$instantiate->table} where id=:id", [
            'id' => $id,
        ])->fetch();
    }

    public static function all()
    {
        $instantiate = new static();
        $query = "select * from {$instantiate->table}";

        return $instantiate->connection->query($query)->fetchAll();
    }

    public static function how_many_comments()
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from  {$instantiate->table} ")->fetchColumn();
    }

    public static function user_comment($user_id)
    {
      return User::find($user_id)['username'];
    }




}
<?php

namespace app\Model;

use Core\App;
use Core\Database;

class Post
{
    protected $connection = [];
    protected $table = 'posts';


    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }

    public static function all()
    {
        $instantiate = new static();
        $query = "select * from {$instantiate->table}";

        return $instantiate->connection->query($query)->fetchAll();
    }

    public static function create($attribute)
    {
        $instantiate = new static();
        $query = "insert into {$instantiate->table} (user_id,title,body)
            values(:user_id,:title,:body)";

        $instantiate->connection->query($query, [
            'user_id' => $attribute['user_id'],
            'title' => $attribute['title'],
            'body' => $attribute['body'],
        ]);

        return $instantiate->connection->lastId();


    }

    public static function update($attribute)
    {
        $instantiate = new static();
        $query = "update {$instantiate->table} set title=:title , body=:body where id=:id";
        $instantiate->connection->query($query, [
            'id' => $attribute['post_id'],
            'title' => $attribute['title'],
            'body' => $attribute['body'],
        ]);

        return $attribute['post_id'];

    }


    public static function delete($id)
    {
        $instantiate = new static();
        $query = "delete from {$instantiate->table} where id=:id";

        $instantiate->connection->query($query, [
            'id' => $id,
        ]);
    }


    public static function find($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select * from  {$instantiate->table}  where id=:id", [
            'id' => $id,
        ])->fetch();
    }

    public static function user_post($user_id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select * from  {$instantiate->table} where user_id=:user_id", [
            'user_id' => $user_id,
        ])->fetchAll();
    }

    public static function post_count($user_id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from {$instantiate->table} where user_id=:user_id",[
            'user_id' => $user_id
        ])->fetchCol();
    }

    public static function how_many_posts()
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from  {$instantiate->table}")->fetchCol();

    }

    public static function post_created_by($post_id)
    {
        return User::find(Post::find($post_id)['user_id'])['username'];
    }
}
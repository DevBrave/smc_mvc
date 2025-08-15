<?php

namespace app\Model;

use Core\App;
use Core\Database;

class Follow
{

    protected $connection = [];
    protected $table = 'follows';

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }


    public static function follow($follower_id,$followed_id)
    {
        $instantiate = new static();
        App::resolve(Database::class)->query("insert into {$instantiate->table} (follower_id,following_id)  values (:follower_id,:following_id)",[
            'follower_id' => $follower_id,
            'following_id' => $followed_id,
        ]);
    }


    public static function unfollow($follower_id,$followed_id)
    {
        $instantiate = new static();
        App::resolve(Database::class)->query("delete from {$instantiate->table} where follower_id=:follower_id and following_id=:following_id",[
            'follower_id' => $follower_id,
            'following_id' => $followed_id,
        ]);
    }

    public static function has_followed($follower_id,$followed_id)
    {
        $instantiate = new static();
        $result = App::resolve(Database::class)->query("select count(*) from {$instantiate->table} where follower_id=:follower_id and following_id=:following_id",[
            'follower_id' => $follower_id,
            'following_id' => $followed_id,
        ])->fetchCol();
        if ($result) {
            return true; // Row exists
        }
        return false; // Row does not exist
    }

    public static function followers($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select follower_id from {$instantiate->table} where following_id=:following_id",[
            'following_id' => $id,
        ])->fetchAll();
    }

    public static function following($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select following_id from {$instantiate->table} where follower_id=:follower_id",[
            'follower_id' => $id,
        ])->fetchAll();
    }

    public static function follower_count($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from {$instantiate->table} where following_id=:following_id",[
            'following_id' => $id
        ])->fetchCol();
    }

    public static function following_count($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from {$instantiate->table} where follower_id=:follower_id",[
            'follower_id' => $id
        ])->fetchCol();
    }





}
<?php

namespace App\Model;

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


    public static function follow($follower_id,$followed_id,$status)
    {
        $instantiate = new static();
        App::resolve(Database::class)->query("insert into {$instantiate->table} (follower_id,following_id,status)  values (:follower_id,:following_id,:status)",[
            'follower_id' => $follower_id,
            'following_id' => $followed_id,
            'status' => $status
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
            return new self();
        }
        return false; // Row does not exist
    }

    public static function followers($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select follower_id from {$instantiate->table} where following_id=:following_id  and status=:status",[
            'following_id' => $id,
            'status' => 'accepted',
        ])->fetchAll();
    }

    public static function following($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select following_id from {$instantiate->table} where follower_id=:follower_id  and status=:status",[
            'follower_id' => $id,
            'status' => 'accepted',
        ])->fetchAll();
    }

    public static function follower_count($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from {$instantiate->table} where following_id=:following_id and status=:status",[
            'following_id' => $id,
            'status' => 'accepted'
        ])->fetchCol();
    }

    public static function following_count($id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select count(*) from {$instantiate->table} where follower_id=:follower_id  and status=:status",[
            'follower_id' => $id,
            'status' => 'accepted'
        ])->fetchCol();
    }


    public static function checkStatus($follower_id,$followed_id)
    {
        $instantiate = new static();
        return App::resolve(Database::class)->query("select status from {$instantiate->table} where follower_id=:follower_id and following_id=:following_id",[
            'follower_id' => $follower_id,
            'following_id' => $followed_id,
        ])->fetch()['status'];
    }

    public static function getFollowState($userId, $ownerId): string
    {
        if ($userId === $ownerId) {
            return 'self';
        }

        if (!self::has_followed($userId, $ownerId)) {
            return 'can_follow';
        }

        return self::checkStatus($userId, $ownerId) === 'accepted'
            ? 'following'
            : 'pending';
    }





}
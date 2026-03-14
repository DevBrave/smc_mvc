<?php

namespace App\Model;

use Core\Database;

class Follow
{


    protected $table = 'follows';

    public function __construct(
        protected Database $db
    ) {}


    public function follow($follower_id, $followed_id, $status)
    {
        $this->db->query("insert into {$this->table} (follower_id,following_id,status)  values (:follower_id,:following_id,:status)", [
            'follower_id' => $follower_id,
            'following_id' => $followed_id,
            'status' => $status
        ]);
    }


    public function unfollow($follower_id, $followed_id)
    {
        $this->db->query("delete from {$this->table} where follower_id=:follower_id and following_id=:following_id", [
            'follower_id' => $follower_id,
            'following_id' => $followed_id,
        ]);
    }

    public function has_followed($follower_id, $followed_id)
    {
        $result = $this->db->query("select count(*) from {$this->table} where follower_id=:follower_id and following_id=:following_id", [
            'follower_id' => $follower_id,
            'following_id' => $followed_id,
        ])->fetchCol();
        if ($result) {
            return true;
        }
        return false; // Row does not exist
    }

    public function followers($id)
    {
        return $this->db->query("select follower_id from {$this->table} where following_id=:following_id  and status=:status", [
            'following_id' => $id,
            'status' => 'accepted',
        ])->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function following($id)
    {
        return $this->db->query("select following_id from {$this->table} where follower_id=:follower_id  and status=:status", [
            'follower_id' => $id,
            'status' => 'accepted',
        ])->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function follower_count($id)
    {
        return $this->db->query("select count(*) from {$this->table} where following_id=:following_id and status=:status", [
            'following_id' => $id,
            'status' => 'accepted'
        ])->fetchCol();
    }

    public function following_count($id)
    {
        return $this->db->query("select count(*) from {$this->table} where follower_id=:follower_id  and status=:status", [
            'follower_id' => $id,
            'status' => 'accepted'
        ])->fetchCol();
    }


    public function checkStatus($follower_id, $followed_id)
    {
        return $this->db->query("select status from {$this->table} where follower_id=:follower_id and following_id=:following_id", [
            'follower_id' => $follower_id,
            'following_id' => $followed_id,
        ])->fetch()['status'];
    }

    public function getFollowState($userId, $ownerId): string
    {
        if ($userId === $ownerId) {
            return 'self';
        }

        if (!$this->has_followed($userId, $ownerId)) {
            return 'can_follow';
        }

        return $this->checkStatus($userId, $ownerId) === 'accepted'
            ? 'following'
            : 'pending';
    }
}

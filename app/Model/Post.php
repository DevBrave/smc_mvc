<?php

namespace App\Model;

use Core\Database;

class Post
{

    protected string $table = 'posts';


    public function __construct(
        protected Database $db,
        protected User $user,
    ) {}

    public function all()
    {
        $query = "select * from {$this->table}";
        return $this->db->query($query)->fetchAll();
    }

    public function create($attribute)
    {
        $query = "insert into {$this->table} (user_id,title,body)
            values(:user_id,:title,:body)";

        $this->db->query($query, [
            'user_id' => $attribute['user_id'],
            'title' => $attribute['title'],
            'body' => $attribute['body'],
        ]);

        return $this->db->lastId();
    }

    public function update($attribute)
    {
        $query = "update {$this->table} set title=:title , body=:body where id=:id";
        $this->db->query($query, [
            'id' => $attribute['post_id'],
            'title' => $attribute['title'],
            'body' => $attribute['body'],
        ]);

        return $attribute['post_id'];
    }


    public function delete($id)
    {
        $query = "delete from {$this->table} where id=:id";

        $this->db->query($query, [
            'id' => $id,
        ]);
    }


    public function find($id)
    {
        return $this->db->query("select * from {$this->table} where id=:id", [
            'id' => $id,
        ])->fetch();
    }

    public function user_post($user_id)
    {
        return $this->db->query("select * from {$this->table} where user_id=:user_id", [
            'user_id' => $user_id,
        ])->fetchAll();
    }

    public function post_count($user_id)
    {
        return $this->db->query("select count(*) from {$this->table} where user_id=:user_id", [
            'user_id' => $user_id
        ])->fetchCol();
    }

    public function how_many_posts()
    {
        return $this->db->query("select count(*) from {$this->table}")->fetchCol();
    }

    public function post_created_by($post_id)
    {
        $post = $this->find($post_id);
        return $this->user->find($post['user_id'])['username'];
    }

    //    public static function search($tag, $limit)
    //    {
    //
    //        $params = [];
    //        $where = 'WHERE 1=1';
    //        if ($tag !== '') {
    //            $where .= ' AND EXISTS (SELECT 1 FROM post_tags pt JOIN tags t ON t.id=pt.tag_id WHERE pt.post_id=p.id AND t.slug=?)';
    //            $params[] = $tag;
    //        }
    //        $sql = "SELECT SQL_CALC_FOUND_ROWS p.* FROM posts p $where ORDER BY p.id DESC LIMIT $limit OFFSET $off";
    //        $stmt = DB::pdo()->prepare($sql);
    //        $stmt->execute($params);
    //        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //        $total = (int)DB::pdo()->query("SELECT FOUND_ROWS()")->fetchCol();
    //        return [$rows, $total];
    //
    //    }
}

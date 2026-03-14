<?php

namespace App\Model;

use Core\Database;

class Tag
{


    protected $table = 'tags';

    public function __construct(
        protected Database $db
    ) {}


    public function findOrCreate($name)
    {

        $slug = strtolower(str_replace(' ', '-', $name));

        $tag = $this->db->query("SELECT * FROM tags where slug=:slug", [
            'slug' => $slug
        ])->fetch();
        if (!$tag) {

            $id = $this->db->query("insert into tags (name,slug) values (:name,:slug)", [
                'name' => $name,
                'slug' => $slug
            ])->lastID();
        } else {
            $id = $tag['id'];
        }

        return $id;
    }

    public function findById($tag_id)
    {
        return $this->db->query("select * from tags where id=:tag_id", [
            'tag_id' => $tag_id,
        ])->fetch();
    }

    public function findBySlug($slug)
    {
        return $this->db->query("select * from tags where slug=:slug", [
            'slug' => $slug,
        ])->fetch();
    }

    public function itsPosts($tag_id)
    {
        return $this->db->query("select post_id from post_tag where tag_id=:tag_id", [
            'tag_id' => $tag_id
        ])->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function how_many_posts($tag_id)
    {
        return $this->db->query("select count(*) from post_tag where tag_id=:tag_id ", [
            'tag_id' => $tag_id
        ])->fetchCol();
    }

    public function attach_tags($tags, $post_id)
    {

        foreach ($tags as $tag) {
            $tag_id = $this->findOrCreate(trim($tag));
            $this->db->query('insert into post_tag (post_id,tag_id) values (:post_id,:tag_id)', [
                'post_id' => $post_id,
                'tag_id' => $tag_id
            ]);
        }
    }

    public function tag_associated($post_id, $attr = '*')
    {
        $mode = ($attr !== '*' && !str_contains($attr, ',')) ? \PDO::FETCH_COLUMN : null;
        return $this->db->query("select {$attr} from post_tag where post_id=:post_id", [
            'post_id' => $post_id
        ])->fetchAll($mode);
    }

    public function all()
    {
        return $this->db->query('select * from tags')->fetchAll();
    }

    public function is_attached($post_id, $tags_id)
    {
        $tag_with_post_id = $this->db->query("select * from post_tag  where post_id=:post_id", [
            'post_id' => $post_id,
        ])->fetchAll();

        $new_tag = [];
        $old_tag = [];
        if ($tag_with_post_id != null) {

            foreach ($tag_with_post_id as $tag) {
                if ($tags_id != $tag['tag_id']) {
                    $old_tag[] = $tag['tag_id'];
                }
                if (!in_array($tag['tag_id'], $new_tag)) {
                    $new_tag = $tag;
                }
            }

            dd($old_tag);
        } else {
            $new_tag = $tags_id;
        }


        return $new_tag;
    }
}

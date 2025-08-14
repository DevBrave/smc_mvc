<?php

namespace app\Model;

use Core\App;
use Core\Database;

class Tag
{

    protected $connection = [];
    protected $table = 'tags';

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }


    public static function findOrCreate($name)
    {

        $slug = strtolower(str_replace(' ', '-', $name));

        $tag = App::resolve(Database::class)->query("SELECT * FROM tags where slug=:slug", [
            'slug' => $slug
        ])->fetch();
        if (!$tag) {

            $id = App::resolve(Database::class)->query("insert into tags (name,slug) values (:name,:slug)", [
                'name' => $name,
                'slug' => $slug
            ])->lastID();


        } else {
            $id = $tag['id'];
        }

        return $id;


    }

    public static function findById($tag_id)
    {
        return App::resolve(Database::class)->query("select * from tags where id=:tag_id", [
            'tag_id' => $tag_id,
        ])->fetch();
    }

    public static function findBySlug($slug)
    {
        return App::resolve(Database::class)->query("select * from tags where slug=:slug", [
            'slug' => $slug,
        ])->fetch();
    }

    public static function itsPosts($tag_id)
    {
        return App::resolve(Database::class)->query("select post_id from post_tag where tag_id=:tag_id", [
            'tag_id' => $tag_id
        ])->fetchAll();
    }

    public static function how_many_posts($tag_id)
    {
        return App::resolve(Database::class)->query("select count(*) from post_tag where tag_id=:tag_id ", [
            'tag_id' => $tag_id
        ])->fetchCol();
    }

    public static function attach_tags($tags, $post_id)
    {

        foreach ($tags['name'] as $name) {
            dd($name);
            $tag_id = self::findOrCreate(trim($name));
            App::resolve(Database::class)->query('insert into post_tag(post_id,tag_id) values(:post_id,:tag_id)', [
                'post_id' => $post_id,
                'tag_id' => $tag_id
            ]);
        }


    }

    public static function tag_associated($post_id, $attr = '*')
    {
        return App::resolve(Database::class)->query("select {$attr} from post_tag where post_id=:post_id", [
            'post_id' => $post_id
        ])->fetchAll();
    }

    public static function all()
    {
        return App::resolve(Database::class)->query('select * from tags')->fetchAll();
    }

    public static function is_attached($post_id, $tags_id)
    {
        $tag_with_post_id = App::resolve(Database::class)->query("select * from post_tag  where post_id=:post_id", [
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
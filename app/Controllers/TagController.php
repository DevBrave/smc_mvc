<?php


namespace App\Controllers;


use App\Model\Tag;

class TagController
{

    public function index()
    {
        $tags = Tag::all();
        view('tags/index.view.php', [
            'tags' => $tags,
        ]);
    }
//    public function create(){
//
//        view('admin/tags/create.view.php');
//    }
//    public function store(){
//
//        $attributes = Request::all();
//
//        Tag::findOrCreate($attributes['name']);
//
//        redirect("/admin/tags");
//    }

    public function show($slug)
    {
        $tag_id = Tag::findBySlug($slug)['id'];
        $posts_id = Tag::itsPosts($tag_id);

        view('tags/show.view.php', [
            'posts_id' => $posts_id
        ]);
    }


}
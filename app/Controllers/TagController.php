<?php


namespace App\Controllers;


use App\Model\Post;
use App\Model\Tag;

class TagController
{


    public function __construct(
        protected Post $post,
        protected Tag $tag
    ) {}

    public function index()
    {
        $tags = $this->tag->all();
        view('tags/index.view.php', [
            'tags' => $tags,
            'tagModel' => $this->tag,
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
        $tag_id = $this->tag->findBySlug($slug)['id'];
        $posts_id = $this->tag->itsPosts($tag_id);

        view('tags/show.view.php', [
            'posts_id' => $posts_id,
            'post_model' => $this->post
        ]);
    }
}

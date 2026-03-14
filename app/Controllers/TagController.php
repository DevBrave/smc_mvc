<?php


namespace App\Controllers;

use App\Model\LikePost;
use App\Model\Post;
use App\Model\Tag;

class TagController
{


    public function __construct(
        protected Post $post,
        protected Tag $tag,
        protected LikePost $like_post,
    ) {}

    public function index()
    {

        $tags = $this->tag->all();
        // dd($tags);
        foreach ($tags as $index => $tag) {
            $tags[$index]['postNumber'] =  $this->tag->how_many_posts($tag['id']);
        }
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
        $tag_id = $this->tag->findBySlug($slug)['id'];
        $posts_id = $this->tag->itsPosts($tag_id);
        $all_posts = [];
        foreach ($posts_id as $index => $post_id) {
            $all_posts[$index][] = $this->post->find($post_id);
        }
        dd($all_posts);
        view('tags/show.view.php', [
            'posts_id' => $posts_id,
            'post_model' => $this->post
        ]);
    }
}

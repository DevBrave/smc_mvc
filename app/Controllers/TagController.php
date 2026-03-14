<?php


namespace App\Controllers;

use App\Model\Comment;
use App\Model\LikePost;
use App\Model\Post;
use App\Model\Tag;

class TagController
{


    public function __construct(
        protected Post $post,
        protected Tag $tag,
        protected LikePost $like_post,
        protected Comment $comment,
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
        $tag = $this->tag->findBySlug($slug);
        $posts_id = $this->tag->itsPosts($tag['id']);
        $all_posts = [];
        foreach ($posts_id as $index => $post_id) {
            $post = $this->post->find($post_id);
            if ($post) {
                $post['like_count'] = $this->like_post->like_count($post_id);
                $post['comment_count'] = $this->comment->comment_count($post_id);
                $all_posts[] = $post;
            }
        }
        view('tags/show.view.php', [
            'posts' => $all_posts,
            'tag' => $tag,
        ]);
    }
}

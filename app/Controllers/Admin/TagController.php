<?php


namespace App\Controllers\Admin;

use App\Model\Tag;
use Core\Request;

class TagController
{



    public function __construct(
        protected Tag $tag
    ) {}

    public function index()
    {
        $tags = $this->tag->all();
        $tags_with_posts_count = [];
        foreach ($tags as $index => $tg) {
            $post_count = $this->tag->how_many_posts($tg['id']);
            $tg['posts_count'] = $post_count;
            $tags_with_posts_count[$index] = $tg;
        }
        view('admin/tags/index.view.php', [
            'tags' => $tags_with_posts_count,
        ]);
    }

    public function create()
    {

        view('admin/tags/create.view.php');
    }

    public function store()
    {
        $attributes = Request::all();

        $this->tag->findOrCreate($attributes['name']);

        redirect("/admin/tags");
    }
}

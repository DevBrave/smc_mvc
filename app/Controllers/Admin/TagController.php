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
        view('admin/tags/index.view.php', [
            'tags' => $tags,
            'tagModel' => $this->tag,
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

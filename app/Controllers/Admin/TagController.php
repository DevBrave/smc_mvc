<?php


namespace App\Controllers\Admin;

use App\Model\Tag;
use Core\Request;

class TagController
{

    protected Tag $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

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

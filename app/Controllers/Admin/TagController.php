<?php


namespace App\Controllers\Admin;

use App\Model\Tag;
use Core\Request;

class TagController
{
    public function index()
    {
        $tags = Tag::all();
        view('admin/tags/index.view.php',[
            'tags' => $tags,
        ]);
    }

    public function create(){

        view('admin/tags/create.view.php');
    }
    public function store(){

        $attributes = Request::all();

        Tag::findOrCreate($attributes['name']);

        redirect("/admin/tags");
    }




}
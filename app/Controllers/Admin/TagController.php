<?php


namespace Admin;

use app\Model\Comment;
use app\Model\Tag;
use app\Model\User;
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
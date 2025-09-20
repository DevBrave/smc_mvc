<?php


namespace App\Controllers;

use App\Model\Comment;
use App\Model\Post;
use App\Model\PostImageManager;
use App\Model\Tag;
use App\Model\User;
use Core\App;
use Core\Config;
use Core\Database;
use Core\FileUploader;
use Core\Request;
use Core\Validator;

class PostController
{
    public function index()
    {
        $posts = Post::all();
        view('posts/index.view.php', [
            'posts' => $posts,
        ]);
    }

    public function show($id)
    {
        $post = Post::find($id);
        $comments = Comment::findByPostId($post['id']);
        $images = (PostImageManager::getImageByPostId($post['id'])) ?? null;
        $user = isset($_SESSION['user']) ? (User::findByUsername($_SESSION['user'])) : ['id' => null];
        $tags = Tag::tag_associated($post['id']);


        view('posts/show.view.php', [
            'post' => $post,
            'comments' => $comments,
            'user' => $user,
            'images' => $images,
            'tags' => $tags,
        ]);
    }


    public function create()
    {
        $tags = Tag::all();
        view('posts/create.view.php',[
            'tags' => $tags
        ]);
    }


    public function store()
    {
        $attributes = Request::all();


        Validator::validate([
            'title' => $attributes['title'],
            'body' => $attributes['body'],
        ], [
            'title' => 'required|min:5|max:100',
            'body' => 'required|max:10000',
        ]);


        if (empty($attributes['tags'])){
            $_SESSION['flash_errors']['tag'] = 'Please select at least one tag';
            redirect(previousurl());
        }



        $hasNewImage = false;
        if (PostImageManager::hasNewImage($attributes['images'])) {
            $hasNewImage = true;
            FileUploader::validate($attributes['images'], 'images');
        }
        $post_id = Post::create($attributes);

        if ($hasNewImage){
        $paths = PostImageManager::uploadImages($attributes['images']);
            PostImageManager::attachImages([
                'post_id' => $post_id,
                'images' => $paths,
            ]);
        }
        Tag::attach_tags($attributes['tags'],$post_id);

        unset($_SESSION['flash_errors']);

        redirect('/post/'.$post_id);

    }

    public function destroy($id)
    {
        $images = (PostImageManager::getImageByPostId($id));
        foreach ($images as $img) {

            if (file_exists($img['path'])) {
                unlink($img['path']);
            }
        }

        Post::delete($id);
        redirect('/posts');

    }


    public function edit($id)
    {
        $post = Post::find($id);
        $images = (PostImageManager::getImageByPostId($post['id'])) ?? null;
        $tags = Tag::tag_associated($post['id'],'tag_id');



        view('posts/edit.view.php', [
            'post' => $post,
            'images' => $images,
            'tags' => $tags
        ]);

    }


    public function update()
    {
        $attributes = Request::all();


        // this is for checking csrf
//        if (!Validator::check_csrf($attributes['csrf_token'])) {
//            dd('here');
//        }


//        unset($_SESSION['csrf_token']);


        Validator::validate([
            'title' => $attributes['title'],
            'body' => $attributes['body'],
        ], [
            'title' => 'required|min:5|max:100',
            'body' => 'required|max:10000',
        ]);

        if (empty($attributes['tags'])){
            $_SESSION['flash_errors']['tag'] = 'Please select at least one tag';
            redirect(previousurl());
        }

        $hasNewImage = false;
        $paths = [];
        if (PostImageManager::hasNewImage($attributes['images'])) {
            $hasNewImage = true;
            FileUploader::validate($attributes['images'], 'images');

        }

        // add new images
        if ($hasNewImage) {
            $paths = PostImageManager::uploadImages($attributes['images']);

        }


        $post_id = Post::update($attributes);

        if ($hasNewImage) {

            PostImageManager::deleteAttachedImages($post_id);

            PostImageManager::updateAttachedImages([
                'post_id' => $post_id,
                'images' => $paths
            ]);
        }



        $newTagsId = $attributes['tags'];


        $associatedCurrentTag = App::resolve(Database::class)->query('select * from post_tag where post_id=:post_id',[
          'post_id' => $post_id
        ])->fetchAll();

        $currentTagId = array_column($associatedCurrentTag, 'tag_id');



        $tagsToRemove = array_diff($currentTagId, $newTagsId);
        $tagsToAdd    = array_diff($newTagsId, $currentTagId);

        if ($tagsToRemove) {
            $in = implode(',', array_fill(0, count($tagsToRemove), '?'));
            $params = array_merge([$post_id], $tagsToRemove);

            App::resolve(Database::class)->query("delete from post_tag where post_id = ? and tag_id in ($in)",$params);
        }


        if ($tagsToAdd) {
            foreach ($tagsToAdd as $tagId) {
                $params = [$post_id, $tagId];
            }

           App::resolve(Database::class)->query("insert into  post_tag (post_id, tag_id) VALUES (?, ?)",$params);

        }


        unset($_SESSION['flash_errors']);
        redirect('/posts');


    }


}
<?php


namespace App\Controllers;

use App\Model\Comment;
use App\Model\LikePost;
use App\Model\Post;
use App\Model\PostImageManager;
use App\Model\Services\PostService;
use App\Model\Tag;
use App\Model\User;
use App\Model\LikeComment;
use App\Model\Follow;
use Core\Database;
use Core\FileUploader;
use Core\Request;
use Core\Validator;

class PostController
{
    protected Database $db;
    protected PostService $postService;
    protected Post $post;
    protected User $user;
    protected Comment $comment;
    protected LikePost $likePost;
    protected Tag $tag;
    protected LikeComment $likeComment;
    protected Follow $follow;

    public function __construct(Database $db, PostService $postService, Post $post, User $user, Comment $comment, LikePost $likePost, Tag $tag, LikeComment $likeComment, Follow $follow)
    {

        $this->db = $db;
        $this->postService = $postService;
        $this->post = $post;
        $this->user = $user;
        $this->comment = $comment;
        $this->likePost = $likePost;
        $this->tag = $tag;
        $this->likeComment = $likeComment;
        $this->follow = $follow;
    }

    public function index()
    {
        $posts = $this->post->all();

        $postsData = array_map(function ($post) {
            $post['author'] = $this->user->find($post['user_id']);
            $post['like_count'] = $this->likePost->like_count($post['id']);
            $post['comment_count'] = $this->comment->comment_count($post['id']);
            return $post;
        }, $posts);

        view('posts/index.view.php', [
            'posts' => $postsData,
            'userModel' => $this->user, // In case view needs it for checking permissions
        ]);
    }

    public function show($id)
    {
        $post = $this->post->find($id);
        $comments = $this->comment->findByPostId($post['id']);
        $images = (PostImageManager::getImageByPostId($post['id'])) ?? null;
        $currentUser = isset($_SESSION['user']) ? ($this->user->findByUsername($_SESSION['user'])) : ['id' => null];
        $tags = $this->tag->tag_associated($post['id']);

        view('posts/show.view.php', [
            'post' => $post,
            'comments' => $comments,
            'currentUser' => $currentUser,
            'userModel' => $this->user,
            'commentModel' => $this->comment,
            'tagModel' => $this->tag,
            'likePostModel' => $this->likePost,
            'likeCommentModel' => $this->likeComment,
            'followModel' => $this->follow,
            'images' => $images,
            'tags' => $tags,
        ]);
    }


    public function create()
    {
        $tags = $this->tag->all();
        view('posts/create.view.php', [
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

        if (empty($attributes['tags'])) {
            $_SESSION['flash_errors']['tag'] = 'Please select at least one tag';
            redirect(previousurl());
        }

        $hasImages = false;
        if (PostImageManager::hasNewImage($attributes['images'])) {
            $hasImages = true;
            FileUploader::validate($attributes['images'], 'images');
        }

        try {
            $post_id = $this->postService->createPost($attributes, $hasImages);
            unset($_SESSION['flash_errors']);
            redirect('/post/' . $post_id);
        } catch (\Exception $e) {
            $_SESSION['flash_errors']['general'] = 'Something went wrong while saving the post. Please try again.';
            redirect(previousurl());
        }
    }

    public function destroy($id)
    {
        $images = (PostImageManager::getImageByPostId($id));
        foreach ($images as $img) {

            if (file_exists($img['path'])) {
                unlink($img['path']);
            }
        }

        $this->post->delete($id);
        redirect('/posts');
    }


    public function edit($id)
    {
        $post = $this->post->find($id);
        $images = (PostImageManager::getImageByPostId($post['id'])) ?? null;
        $tags = $this->tag->tag_associated($post['id'], 'tag_id');


        view('posts/edit.view.php', [
            'post' => $post,
            'images' => $images,
            'tags' => $tags
        ]);
    }


    public function update()
    {
        $attributes = Request::all();

        Validator::validate([
            'title' => $attributes['title'],
            'body' => $attributes['body'],
        ], [
            'title' => 'required|min:5|max:100',
            'body' => 'required|max:10000',
        ]);

        if (empty($attributes['tags'])) {
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


        $post_id = $this->post->update($attributes);

        if ($hasNewImage) {

            PostImageManager::deleteAttachedImages($post_id);

            PostImageManager::updateAttachedImages([
                'post_id' => $post_id,
                'images' => $paths
            ]);
        }


        $newTagsId = $attributes['tags'];


        $associatedCurrentTag = $this->db->query('select * from post_tag where post_id=:post_id', [
            'post_id' => $post_id
        ])->fetchAll();

        $currentTagId = array_column($associatedCurrentTag, 'tag_id');


        $tagsToRemove = array_diff($currentTagId, $newTagsId);
        $tagsToAdd = array_diff($newTagsId, $currentTagId);

        if ($tagsToRemove) {
            $in = implode(',', array_fill(0, count($tagsToRemove), '?'));
            $params = array_merge([$post_id], $tagsToRemove);

            $this->db->query("delete from post_tag where post_id = ? and tag_id in ($in)", $params);
        }


        if ($tagsToAdd) {
            foreach ($tagsToAdd as $tagId) {
                $params = [$post_id, $tagId];
            }

            $this->db->query("insert into  post_tag (post_id, tag_id) VALUES (?, ?)", $params);
        }


        unset($_SESSION['flash_errors']);
        redirect('/posts');
    }
}

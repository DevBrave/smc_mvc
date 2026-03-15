<?php

namespace App\Controllers\Api;

use App\Model\Tag;
use App\Model\Post;
use App\Model\LikePost;
use App\Model\Comment;

class TagController
{
    public function __construct(
        protected Tag $tag,
        protected Post $post,
        protected LikePost $like_post,
        protected Comment $comment
    ) {}

    /**
     * Get all tags (Equivalent to the index method)
     * GET /api/tags
     */
    public function index()
    {
        // 1. Get the data from the model (just like the normal controller)
        $tags = $this->tag->all();
        
        foreach ($tags as $index => $tag) {
            $tags[$index]['postNumber'] = $this->tag->how_many_posts($tag['id']);
        }

        // 2. Instead of calling view(), we format it as a clean JSON response
        header('Content-Type: application/json');
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Tags retrieved successfully.',
            'data' => $tags
        ]);
        
        exit(); // Stop further execution so no HTML accidentally prints
    }

    /**
     * Get a specific tag with its posts (Equivalent to the show method)
     * GET /api/tags/{slug}
     */
    public function show($slug)
    {
        $tag = $this->tag->findBySlug($slug);
        
        // Error Handling: In an API, if the tag doesn't exist, we send a 404 response
        if (!$tag) {
            header('Content-Type: application/json');
            http_response_code(404); // Important: Tell the client it's not found
            echo json_encode([
                'status' => 'error',
                'message' => 'Tag not found'
            ]);
            exit();
        }

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

        // 3. Return the single tag and its posts as JSON
        header('Content-Type: application/json');
        
        echo json_encode([
            'status' => 'success',
            'data' => [
                'tag' => $tag,
                'posts' => $all_posts
            ]
        ]);
        
        exit();
    }
}

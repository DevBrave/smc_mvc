<?php

namespace App\Model\Services;

use App\Model\Follow;
use App\Model\NotificationService;
use App\Model\Post;
use App\Model\PostImageManager;
use App\Model\Tag;
use Core\Database;

class PostService
{
    public function __construct(
        protected Database $db,
        protected Post $post,
        protected Tag $tag,
        protected Follow $follow,
        protected NotificationService $notifService,
        protected PostImageManager $postImageManagerModel,
    ) {}

    /**
     * Create a post with images, tags, and notifications — all in one transaction.
     * Returns the new post ID on success.
     * Throws an exception on failure (rolls back + cleans up uploaded files).
     */
    public function createPost(array $attributes, bool $hasImages): int
    {
        $paths = [];

        $this->db->beginTransaction();
        try {
            $post_id = $this->post->create($attributes);

            // Notify followers
            $followers = $this->follow->followers(auth()->user()['id']);
            if (count($followers) != 0) {
                $this->notifService->createOrBump('create_post', $followers, $attributes['user_id'], 'post', $post_id);
            }

            // Upload and attach images
            if ($hasImages) {
                $paths = $this->postImageManagerModel->uploadImages($attributes['images']);
                $this->postImageManagerModel->attachImages([
                    'post_id' => $post_id,
                    'images' => $paths,
                ]);
            }

            // Attach tags
            $this->tag->attach_tags($attributes['tags'], $post_id);

            $this->db->commit();

            return $post_id;
        } catch (\Exception $e) {
            $this->db->rollBack();

            // Clean up any uploaded files
            foreach ($paths as $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            throw $e; // re-throw so the controller can handle the redirect
        }
    }
}

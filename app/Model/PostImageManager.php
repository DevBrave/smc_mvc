<?php

namespace App\Model;

use Core\App;
use Core\Config;
use Core\Database;
use Core\FileUploader;

class PostImageManager
{


    protected $table = 'post_images';

    public function __construct(
        protected Database $db,
    ) {}

    public function uploadImages($images)
    {

        return FileUploader::multipleUpload($images, 'posts');
    }

    public function attachImages($attributes)
    {


        $query = "insert into $this->table (post_id,path)
            values(:post_id,:path)";

        foreach ($attributes['images'] as $image) {

            $this->db->query($query, [
                'post_id' => $attributes['post_id'],
                'path' => $image,
            ]);
        }
    }


    public function updateAttachedImages($attributes)
    {
        foreach ($attributes['images'] as $path) {
            $this->db->query("INSERT INTO post_images (post_id, path) VALUES (:post_id, :path)", [
                'post_id' => $attributes['post_id'],
                'path' => $path
            ]);
        }
    }

    public function deleteAttachedImages($post_id)
    {
        $images = $this->db->query("select path from post_images where post_id=:post_id", [
            'post_id' => $post_id
        ])->fetchAll();

        foreach ($images as $img) {
            if (!empty($img['path']) && file_exists($img['path'])) {
                unlink($img['path']);
            }
        }

        $this->db->query("delete from post_images WHERE post_id = :post_id", [
            'post_id' => $post_id
        ]);
    }

    public function getImageByPostId($post_id)
    {
        return $this->db->query("select * from  post_images where post_id=:post_id", [
            'post_id' => $post_id,
        ])->fetchAll();
    }

    public function hasNewImage($file)
    {
        if ($file['name'][0] == null) {
            return false;
        }
        return true;
    }
}

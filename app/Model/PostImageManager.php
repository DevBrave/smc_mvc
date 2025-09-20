<?php

namespace App\Model;

use Core\App;
use Core\Config;
use Core\Database;
use Core\FileUploader;

class PostImageManager
{

    protected $connection = [];
    protected $table = 'post_images';

    public function __construct()
    {
        $this->connection = App::resolve(Database::class);
    }

    public static function uploadImages($images)
    {

        return FileUploader::multipleUpload($images,'posts');

    }

    public static function attachImages($attributes)
    {
        $instantiate = new static();

        $query = "insert into $instantiate->table (post_id,path)
            values(:post_id,:path)";

        foreach ($attributes['images'] as $image) {

            $instantiate->connection->query($query, [
                'post_id' => $attributes['post_id'],
                'path' => $image,
            ]);

        }
    }


    public static function updateAttachedImages($attributes)
    {
        foreach ($attributes['images'] as $path) {
            App::resolve(Database::class)->query("INSERT INTO post_images (post_id, path) VALUES (:post_id, :path)", [
                'post_id' => $attributes['post_id'],
                'path' => $path
            ]);
        }
    }

    public static function deleteAttachedImages($post_id)
    {
        $images = App::resolve(Database::class)->query("select path from post_images where post_id=:post_id", [
            'post_id' => $post_id
        ])->fetchAll();

        foreach ($images as $img) {
            if (!empty($img['path']) && file_exists($img['path'])) {
                unlink($img['path']);
            }
        }

        App::resolve(Database::class)->query("delete from post_images WHERE post_id = :post_id", [
            'post_id' => $post_id
        ]);

    }

    public static function getImageByPostId($post_id)
    {
        return App::resolve(Database::class)->query("select * from  post_images where post_id=:post_id", [
            'post_id' => $post_id,
        ])->fetchAll();
    }

    public static function hasNewImage($file)
    {
        if ($file['name'][0] == null){
            return false;
        }
        return true;
    }


}
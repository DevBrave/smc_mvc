<?php
// run_test.php
$baseDir = __DIR__;

// Setup environment for testing
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['HTTP_REFERER'] = 'http://localhost/post/create';
$_SERVER['REQUEST_URI'] = '/post/create';

const BASE_PATH = __DIR__ . '/';
require(BASE_PATH . 'vendor/autoload.php');
require(BASE_PATH . 'helpers/functions.php');
session_start();
$_SESSION['user'] = 'admin'; // Based on seed.php

require(BASE_PATH . 'bootstrap.php');

use App\Controllers\PostController;
use App\Model\User;
use App\Model\Post;
use Core\Database;
use Core\App;

$user = User::findByUsername('admin');
if (!$user) {
    die("Error: Admin user not found. Run seed.php first.\n");
}

echo "Starting post creation test...\n";

// Setup tags (make sure we have at least one tag)
$db = App::resolve(Database::class);
$tag = $db->query("SELECT id FROM tags LIMIT 1")->fetch();
if (!$tag) {
    echo "No tags found, inserting a test tag...\n";
    $db->query("INSERT INTO tags (name, slug) VALUES ('Test Tag', 'test-tag')");
    $tagId = $db->lastInsertId();
} else {
    $tagId = $tag['id'];
}

$countBefore = count(Post::all());
echo "Total posts before: $countBefore\n";

$_POST = [
    'title' => 'Test Post From CLI ' . time(),
    'body' => 'This is an automated test post to check if post creation works correctly and generates logs.',
    'tags' => [$tagId],
    'user_id' => $user['id'],
];
$_FILES = []; // No images

// We will trap the redirect header and exit to see what happened.
register_shutdown_function(function () use ($countBefore) {
    $countAfter = count(\App\Model\Post::all());
    echo "Total posts after: $countAfter\n";
    if ($countAfter > $countBefore) {
        echo "Post created successfully!\n";
    } else {
        echo "Post creation failed or no new post was added.\n";
    }

    $headers = headers_list();
    if (!empty($headers)) {
        echo "Headers sent:\n";
        print_r($headers);
    }

    if (isset($_SESSION['flash_errors']) && !empty($_SESSION['flash_errors'])) {
        echo "Validation Errors:\n";
        print_r($_SESSION['flash_errors']);
    }
});

echo "Calling PostController::store()...\n";

$controller = new PostController();
$controller->store();

echo "Returned from store (this shouldn't print because of redirect/exit).\n";

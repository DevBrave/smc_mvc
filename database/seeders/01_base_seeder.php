<?php

/** @var \Core\Database $db */

// Create standard testing users
$password = password_hash('password', PASSWORD_BCRYPT);

try {
    $db->connection->exec("
        INSERT INTO `users` (`username`, `first_name`, `last_name`, `email`, `password`, `role`) 
        VALUES 
        ('admin', 'Admin', 'User', 'admin@example.com', '$password', 'admin'),
        ('testuser', 'Test', 'User', 'testuser@example.com', '$password', 'user')
    ");

    $adminId = $db->connection->lastInsertId();

    // Create some base tags
    $db->connection->exec("
        INSERT INTO `tags` (`name`, `slug`) 
        VALUES 
        ('Technology', 'technology'),
        ('Life', 'life'),
        ('Coding', 'coding')
    ");

    // Create a base post
    $db->connection->exec("
        INSERT INTO `posts` (`user_id`, `title`, `body`) 
        VALUES 
        ($adminId, 'Hello World', 'This is the very first post on this platform!')
    ");

    $postId = $db->connection->lastInsertId();

    // Attach a tag to the post
    $db->connection->exec("
        INSERT INTO `post_tag` (`post_id`, `tag_id`) 
        VALUES 
        ($postId, 1),
        ($postId, 3)
    ");
} catch (\Exception $e) {
    if ($e->getCode() == 23000) {
        // Unique constraint violation - means seeder ran before, we can just ignore
        echo " (Data already exists) ";
    } else {
        throw $e;
    }
}

<?php

/** @var \Core\Database $db */



require(BASE_PATH . '/vendor/autoload.php');  // autoload with composer


$faker = Faker\Factory::create();

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
    $testuserId = $adminId + 1; // It was inserted immediately after admin, so +1

    // Generate 10 fake users
    $userIds = [$adminId, $testuserId];
    for ($i = 0; $i < 5; $i++) {
        $db->query("INSERT INTO `users` (`username`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES (:username, :first_name, :last_name, :email, :password, 'user')", [
            'username' => $faker->unique()->userName,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'password' => $password,
        ]);
        $userIds[] = $db->connection->lastInsertId();
    }

    // Create some base tags
    $db->connection->exec("
        INSERT INTO `tags` (`name`, `slug`) 
        VALUES 
        ('Technology', 'technology'),
        ('Life', 'life'),
        ('Coding', 'coding')
    ");

    $tagIds = [1, 2, 3]; // We know these are 1, 2, 3 on fresh migrations

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

    $postIds = [$postId];

    // Generate 50 fake posts
    for ($i = 0; $i < 5; $i++) {
        $db->query("INSERT INTO `posts` (`user_id`, `title`, `body`, `created_at`) VALUES (:user_id, :title, :body, :created_at)", [
            'user_id' => $faker->randomElement($userIds),
            'title' => $faker->sentence,
            'body' => $faker->paragraphs(3, true),
            'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
        ]);

        $newPostId = $db->connection->lastInsertId();
        $postIds[] = $newPostId;

        // Attach random tags
        $numTags = random_int(1, 3);
        $randomTags = $faker->randomElements($tagIds, $numTags);
        foreach ($randomTags as $tagId) {
            $db->query("INSERT INTO `post_tag` (`post_id`, `tag_id`) VALUES (:post_id, :tag_id)", [
                'post_id' => $newPostId,
                'tag_id' => $tagId,
            ]);
        }
    }

    // Generate 100 fake comments
    for ($i = 0; $i < 10; $i++) {
        $db->query("INSERT INTO `comments` (`user_id`, `post_id`, `body`, `status`, `created_at`) VALUES (:user_id, :post_id, :body, 1, :created_at)", [
            'user_id' => $faker->randomElement($userIds),
            'post_id' => $faker->randomElement($postIds),
            'body' => $faker->paragraph,
            'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
        ]);
    }
} catch (\Exception $e) {
    if ($e->getCode() == 23000) {
        // Unique constraint violation - means seeder ran before, we can just ignore
        echo " (Data already exists) ";
    } else {
        throw $e;
    }
}

<?php

use Core\Router;


layout('header.php');
?>

<?php
layout('nav.php');
?>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">

    </div>

    <!-- views/users/profile.view.php -->

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-lg">
        <div class="flex flex-col md:flex-row items-center md:items-start md:space-x-6">
            <!-- Avatar -->
            <img
                    src="/<?= $user['avatar'] != null ? $user['avatar'] : 'assets/img/avatar.jpg' ?> "
                    alt="User Avatar"
                    class="w-25 h-20 rounded-full object-cover border border-gray-300">

            <!-- User Info -->
            <div class="mt-4 md:mt-0 text-center md:text-left space-y-2">
                <h2 class="text-2xl font-bold text-gray-800">
                    <?= htmlspecialchars($user['username']) ?>
                </h2>
                <p class="text-sm text-gray-500">
                    Joined: <?= date('F j, Y', strtotime($user['reg_date'])) ?>
                </p>
                <p class="text-gray-700">
                    bio : <?= nl2br(htmlspecialchars($user['bio'])) ?><span class="text-gray-400 italic"></span>
                </p>
                <p class="text-gray-700">
                    FullName : <?= $user['first_name'] . ' ' . $user['last_name'] ?><span
                            class="text-gray-400 italic"></span>
                </p>
            </div>
        </div>

        <!-- Stats and Actions -->
        <div class="mt-6 border-t pt-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Stats -->
            <div class="text-center md:text-left">
                <p class="text-sm text-gray-500">Total Posts</p>
                <p class="text-xl font-semibold text-blue-600"><?= $post_count ?? 0 ?></p>

            </div>
            <div class="text-center md:text-left">
                <p class="text-sm text-gray-500">Follower</p>
                <p class="text-xl font-semibold text-blue-600"><?= $follower_count ?? 0 ?></p>

            </div>
            <div class="text-center md:text-left">
                <p class="text-sm text-gray-500">Following</p>
                <p class="text-xl font-semibold text-blue-600"><?= $following_count ?? 0 ?></p>

            </div>

            <!-- Buttons -->
            <div class="flex space-x-4">
                <?php if ($post_count != 0): ?>
                    <a href="/user/posts/<?= $user['username'] ?>"
                       class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg shadow">
                        My Posts
                    </a>
                <?php endif; ?>
                <a href="/user/followers/<?= $user['username'] ?>"
                   class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg shadow">
                    Followers
                </a>
                <a href="/user/following/<?= $user['username'] ?>"
                   class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg shadow">
                    Following
                </a>
                <a href="/user/edit/<?= $user['username'] ?>"
                   class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow">
                    Edit Profile
                </a>
                <form action="/logout" method="POST">
                    <?= csrf_input() ?>
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>

<?php
layout('footer.php');
?>
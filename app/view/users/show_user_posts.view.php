<?php

use App\Model\Comment;
use App\Model\LikePost;
use App\Model\User;

layout('header.php');
?>

<?php
layout('nav.php');
?>

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-lg">
        <div class="mt-4 md:mt-0 text-center md:text-left space-y-2">
            <h2 class="text-2xl font-bold text-gray-800">My Posts</h2>
        </div>
        <?php foreach ($posts as $post): ?>
            <div class="mt-12">     <!-- Post Card -->
                <div class="flex gap-4 border-b pb-6">

                    <div class="flex-1 space-y-2">
                        <h2 class="font-bold text-lg text-gray-900 hover:text-blue-600 cursor-pointer">
                            <a href="/post/<?= $post['id'] ?>"><?= $post['title'] ?></a>
                        </h2>

                        <p class="text-sm text-gray-700 leading-snug line-clamp-2">
                            <?= $post['body'] ?>
                        </p>


                        <div class="flex items-center gap-6 mt-2 text-sm text-gray-600">

                            <div class="flex items-center gap-1">
                                <?= '❤️' . LikePost::like_count($post['id']) ?>
                            </div>
                            <div class="flex items-center gap-1">
                                <?= '💬' . Comment::comment_count($post['id']) ?>
                            </div>
                            <div class="flex items-center gap-1">
                                <?php if (isset($_SESSION['user']) && $post['user_id'] == (User::findByUsername($_SESSION['user']))['id']): ?>
                                    <a href="/post/edit/<?= $post['id'] ?>"
                                       class="inline-flex rounded bg-indigo-600 px-3 py-1.5 text-white text-sm font-semibold shadow-md hover:bg-indigo-700 transition duration-200">
                                        Edit
                                    </a>
                                    <form action="/post/<?= $post['id'] ?>" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="inline-flex rounded bg-indigo-600 px-3 py-1.5 text-white text-sm font-semibold shadow-md hover:bg-indigo-700 transition duration-200"
                                                type="submit">
                                            Delete
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <a href="/post/<?= $post['id'] ?>"
                                   class="inline-flex rounded bg-indigo-600 px-3 py-1.5 text-white text-sm font-semibold shadow-md hover:bg-indigo-700 transition duration-200">
                                    Open
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>

    </div>
<?php
layout('footer.php');
?>
<?php

layout('header.php');
?>

<?php
layout('nav.php');
?>

<div class="flex  flex-col justify-center px-6 py-5  lg:px-20">
    <?php foreach ($posts as $post): ?>
        <div class="mt-12"> <!-- Post Card -->
            <div class="flex gap-4 border-b pb-6">

                <div class="flex-1 space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <span class="font-medium text-gray-800"><?= $post['author']['first_name'] ?></span>
                        <span>·</span>
                        <span>10 months ago</span>
                    </div>

                    <h2 class="font-bold text-lg text-gray-900 hover:text-blue-600 cursor-pointer">
                        <a href="/post/<?= $post['id'] ?>"><?= $post['title'] ?></a>
                    </h2>

                    <p class="text-sm text-gray-700 leading-snug line-clamp-2">
                        <?= $post['body'] ?>
                    </p>

                    <div class="flex items-center gap-6 mt-2 text-sm text-gray-600">
                        <div class="flex items-center gap-1">
                            <?= $post['like_count'] != 0 ? '❤️' . $post['like_count']  : '❤️ 0'  ?>
                        </div>

                        <div class="flex items-center gap-1">
                            <?= $post['comment_count'] != 0 ? '💬' . $post['comment_count'] : '💬 0'  ?>
                        </div>
                        <div class="flex items-center gap-1">
                            <?php if (isset($_SESSION['user']) && $post['user_id'] == ($userModel->findByUsername($_SESSION['user']))['id']): ?>
                                <a href="/post/edit/<?= $post['id'] ?>"
                                    class="inline-flex rounded bg-indigo-600 px-2 py-1 text-white text-sm font-semibold shadow-md hover:bg-indigo-700 transition duration-200">
                                    Edit
                                </a>
                                <form action="/post/<?= $post['id'] ?>" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="inline-flex rounded bg-indigo-600 px-2 py-1 text-white text-sm font-semibold shadow-md hover:bg-indigo-700 transition duration-200"
                                        type="submit">
                                        Delete
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php endforeach; ?>
    <div class="max-w-4xl mx-auto mt-10">
        <a href="/post/create"
            class="inline-flex rounded bg-indigo-600 px-6 py-3 text-white text-sm font-semibold shadow-md hover:bg-indigo-700 transition duration-200">
            Create
        </a>
    </div>

</div>

<?php
layout('footer.php');
?>
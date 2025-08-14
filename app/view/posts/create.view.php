<?php

use app\Model\User;

layout('header.php');
$user = User::findByUsername($_SESSION['user'], 'id');
?>

<?php
layout('nav.php');
?>

    <div class="flex min-h-full flex-col justify-center px-6 py-5  lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">New Post</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="/post/create" method="POST" enctype="multipart/form-data">
                <?= csrf_input() ?>
                <div>
                    <?php if (isset($_SESSION['flash_errors'])): ?>
                        <?php foreach ($_SESSION['flash_errors'] as $error): ?>
                            <p class="text-xs text-red-600"><?= $error ?> </p>
                        <?php endforeach; endif; ?>
                    <div class="mt-2">
                        <input type="file" name="images[]" multiple>
                    </div>
                    <div class="mt-2">
                        <label for="title" class="block text-sm/6 font-medium text-gray-900">Tags</label>
                        <select  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1
                         outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" name="tags[]" id="tags" multiple>
                            <?php foreach ($tags as $tag): ?>
                                <option value="<?= $tag['slug'] ?>"> <?= $tag['name'] ?> </option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="mt-2">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <label for="title" class="block text-sm/6 font-medium text-gray-900">Title</label>
                        <input type="text" name="title" id="title" autocomplete="title" required
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                    <div class="mt-2">
                        <label for="body" name="body"
                               class="block text-sm/6 font-medium text-gray-900">Description</label>
                        <textarea
                                id="description"
                                name="body"
                                rows="5"
                                placeholder="Write a brief description of your post..."
                                class="w-full rounded-xl border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 shadow-sm p-3 text-sm text-gray-800 resize-y placeholder-gray-400 transition duration-150 ease-in-out"
                        ></textarea>
                    </div>
                </div>
                <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Create
                </button>
            </form>
        </div>
    </div>
<?php
layout('footer.php');
?>
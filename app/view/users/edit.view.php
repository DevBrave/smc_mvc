<?php

layout('header.php');
?>

<?php
layout('nav.php');
?>
    <div class="flex min-h-full flex-col justify-center px-6 py-5  lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Edit your Info</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="/user/edit/<?= $user['username'] ?>" method="POST"
                  enctype="multipart/form-data">
                <?= csrf_input() ?>
                <div>
                    <?php if (isset($_SESSION['flash_errors'])): ?>
                        <?php foreach ($_SESSION['flash_errors'] as $error): ?>
                            <p class="text-xs text-red-600"><?= $error ?></p>
                        <?php endforeach; endif; ?>
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="mt-2 flex flex-col items-center">
                        <div class="w-25 h-20 flex justify-center">
                            <img
                                    src="/<?= $user['avatar'] != null ? $user['avatar'] : 'assets/img/avatar.jpg' ?> "
                                    alt="User Avatar"
                                    class="rounded-full object-cover border border-gray-300">
                        </div>
                        <label for="avatar" class="block text-sm/6 font-medium text-gray-900">Edit your Avatar</label>
                        <div class="mt-2 w-full">
                            <input type="file" name="avatar" id="avatar" autocomplete="avatar"
                                   value="<?= $user['avatar'] ?>"
                                   class="block w-full rounded-md bg-white px-3
                                    py-1.5 text-base text-gray-900 outline-1
                                     -outline-offset-1 outline-gray-300 placeholder:text-gray-400
                                     focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="username" class="block text-sm/6 font-medium text-gray-900">Username</label>
                        <input type="text" name="username" id="username" autocomplete="username" required
                               value="<?= $user['username'] ?>"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div>
                    <div class="mt-2">
                        <label for="first_name" class="block text-sm/6 font-medium text-gray-900">First Name</label>
                        <input type="text" name="first_name" id="first_name" autocomplete="first_name" required
                               value="<?= $user['first_name'] ?>"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div>
                    <div class="mt-2">
                        <label for="last_name" class="block text-sm/6 font-medium text-gray-900">Last Name</label>
                        <input type="text" name="last_name" id="last_name" autocomplete="last_name" required
                               value="<?= $user['last_name'] ?>"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                    <div class="mt-2">
                        <label for="privacy" class="block text-sm/6 font-medium text-gray-900">Privacy</label>
                        <select class="form-select" id="privacy" name="status">
                            <option value="public" <?= $user['status'] == 'public' ? 'selected' : '' ?>>Public</option>
                            <option value="private" <?= $user['status'] == 'private' ? 'selected' : '' ?>  >Private</option>
                        </select>
                         </div>
                </div>
                <div class="mt-2">

                    <label for="bio" name="bio"
                           class="block text-sm/6 font-medium text-gray-900">Bio</label>
                    <?php if ($user['bio'] == null) : ?>

                        <textarea
                                id="description"
                                name="bio"
                                rows="2"
                                placeholder="<?= 'My bio still empty and no one does not know me' ?>"
                                class="w-full rounded-xl border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 shadow-sm p-3 text-sm text-gray-800 resize-y placeholder-gray-400 transition duration-150 ease-in-out"

                        ></textarea>

                    <?php else: ?>
                        <textarea
                                id="description"
                                name="bio"
                                rows="2"
                                placeholder=""
                                class="w-full rounded-xl border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 shadow-sm p-3 text-sm text-gray-800 resize-y placeholder-gray-400 transition duration-150 ease-in-out"

                        ><?= nl2br(htmlspecialchars($user['bio'])) ?></textarea>
                    <?php endif; ?>
                </div>
                <div>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow">
                        Edit
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php
layout('footer.php');
?>
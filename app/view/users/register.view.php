<?php

layout('header.php');
?>

<?php
layout('nav.php');
?>
    <script>
        window.onload = function () {
            fetch('fake_user_data.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('username').value = data.username;
                    document.getElementById('first_name').value = data.first_name;
                    document.getElementById('last_name').value = data.last_name;
                    document.getElementById('email').value = data.email;
                    document.getElementById('password').value = data.password;
                    document.getElementById('confirmation_password').value = data.confirmation_password;
                });
        };
    </script>
    <div class="flex min-h-full flex-col justify-center px-6 py-5  lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Register a new account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="/register" method="POST" enctype="multipart/form-data">
                <?= csrf_input() ?>
                <div>
                    <label for="avatar" class="block text-sm/6 font-medium text-gray-900">choose your Avatar</label>
                    <div class="mt-2">
                        <input type="file" name="avatar" id="avatar" autocomplete="avatar" required
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div>
                <?php if (isset($_SESSION['flash_errors'])): ?>
                <?php foreach ($_SESSION['flash_errors'] as $error): ?>
                        <p class="text-xs text-red-600"><?= $error  ?> </p>
                <?php endforeach; endif; ?>
                    <label for="username" class="block text-sm/6 font-medium text-gray-900">Username</label>
                    <div class="mt-2">
                        <input type="text" name="username" id="username" autocomplete="username" required
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div>
                    <label for="first_name" class="block text-sm/6 font-medium text-gray-900">First Name</label>
                    <div class="mt-2">
                        <input type="text" name="first_name" id="first_name" autocomplete="first_name" required
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div>
                    <label for="last_name" class="block text-sm/6 font-medium text-gray-900">Last Name</label>
                    <div class="mt-2">
                        <input type="text" name="last_name" id="last_name" autocomplete="last_name" required
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" autocomplete="email" required
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input type="password" name="password" id="password" autocomplete="current-password" required
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="confirmation_password" class="block text-sm/6 font-medium text-gray-900">Confirmation
                            Password</label>
                    </div>
                    <div class="mt-2">
                        <input type="password" name="confirmation_password" id="confirmation_password"
                               autocomplete="confirmation_password" required
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php
layout('footer.php');
?>
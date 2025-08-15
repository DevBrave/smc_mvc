<?php

use app\Model\Comment;
use app\Model\LikePost;
use app\Model\User;

layout('header.php');
?>

<?php
layout('nav.php');
?>

    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-lg">
            <div class="mt-4 md:mt-0 text-center md:text-left space-y-2">
                <h2 class="text-2xl font-bold text-gray-800">My <?= $title  ?></h2>
            </div>
        <?php foreach ($follows as $follow):   ?>
            <div class="mt-12">     <!-- Post Card -->
                <div class="flex gap-4 border-b pb-6">

                    <div class="flex-1 space-y-2">
                        <table class="table table-bordered m-4">

                            <tbody>

                                <tr class="align-middle">

                                    <td>
                                        <img
                                                src="/<?= user($follow)['avatar'] != null ? user($follow)['avatar'] : 'assets/img/avatar.jpg' ?> "
                                                alt="User Avatar"
                                                class="w-25 h-20 rounded-full object-cover border border-gray-300">
                                    </td>
                                    <td>
                                        <?= \user($follow)['username'] ?>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>

    </div>
<?php
layout('footer.php');
?>
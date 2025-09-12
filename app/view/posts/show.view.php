<?php

use app\Model\Comment;
use app\Model\Follow;
use app\Model\LikeComment;
use app\Model\LikePost;
use app\Model\Tag;
use app\Model\User;

layout('header.php');
$owner = User::find($post['user_id']);

?>

<?php
layout('nav.php');
?>

    <div class="flex min-h-full flex-col justify-center px-6 py-5  lg:px-8">


        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Powered
                by <?= $owner['username'] ?>
            </h2>
        </div>


        <div class="max-w-3xl mx-auto px-4 py-8">
            <article class="bg-white shadow-xl rounded-2xl p-6 space-y-4">
                <?php foreach ($images as $img): ?>

                    <img style="border:solid 1px indigo" src="/<?= $img['path'] ?>"
                         class="w-full h-64  object-cover rounded-xl"
                         alt="">
                <?php endforeach; ?>
                <h1 class="text-3xl font-bold text-gray-900">
                    <?= $post['title'] ?>
                </h1>
                <p class="text-gray-600 text-sm">
                    Published
                    on <?= date("l, F jS, Y h:i A", strtotime($post['created_at'])) . ' - ' . $owner['first_name'] ?>
                </p>
                <p class="text-gray-800 leading-relaxed">
                    <?= $post['body'] ?>
                </p>
                <p class="leading-relaxed">
                    <?php foreach ($tags as $tag): ?>
                        <a href="/tag/<?= Tag::findById($tag['tag_id'])['slug'] ?>" class="text-blue-500">
                            <?= '#' . Tag::findById($tag['tag_id'])['slug'] ?>
                        </a>

                    <?php endforeach; ?>
                </p>
                <div class="flex items-center gap-1">
                    <!-- Like Button -->
                    <form action="/like/store" method="POST">
                        <?= csrf_input() ?>
                        <input type="hidden" name="user_id"
                               value="<?= $user['id'] ?>">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 <?= LikePost::hasLiked($post['id'], $user['id']) ? 'bg-red-500' : 'bg-red-200' ?> text-white text-sm font-medium shadow-md rounded hover:bg-red-700 transition">
                            ❤️ <?= LikePost::like_count($post['id']) == 0 ? '' : LikePost::like_count($post['id']) ?>
                        </button>
                    </form>

                    <?php if ($post['user_id'] == $user['id']): ?>
                        <a href="/post/edit/<?= $post['id'] ?>"
                           class="inline-flex rounded bg-indigo-600 px-3 py-1.5 text-white text-sm font-semibold shadow-md hover:bg-indigo-700 transition duration-200">
                            Edit
                        </a>
                        <form action="/post/<?= $post['id'] ?>" method="POST">
                            <?= csrf_input() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="inline-flex rounded bg-indigo-600  px-3 py-1.5 text-white text-sm font-semibold shadow-md hover:bg-indigo-700 transition duration-200"
                                    type="submit">
                                Delete
                            </button>
                        </form>
                    <?php endif; ?>
                    <?php
                    $followButtonState = Follow::getFollowState($user['id'], $owner['id']);
                    switch($followButtonState):
                        case 'can_follow': ?>
                            <form action="/user/<?= $owner['id'] ?>/follow" method="POST">
                                <?= csrf_input() ?>
                                <button type="submit"
                                        class="inline-flex rounded bg-blue-600 px-3 py-1.5 text-white text-sm font-semibold shadow-md hover:bg-blue-700 transition duration-200">
                                    Follow
                                </button>
                            </form>
                            <?php break;
                        case 'following': ?>
                            <form action="/user/<?= $owner['id'] ?>/unfollow" method="POST">
                                <?= csrf_input() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit"
                                        class="inline-flex rounded bg-blue-600 px-3 py-1.5 text-white text-sm font-semibold shadow-md hover:bg-blue-700 transition duration-200">
                                    Unfollow
                                </button>
                            </form>
                            <?php break;
                        case 'pending': ?>
                            <button disabled
                                    class="inline-flex rounded bg-gray-300 px-3 py-1.5 text-white text-sm font-semibold">
                                Requested...
                            </button>
                        <?php endswitch; ?>

                </div>

                <!-- This is the comment section -->
                <?php if (isset($_SESSION['flash_errors'])): ?>
                    <?php foreach ($_SESSION['flash_errors'] as $error): ?>
                        <p class="text-xs text-red-600"><?= $error ?> </p>
                    <?php endforeach; endif; ?>
                <div class="bg-gray-50 rounded-xl p-6 shadow space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800">Comments</h2>
                    <form action="/comment/store" method="POST" class="space-y-3">
                        <?= csrf_input() ?>
                        <input type="hidden" name="user_id"
                               value="<?= $user['id'] ?>">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <input type="hidden" name="parent_id">
                        <label for="body" class="block text-sm font-medium text-gray-700">Add a comment</label>
                        <textarea name="body" id="body" rows="3"
                                  class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                                  placeholder="Write your comment here..."></textarea>
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition font-semibold text-sm">
                            Post Comment
                        </button>
                    </form>
                </div>

                <?php foreach ($comments as $comment) : ?>
                    <?php if ($comment['parent_id'] == 0) : ?>
                        <!-- Comment -->
                        <div class="flex items-start gap-3 py-4 px-4 border-b border-gray-200">
                            <!-- Avatar -->
                            <img src="/<?= (User::find($comment['user_id']))['avatar'] ?>" alt="avatar"
                                 class="w-10 h-10 rounded-full object-cover">

                            <!-- Comment Content -->
                            <div class="flex-1">
                                <!-- Main comment -->
                                <div class="text-sm text-gray-800">
                                    <span class="font-semibold mr-1"><?= (User::find($comment['user_id']))['username'] ?></span>
                                    <?= htmlspecialchars($comment['body']) ?>
                                </div>

                                <div class="flex items-center gap-4 text-xs text-gray-500 mt-1">
                                    <span><?= date("F jS, Y h:i", strtotime($comment['created_at'])) ?></span>
                                    <button onclick="toggleReply(this)" class="hover:underline">Reply</button>
                                </div>
                                <div class="hidden mt-2">
                                    <form action="/comment/store" method="POST" class="space-y-2">
                                        <?= csrf_input(); ?>
                                        <input type="hidden" name="user_id"
                                               value="<?= $user['id'] ?>">
                                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                        <input type="hidden" name="parent_id" value="<?= $comment['id'] ?>">
                                        <textarea name="body" rows="2" placeholder="Write your reply..."
                                                  class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-400"></textarea>
                                        <button type="submit"
                                                class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                            Post Reply
                                        </button>
                                    </form>
                                </div>

                                <!-- Replies -->
                                <div class="mt-3 pl-4 border-l border-gray-100">
                                    <?php
                                    foreach ($comments as $reply) : ?>
                                        <?php if ($reply['parent_id'] == $comment['id'] || in_array($reply['parent_id'], array_column(array_filter($comments, fn($c) => $c['parent_id'] == $comment['id']), 'id'))) : ?>
                                            <div class="flex items-start gap-3 mb-3">
                                                <img src="/<?= (User::find($reply['user_id']))['avatar'] ?>"
                                                     class="w-8 h-8 rounded-full object-cover" alt="reply avatar">
                                                <div class="text-xs text-gray-800">
                                                    <span class="font-semibold mr-1"><?= (User::find($reply['user_id']))['username'] ?></span>
                                                    <?= '<a class="text-blue-500">@' . User::find(Comment::findById($reply['parent_id'])['user_id'])['username'] . '</a> ' . htmlspecialchars($reply['body']) ?>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-3">
                                                    <button onclick="toggleReply(this)" class="hover:underline">Reply
                                                    </button>
                                                </div>
                                                <div class="hidden mt-2">
                                                    <form action="/comment/store" method="POST" class="space-y-2">
                                                        <?= csrf_input(); ?>
                                                        <input type="hidden" name="user_id"
                                                               value="<?= $user['id'] ?>">
                                                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                                        <input type="hidden" name="parent_id"
                                                               value="<?= $reply['id'] ?>">
                                                        <textarea name="body" rows="2" placeholder="Write your reply..."
                                                                  class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-400"></textarea>
                                                        <button type="submit"
                                                                class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                            Post Reply
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="flex flex-col items-center ml-2">
                                                    <form action="/comment/like/store" method="POST">
                                                        <?= csrf_input() ?>
                                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                        <input type="hidden" name="comment_id"
                                                               value="<?= $reply['id'] ?>">
                                                        <button type="submit"
                                                                class="inline-flex items-center px-1 py-0.5 <?= LikeComment::hasLiked($reply['id'], $user['id']) ? 'bg-red-400' : 'bg-red-200' ?> text-white text-sm font-medium shadow-md rounded hover:bg-red-700 transition">
                                                            ❤️ <?= LikeComment::like_count($reply['id']) == 0 ? '' : LikeComment::like_count($reply['id']) ?>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                        <?php endif; ?>

                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Like Button for main comment -->
                            <div class="flex flex-col items-center ml-2">
                                <form action="/comment/like/store" method="POST">
                                    <?= csrf_input() ?>
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                    <button type="submit"
                                            class="inline-flex items-center px-1 py-0.5 <?= LikeComment::hasLiked($comment['id'], $user['id']) ? 'bg-red-400' : 'bg-red-200' ?> text-white text-sm font-medium shadow-md rounded hover:bg-red-700 transition">
                                        ❤️ <?= LikeComment::like_count($comment['id']) == 0 ? '' : LikeComment::like_count($comment['id']) ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>


            </article>
        </div>

    </div>


    <script>
        function toggleReply(btn) {
            const replyBox = btn.closest('div').nextElementSibling;
            replyBox.classList.toggle('hidden');
        }
    </script>
<?php
layout('footer.php');
?>
<?php

use app\Model\Comment;

layout('admin/header.php'); ?>
<?php layout('admin/navbar.php'); ?>
<!--begin::App Main-->
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Comments</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Comments</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="card mb-4">
                    <div class="card-header"><h3 class="card-title">All Comments</h3></div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Title</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Change</th>
                                <th>Commented_at</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;
                            foreach ($comments as $comment): ?>
                                <tr class="align-middle">
                                    <td>
                                        <?= $i ?>
                                    </td>
                                    <td>
                                        <?= $comment['body'] ?>
                                    </td>
                                    <td>
                                        <?= Comment::user_comment($comment['user_id']) ?>

                                    </td>
                                    <td>
                                        <?= $comment['status'] === 1 ? '<span class="badge bg-primary"> Verified </span>' : 'Still waiting' ?>

                                    </td>
                                    <td>

                                        <?php if ($comment['status'] == 1): ?>
                                            <form action="/admin/comment/update" method="POST">
                                                <?= csrf_input() ?>
                                                <input type="hidden" name="_method" value="PATCH">
                                                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                                <input type="hidden" name="status" value="0">
                                                <button type="submit" class="btn btn-outline-danger px-1 py-1">Not
                                                    Verified
                                                </button>
                                            </form>
                                        <?php else : ?>
                                            <form action="/admin/comment/update" method="POST">
                                                <?= csrf_input() ?>
                                                <input type="hidden" name="_method" value="PATCH">
                                                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                                <input type="hidden" name="status" value="1">
                                                <button type="submit" class="btn btn-outline-success px-1 py-1">Verify
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= date("F jS, Y h:i", strtotime($comment['created_at'])) ?>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-end">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
    <!--end::App Content-->
</main>
<!--end::App Main-->
<?php layout('admin/footer.php') ?>

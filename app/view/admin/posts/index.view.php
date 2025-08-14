<?php use app\Model\Post;
use app\Model\User;

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
                <div class="col-sm-6"><h3 class="mb-0">Simple Tables</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Simple Tables</li>
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
                    <div class="card-header"><h3 class="card-title">All Posts</h3></div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th>By</th>
                                <th>Created At</th>
                                <th>Last Update</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; foreach ($posts as $post): ?>
                                <tr class="align-middle">
                                    <td>
                                        <?= $i  ?>
                                    </td>
                                    <td>
                                        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                           href="/post/<?= $post['id'] ?>" > <?= ucwords($post['title']) ?></a>
                                    </td>
                                    <td>
                                        <?= truncateText($post['body'],50) ?>
                                    </td>
                                    <td>
                                        @<?= Post::post_created_by($post['id']) ?>

                                    </td>
                                    <td>
                                        <?= date("F jS", strtotime($post['created_at'])) ?>

                                    </td>
                                    <td>
                                        <?= date("F jS, Y h:i", strtotime($post['updated_at'])) ?>

                                    </td>
                                </tr>
                            <?php $i++;  endforeach; ?>
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

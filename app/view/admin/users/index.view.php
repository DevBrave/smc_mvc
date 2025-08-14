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
                <div class="col-sm-6"><h3 class="mb-0">Tags</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                    <div class="card-header"><h3 class="card-title">Registered User</h3></div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Bio</th>
                                <th>Role</th>
                                <th>Action</th>
                                <th>Registered IN</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;
                            foreach ($users as $user): ?>
                                <tr class="align-middle">
                                    <td>
                                        <?= $i ?>
                                    </td>
                                    <td>
                                        <?= ucwords($user['first_name']) . ' ' . ucwords($user['last_name']) ?>
                                    </td>
                                    <td>
                                        <?= $user['username'] ?>
                                    </td>
                                    <td>
                                        <?= $user['email'] ?>
                                    </td>
                                    <td>
                                        <?= truncateText($user['bio'],20) ?>
                                    </td>
                                    <td>
                                        <?= $user['role'] == 'admin' ? '<span class="badge bg-primary">Admin</span>' : $user['role'] ?>
                                    </td>
                                    <td>
                                            <a href="/admin/user/edit/<?= $user['username'] ?>" class="btn btn-warning px-1 py-1">Edit
                                            </a>
                                    </td>
                                    <td>
                                        <?= date("F jS, Y h:i", strtotime($user['reg_date'])) ?>
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

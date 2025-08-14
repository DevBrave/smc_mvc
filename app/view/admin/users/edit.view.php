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

                <div class="card card-info card-outline mb-4">
                    <!--begin::Header-->
                    <div class="card-header">
                        <div class="card-title">Edit <strong>@<?= $user['username'] ?>  </strong></div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Form-->
                    <form class="needs-validation" action="/admin/user/update" method="POST" novalidate>
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Row-->
                            <div class="row g-3">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <?= csrf_input() ?>
                                    <input type="hidden" name="_method" value="PATCH">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input
                                            type="text"
                                            name="first_name"
                                            class="form-control"
                                            id="name"
                                            value="<?= ucwords($user['first_name']) ?> "
                                            required
                                    />
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input
                                            type="text"
                                            name="last_name"
                                            class="form-control"
                                            id="last_name"
                                            value="<?= ucwords($user['last_name']) ?> "
                                            required
                                    />
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <label for="username" class="form-label">Username</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                        <input
                                                type="text"
                                                name="username"
                                                class="form-control"
                                                id="username"
                                                aria-describedby="inputGroupPrepend"
                                                value="<?= $user['username'] ?> "
                                                required
                                        />
                                    </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input
                                            type="text"
                                            name="email"
                                            class="form-control"
                                            id="email"
                                            value="<?= $user['email'] ?> "
                                            required
                                    />
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role">
                                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>admin</option>
                                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>  >user</option>
                                    </select>
                                </div>


                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <label for="bio" class="form-label">Bio</label>
                                    <input
                                            type="text"
                                            name="bio"
                                            class="form-control"
                                            id="bio"
                                            value="<?= $user['bio'] ?>"
                                            required
                                    />
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer">
                            <button class="btn btn-info" type="submit">Edit</button>
                        </div>
                        <!--end::Footer-->
                    </form>

                </div>
                <!--end::Row-->
            </div>
            <!--end::Body-->
            <!--begin::Footer-->

            <!--end::Footer-->
            <!--end::Form-->
            <!--begin::JavaScript-->
        </div>
    </div>
    <!--end::Container-->
    <!--end::App Content-->
</main>
<!--end::App Main-->
<?php layout('admin/footer.php') ?>

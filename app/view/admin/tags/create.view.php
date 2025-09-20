<?php

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
                    <div class="card-header"><div class="card-title">Create Tag </strong></div></div>
                    <!--end::Header-->
                    <!--begin::Form-->
                    <form class="needs-validation" action="/admin/tag/store" method="POST" novalidate>
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Row-->
                            <div class="row g-3">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <?= csrf_input() ?>
                                    <?php if (isset($_SESSION['flash_errors'])): ?>
                                        <?php foreach ($_SESSION['flash_errors'] as $error): ?>
                                            <p class="text-danger"><?= $error ?> </p>
                                        <?php endforeach; endif; ?>
                                    <label for="name" class="form-label">Name</label>
                                    <input
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            id="name"
                                            required
                                    />
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer">
                            <button class="btn btn-info" type="submit">Create</button>
                        </div>
                        <!--end::Footer-->
                    </form>
                    <!--end::Form-->
                    <!--begin::JavaScript-->
                    <script>
                        // Example starter JavaScript for disabling form submissions if there are invalid fields
                        (() => {
                            'use strict';

                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            const forms = document.querySelectorAll('.needs-validation');

                            // Loop over them and prevent submission
                            Array.from(forms).forEach((form) => {
                                form.addEventListener(
                                    'submit',
                                    (event) => {
                                        if (!form.checkValidity()) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }

                                        form.classList.add('was-validated');
                                    },
                                    false,
                                );
                            });
                        })();
                    </script>
                    <!--end::JavaScript-->
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

        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
    <!--end::App Content-->
</main>
<!--end::App Main-->
<?php layout('admin/footer.php') ?>

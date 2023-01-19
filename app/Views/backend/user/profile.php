<div class="card shadow-lg mx-4 card-profile-bottom">
    <div class="card-body p-3">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="/public/avatar.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm" />
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        <?php echo $user['name'] ?>
                    </h5>
                    <p class="mb-0 font-weight-bold text-sm">
                        Quản trị viên
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Chỉnh sửa thông tin cá nhân</p>
                        <button class="btn btn-primary btn-sm ms-auto">Lưu</button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <p class="text-uppercase text-sm">Thông tin cá nhân</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Username</label>
                                    <input class="form-control" type="text" value="lucky.jesse" onfocus="focused(this)" onfocusout="defocused(this)" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Email address</label>
                                    <input class="form-control" type="email" value="jesse@example.com" onfocus="focused(this)" onfocusout="defocused(this)" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">First name</label>
                                    <input class="form-control" type="text" value="Jesse" onfocus="focused(this)" onfocusout="defocused(this)" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Last name</label>
                                    <input class="form-control" type="text" value="Lucky" onfocus="focused(this)" onfocusout="defocused(this)" />
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr class="horizontal dark" />
                    <form action="" method="post">
                        <p class="text-uppercase text-sm">Đổi mật khẩu</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Address</label>
                                    <input class="form-control" type="text" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09" onfocus="focused(this)" onfocusout="defocused(this)" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">City</label>
                                    <input class="form-control" type="text" value="New York" onfocus="focused(this)" onfocusout="defocused(this)" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Country</label>
                                    <input class="form-control" type="text" value="United States" onfocus="focused(this)" onfocusout="defocused(this)" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Postal code</label>
                                    <input class="form-control" type="text" value="437300" onfocus="focused(this)" onfocusout="defocused(this)" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

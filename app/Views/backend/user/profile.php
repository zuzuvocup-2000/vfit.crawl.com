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
                        <?php echo isset($user['name']) ? $user['name'] : '' ?>
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
                <div class="card-body">
                    <form action="profile/update" method="post">
                        <p class="text-uppercase text-sm">Thông tin cá nhân</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Họ và tên <span class="text-danger">*</span></label>
                                    <?php echo form_input('name', validate_input(set_value('name', (isset($user['name'])) ? $user['name'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Email <span class="text-danger">*</span></label>
                                    <?php echo form_input('email', validate_input(set_value('email', (isset($user['email'])) ? $user['email'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto">Cập nhật</button>
                    </form>
                    <hr class="horizontal dark" />
                    <form action="/profile/change-password" method="post" >
                        <p class="text-uppercase text-sm">Đổi mật khẩu</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Mật khẩu cũ </label>
                                    <?php echo form_password('password', '', 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" minlength="6" id="password"'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Mật khẩu mới </label>
                                    <?php echo form_password('new_password', '', 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" minlength="6" id="new_password"'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Nhập lại mật khẩu </label>
                                    <div class="message"></div>
                                    <?php echo form_password('confirm_password', '', 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" minlength="6" id="confirm_password"'); ?>
                                </div>
                            </div>
                        </div>
                        <button type="submit" disabled class="btn btn-primary btn-sm ms-auto button-submit-password">Đổi mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $("#confirm_password").on("keyup", function(){
            var password = $("#new_password").val();
            var confirm_password = $("#confirm_password").val();
            if(password != confirm_password){
                $('.button-submit-password').attr('disabled','disabled')
                $("#confirm_password").addClass('is-invalid')
                $("#new_password").addClass('is-invalid')
            }else{
                $("#confirm_password").removeClass('is-invalid')
                $('.button-submit-password').removeAttr('disabled')
                $("#new_password").removeClass('is-invalid')
            }
        });
    });
</script>
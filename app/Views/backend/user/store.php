<div class="container-fluid py-4">
    <div class="card">
        <form action="" method="post">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <p class="mb-0"><?php echo $title ?></p>
                    <button class="btn btn-success m-0 btn-sm ms-auto button-save" <?php echo $method == 'create' ? 'disabled' : ''  ?>>Lưu</button>
                </div>
            </div>
            <div class="card-body">
                <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Họ và tên <span class="text-danger">(*)</span></label>
                            <?php echo form_input('name', validate_input(set_value('name', (isset($user['data']['name'])) ? $user['data']['name'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Email <span class="text-danger">(*)</span></label>
                            <?php echo form_input('email', validate_input(set_value('email', (isset($user['data']['email'])) ? $user['data']['email'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
                            <?php echo form_hidden('email_original', (isset($user['data']['email']) ? $user['data']['email'] : ''), 'class="form-control" '); ?>
                        </div>
                    </div>
                    <?php if($method == 'create'){ ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Mật khẩu mới <span class="text-danger">(*)</span></label>
                                <?php echo form_password('password', '', 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" minlength="6" id="password"'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Nhập lại mật khẩu <span class="text-danger">(*)</span></label>
                                <div class="message"></div>
                                <?php echo form_password('confirm_password', '', 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" minlength="6" id="confirm_password"'); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#confirm_password").on("keyup", function(){
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();
            if(password != confirm_password){
                $('.button-save').attr('disabled','disabled')
                $("#confirm_password").addClass('is-invalid')
                $("#password").addClass('is-invalid')
            }else{
                $("#confirm_password").removeClass('is-invalid')
                $('.button-save').removeAttr('disabled')
                $("#password").removeClass('is-invalid')
            }
        });
    });
</script>
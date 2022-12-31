<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <base href="<?php echo BASE_URL; ?>">
        <title>Đăng nhập</title>
        <link href="<?php echo ASSET_BACKEND; ?>css/bootstrap.min2.css" rel="stylesheet">
        <link href="<?php echo ASSET_BACKEND; ?>font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo ASSET_BACKEND; ?>css/animate.css" rel="stylesheet">
        <link href="<?php echo ASSET_BACKEND; ?>css/style.css" rel="stylesheet">
        <link href="<?php echo ASSET_BACKEND; ?>css/customize.css" rel="stylesheet">
        
    </head>
    <body class="gray-bg">
        <div class="container">
            <div class='col-md-9 card mx-auto d-flex flex-row px-0'>
                
                <div class="img-left d-md-flex d-none"></div>
                
                <div class="card-body d-flex flex-column justify-content-center">
                    <h4 class="title text-center mt-4 pb-3 title-login">Đăng nhập</h4>
                    <form class='col-sm-10 col-12 mx-auto' action="backend/authentication/auth/login" method="post" >
                        <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
                        <div class='form-group '>
                            <input type="email" class="form-control " name="email" placeholder="Nhập vào email của bạn">
                        </div>
                        <div class='form-group py-3 ' >
                            <input type="password" class="form-control" name="password" placeholder='******'>
                        </div>
                        <a href="/backend/authentication/auth/forgot" class="mb-3 display-block">
                            <small>Quên mật khẩu?</small>
                        </a>
                        <div class=''>
                            <input type="submit" class="btn  btn-outline-primary d-block w-100 " value='Đăng nhập'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
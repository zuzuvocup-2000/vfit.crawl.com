<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="apple-touch-icon" sizes="76x76" href="/template/assets/img/apple-icon.png" />
        <link rel="icon" type="image/png" href="/template/assets/img/favicon.png" />
        <title>
            Quên mật khẩu | <?php echo NAME_PROJECT ?>
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/template/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/template/assets/css/nucleo-svg.css" rel="stylesheet" />
        <link href="public/backend/css/plugins/toastr/toastr.min.css" rel="stylesheet">
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="/template/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/template/assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
        <script src="public/backend/js/jquery-3.1.1.min.js"></script>
    </head>

    <body class="">
        <main class="main-content mt-0">
            <section>
                <div class="page-header min-vh-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                                <div class="card card-plain">
                                    <div class="card-header pb-0 text-start">
                                        <h4 class="font-weight-bolder">Quên mật khẩu</h4>
                                        <p class="mb-0">Nhập email và mật khẩu của bạn để đăng nhập</p>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post" >
                                            <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
                                            <div class="mb-3">
                                                <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" aria-label="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''  ?>" />
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" onclick="$(this).html('<i class=\'fa fa-spinner fa-spin\'></i> Loading');$(this).attr('disabled','disabled');$(this).parents('form').submit();" class="btn btn-lg btn-primary btn-lg w-100 mt-2 mb-0">Quên mật khẩu</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                        <p class="mb-4 text-sm mx-auto">
                                            Đã có tài khoản, <a href="/login" class="text-primary text-gradient font-weight-bold">Đăng nhập?</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                                <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: none;background-image: url(public/logo.png);background-size: contain;background-repeat: no-repeat;background-position: center center; " >
                                    <span class="mask bg-gradient-primary opacity-6"></span>
                                    <h4 class="mt-5 text-white font-weight-bolder position-relative">"Khoa Công nghệ thông tin Trường Đại học Kiến trúc Hà Nội"</h4>
                                    <p class="text-white position-relative">Chất lượng cao - Sáng tạo - Tiên phong - Tích hợp - Trách nhiệm - Phát triển bền vững</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!--   Core JS Files   -->
        <script src="public/backend/js/plugins/toastr/toastr.min.js"></script>
        <script src="/template/assets/js/core/popper.min.js"></script>
        <script src="/template/assets/js/core/bootstrap.min.js"></script>
        <script src="/template/assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="/template/assets/js/plugins/smooth-scrollbar.min.js"></script>
        <script>
            var win = navigator.platform.indexOf("Win") > -1;
            if (win && document.querySelector("#sidenav-scrollbar")) {
                var options = {
                    damping: "0.5",
                };
                Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="/template/assets/js/argon-dashboard.min.js?v=2.0.4"></script>
        <?php echo view('backend/dashboard/common/notification') ?>
    </body>
</html>

<?php
    $baseController = new App\Controllers\BaseController();
?>
<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message"></i> Xin chào các bạn đã đến với hệ thống V-FIT</span>
            </li>
            <li>
                <a href="<?php echo base_url('logout') ?>">
                    <i class="fa fa-sign-out"></i> Đăng xuất
                </a>
            </li>
        </ul>
    </nav>
</div>


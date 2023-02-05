<?php
$uri = service('uri');
$uri = current_url(true);
$uriSegment = $uri->getSegment(1);
?>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="">
            <img src="public/logo.png" class="navbar-brand-img h-100" alt="main_logo" />
            <span class="ms-1 font-weight-bold"><?php echo NAME_PROJECT ?></span>
        </a>
    </div>
    <hr class="horizontal dark mt-0" />
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php echo $uriSegment == 'dashboard' ? 'active' : '' ?>" href="">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Trang chủ</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $uriSegment == 'statistic' ? 'active' : '' ?>" href="template/pages/virtual-reality.html">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-chart-pie-35 text-info text-sm opacity-10"></i>
                        <i class="ni ni-app text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Báo cáo thống kê</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $uriSegment == 'website' ? 'active' : '' ?>" href="/website/index">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Quản lý Website</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $uriSegment == 'criteria' ? 'active' : '' ?>" href="/criteria/index">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-key-25 text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Quản lý tiêu chí</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $uriSegment == 'user' ? 'active' : '' ?>" href="user/index">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-users text-warning text-sm opacity-10" aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Quản lý tài khoản</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Tài khoản</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $uriSegment == 'profile' ? 'active' : '' ?>" href="/profile">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1"><?php echo session()->get('name') ?></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
        <a href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">Documentation</a>
    </div>
</aside>
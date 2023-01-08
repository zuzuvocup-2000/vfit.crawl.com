<nav class="navbar-default navbar-static-side" role="navigation">
    <?php
    $user = authentication();
    // $uri = service('uri');
    // $uri = current_url(true);
    // $uriModule = $uri->getSegment(2);
    // $uriModule_name = $uri->getSegment(3);
    $baseController = new App\Controllers\BaseController();
    ?>
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" class="img-circle" src="public/avatar.png" style="min-width:48px;height:48px;" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle display-block" href="<?php echo site_url('profile') ?>" style="margin-top: 15px;">
                        <span class="clear"> <span class="block m-t-xs">
                            <strong class="font-bold" style="color:#fff">
                            <?php echo $user['name'] ?>
                            </strong>
                        </span>
                        <span class="text-muted text-xs block">Quản trị viên
                            <b class="caret" style="color: #8095a8"></b>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="<?php echo base_url('backend/user/profile/profile/'.$user['_id']['$oid']) ?>">Đổi mật khẩu</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('logout') ?>">Đăng xuất</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    V-FIT
                </div>
            </li>
            <li class="">
                <a href="<?php echo base_url('website') ?>"><i class="fa fa-globe" aria-hidden="true"></i><span class="nav-label">QL Website</span> </a>
            </li>
        </ul>
    </div>
</nav>
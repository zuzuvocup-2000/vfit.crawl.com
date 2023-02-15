<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 mb-3">
                <h6><?php echo $title ?></h6>
                <div class="wrap-search ">
                    <form class="d-flex justify-content-between mb-3" action="" method="get">
                        <select class="form-control select-user" style="width: 200px;" name="limit">
                            <option value='20' <?php echo isset($_GET['limit']) && $_GET['limit'] == '20' ? 'selected' : ''  ?>>20 bản ghi</option>
                            <option value='30' <?php echo isset($_GET['limit']) && $_GET['limit'] == '30' ? 'selected' : ''  ?>>30 bản ghi</option>
                            <option value='40' <?php echo isset($_GET['limit']) && $_GET['limit'] == '40' ? 'selected' : ''  ?>>40 bản ghi</option>
                            <option value='50' <?php echo isset($_GET['limit']) && $_GET['limit'] == '50' ? 'selected' : ''  ?>>50 bản ghi</option>
                            <option value='100' <?php echo isset($_GET['limit']) && $_GET['limit'] == '100' ? 'selected' : ''  ?>>100 bản ghi</option>
                        </select>
                        <div class="d-flex flex-middle">
                            <div class="input-group " style="width: 500px;">
                                <input type="text" name="keyword" class="form-control keyword-search" placeholder="Nhập từ khóa để tìm kiếm..." aria-label="Nhập từ khóa để tìm kiếm" aria-describedby="button-addon2" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                                <button class="btn btn-outline-primary mb-0 btn-click-search-user" type="submit" id="button-addon2">Tìm kiếm</button>
                            </div>
                            <a href="/user/create" class="btn btn-primary m-0 ms-3">Thêm mới</a>
                        </div>
                    </form>  
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-0">
                <div class="table-responsive p-0">
                    
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width: 40px;"></th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="width: 400px;">Tiêu đề</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width: 40px;">Điểm </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width: 200px;">Thông tin </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Biểu đồ</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width: 150px;">Tổng kết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="list-item" >
                                <td class="text-center">
                                    <div class="form-check text-center p-0 m-0 d-flex align-items-center justify-content-center click ">
                                        <input class="form-check-input m-auto" type="checkbox" value="" onchange="$(this).parents('.list-item').toggleClass('change-bg')">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="wrap-flex-title" style="width: calc( 100% - 65px);">
                                            <a href="http://vfit.com/" class="">Tiêu đề</a>
                                            <br>
                                            <span class="text-xs">URL: <a href="http://vfit.com/" class="text-warning">http://vfit.com/</a></span>
                                        </div>
                                        <div class="wrap-btn" style="width: 55px;margin-left: 10px;">
                                            <a href="/user/update/1" target="_blank" class="btn bg-gradient-info mb-0" style="margin-right: 10px;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    10
                                </td>
                                <td>
                                    <div class="content-keyword mb-2">
                                        <div class="title text-sm">Nội dung:</div>
                                        <ul class="list-keyword">
                                            <li class="danger">dmm: 1</li>
                                            <li class="success">abc: 1</li>
                                        </ul>
                                    </div>
                                    <div class="rate-keyword ">
                                        <div class="title text-sm">Đánh giá:</div>
                                        <ul class="list-keyword">
                                            <li class="danger">dmm: 1</li>
                                            <li class="success">abc: 1</li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="align-middle ">
                                    <div class="chart-wrap">
                                        <div class="title text-sm">Nội dung:</div>
                                        <div class="progress-wrapper d-flex align-items-center">
                                            <div class="progress-info" style="width: 50px">
                                                <div class="progress-percentage">
                                                    <span class="text-sm font-weight-bold text-success">60%</span>
                                                </div>
                                            </div>
                                            <div class="progress" style="width: calc(100% - 50px)">
                                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                            </div>
                                        </div>
                                        <div class="progress-wrapper d-flex align-items-center">
                                            <div class="progress-info" style="width: 50px">
                                                <div class="progress-percentage">
                                                    <span class="text-sm font-weight-bold text-danger">40%</span>
                                                </div>
                                            </div>
                                            <div class="progress" style="width: calc(100% - 50px)">
                                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-wrap">
                                        <div class="title text-sm">Đánh giá:</div>
                                        <div class="progress-wrapper d-flex align-items-center">
                                            <div class="progress-info" style="width: 50px">
                                                <div class="progress-percentage">
                                                    <span class="text-sm font-weight-bold text-success">60%</span>
                                                </div>
                                            </div>
                                            <div class="progress" style="width: calc(100% - 50px)">
                                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                            </div>
                                        </div>
                                        <div class="progress-wrapper d-flex align-items-center">
                                            <div class="progress-info" style="width: 50px">
                                                <div class="progress-percentage">
                                                    <span class="text-sm font-weight-bold text-danger">40%</span>
                                                </div>
                                            </div>
                                            <div class="progress" style="width: calc(100% - 50px)">
                                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center text-success">
                                    Rất tốt
                                </td>
                            </tr>

                            <?php if(isset($userList['data']) && is_array($userList['data']) && count($userList['data'])){ 
                                foreach ($userList['data'] as $key => $value) {
                            ?>
                                <tr class="list-item" >
                                    <td class="text-center">
                                        <div class="form-check text-center p-0 m-0 d-flex align-items-center justify-content-center click ">
                                            <input class="form-check-input m-auto" type="checkbox" value="" onchange="$(this).parents('.list-item').toggleClass('change-bg')">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $value['name']  ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $value['email']  ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo isset($value['createdAt']) ? date('d-m-Y H:i:s', strtotime($value['createdAt'])) : '-' ?></span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <a href="/user/update/<?php echo $value['_id'] ?>" class="btn bg-gradient-success mb-0" style="margin-right: 10px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a class="btn bg-gradient-danger btn-delete-user mb-0" data-id="<?php echo $value['_id'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>

                </div>
                <?php $actual_link = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REDIRECT_URL]"; ?>
                <?php if(isset($userList['pagination']) && is_array($userList['pagination']) && count($userList['pagination'])){ 
                    if($userList['pagination']['limit'] < $userList['pagination']['total']){
                    $pagination = ceil($userList['pagination']['total'] / $userList['pagination']['limit']);
                ?>
                    <ul class="pagination d-flex justify-content-center mt-3">
                        <?php $current_page = (isset($_GET['page']) ? $_GET['page'] : 0) ?>
                        <?php for ($i = 0; $i < $pagination; $i++) {   ?>
                            <?php 
                                $_GET['page'] = $i ;
                             ?>
                            <li class="page-item <?php echo $current_page == $i  ? 'active' : '' ?>"><a class="page-link " href="<?php echo $actual_link.'?'.http_build_query($_GET) ?>"><?php echo $i + 1 ?></a></li>
                        <?php } ?>
                    </ul>
                <?php }} ?>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 mb-3">
                <h6><?php echo $title ?></h6>
                <div class="wrap-search ">
                    <form class="d-flex justify-content-between mb-3" action="" method="get">
                        <div class="d-flex">
                            <select class="form-control select-user" style="width: 200px;" name="limit">
                                <option value='100' <?php echo isset($_GET['limit']) && $_GET['limit'] == '100' ? 'selected' : ''  ?>>100 bản ghi</option>
                                <option value='200' <?php echo isset($_GET['limit']) && $_GET['limit'] == '200' ? 'selected' : ''  ?>>200 bản ghi</option>
                                <option value='500' <?php echo isset($_GET['limit']) && $_GET['limit'] == '500' ? 'selected' : ''  ?>>500 bản ghi</option>
                            </select>
                            <select class="form-control select-user" style="width: 200px;margin-left: 15px;" name="point">
                                <option value="">Chọn trạng thái báo cáo</option>
                                <option value='bad' <?php echo isset($_GET['point']) && $_GET['point'] == 'bad' ? 'selected' : ''  ?>>Không tốt</option>
                                <option value='normal' <?php echo isset($_GET['point']) && $_GET['point'] == 'normal' ? 'selected' : ''  ?>>Bình thường</option>
                                <option value='good' <?php echo isset($_GET['point']) && $_GET['point'] == 'good' ? 'selected' : ''  ?>>Tốt</option>
                            </select>
                        </div>
                        <div class="d-flex flex-middle">
                            <button class="btn btn-outline-primary mb-0 btn-click-search-user" type="submit" id="button-addon2">Tìm kiếm</button>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width: 250px;">Thông tin </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Biểu đồ</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width: 150px;">Tổng kết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($statisticList['data']) && is_array($statisticList['data']) && count($statisticList['data'])){ 
                                foreach ($statisticList['data'] as $key => $value) {
                                    $point = $value['point'];
                            ?>
                                <tr class="list-item" >
                                    <td class="text-center">
                                        <div class="form-check text-center p-0 m-0 d-flex align-items-center justify-content-center click ">
                                            <input class="form-check-input m-auto" type="checkbox" value="" onchange="$(this).parents('.list-item').toggleClass('change-bg')">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="wrap-flex-title" style="width: calc( 100% - 65px);">
                                                <a href="statistic/article/<?php echo $value['articleId']['_id'] ?>" target="_blank" class=""><?php echo $value['articleId']['title'] ?></a>
                                                <br>
                                                <span class="text-xs">URL: <a target="_blank" href="<?php echo $value['articleId']['url'] ?>" class="text-warning"><?php echo $value['articleId']['url'] ?></a></span>
                                            </div>
                                            <div class="wrap-btn" style="width: 55px;margin-left: 10px;">
                                                <a href="statistic/article/<?php echo $value['articleId']['_id'] ?>" target="_blank" class="btn bg-gradient-info mb-0" style="margin-right: 10px;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="<?php echo $point > 7 ? 'text-success' : ($point < 4 ? 'text-danger' : 'text-primary') ?>"><?php echo $point ?></span>
                                    </td>
                                    <td>
                                        <div class="content-keyword mb-2">
                                            <div class="title text-sm">Nội dung:</div>
                                            <ul class="list-keyword">
                                                <?php 
                                                    $bad = reset($value['bad']);
                                                    $good = reset($value['good']);
                                                 ?>
                                                <?php if(isset($good['content']) && is_array($good['content']) && count($good['content'])){
                                                    foreach ($good['content'] as $keyContent => $valueContent) {
                                                 ?>
                                                    <li class="success mb-2"><?php echo key($valueContent) ?>: <?php echo $valueContent[key($valueContent)] ?></li>
                                                <?php }} ?>
                                                <?php if(isset($bad['content']) && is_array($bad['content']) && count($bad['content'])){
                                                    foreach ($bad['content'] as $keyContent => $valueContent) {
                                                 ?>
                                                    <li class="danger mb-2"><?php echo key($valueContent) ?>: <?php echo $valueContent[key($valueContent)] ?></li>
                                                <?php }} ?>
                                            </ul>
                                        </div>
                                        <div class="rate-keyword ">
                                            <div class="title text-sm">Đánh giá:</div>
                                            <ul class="list-keyword">
                                                <?php if(isset($good['rate']) && is_array($good['rate']) && count($good['rate'])){
                                                    foreach ($good['rate'] as $keyRate => $valueRate) {
                                                 ?>
                                                    <li class="success mb-2"><?php echo key($valueRate) ?>: <?php echo $valueRate[key($valueRate)] ?></li>
                                                <?php }} ?>
                                                <?php if(isset($bad['rate']) && is_array($bad['rate']) && count($bad['rate'])){
                                                    foreach ($bad['rate'] as $keyRate => $valueRate) {
                                                 ?>
                                                    <li class="danger mb-2"><?php echo key($valueRate) ?>: <?php echo $valueRate[key($valueRate)] ?></li>
                                                <?php }} ?>
                                            </ul>
                                        </div>
                                    </td>
                                    <?php 
                                        $total = 0;
                                        $total_content_good = 0;
                                        $total_content_bad = 0;
                                        $total_rate_good = 0;
                                        $total_rate_bad = 0;
                                        if(isset($good['content']) && is_array($good['content']) && count($good['content'])){
                                            foreach ($good['content'] as $value) {
                                                if(isset($value) && is_array($value) && count($value)) {
                                                    $total += $value[key($value)];
                                                    $total_content_good += $value[key($value)];
                                                }
                                            }
                                        }
                                        if(isset($good['rate']) && is_array($good['rate']) && count($good['rate'])){
                                            foreach ($good['rate'] as $value) {
                                                if(isset($value) && is_array($value) && count($value)) {
                                                    $total += $value[key($value)];
                                                    $total_rate_good += $value[key($value)];
                                                }
                                            }
                                        }
                                        if(isset($bad['content']) && is_array($bad['content']) && count($bad['content'])){
                                            foreach ($bad['content'] as $value) {
                                                if(isset($value) && is_array($value) && count($value)) {
                                                    $total += $value[key($value)];
                                                    $total_content_bad += $value[key($value)];
                                                }
                                            }
                                        }
                                        if(isset($bad['rate']) && is_array($bad['rate']) && count($bad['rate'])){
                                            foreach ($bad['rate'] as $value) {
                                                if(isset($value) && is_array($value) && count($value)) {
                                                    $total += $value[key($value)];
                                                    $total_rate_bad += $value[key($value)];
                                                }
                                            }
                                        }
                                    ?>
                                    <td class="align-middle ">
                                        <div class="chart-wrap">
                                            <div class="title text-sm">Nội dung:</div>
                                            <div class="progress-wrapper d-flex align-items-center">
                                                <div class="progress-info" style="width: 50px">
                                                    <div class="progress-percentage">
                                                        <span class="text-sm font-weight-bold text-success"><?php echo $total != 0 ? round($total_content_good / $total * 100, 1) : 0 ?>%</span>
                                                    </div>
                                                </div>
                                                <div class="progress" style="width: calc(100% - 50px)">
                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $total != 0 ? round($total_content_good / $total * 100, 1) : 0 ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $total != 0 ? round($total_content_good / $total * 100, 1) : 0 ?>%;"></div>
                                                </div>
                                            </div>
                                            <div class="progress-wrapper d-flex align-items-center">
                                                <div class="progress-info" style="width: 50px">
                                                    <div class="progress-percentage">
                                                        <span class="text-sm font-weight-bold text-danger"><?php echo $total == 0 ? 0 : round($total_content_bad / $total * 100, 1) ?>%</span>
                                                    </div>
                                                </div>
                                                <div class="progress" style="width: calc(100% - 50px)">
                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="<?php echo $total == 0 ? 0 : round($total_content_bad / $total * 100, 1) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $total == 0 ? 0 : round($total_content_bad / $total * 100, 1) ?>%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chart-wrap">
                                            <div class="title text-sm">Đánh giá:</div>
                                            <div class="progress-wrapper d-flex align-items-center">
                                                <div class="progress-info" style="width: 50px">
                                                    <div class="progress-percentage">
                                                        <span class="text-sm font-weight-bold text-success"><?php echo $total == 0 ? 0 : round($total_rate_good / $total * 100, 1) ?>%</span>
                                                    </div>
                                                </div>
                                                <div class="progress" style="width: calc(100% - 50px)">
                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $total == 0 ? 0 : round($total_rate_good / $total * 100, 1) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $total == 0 ? 0 : round($total_rate_good / $total * 100, 1) ?>%;"></div>
                                                </div>
                                            </div>
                                            <div class="progress-wrapper d-flex align-items-center">
                                                <div class="progress-info" style="width: 50px">
                                                    <div class="progress-percentage">
                                                        <span class="text-sm font-weight-bold text-danger"><?php echo $total == 0 ? 0 : round($total_rate_bad / $total * 100, 1) ?>%</span>
                                                    </div>
                                                </div>
                                                <div class="progress" style="width: calc(100% - 50px)">
                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="<?php echo $total == 0 ? 0 : round($total_rate_bad / $total * 100, 1) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $total == 0 ? 0 : round($total_rate_bad / $total * 100, 1) ?>%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center text-success">
                                        <span class="<?php echo $point > 7 ? 'text-success' : ($point < 4 ? 'text-danger' : 'text-primary') ?>"><?php echo $point > 7 ? 'Tốt' : ($point < 4 ? 'Không tốt' : 'Bình thường') ?></span>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
                <?php $actual_link = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REDIRECT_URL]"; ?>
                <?php if(isset($statisticList['paginate']) && is_array($statisticList['paginate']) && count($statisticList['paginate'])){ 
                    if($statisticList['paginate']['limit'] < $statisticList['paginate']['total']){
                    $pagination = ceil($statisticList['paginate']['total'] / $statisticList['paginate']['limit']);
                ?>
                    <?php if($statisticList['paginate']['total'] <= 7){ ?>
                        <ul class="pagination d-flex justify-content-center mt-3">
                            <?php $current_page = (isset($_GET['page']) ? $_GET['page'] : 0) ?>
                            <?php for ($i = 0; $i < $pagination; $i++) {   ?>
                                <?php 
                                    $_GET['page'] = $i ;
                                 ?>
                                <li class="page-item <?php echo $current_page == $i  ? 'active' : '' ?>"><a class="page-link " href="<?php echo $actual_link.'?'.http_build_query($_GET) ?>"><?php echo $i + 1 ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <ul class="pagination d-flex justify-content-center mt-3">
                            <?php $current_page = (isset($_GET['page']) ? $_GET['page'] : 0) ?>
                            <?php for ($i = 0; $i < $pagination; $i++) {   ?>
                                <?php 
                                    $_GET['page'] = $i ;
                                 ?>
                                <li class="page-item <?php echo $current_page == $i  ? 'active' : '' ?>"><a class="page-link " href="<?php echo $actual_link.'?'.http_build_query($_GET) ?>"><?php echo $i + 1 ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                <?php }} ?>
            </div>
        </div>
    </div>
</div>


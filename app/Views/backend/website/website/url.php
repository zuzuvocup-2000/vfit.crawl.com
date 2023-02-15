
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 mb-3">
                <h6><?php echo $title ?></h6>
                <div class="wrap-search ">
                    <form class="d-flex justify-content-between mb-3" action="" method="get">
                        <select class="form-control select-website" style="width: 200px;" name="limit">
                            <option value='20' <?php echo isset($_GET['limit']) && $_GET['limit'] == '20' ? 'selected' : ''  ?>>20 bản ghi</option>
                            <option value='30' <?php echo isset($_GET['limit']) && $_GET['limit'] == '30' ? 'selected' : ''  ?>>30 bản ghi</option>
                            <option value='40' <?php echo isset($_GET['limit']) && $_GET['limit'] == '40' ? 'selected' : ''  ?>>40 bản ghi</option>
                            <option value='50' <?php echo isset($_GET['limit']) && $_GET['limit'] == '50' ? 'selected' : ''  ?>>50 bản ghi</option>
                            <option value='100' <?php echo isset($_GET['limit']) && $_GET['limit'] == '100' ? 'selected' : ''  ?>>100 bản ghi</option>
                        </select>
                        <div class="d-flex flex-middle">
                            <div class="input-group " style="width: 500px;">
                                <input type="text" name="keyword" class="form-control keyword-search" placeholder="Nhập từ khóa để tìm kiếm..." aria-label="Nhập từ khóa để tìm kiếm" aria-describedby="button-addon2" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                                <button class="btn btn-outline-primary mb-0 btn-click-search-website" type="submit" id="button-addon2">Tìm kiếm</button>
                            </div>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="width:300px">URL</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center" >Website gốc</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 130px;">Trạng thái URL</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 130px;">Trạng thái thu thập</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($urlList['data']) && is_array($urlList['data']) && count($urlList['data'])){ 
                                foreach ($urlList['data'] as $key => $value) {
                            ?>
                                <tr class="list-item" >
                                    <td class="text-center">
                                        <div class="form-check text-center p-0 m-0 d-flex align-items-center justify-content-center click ">
                                            <input class="form-check-input m-auto" type="checkbox" value="" onchange="$(this).parents('.list-item').toggleClass('change-bg')">
                                        </div>
                                    </td>
                                    <td style="width: 300px;">
                                        <div class="d-flex flex-column justify-content-center">
                                            <a href="<?php echo $value['url'] ?>" target="_blank" class="mb-0 text-sm"><?php echo $value['url'] ?></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $website['data']['url']  ?>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="switch">
                                            <div class="onoffswitch" style="margin: auto">
                                                <input type="checkbox" <?php echo $value['status'] == 1 ? 'checked' : '' ?> class="onoffswitch-checkbox status" data-id="<?php echo $value['_id'] ?>" id="status-<?php echo $value['_id'] ?>">
                                                <label class="onoffswitch-label" for="status-<?php echo $value['_id'] ?>">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <?php if($value['isCrawl']){ ?>
                                            <span class="badge badge-sm bg-gradient-success">Đã thu thập</span>
                                        <?php }else{ ?>
                                            <span class="badge badge-sm bg-gradient-warning">Chưa thu thập</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
                <?php $actual_link = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REDIRECT_URL]"; ?>
                <?php if(isset($urlList['pagination']) && is_array($urlList['pagination']) && count($urlList['pagination'])){ 
                    if($urlList['pagination']['limit'] < $urlList['pagination']['total']){
                    $pagination = ceil($urlList['pagination']['total'] / $urlList['pagination']['limit']);
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

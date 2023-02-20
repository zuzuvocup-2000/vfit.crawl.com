<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 mb-3">
                <h6><?php echo $title ?>: <?php echo $website['data']['url'] ?></h6>
                <div class="wrap-search ">
                    <form class="d-flex justify-content-between mb-3" action="" method="get">
                        <select class="form-control select-user" style="width: 200px;" name="limit">
                            <option value='20' <?php echo isset($_GET['limit']) && $_GET['limit'] == '20' ? 'selected' : ''  ?>>20 bản ghi</option>
                            <option value='30' <?php echo isset($_GET['limit']) && $_GET['limit'] == '30' ? 'selected' : ''  ?>>30 bản ghi</option>
                            <option value='40' <?php echo isset($_GET['limit']) && $_GET['limit'] == '40' ? 'selected' : ''  ?>>40 bản ghi</option>
                            <option value='50' <?php echo isset($_GET['limit']) && $_GET['limit'] == '50' ? 'selected' : ''  ?>>50 bản ghi</option>
                            <option value='100' <?php echo isset($_GET['limit']) && $_GET['limit'] == '100' ? 'selected' : ''  ?>>100 bản ghi</option>
                        </select>
                        <div class="d-flex flex-middle ">
                            <div class="input-group ms-3" style="width: 500px;">
                                <input type="text" name="keyword" class="form-control keyword-search" placeholder="Nhập từ khóa để tìm kiếm..." aria-label="Nhập từ khóa để tìm kiếm" aria-describedby="button-addon2" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                                <button class="btn btn-outline-primary mb-0 btn-click-search-user" type="submit" id="button-addon2">Tìm kiếm</button>
                            </div>
                            <a href="config/article/create/<?php echo $website['data']['_id'] ?>" class="btn btn-primary m-0 ms-3">Thêm mới</a>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bộ chọn HTML</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center" style="width: 120px;">Loại Bài Viết</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center" style="width: 120px;">Nhóm Bài Viết</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Website gốc</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($configArticleList['data']) && is_array($configArticleList['data']) && count($configArticleList['data'])){ 
                                foreach ($configArticleList['data'] as $key => $value) {
                            ?>
                                <tr class="list-item">
                                    <td class="text-center">
                                        <div class="form-check text-center p-0 m-0 d-flex align-items-center justify-content-center click ">
                                            <input class="form-check-input m-auto" type="checkbox" value="" onchange="$(this).parents('.list-item').toggleClass('change-bg')">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center wrap-selector">
                                            <h6 class="mb-0 text-sm"><?php echo $value['dataType'] == 'RATE' ? 'Array[]' : $value['selector'] ?></h6>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $value['dataType'] ?>                                    
                                    </td>
                                    <td class="text-center">
                                        <?php echo $value['group'] ?>                                    
                                    </td>
                                    <td class="text-center">
                                        <?php echo $website['data']['url'] ?>                                      
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            
                                            <a href="/config/article/update/<?php echo $website['data']['_id'] ?>/<?php echo $value['_id'] ?>" class="btn bg-gradient-success mb-0" style="margin-right: 10px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a class="btn bg-gradient-danger btn-delete-article mb-0" data-id="<?php echo $value['_id'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
                <?php $actual_link = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REDIRECT_URL]"; ?>
                <?php if(isset($configArticleList['pagination']) && is_array($configArticleList['pagination']) && count($configArticleList['pagination'])){ 
                    if($configArticleList['pagination']['limit'] < $configArticleList['pagination']['total']){
                    $pagination = ceil($configArticleList['pagination']['total'] / $configArticleList['pagination']['limit']);
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

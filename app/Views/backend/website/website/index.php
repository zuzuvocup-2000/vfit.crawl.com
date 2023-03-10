<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 mb-3">
                <h6><?php echo $title ?></h6>
                <div class="note-table">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="note-table-title text-xs">Chú thích:</div>
                            <ul>
                                <li class="text-danger text-xs">TLBV: Thiết lập bài viết</li>
                                <li class="text-danger text-xs">TLDM: Thiết lập danh mục</li>
                            </ul>
                        </div>
                        <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Cài đặt hệ thống
                        </button>
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title" id="exampleModalLabel">Cài đặt hệ thống</h5>
                                        <div class="text-warning text-xs">Lưu ý: Hệ thống chạy ẩn, xin vui lòng chờ ít phút để tiếp tục sử dụng chức năng hệ thống!</div>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="wrap-crawl-modal mb3">
                                        <div class="title-modal mb-2">Thu thập toàn bộ Url của các Website</div>
                                        <div class="wrap-btn">
                                            <button class="btn-crawl-url-sitemap btn me-3 btn-primary">1. Thu thập Url bằng Sitemap</button>
                                            <button class="btn-crawl-url-normal btn btn-secondary me-3">2. Thu thập Url bình thường</button>
                                            <button class="btn-crawl-url-sitemap-pending btn btn-info">3. Thu thập Sitemap chờ</button>
                                        </div>
                                    </div>
                                    <div class="wrap-crawl-modal mb3">
                                        <div class="title-modal mb-2">Thu thập dữ liệu bài viết và danh mục</div>
                                        <div class="wrap-btn">
                                            <button class="btn-crawl-url-chunk-site btn me-3 btn-primary">1. Chia đều Website theo 5 luồng</button>
                                            <button class="btn-crawl-data btn me-3 btn-secondary">2. Thu thập dữ liệu</button>
                                        </div>
                                    </div>
                                    <div class="wrap-crawl-modal mb3">
                                        <div class="title-modal mb-2">Phân tích và đánh giá dữ liệu</div>
                                        <div class="wrap-btn">
                                            <button class="btn-crawl-url-chunk-article btn me-3 btn-primary">1. Chia đều bài viết theo 10 luồng</button>
                                            <button class="btn-statistic btn me-3 btn-secondary">2. Phân tích dữ liệu</button>
                                            <button class="btn-result btn me-3 btn-info">3. Tổng kết dữ liệu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <a href="/website/create" class="btn btn-primary m-0 ms-3">Thêm mới</a>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">URL</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center" style="width: 120px;">Loại Website</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center" style="width: 120px;">Loại Crawl</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 80px;">TLBV</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 80px;">TLDM</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 100px;">Ngày thu thập</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 130px;">Trạng thái</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($websiteList['data']) && is_array($websiteList['data']) && count($websiteList['data'])){ 
                                foreach ($websiteList['data'] as $key => $value) {
                            ?>
                                <tr class="list-item" >
                                    <td class="text-center">
                                        <div class="form-check text-center p-0 m-0 d-flex align-items-center justify-content-center click ">
                                            <input class="form-check-input m-auto" type="checkbox" value="" onchange="$(this).parents('.list-item').toggleClass('change-bg')">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <a href="<?php echo $value['url'] ?>" target="_blank" class="mb-0 text-sm"><?php echo $value['url'] ?></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $value['type']  ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $value['typeCrawl']  ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="config/article/index/<?php echo $value['_id'] ?>" class="btn bg-gradient-primary m-0"><i class="ni ni-settings-gear-65"></i></a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="config/catalogue/index/<?php echo $value['_id'] ?>"  class="btn bg-gradient-secondary m-0"><i class="ni ni-settings-gear-65"></i></a>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo isset($value['crawlUrlAt']) ? date('d-m-Y H:i:s', strtotime($value['crawlUrlAt'])) : '-' ?></span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <?php if($value['status'] == 1){ ?>
                                            <span class="badge badge-sm bg-gradient-success">Active</span>
                                        <?php }else{ ?>
                                            <span class="badge badge-sm bg-gradient-warning">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <a href="/website/url/<?php echo $value['_id'] ?>" class="btn bg-gradient-info mb-0" style="margin-right: 10px;"><i class="fa fa-globe" aria-hidden="true"></i></a>
                                            <a href="/website/update/<?php echo $value['_id'] ?>" class="btn bg-gradient-success mb-0" style="margin-right: 10px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a class="btn bg-gradient-danger btn-delete-website mb-0" data-id="<?php echo $value['_id'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
                <?php $actual_link = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REDIRECT_URL]"; ?>
                <?php if(isset($websiteList['pagination']) && is_array($websiteList['pagination']) && count($websiteList['pagination'])){ 
                    if($websiteList['pagination']['limit'] < $websiteList['pagination']['total']){
                    $pagination = ceil($websiteList['pagination']['total'] / $websiteList['pagination']['limit']);
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

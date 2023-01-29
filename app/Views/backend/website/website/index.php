<?php 
    $actual_link = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(isset($_GET['filter'])){
        $filter = json_decode($_GET['filter'],true);
    }
?>
<?php $url_dropdown = $_SERVER['REDIRECT_URL'].'?filter='.(isset($_GET['filter']) ? $_GET['filter'] : '{}').'&page='.(isset($_GET['page']) ? $_GET['page'] : 0).'&limit=' ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 mb-3">
                <h6>Danh sách Website</h6>
                <div class="note-table">
                    <div class="note-table-title text-xs">Chú thích:</div>
                    <ul>
                        <li class="text-danger text-xs">TLBV: Thiết lập bài viết</li>
                        <li class="text-danger text-xs">TLDM: Thiết lập danh mục</li>
                    </ul>
                </div>
                <div class="wrap-search">
                    <div class="d-flex justify-content-between">
                        <select class="form-control select-website" style="width: 200px;">
                            <option value='<?php echo $url_dropdown.'20' ?>' <?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_dropdown.'20' == urldecode($actual_link) ? 'selected' : ''  ?>>20 bản ghi</option>
                            <option value='<?php echo $url_dropdown.'30' ?>' <?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_dropdown.'30' == urldecode($actual_link) ? 'selected' : ''  ?>>30 bản ghi</option>
                            <option value='<?php echo $url_dropdown.'40' ?>' <?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_dropdown.'40' == urldecode($actual_link) ? 'selected' : ''  ?>>40 bản ghi</option>
                            <option value='<?php echo $url_dropdown.'50' ?>' <?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_dropdown.'50' == urldecode($actual_link) ? 'selected' : ''  ?>>50 bản ghi</option>
                            <option value='<?php echo $url_dropdown.'100' ?>' <?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_dropdown.'100' == urldecode($actual_link) ? 'selected' : ''  ?>>100 bản ghi</option>
                        </select>
                        <div class="d-flex flex-middle">
                            <div class="input-group " style="width: 500px;">
                                <input type="text" name="keyword" class="form-control keyword-search" placeholder="Nhập từ khóa để tìm kiếm..." aria-label="Nhập từ khóa để tìm kiếm" aria-describedby="button-addon2" value="<?php echo isset($filter['url']['$regex']) ? $filter['url']['$regex'] : '' ?>">
                                <button class="btn btn-outline-primary mb-0 btn-click-search-website" type="submit" id="button-addon2">Tìm kiếm</button>
                            </div>
                            <a href="/website/create" class="btn btn-primary m-0 ms-3">Thêm mới</a>
                        </div>
                    </div>  
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
                                            <h6 class="mb-0 text-sm"><?php echo $value['url'] ?></h6>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $value['type']  ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $value['typeCrawl']  ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn bg-gradient-primary m-0"><i class="ni ni-settings-gear-65"></i></button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn bg-gradient-secondary m-0"><i class="ni ni-settings-gear-65"></i></button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo date('d-m-Y H:i:s', strtotime($value['crawlUrlAt'])) ?></span>
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
                                            <a href="/website/update/<?php echo $value['_id'] ?>" class="btn bg-gradient-success mb-0" style="margin-right: 10px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a class="btn bg-gradient-danger btn-delete-website mb-0" data-id="<?php echo $value['_id'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.keyword-search').keyup(function(e){
        if(e.keyCode == 13)
        {
            let val = $('.keyword-search').val();
            if(val != ''){
                let url = '<?php echo $_SERVER['REDIRECT_URL'].'?filter={"url":{"$regex":"{keyword}"}}&page='.(isset($_GET['page']) ? $_GET['page'] : 0).'&limit='.(isset($_GET['limit']) ? $_GET['limit'] : 20) ?>';
                window.location.href = url.replace("{keyword}", val);
            }else{
                window.location.href = '<?php echo $_SERVER['REDIRECT_URL'].'?filter={}&page='.(isset($_GET['page']) ? $_GET['page'] : 0).'&limit='.(isset($_GET['limit']) ? $_GET['limit'] : 20) ?>';
            }
        }
    });
    $(document).on('click', '.btn-click-search-website', function(){
        let val = $('.keyword-search').val();
        if(val != ''){
            let url = '<?php echo $_SERVER['REDIRECT_URL'].'?filter={"url":{"$regex":"{keyword}"}}&page='.(isset($_GET['page']) ? $_GET['page'] : 0).'&limit='.(isset($_GET['limit']) ? $_GET['limit'] : 20) ?>';
            window.location.href = url.replace("{keyword}", val);
        }else{
            window.location.href = '<?php echo $_SERVER['REDIRECT_URL'].'?filter={}&page='.(isset($_GET['page']) ? $_GET['page'] : 0).'&limit='.(isset($_GET['limit']) ? $_GET['limit'] : 20) ?>';
        }
    })

    $(document).on('change', '.select-website', function(){
        let val = $(this).val();
        window.location.href = val;
    })
</script>
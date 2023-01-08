<?php
    helper('form');
    $baseController = new App\Controllers\BaseController();
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản lý Website</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Trang chủ</a>
         </li>
         <li class="active"><strong>Quản lý Website</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Website </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" method="">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
                            <div class="perpage">
                                <div class="uk-flex uk-flex-middle mb10">
                                    <select name="perpage" class="form-control input-sm perpage filter mr10">
                                        <option value="20">20 bản ghi</option>
                                        <option value="30">30 bản ghi</option>
                                        <option value="40">40 bản ghi</option>
                                        <option value="50">50 bản ghi</option>
                                        <option value="60">60 bản ghi</option>
                                        <option value="70">70 bản ghi</option>
                                        <option value="80">80 bản ghi</option>
                                        <option value="90">90 bản ghi</option>
                                        <option value="100">100 bản ghi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="uk-search uk-flex uk-flex-middle mr10 ml10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập từ khóa để tìm kiếm..." class="form-control">
                                            <span class="input-group-btn">
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm kiếm
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="uk-button" style="background: transparent !important;">
                                        <a href="<?php echo base_url('website/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus mr10"></i>Thêm mới Website</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th style="width: 35px;">
                                    <input type="checkbox" id="checkbox-all">
                                    <label for="check-all" class="labelCheckAll"></label>
                                </th>
                                <th class="text-center" style="width: 35px;">STT</th>
                                <th class="text-center">URL Website</th>
                                <th class="text-center" style="width:120px;">Run crawl product</th>
                                <th class="text-center" style="width:120px;">Run crawl category</th>
                                <th class="text-center" style="width:120px;">Config article</th>
                                <th class="text-center" style="width:120px;">Config catalogue</th>
                                <th class="text-center" style="width:120px;">Config sitemap</th>
                                <th class="text-center" style="width:120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if(isset($articleList) && is_array($articleList) && count($articleList)){ ?>
                            <?php foreach($articleList as $key => $val){ ?>

                            <?php
                                $image = ( isset($val['image']) && $val['image'] != '' ? getthumb($val['image'], true) : 'public/not-found.png');
                                $catalogue = json_decode($val['catalogue'], TRUE);
                                $cat_list = [];
                                if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
                                    $cat_list = get_catalogue_object([
                                        'module' => $module,
                                        'catalogue' => $catalogue,
                                    ]);
                                }

                            ?>
                            <?php
                                $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                            ?>

                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td><?php echo $val['id']; ?></td>
                                <td>
                                    <div class="uk-flex uk-flex-middle">
                                        <div class="main-info">
                                            <div class="title"><a class="maintitle" href="<?php echo site_url('backend/article/article/update/'.$val['id']); ?>" title=""><?php echo $val['article_title']; ?> (<?php echo $val['viewed']; ?>)</a></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/article/article/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/article/article/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                    <a type="button" href="#my-id" class="btn btn-success" data-uk-modal="{target:'#my-id'}"><i class="fa fa-cogs" aria-hidden="true"></i></a>
                                </td>
                                <td class="text-center">
                                    <a type="button" href="#my-id2" class="btn btn-warning" data-uk-modal="{target:'#my-id2'}"><i class="fa fa-cogs" aria-hidden="true"></i></a>
                                </td>
                                <td class="text-center">
                                    <a type="button" href="#my-id3" class="btn btn-info" data-uk-modal="{target:'#my-id3'}"><i class="fa fa-bars"></i></a>
                                </td>
                                <td class="text-center td-status" data-field="publish" data-module="<?php echo $module; ?>" data-where="id"><?php echo $status; ?></td>
                               
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="100%"><span class="text-danger">Không có bản ghi cần hiển thị...</span></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                    <div id="pagination">
                        <?php echo (isset($pagination)) ? $pagination : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div id="my-id" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
                <div class="uk-flex uk-flex-middle uk-flex-space-between mb10">
                    <div class="webname">https://demo.com.vn/</div>
                    <div class="btn btn-success"><a href="" title="" style="color: white;">Add more</a></div>
                </div>
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th style="width: 35px;">
                                <input type="checkbox" id="checkbox-all">
                                <label for="check-all" class="labelCheckAll"></label>
                            </th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Step</th>
                            <th class="text-center" style="width:103px;">Field</th>
                            <th class="text-center" style="width:103px;">Pattern type</th>
                            <th class="text-center" style="width:103px;">Data type</th>
                            <th class="text-center" style="width:103px;">Pattern</th>
                            <th class="text-center" style="width:103px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(isset($articleList) && is_array($articleList) && count($articleList)){ ?>
                        <?php foreach($articleList as $key => $val){ ?>

                        <?php
                            $image = ( isset($val['image']) && $val['image'] != '' ? getthumb($val['image'], true) : 'public/not-found.png');
                            $catalogue = json_decode($val['catalogue'], TRUE);
                            $cat_list = [];
                            if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
                                $cat_list = get_catalogue_object([
                                    'module' => $module,
                                    'catalogue' => $catalogue,
                                ]);
                            }

                        ?>
                        <?php
                            $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                        ?>

                        <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                            <td>
                                <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                <div for="" class="label-checkboxitem"></div>
                            </td>
                            <td><?php echo $val['id']; ?></td>
                            <td>
                                1
                            </td>
                            <td class="text-center">
                                title
                            </td>
                            <td class="text-center">
                                css
                            </td>
                            <td class="text-center">
                                text
                            </td>
                            <td class="text-center">
                                h1.title
                            </td>
                            <td class="text-center uk-flex">
                                <a type="button" href="" class="btn btn-primary mr10"><i class="fa fa-edit"></i></a>
                                <a type="button" href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                            
                        </tr>
                        <?php }}else{ ?>
                            <tr>
                                <td colspan="100%"><span class="text-danger">Không có bản ghi cần hiển thị...</span></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </div>
    </div>
    <div id="my-id2" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
             <table class="table table-striped table-bordered table-hover dataTables-example ">
                <thead>
                    <tr>
                        <th style="width: 35px;">
                            <input type="checkbox" id="checkbox-all">
                            <label for="check-all" class="labelCheckAll"></label>
                        </th>
                        <th class="text-center">ID</th>
                        <th class="text-center">Pattern</th>
                        <th class="text-center" style="width:103px;">Type</th>
                        <th class="text-center" style="width:103px;">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if(isset($articleList) && is_array($articleList) && count($articleList)){ ?>
                    <?php foreach($articleList as $key => $val){ ?>

                    <?php
                        $image = ( isset($val['image']) && $val['image'] != '' ? getthumb($val['image'], true) : 'public/not-found.png');
                        $catalogue = json_decode($val['catalogue'], TRUE);
                        $cat_list = [];
                        if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
                            $cat_list = get_catalogue_object([
                                'module' => $module,
                                'catalogue' => $catalogue,
                            ]);
                        }
                    ?>
                    <?php
                        $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                    ?>

                    <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                            <div for="" class="label-checkboxitem"></div>
                        </td>
                        <td><?php echo $val['id']; ?></td>
                        <td>
                            <div class="uk-flex uk-flex-middle">
                                <div class="main-info">
                                    <div class="title"><a class="maintitle" href="<?php echo site_url('backend/article/article/update/'.$val['id']); ?>" title=""><?php echo $val['article_title']; ?> (<?php echo $val['viewed']; ?>)</a></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            CSS
                        </td>
                        <td class="text-center">
                            <a type="button" href="<?php echo base_url('backend/article/article/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                    <?php }}else{ ?>
                        <tr>
                            <td colspan="100%"><span class="text-danger">Không có bản ghi cần hiển thị...</span></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="btn-group-popup mt30">
                <div class="uk-text-right" ><a class="btn btn-success  btn-add " href="" title="">Add more</a></div>
                <div class="uk-flex uk-flex-right mt10">
                    <a href="" class="btn btn-close mr20" style="background: gray">Close</a>
                    <a href="" class="btn btn-save btn-info" style="width: 81.36px">Save as</a>
                </div>
            </div>
        </div>
    </div>
    <div id="my-id3" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
             <table class="table table-striped table-bordered table-hover dataTables-example ">
                <thead>
                    <tr>
                        <th style="width: 35px;">
                            <input type="checkbox" id="checkbox-all">
                            <label for="check-all" class="labelCheckAll"></label>
                        </th>
                        <th class="text-center">ID</th>
                        <th class="text-center">URL</th>
                        <th class="text-center" style="width:103px;">Type</th>
                        <th class="text-center" style="width:103px;">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if(isset($articleList) && is_array($articleList) && count($articleList)){ ?>
                    <?php foreach($articleList as $key => $val){ ?>

                    <?php
                        $image = ( isset($val['image']) && $val['image'] != '' ? getthumb($val['image'], true) : 'public/not-found.png');
                        $catalogue = json_decode($val['catalogue'], TRUE);
                        $cat_list = [];
                        if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
                            $cat_list = get_catalogue_object([
                                'module' => $module,
                                'catalogue' => $catalogue,
                            ]);
                        }
                    ?>
                    <?php
                        $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                    ?>

                    <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                            <div for="" class="label-checkboxitem"></div>
                        </td>
                        <td><?php echo $val['id']; ?></td>
                        <td>
                            <div class="uk-flex uk-flex-middle">
                                <div class="main-info">
                                    <input type="text">
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <select class="select2" name="" id="">
                                <option value="0">CSS</option>
                                <option value="1">HTML</option>
                                <option value="0">JS</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <a type="button" href="<?php echo base_url('backend/article/article/update/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php }}else{ ?>
                        <tr>
                            <td colspan="100%"><span class="text-danger">Không có bản ghi cần hiển thị...</span></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="btn-group-popup mt30">
                <div class="uk-text-right" ><a class="btn btn-success  btn-add " href="" title="">Add more</a></div>
            </div>
        </div>
    </div>
<?php
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2><?php echo translate('cms_lang.post.post_title', $language) ?></h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><?php echo translate('cms_lang.post.post_home', $language) ?></a>
         </li>
         <li class="active"><strong><?php echo translate('cms_lang.post.post_title', $language) ?></strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo translate('cms_lang.post.post_title', $language) ?> </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                         <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="delete-all" data-module="<?php echo $module; ?>"><?php echo translate('cms_lang.post.post_deleteall', $language) ?></a>
                            </li>
                            <li><a href="#" class="clone-all" data-toggle="modal" data-target="#clone_modal" data-module="<?php echo $module; ?>">Sao chép</a>
                            <li><a href="#" class="status" data-value="0" data-field="publish" data-module="<?php echo $module; ?>" title="Cập nhật trạng thái bài viết"><?php echo translate('cms_lang.post.post_deactive', $language) ?></a>
                            </li>
                            <li><a href="#" class="status" data-value="1" data-field="publish" data-module="<?php echo $module; ?>" data-title="Cập nhật trạng thái bài viết"><?php echo translate('cms_lang.post.post_active', $language) ?></a>
                            </li>
                        </ul>
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
                                        <option value="20">20 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="30">30 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="40">40 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="50">50 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="60">60 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="70">70 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="80">80 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="90">90 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                        <option value="100">100 <?php echo translate('cms_lang.post.post_record', $language) ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="form-row cat-wrap">
                                        <?php echo form_dropdown('catalogueid', $dropdown, set_value('catalogueid', (isset($_GET['catalogueid'])) ? $_GET['catalogueid'] : ''), 'class="form-control m-b select2 mr10" style="width:220px;"');?>
                                    </div>
                                    <div class="uk-search uk-flex uk-flex-middle mr10 ml10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="<?php echo translate('cms_lang.post.post_placeholder', $language) ?>" class="form-control">
                                            <span class="input-group-btn">
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm"><?php echo translate('cms_lang.post.post_search', $language) ?>
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="uk-button" style="background: transparent !important;">
                                        <a href="<?php echo base_url('backend/article/article/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus mr10"></i><?php echo translate('cms_lang.post.post_add', $language) ?></a>
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
                                <th class="text-center">ID</th>
                                <th class="text-center">URL</th>
                                <th class="text-center" style="width:103px;">Run crawl product</th>
                                <th class="text-center" style="width:103px;">Run crawl category</th>
                                <th class="text-center" style="width:103px;">Config article</th>
                                <th class="text-center" style="width:103px;">Config catalogue</th>
                                <th class="text-center" style="width:103px;">Config sitemap</th>
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
                                    <td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.post.empty', $language) ?></span></td>
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
<div id="clone_modal" class="modal fade va-general">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">
                    <div class="uk-flex uk-flex-space-between uk-flex-middle" >
                        <h4 class="modal-title">Nhập số lượng cần Sao chép</h4>  
                        <button type="button" class="close" data-dismiss="modal">&times;</button>  
                    </div>  
                </div>  
                <div class="modal-body">  
                    <form method="post" id="clone_general" class="uk-clearfix" data-max-0="3">  
                        <div class="va-input-general mb15">
                            <label>Số lượng</label>  
                            <input type="text" name="quantity" id="quantity" class="form-control" />  
                        </div>
                        <input type="submit"  value="Sao chép" data-module="<?php echo $module ?>" class="btn btn-success clone-btn float-right" />  
                    </form>  
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
                                <td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.post.empty', $language) ?></span></td>
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
                            <td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.post.empty', $language) ?></span></td>
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
                            <td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.post.empty', $language) ?></span></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="btn-group-popup mt30">
                <div class="uk-text-right" ><a class="btn btn-success  btn-add " href="" title="">Add more</a></div>
            </div>
        </div>
    </div>
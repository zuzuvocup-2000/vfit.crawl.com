<?php  
    helper('form');
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Tác giả</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Tác giả</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Tác giả </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-author">
                            <li><a href="#" class="delete-all">Xóa tất cả</a>
                            </li>
                            <li><a href="#" class="status" data-value="0" data-field="publish" data-module="author" title="Cập nhật trạng thái người dùng">Deactive Tác giả</a>
                            </li> 
                            <li><a href="#" class="status" data-value="1" data-field="publish" data-module="author" data-title="Cập nhật trạng thái người dùng">Active Tác giả</a>
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
                                    <?php 
                                        $authorCatalogue = get_data(['select' => 'id, title','table' => 'author_catalogue','where' => ['deleted_at' => 0],'order_by' => 'title asc']);
                                        $authorCatalogue = convert_array([
                                            'data' => $authorCatalogue,
                                            'field' => 'id',
                                            'value' => 'title',
                                            'text' => 'Nhóm Tác giả',
                                        ]);
                                    ?>
                                    <?php echo form_dropdown('catalogueid', $authorCatalogue, set_value('catalogueid', (isset($_GET['catalogueid'])) ? $_GET['catalogueid'] : 0), 'class="form-control select2 mr10"');?>
                                   
                                    
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    
                                    <?php   
                                         $gender = [
                                            -1 => 'Giới Tính',
                                            0 => 'Nữ',
                                            1 => 'Nam',
                                         ];
                                        echo form_dropdown('gender', $gender, set_value('gender', (isset($_GET['gender'])) ? $_GET['gender'] : -1),'class="form-control mr10 input-sm perpage filter" style="width:115px"'); 
                                    ?>
                                    <div class="uk-search uk-flex uk-flex-middle mr10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control"> 
                                            <span class="input-group-btn"> 
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                                            </button> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/author/author/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm Tác giả mới</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="checkbox-all">
                                <label for="check-all" class="labelCheckAll"></label>
                            </th>
                            <th>Họ Tên</th>
                            <th class="text-center">Nghề nghiệp</th>
                            <th style="width: 80px;" class="text-center">Giới tính</th>
                            <th class="text-center">Tình trạng</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($authorList) && is_array($authorList) && count($authorList)){ ?>
                            <?php foreach($authorList as $key => $val){ ?>
                            <?php  
                                $gender = ($val['gender'] == 1) ? 'Nam' : 'Nữ';
                                $fullname = ($val['fullname'] != '') ? $val['fullname'] : '-';
                                $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
                            ?>
                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td><?php echo $fullname ?></td>
                                <td class="text-center"><?php echo $val['job'] ?></td>
                                <td  class="text-center"><?php echo $gender; ?></td>
                                <td class="text-center td-status" data-field="publish" data-module="<?php echo $module; ?>"><?php echo $status; ?></td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/author/author/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/author/author/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>
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
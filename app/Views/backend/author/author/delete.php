<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Xóa Tác giả: <?php echo $author['fullname'] ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>">Home</a>
			</li>
			<li class="active"><strong>Xóa Tác giả</strong></li>
		</ol>
	</div>
</div>
<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-5">
				<div class="panel-head">
					<h2 class="panel-title">Thông tin chung</h2>
					<div class="panel-description">
						Một số thông tin cơ bản của người sử dụng.
						<div><span class="text-danger">Khi xóa Tác giả, thì Tác giả này sẽ không thể truy cập và mất toàn bộ thông tin. Hãy chắc chắn bạn muốn thực hiện chức năng này!</span></div>
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="ibox m0">
					<div class="ibox-content">
						<div class="row ">
								<div class="col-lg-6 mb10">
									<div class="form-row">
										<label class="control-label text-left">
											<span>Họ tên <b class="text-danger">(*)</b></span>
										</label>
										<?php echo form_input('fullname', set_value('fullname', (isset($author['fullname'])) ? $author['fullname'] : ''), 'disabled class="form-control " placeholder="" autocomplete="off"');?>
									</div>
								</div>
								<div class="col-lg-6 mb10">
									<div class="form-row">
										<label class="control-label text-left">
											<span>Nhóm Tác giả <b class="text-danger">(*)</b></span>
										</label>
										<?php
											$authorCatalogue = get_data(['select' => 'id, title','table' => 'author_catalogue','where' => ['deleted_at' => 0],'order_by' => 'title asc']);
											$authorCatalogue = convert_array([
												'data' => $authorCatalogue,
												'field' => 'id',
												'value' => 'title',
												'text' => 'Nhóm Tác giả',
											]);
										?>
										<?php echo form_dropdown('catalogueid', $authorCatalogue, set_value('catalogueid', (isset($author['catalogueid'])) ? $author['catalogueid'] : ''), 'class="form-control m-b select2 " disabled');?>
									</div>
								</div>
								<div class="col-lg-6 mb10">
									<div class="form-row">
										<label class="control-label text-left">
											<span>Email </span>
										</label>
										<?php echo form_input('email', set_value('email', (isset($author['email'])) ? $author['email'] : ''), 'class="form-control " disabled placeholder="" autocomplete="off"');?>
									</div>
								</div>
								<div class="col-lg-6 mb10">
									<div class="form-row">
										<label class="control-label text-left">
											<span>Số điện thoại </span>
										</label>
										<?php echo form_input('phone', set_value('phone', (isset($author['phone'])) ? $author['phone'] : ''), 'class="form-control " disabled placeholder="" autocomplete="off"');?>
									</div>
								</div>
								<div class="col-lg-6 mb10">
									<div class="form-row">
										<label class="control-label text-left">
											<span>Giới tính</span>
										</label>
										<?php
										$gender = [
										-1 => 'Giới Tính',
										0 => 'Nữ',
										1 => 'Nam',
										];
										echo form_dropdown('gender', $gender, set_value('gender', (isset($author['gender'])) ? $author['gender'] : -1),'class="form-control mr20 input-sm perpage filter" style="width:100%" disabled');
										?>
									</div>
								</div>
								<div class="col-lg-6 mb10 ">
									<div class="form-row">
										<label class="control-label text-left">
											<span>Nghề nghiệp</span>
										</label>
										<?php echo form_input('job', set_value('job', (isset($author['job'])) ? $author['job'] : ''), 'class="form-control" placeholder="" disabled autocomplete="off" ');?>
									</div>
								</div>
							</div>
						<div class="toolbox action clearfix">
							<div class="uk-flex uk-flex-middle uk-button pull-right">
								<button class="btn btn-danger btn-sm" name="delete" value="delete" type="submit">Xóa Tác giả</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
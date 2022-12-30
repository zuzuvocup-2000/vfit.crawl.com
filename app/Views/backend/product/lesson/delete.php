<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<script type="text/javascript">
	var id = '<?php echo $lesson['id'] ?>';
</script>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Xóa bài học: <?php echo $lesson['title'] ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>"><?php echo translate('cms_lang.post.post_home', $language) ?></a>
			</li>
			<li class="active"><strong>Xóa bài học</strong></li>
		</ol>
	</div>
</div>
<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-5">
				<div class="panel-head">
					<h2 class="panel-title"><?php echo translate('cms_lang.post.post_delete_general', $language) ?></h2>
					<div class="panel-description">
						Khi xóa Bài học, thì Bài học này sẽ không thể truy cập và mất toàn bộ thông tin. Hãy chắc chắn bạn muốn thực hiện chức năng này!
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="ibox m0">
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tiêu đề bài học <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', set_value('title', $lesson['title']), 'class="form-control" disabled placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('id', set_value('id', $lesson['id']), 'class="form-control" disabled placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="toolbox action clearfix">
							<div class="uk-flex uk-flex-middle uk-button pull-right">
								<button class="btn btn-danger btn-sm" name="delete" value="delete" type="submit"><?php echo translate('cms_lang.post.post_delete_btn', $language) ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</form>
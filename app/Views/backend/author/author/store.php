<?php
helper('form', 'data');
$baseController = new App\Controllers\BaseController();
$language = $baseController->currentLanguage();
?>
<style>
	.sort-slide .show-image {
	display: none;
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
	text-align: center;
	color: #fff;
	width: 100%;
	font-size: 15px;
	}
	.sort-slide .thumb:hover .show-image {
	display: block;
	}
</style>
<form method="post" action="" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
				</div><!-- /.box-body -->
			</div>
			<div class="row">
				<div class="col-lg-8 clearfix">
					<div class="ibox mb20">
						<div class="ibox-title" style="padding: 9px 15px 0px;">
							<div class="uk-flex uk-flex-middle uk-flex-space-between">
								<h5><?php echo translate('cms_lang.post.post_info', $language) ?> <small class="text-danger"> điền đầy đủ các thông tin được mô tả dưới đây</small></h5>
								<div class="ibox-tools">
									<button type="submit" name="create" value="create" class="btn btn-primary block full-width m-b">Lưu</button>
								</div>
							</div>
						</div>
						<div class="ibox-content">
							<div class="row ">
								<div class="col-lg-12 mb10">
									<div class="form-row">
										<label class="control-label text-left">
											<span>Họ tên <b class="text-danger">(*)</b></span>
										</label>
										<?php echo form_input('fullname', set_value('fullname', (isset($author['fullname'])) ? $author['fullname'] : ''), 'class="form-control title" placeholder="" autocomplete="off"');?>
									</div>
								</div>
								<div class="col-lg-6 mb10">
									<div class="form-row">
										<label class="control-label text-left">
											<span>Email </span>
										</label>
										<?php echo form_input('email', set_value('email', (isset($author['email'])) ? $author['email'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
									</div>
								</div>
								<div class="col-lg-6 mb10">
									<div class="form-row">
										<label class="control-label text-left">
											<span>Số điện thoại </span>
										</label>
										<?php echo form_input('phone', set_value('phone', (isset($author['phone'])) ? $author['phone'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
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
											echo form_dropdown('gender', $gender, set_value('gender', (isset($author['gender'])) ? $author['gender'] : -1),'class="form-control mr20 input-sm perpage filter" style="width:100%"');
										?>
									</div>
								</div>
								<div class="col-lg-6 mb10 ">
									<div class="form-row">
										<label class="control-label text-left">
											<span>Nghề nghiệp</span>
										</label>
										<?php echo form_input('job', set_value('job', (isset($author['job'])) ? $author['job'] : ''), 'class="form-control" placeholder="" autocomplete="off" ');?>
									</div>
								</div>
							</div>
							<div class="row mb15">
								<div class="col-lg-12">
									<div class="form-row form-description">
										<div class="uk-flex uk-flex-middle uk-flex-space-between">
											<label class="control-label text-left">
												<span><?php echo translate('cms_lang.post.post_description', $language) ?></span>
											</label>
											<a href="" title="" data-target="description" class="uploadMultiImage"><?php echo translate('cms_lang.post.post_upload', $language) ?></a>
										</div>
										<?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($author['description'])) ? $author['description'] : ''))), 'class="form-control ck-editor" id="description" placeholder="" autocomplete="off"');?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox ibox-seo mb20">
						<div class="ibox-title">
							<div class="uk-flex uk-flex-middle uk-flex-space-between">
								<h5><?php echo translate('cms_lang.post.post_seo', $language) ?></h5>
								<div class="uk-flex uk-flex-middle uk-flex-space-between">
									<div class="edit">
										<a href="#" class="edit-seo"><?php echo translate('cms_lang.post.post_seo_edit', $language) ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="col-lg-12">
									<?php
										$metaTitle = (isset($_POST['meta_title'])) ? $_POST['meta_title'] : ((isset($author['meta_title']) && $author['meta_title'] != '') ? $author['meta_title'] : translate('cms_lang.post.post_seo_validate_title', $language)) ;
										$googleLink = (isset($_POST['canonical'])) ? $_POST['canonical'] : ((isset($author['canonical']) && $author['canonical'] != '') ? BASE_URL.$author['canonical'].HTSUFFIX : BASE_URL.'duong-dan-website'.HTSUFFIX) ;
										$metaDescription = (isset($_POST['meta_description'])) ? $_POST['meta_description'] : ((isset($author['meta_description']) && $author['meta_description'] != '') ? $author['meta_description'] : translate('cms_lang.post.post_seo_validate_description', $language)) ;
									?>
									<div class="google">
										<div class="g-title"><?php echo $metaTitle; ?></div>
										<div class="g-link"><?php echo $googleLink ?></div>
										<div class="g-description" id="metaDescription">
											<?php echo $metaDescription; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="seo-group hidden">
								<hr>
								<div class="row mb15">
									<div class="col-lg-12">
										<div class="form-row">
											<div class="uk-flex uk-flex-middle uk-flex-space-between">
												<label class="control-label ">
													<span><?php echo translate('cms_lang.post.post_seo_title', $language) ?></span>
												</label>
												<span style="color:#9fafba;"><span id="titleCount">0</span> <?php echo translate('cms_lang.post.post_seo_number_title', $language) ?></span>
											</div>
											<?php echo form_input('meta_title', htmlspecialchars_decode(html_entity_decode(set_value('meta_title', (isset($author['meta_title'])) ? $author['meta_title'] : ''))), 'class="form-control meta-title" placeholder="" autocomplete="off"');?>
										</div>
									</div>
								</div>
								<div class="row mb15">
									<div class="col-lg-12">
										<div class="form-row">
											<div class="uk-flex uk-flex-middle uk-flex-space-between">
												<label class="control-label ">
													<span><?php echo translate('cms_lang.post.post_seo_description', $language) ?></span>
												</label>
												<span style="color:#9fafba;"><span id="descriptionCount">0</span> <?php echo translate('cms_lang.post.post_seo_number_description', $language) ?></span>
											</div>
											<?php echo form_textarea('meta_description', set_value('meta_description', (isset($author['meta_description'])) ? $author['meta_description'] : ''), 'class="form-control meta-description" id="seoDescription" placeholder="" autocomplete="off"');?>
										</div>
									</div>
								</div>
								<div class="row mb15">
									<div class="col-lg-12">
										<div class="form-row">
											<div class="uk-flex uk-flex-middle uk-flex-space-between">
												<label class="control-label ">
													<span><?php echo translate('cms_lang.post.post_seo_canonical', $language) ?><b class="text-danger">(*)</b></span>
												</label>
											</div>
											<div class="outer">
												<div class="uk-flex uk-flex-middle">
													<div class="base-url"><?php echo base_url(); ?></div>
													<?php echo form_input('canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($author['canonical'])) ? $author['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off" data-flag="0" ');?>
													<?php echo form_hidden('original_canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($author['canonical'])) ? $author['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off"');?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right">Lưu</button>
				</div>
				<div class="col-lg-4">
					<div class="ibox mb20">
						<div class="ibox-title">
							<h5>Nhóm Tác giả <b class="text-danger">(*)</b></h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-row">
										<?php
											$authorCatalogue = get_data(['select' => 'id, title','table' => 'author_catalogue','where' => ['deleted_at' => 0],'order_by' => 'title asc']);
											$authorCatalogue = convert_array([
												'data' => $authorCatalogue,
												'field' => 'id',
												'value' => 'title',
												'text' => 'Nhóm Tác giả',
											]);
										?>
										<?php echo form_dropdown('catalogueid', $authorCatalogue, set_value('catalogueid', (isset($author['catalogueid'])) ? $author['catalogueid'] : ''), 'class="form-control m-b select2 "');?>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="ibox mb20">
						<div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
							<h5 class="choose-image" style="cursor: pointer;margin:0;">Video Iframe</h5>
						</div>
						<div class="ibox-content">
							<div class="row mb15">
								<div class="col-lg-12">
									<div class="form-row form-description">
										<?php echo form_textarea('video', htmlspecialchars_decode(html_entity_decode(set_value('video', (isset($author['video'])) ? $author['video'] : ''))), 'class="form-control"  placeholder="" autocomplete="off"');?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox mb20">
						<div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
							<h5 class="choose-image" style="cursor: pointer;margin:0;">Router</h5>
						</div>
						<div class="ibox-content">
							<div class="form-row">
								<div class="text-danger">Lưu ý: Chỉ dành cho lập trình viên</div>
								<?php echo form_input('router', set_value('router', (isset($author['router']) && $author['router'] != '') ? $author['router'] : '\App\Controllers\Frontend\Author\Author::index'), 'class="form-control router-display"  placeholder="" autocomplete="off" data-flag="0" ');?>
							</div>
						</div>
					</div>
					<div class="ibox mb20">
						<div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
							<h5 class="choose-image" style="cursor: pointer;margin:0;">Template hiển thị Website</h5>
						</div>
						<div class="ibox-content">
							<div class="form-row">
								<div class="text-danger">Lưu ý: Chỉ dành cho lập trình viên</div>
								<?php echo form_input('template', set_value('template', (isset($author['template']) && $author['template'] != '') ? $author['template'] : 'frontend/author/author/index'), 'class="form-control router-display"  placeholder="" autocomplete="off" data-flag="0" ');?>
							</div>
						</div>
					</div>
					<div class="ibox mb20">
						<div class="ibox-title">
							<h5 class="choose-image" style="cursor: pointer;"><?php echo translate('cms_lang.post.post_avatar', $language) ?> </h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-row">
										<div class="avatar" style="cursor: pointer;"><img src="<?php echo (isset($_POST['image'])) ? $_POST['image'] : ((isset($author['image']) && $author['image'] != '') ? $author['image'] : 'public/not-found.png') ?>" class="img-thumbnail" alt=""></div>
										<?php echo form_input('image', htmlspecialchars_decode(html_entity_decode(set_value('image', (isset($author['image'])) ? $author['image'] : ''))), 'class="form-control " placeholder="Đường dẫn của ảnh"  id="imageTxt"  autocomplete="off" style="display:none;" ');?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox mb20">
						<div class="ibox-title">
							<h5 class="choose-image" style="cursor: pointer;">Chữ ký </h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-row">
										<div class="avatar" style="cursor: pointer;"><img src="<?php echo (isset($_POST['signature'])) ? $_POST['signature'] : ((isset($author['signature']) && $author['signature'] != '') ? $author['signature'] : 'public/not-found.png') ?>" class="img-thumbnail" alt=""></div>
										<?php echo form_input('signature', htmlspecialchars_decode(html_entity_decode(set_value('signature', (isset($author['signature'])) ? $author['signature'] : ''))), 'class="form-control " placeholder="Đường dẫn của ảnh"    autocomplete="off" style="display:none;" ');?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox mb20">
						<div class="ibox-title">
							<h5><?php echo translate('cms_lang.post.post_display', $language) ?></h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-row">
										<div class="text-warning mb15"><?php echo translate('cms_lang.post.post_display_des', $language) ?></div>
										<div class="block clearfix">
											<div class="i-checks mr30" style="width:100%;">
												<span style="color:#000;" class="uk-flex uk-flex-middle">
													<?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($author['publish']) && $author['publish'] == 1)) ? true : (!isset($_POST['publish'])) ? true : false),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
													<label for="publish" style="margin:0;cursor:pointer;"><?php echo translate('cms_lang.post.post_display_1', $language) ?></label>
												</span>
											</div>
										</div>
										<div class="block clearfix">
											<div class="i-checks" style="width:100%;">
												<span style="color:#000;" class="uk-flex uk-flex-middle">
													<?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($author['publish']) && $author['publish'] == 0)) ? true : false),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>
													<label for="no-publish" style="margin:0;cursor:pointer;"><?php echo translate('cms_lang.post.post_display_0', $language) ?></label>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
<?php
    helper('form', 'data');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $get_catalogue = check_type_canonical($language);
    if($get_catalogue['content'] == 'silo'){
    	$class = 'get_catalogue';
    }else{
    	$class = '';
    }
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
							<h5><?php echo translate('cms_lang.post.post_info', $language) ?> <small class="text-danger"><?php echo translate('cms_lang.post.post_sub_info', $language) ?></small></h5>
							<div class="ibox-tools">
								<button type="submit" name="create" value="create" class="btn btn-primary block full-width m-b"><?php echo translate('cms_lang.post.post_save', $language) ?></button>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tiêu đề bài học <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', validate_input(set_value('title', (isset($lesson['title'])) ? $lesson['title'] : '')), 'class="form-control '.(($method == 'create') ? 'title' : '').'" placeholder="" id="title" autocomplete="off"'); ?>
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
									<?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($lesson['description'])) ? $lesson['description'] : ''))), 'class="form-control ck-editor" id="description" placeholder="" autocomplete="off"');?>

								</div>
							</div>
						</div>

						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											<span><?php echo translate('cms_lang.post.post_content', $language) ?></span>
										</label>
										<a href="" title="" data-target="content" class="uploadMultiImage"><?php echo translate('cms_lang.post.post_upload', $language) ?></a>
									</div>
									<?php echo form_textarea('content', htmlspecialchars_decode(html_entity_decode(set_value('content', (isset($lesson['content'])) ? $lesson['content'] : ''))), 'class="form-control ck-editor" id="content" placeholder="" autocomplete="off"');?>
								</div>
								<div class="uk-flex uk-flex-middle uk-flex-space-between">
									<label class="control-label text-left ">
										<span>Nội dung mở rộng</span>
									</label>
									<a href="" title="" class="add-attr" onclick="return false;">Thêm nội dung +</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ibox">
					<div class="row" id="sortable-view">
					    <div class="col-lg-12 ui-sortable attr-more">
					    	<?php if(isset($lesson['sub_title']) && is_array($lesson['sub_title']) && count($lesson['sub_title'])){ ?>
							<?php foreach ($lesson['sub_title'] as $key => $value) {?>
								<?php $id = slug($value) ?>
						        <div class="ibox desc-more" style="opacity: 1;">
						            <div class="ibox-title ui-sortable-handle ">
						            	<div class="uk-flex uk-flex-middle row">
							                <div class="col-lg-8">
												<input type="text" name="sub_content[title][]" class="form-control" value="<?php echo $value ?>" placeholder="Tiêu đề">
											</div>
											<div class="col-lg-4">
												<div class="uk-flex uk-flex-middle uk-flex-space-between">
													<a href="" title="" data-target="<?php echo $id ?>" class="uploadMultiImage">Upload hình ảnh</a>
									                <div class="ibox-tools">
									                    <a class="collapse-link ui-sortable">
									                        <i class="fa fa-chevron-up"></i>
									                    </a>
									                    <a class="close-link">
									                        <i class="fa fa-times"></i>
									                    </a>
									                </div>
												</div>
											</div>

						            	</div>
						            </div>
						            <div class="ibox-content" style="">
						            	<div class="row">
							                <div class="col-lg-12" >
							                	<textarea name="sub_content[description][]" class="form-control ck-editor" id="<?php echo $id ?>" placeholder="Mô tả"><?php echo $lesson['sub_content'][$key] ?></textarea>
											</div>
										</div>
						            </div>
						        </div>
					        <?php }} ?>
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
									$metaTitle = (isset($_POST['meta_title'])) ? $_POST['meta_title'] : ((isset($lesson['meta_title']) && $lesson['meta_title'] != '') ? $lesson['meta_title'] : translate('cms_lang.post.post_seo_validate_title', $language)) ;
									$googleLink = (isset($_POST['canonical'])) ? $_POST['canonical'] : ((isset($lesson['canonical']) && $lesson['canonical'] != '') ? BASE_URL.$lesson['canonical'].HTSUFFIX : BASE_URL.'duong-dan-website'.HTSUFFIX) ;
									$metaDescription = (isset($_POST['meta_description'])) ? $_POST['meta_description'] : ((isset($lesson['meta_description']) && $lesson['meta_description'] != '') ? $lesson['meta_description'] : translate('cms_lang.post.post_seo_validate_description', $language)) ;
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
										<?php echo form_input('meta_title', htmlspecialchars_decode(html_entity_decode(set_value('meta_title', (isset($lesson['meta_title'])) ? $lesson['meta_title'] : ''))), 'class="form-control meta-title" placeholder="" autocomplete="off"');?>
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
										<?php echo form_textarea('meta_description', set_value('meta_description', (isset($lesson['meta_description'])) ? $lesson['meta_description'] : ''), 'class="form-control meta-description" id="seoDescription" placeholder="" autocomplete="off"');?>
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
												<?php echo form_input('canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($lesson['canonical'])) ? $lesson['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off" data-flag="0" ');?>
												<?php echo form_hidden('original_canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($lesson['canonical'])) ? $lesson['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off"');?>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
				<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right"><?php echo translate('cms_lang.post.post_save', $language) ?></button>

			</div>
			<div class="col-lg-4">
				<div class="ibox mb20">
					<div class="ibox-title">
						<h5>Lựa chọn Khóa học</h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<?php echo form_dropdown('catalogueid', $dropdown, set_value('catalogueid', (isset($lesson['catalogueid'])) ? $lesson['catalogueid'] : ''), 'class="form-control m-b select2 '.($method == 'create' ? $class : '').'" data-module="'.$module.'"');?>
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
                            	<div class="form-row mb15">
                            		<label>Thời lượng video</label>
                            		<?php echo form_input('time', validate_input(set_value('time', (isset($lesson['time'])) ? $lesson['time'] : '')), 'class="form-control" placeholder="" autocomplete="off"'); ?>
                            	</div>
                                <div class="form-row form-description">
                                    <?php echo form_textarea('video', htmlspecialchars_decode(html_entity_decode(set_value('video', (isset($lesson['video'])) ? $lesson['video'] : ''))), 'class="form-control"  placeholder="" autocomplete="off"');?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="ibox mb20" style="display:none">
					<div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
						<h5 class="choose-image" style="cursor: pointer;margin:0;">Router</h5>
					</div>
					<div class="ibox-content">
						<div class="form-row">
							<div class="text-danger">Lưu ý: Chỉ dành cho lập trình viên</div>
							<?php echo form_input('router', set_value('router', (isset($lesson['router']) && $lesson['router'] != '') ? $lesson['router'] : '\App\Controllers\Frontend\Product\Lesson::index'), 'class="form-control router-display"  placeholder="" autocomplete="off" data-flag="0" ');?>
						</div>
					</div>
				</div>
				<div class="ibox mb20" style="display:none">
					<div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
						<h5 class="choose-image" style="cursor: pointer;margin:0;">Template hiển thị Website</h5>
					</div>
					<div class="ibox-content">
						<div class="form-row">
							<div class="text-danger">Lưu ý: Chỉ dành cho lập trình viên</div>
							<?php echo form_input('template', set_value('template', (isset($lesson['template']) && $lesson['template'] != '') ? $lesson['template'] : 'frontend/product/lesson/index'), 'class="form-control router-display"  placeholder="" autocomplete="off" data-flag="0" ');?>
						</div>
					</div>
				</div>
				<div class="ibox mb20" style="display:none">
					<div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
						<h5 class="choose-image" style="cursor: pointer;margin:0;">Icon hiển thị </h5>
						<a href="" title="" data-target="image" class="uploadIcon">Upload hình ảnh</a>
					</div>
					<div class="ibox-content">
						<div class="form-row">
							<small class="text-danger">Chọn icon hoặc ảnh để hiển thị ra website</small>
							<?php echo form_input('icon', htmlspecialchars_decode(set_value('icon', (isset($lesson['icon'])) ? $lesson['icon'] : '')), 'class="form-control icon-display" placeholder="" autocomplete="off" data-flag="0" ');?>
						</div>
					</div>
				</div>
				<div class="ibox mb20">
					<div class="ibox-title">
						<h5>Chọn TAGS cho Bài học </h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<?php echo form_input('tags', validate_input(set_value('tags', (isset($tags)) ? $tags : '')), 'class="form-control tags tagsinput" placeholder="" id="tags" autocomplete="off"'); ?>
								</div>
							</div>
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
									<div class="avatar" style="cursor: pointer;"><img src="<?php echo (isset($_POST['image'])) ? $_POST['image'] : ((isset($lesson['image']) && $lesson['image'] != '') ? $lesson['image'] : 'public/not-found.png') ?>" class="img-thumbnail" alt=""></div>
									<?php echo form_input('image', htmlspecialchars_decode(html_entity_decode(set_value('image', (isset($lesson['image'])) ? $lesson['image'] : ''))), 'class="form-control " placeholder="Đường dẫn của ảnh"  id="imageTxt"  autocomplete="off" style="display:none;" ');?>
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
												<?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($lesson['publish']) && $lesson['publish'] == 1)) ? true : (!isset($_POST['publish'])) ? true : false),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
												<label for="publish" style="margin:0;cursor:pointer;"><?php echo translate('cms_lang.post.post_display_1', $language) ?></label>
											</span>
										</div>
									</div>
									<div class="block clearfix">
										<div class="i-checks" style="width:100%;">
											<span style="color:#000;" class="uk-flex uk-flex-middle">
												<?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($lesson['publish']) && $lesson['publish'] == 0)) ? true : false),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>

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
<div id="show_detail_image" class="modal fade va-general modal-banner" >
      <div class="modal-dialog modal-xl">
           <div class="modal-content">
                <div class="modal-header ">
                	<div class="uk-flex uk-flex-middle uk-flex-space-between">
	                    <h4 class="modal-title">Chi tiết ảnh</h4>
	                    <button type="button" class="close " data-dismiss="modal">&times;</button>
                	</div>
                </div>
                <div class="modal-body">
                	<form action="" class="form-horizontal-banner">
	                	<div class="form-group form-item-va uk-clearfix">
				            <label class="col-xs-4 control-label control-title-modal"  for="attachment-details-two-column-title">Đường dẫn ảnh</label>
				            <div class="col-xs-8"> <input type="text" id="attachment-details-two-column-title" placeholder="Đường dẫn ảnh..." name="title" class="form-control"> </div>
				        </div>
				        <div class="btn-question uk-clearfix mt20">
				        	<button class="btn btn-primary pull-right" type="submit">Lưu</button>
				        </div>
                	</form>
                </div>
           </div>
      </div>
 </div>
<script>
	
	$(document).on('click','.show-image', function(){
		let _this = $(this)
		get_data_image(_this)
		return false;
	});

	function get_data_image(_this){
		let data = _this.parents('.ui-state-default').find('.value-data-banner').val()
		console.log(data)
		let _class = _this.attr('data-class')
		
		$('.icon-change-image').removeAttr('disabled')
		if($(_class).is(':first-child') == true){
			$('.icon-change-image.left').attr('disabled', 'disabled')
		}
		if($(_class).is(':last-child') == true){
			$('.icon-change-image.right').attr('disabled', 'disabled')
		}
		$('.form-horizontal-banner').attr('data-target' , _class)
		$('.form-horizontal-banner')[0].reset();

		$('#attachment-details-two-column-title').val(data)
	}

	$(document).on('submit','.form-horizontal-banner', function(){
		let _this = $(this);
		let title = _this.find('#attachment-details-two-column-title').val()
		let _class = _this.attr('data-target')
		$(_class).find('.value-data-banner').val(title)
		toastr.success('Khởi tạo dữ liệu ảnh thành công','Thành công!');
		$('#show_detail_image').modal('hide');
		
		return false;
	})
</script>
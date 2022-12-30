<?php $gallery = get_slide(['keyword' => 'gallery' , 'language' => $language, ]) ?>
<div class="education uk-container-center container-1 pt50">
	<header class="header">
		<h1 class="main-heading uk-width-large-1-2 uk-container-center">
			<?php echo $object['title'] ?>
		</h1>
	</header>
	<section class="lodon-panel mb50">
		<header class="header mb20">
			<div class="description description_chuong_trinh">
				<?php echo $object['description'] ?>
			</div>
		</header>
	</section>
	<section class="classroom-panel content-chuong-trinh mb50">
		<?php echo $object['content'] ?>
	</section>
</div>
<section class="register-learn">
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-medium uk-clearfix ">
            <div class="uk-width-1-1 uk-width-1-4">
                <h2 class="tieude_dangkyhocthu ">Đăng ký học âm nhạc <br><span class="s" style="color:#ffde00;"> NGAY HÔM NAY</span></h2>
            </div>
            <div class="uk-width-1-1 uk-width-3-4">
                <form action="" class="va-form-contact form_tuvan " method="post">
                    <div class="uk-grid uk-grid-medium uk-grid-width-1-1 uk-grid-width-large-1-2 uk-clearfix mb20">
                        <div class="wrap-grid mb10">
                            <input type="text" name="fullname" value=""  class="form-control va-fullname-contact icon_hoten" placeholder="Nhập họ tên">
                        </div>
                        <div class="wrap-grid mb10">
                            <input type="text" name="phone" value=""  class="form-control va-phone-contact icon_sdt" placeholder="Nhập số điện thoại">
                        </div>
                        <div class="wrap-grid mb10">
                            <input type="text" name="email" value=""  class="form-control va-email-contact icon_email" placeholder="Nhập email của bạn">
                        </div>
                        <?php
                            $learn= explode('|', $general['parameter_learn']);
                        ?>
                        <div class="wrap-grid mb10">
                            <select name="message" class="nice-select icon_tieudetv w100 va-message-contact" aria-invalid="false">
                                <option value="">Lựa chọn khoá học</option>
                                <?php if(isset($learn) && is_array($learn) && count($learn)){
                                    foreach ($learn as $value) { ?>
                                    <option value="<?php echo $value ?>"><?php echo $value ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-flex uk-flex-center">
                        <input type="submit" value="ĐĂNG KÝ NGAY" class="btn-submit-form btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="another-lesson-panel mb50 pt30 pb30">
	<div class="uk-container-center container-1">
		<header class="header mb20">
			<h2 class="main-heading">
			CHƯƠNG TRÌNH ĐÀO TẠO KHÁC
			</h2>
		</header>
		<div class="another-lesson-body ">
			<div class="uk-grid uk-grid-medium">
				<?php if(isset($object['album']) && is_array($object['album']) && count($object['album'])){
					foreach ($object['album'] as $key => $value) {  ?>
					<div class="uk-width-large-1-2">
						<div class="the-pic">
							<a href="<?php echo $object['album_title'][$key] ?>" title="img" class="img img-cover">
								<?php echo render_img(['src' => $value]) ?>
							</a>
						</div>
					</div>
				<?php }} ?>
			</div>
		</div>
	</div>
</section>
<?php if(isset($object['sub_title']) && is_array($object['sub_title']) && count($object['sub_title'])){
	foreach ($object['sub_title'] as $key => $value) {
?>
	<section class="benefit-panel">
		<div class="uk-container-center container-1">
			<header class="header mb20">
				<h2 class="main-heading">
					<?php echo $value ?>
				</h2>
			</header>
			<div class="benefit-body uk-grid uk-grid-collapse uk-clearfix">
				<?php echo $object['sub_content'][$key] ?>
			</div>
		</div>
	</section>
<?php }} ?>

<?php if(isset($gallery) && is_array($gallery) && count($gallery)){ ?>
    <section class="gallery-panel">
        <h2 class="tieude_chuongtrinhhoc mb30" ><?php echo $gallery[0]['cat_title'] ?></h2>
        <div class="gallery" id="gallery">
            <?php foreach ($gallery as $value) { ?>
                <div class="pics animation all imggallery ">
                    <a class="img-cover img" href="<?php echo $value['image'] ?>" target="_blank">
                        <?php echo render_img(['src' => $value['image']]) ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>

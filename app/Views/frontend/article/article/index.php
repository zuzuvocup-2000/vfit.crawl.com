<?php $gallery = get_slide(['keyword' => 'gallery' , 'language' => $language, ]) ?>
<div class="article-panel ">
	<div class="uk-container uk-container-center">
		<h3 class="title_posthomesukien limit-line-3"><?php echo $object['title'] ?> </h3>
		<div class="box_thoigian"><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y', strtotime($object['created_at'])) ?> </div>
        <div class="homendsukien"><?php echo $object['description'] ?></div>
        <div class="article-content">
        	<?php echo $object['content'] ?>
        </div>
	</div>
</div>

<div class="wrap-relationship pb30">
	<div class="uk-container uk-container-center">
		<div class="article-realtionship uk-text-uppercase">Tin tức liên quan</div>
		<ul class="menu_footer uk-list">
            <?php if(isset($articleRelate) && is_array($articleRelate) && count($articleRelate)){
                foreach ($articleRelate as $value) {
            ?>
                <li  class="menu-item menu-item-type-post_type menu-item-object-page mb15 "><a href="<?php echo write_url($value['canonical']) ?>" title="<?php echo $value['title'] ?>" class="black"><?php echo $value['title'] ?></a></li>
            <?php }} ?>
        </ul>
	</div>
</div>
<section class="register-learn">
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-medium uk-clearfix ">
            <div class="uk-width-1-1 uk-width-large-1-4">
                <h2 class="tieude_dangkyhocthu ">ĐĂNG KÝ HỌC THỬ  <br> <span style="color:#ffde00;">NIỀM VUI NHÂN ĐÔI</span></h2>
            </div>
            <div class="uk-width-1-1 uk-width-large-3-4">
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

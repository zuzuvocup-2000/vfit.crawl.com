<?php $gallery = get_slide(['keyword' => 'gallery' , 'language' => $language, ]) ?>
<?php $event_banner = get_slide(['keyword' => 'banner-event' , 'language' => $language, ]) ?>
<?php $color = explode('|', $general['parameter_color']); ?>


<section class="wrap-contact-panel pt50">
    <div class="uk-container uk-container-center">
        <header class="header mb40">
            <h2 class="main-heading uk-text-uppercase">
                Liên hệ
            </h2>
        </header>
        <form action="" class="va-form-contact form_tuvan " method="post">
            <div class="uk-grid uk-grid-medium uk-grid-width-1-1 uk-grid-width-large-1-2 uk-clearfix ">
                <div class="wrap-grid mb10">
                    <input type="text" name="fullname" value=""  class="form-control va-fullname-contact icon_hoten" placeholder="Nhập họ tên">
                </div>
                <div class="wrap-grid mb10">
                    <input type="text" name="phone" value=""  class="form-control va-phone-contact icon_sdt" placeholder="Nhập số điện thoại">
                </div>
            </div>
            <div class="wrap-grid mb10">
                <input type="text" name="email" value=""  class="form-control icon-contact  va-email-contact icon_email" placeholder="Nhập email của bạn">
            </div>
            
            <div class="wrap-grid mb10">
                <textarea name="message" placeholder="Nhập nội dung" rows="5" class="icon_tieudetv icon-contact form-textarea w100 va-message-contact"></textarea>
            </div>
            <div class="uk-flex uk-flex-center">
                <input type="submit" value="Gửi đi" class="btn-submit-form btn btn-success">
            </div>
        </form>
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

<section class="news-panel">
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-medium uk-grid-width-large-1-2 uk-clearfix">
            <div class="wrap-grid">
                <?php if(isset($event_banner) && is_array($event_banner) && count($event_banner)){ ?>
                    <div class="wrap-box-1">
                        <h2 class="tieude_chuongtrinhhoc mb20" ><?php echo $event_banner[0]['cat_title'] ?></h2>
                        <div class="banner-aside">
                            <div class="va-thumb-1-1">
                                <a class="image img-cover" href="<?php echo $event_banner[0]['canonical'] ?>" title="<?php echo $event_banner[0]['title'] ?>">
                                    <?php echo render_img(['src' => $event_banner[0]['image']]) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if(isset($panel['event']['data']) && is_array($panel['event']['data']) && count($panel['event']['data'])){ ?>
                    <div class="wrap-box-2">
                        <h2 class="tieude_chuongtrinhhoc mb20" ><?php echo $panel['event']['title'] ?></h2>
                        <div class="bd_ngaydienrasukien">
                            <?php foreach ($panel['event']['data'] as $value) { ?>
                                <?php $new_color = $color[array_rand($color)] ?> 
                                <div class="uk-grid uk-grid-medium uk-clearfix box_hometintuc mb30">
                                    <div class="uk-width-1-3 uk-width-medium-1-4 uk-width-large-1-4" >
                                        <div class="ngaydienrasukien ngaydienrasukien1" style="background-color:<?php echo $new_color ?>;">
                                        <?php echo isset($value['video']) ? $value['video'] : '' ?>  </div>
                                    </div>
                                    <div class="uk-width-2-3 uk-width-medium-3-4 uk-width-large-3-4" >
                                        <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="" title="<?php echo $value['title'] ?>">
                                            <h3 class="title_posthomesukien"> <?php echo $value['title'] ?> </h3>
                                        </a>
                                        <p class="box_thoigian"><i class="fa fa-clock-o"></i> Bắt đầu </p>
                                        <p class="homendsukien limit-line-3"><?php echo strip_tags(base64_decode($value['description'])) ?></p>
                                        
                                        <a class="tbl_xemngaysukienst" title="<?php echo $value['title'] ?>" href="<?php echo $value['canonical'].HTSUFFIX ?>"> Xem ngay</a>
                                        
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="wrap-grid">
                <?php if(isset($panel['news']['data']) && is_array($panel['news']['data']) && count($panel['news']['data'])){ ?>
                    <h2 class="tieude_chuongtrinhhoc mb20" ><?php echo $panel['news']['title'] ?></h2>
                    <?php foreach ($panel['news']['data'] as $value) { ?>
                        <div class=" box_hometintuc uk-grid uk-grid-medium uk-clearfix mb20">
                            <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-2">
                                <div class="va-thumb-1-1">
                                    <a class="img-cover" href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>">
                                        <?php echo render_img(['src' => $value['image'], 'class' => 'img-fluid center-block imgposthomesukien wp-post-image']) ?>
                                    </a>
                                </div>
                            </div>
                            <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-2">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="">
                                    <h3 class="title_posthomesukien limit-line-3"><?php echo $value['title'] ?> </h3>
                                </a>
                                <p class="box_thoigian"><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y', strtotime($value['created_at'])) ?> </p>
                                <p class="homendsukien limit-line-5"><?php echo strip_tags(base64_decode($value['description'])) ?></p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
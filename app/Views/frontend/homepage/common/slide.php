<?php
    $owlInit = array(
        'lazyload' => true,
        'loop' => false,
        'margin' => 15,
        'autoplay' => false,
        'autoplayTimeout' => 3000,
        'items' => 1,
        'nav' => true,
        'dots' => true,
        'navText' => ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    );
?>
<div class="wrap-slide-product">
    <div class="owl-slide ">
        <div class="owl-carousel owl-theme" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>">
            <?php if(isset($object['album']) && is_array($object['album']) && count($object['album'])){
            foreach ($object['album'] as $value) {
            ?>
                <div class="slide-product-item">
                    <div class="img-scaledown">
                        <img src="<?php echo $value ?>" alt="<?php echo $value ?>">
                    </div>
                </div>
            <?php }} ?>
        </div>
    </div>
    <div class="row-viewmore-thumb">
        <div class="col-viewmore-item pop1 gallery">
            <a href="#" class="pop-gallery">
                <?php echo render_img(['src' => $object['image']]) ?>
                <div class="over-gallery">Xem <?php echo (isset($object['album']) ? count($object['album']) : 0) ?> hình</div>
            </a>
        </div>

        <div class="col-viewmore-item comment" style="cursor: pointer;">
            <div class="icon-spec">
                <?php echo render_img(['src' => 'public/Comments-icon.png']) ?>
            </div>
            <div class="title-spec">
                <a href="#box-danhgia">
                Xem 273 nhận xét</a>
            </div>
        </div>
        
        <div class="col-viewmore-item special" style="cursor: pointer;">
            <div class="icon-spec">
                <?php echo render_img(['src' => 'public/thong-so-icon.png']) ?>
            </div>
            <div class="title-spec"><a href="#box-thongso">Thông số kỹ thuật</a></div>
        </div>
        <?php if(isset($object['icon']) && $object['icon'] != ''){ ?>
            <div class="col-viewmore-item qrcode-prod" title="Soi QR Code để chuyển sang điện thoại. Bấm vào để phóng to, thu nhỏ">
                <?php echo render_img(['src' => $object['icon'], 'attr' => 'id = "img_qr_code"']) ?>
            </div>
            <script>
                $(document).on('click', '#img_qr_code', function(){
                    $(this).toggleClass('hover');

                })
            </script>
        <?php } ?>
        
    </div>
</div>
<section id="popme">
    <div class="popupGallery">
        <h2>Bộ hình sản phẩm (<?php echo (isset($object['album']) ? count($object['album']) : 0) ?>)</h2>
        <a href="#" class="close">x Đóng</a>
        <div class="gallery">
            <?php if(isset($object['album']) && is_array($object['album']) && count($object['album'])){
            foreach ($object['album'] as $value) {
            ?>
                <div>
                    <img id="owl-img-0" src="<?php echo $value ?>" alt="Ảnh">
                </div>
            <?php }} ?>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).on('click', '.pop-gallery' , function(){
        $('#popme').addClass('active')
        return false
    })

    $(document).on('click', '#popme .close' , function(){
        $('#popme').removeClass('active')
        return false
    })
</script>
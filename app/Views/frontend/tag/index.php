<?php
	helper(['mydatafrontend','mydata']);
	$baseController = new App\Controllers\FrontendController();
?>
<div id="catalogue">
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-small">
			<div class="uk-width-large-1-5">
				<?php echo view('frontend/homepage/common/aside') ?>
			</div>
			<div class="uk-width-large-4-5">
				<div class="catalogue-container">
					<h1 class="title">Tìm kiếm theo Tag: <?php echo (isset($tag_title) ? $tag_title : '') ?></h1>
					<div class="panel-body main-category">
						<?php if(isset($productList) && is_array($productList) && count($productList)){ ?>
						<div class="uk-grid uk-grid-small ajax-list">
							<?php foreach($productList as $keyPost => $valPost){ ?>
							<?php
	                            $titleS = $valPost['title'];
	                            $canonicalS = write_url($valPost['canonical']);
	                            $percent = percent($valPost['price'], $valPost['price_promotion']);
	                            $brand = (!empty($valPost['brand_title'])) ? $valPost['brand_title'] : 'Đang cập nhật';
	                            $price_show = ($valPost['price_promotion'] > 0) ? number_format($valPost['price_promotion'],'0',',','.').'đ' : ($valPost['price'] > 0 ?  number_format($valPost['price'], 0, ',', '.') : 0).'đ';
	                            if($price_show == 0){
	                                $price_show = 'Liên Hệ';
	                            }
	                        ?>
							<div class="uk-width-1-2 uk-width-medium-1-2 uk-width-large-1-4 mb10">
								<div class="product-item mb10">
	                                <div class="percent">-<?php echo $percent; ?>%</div>
	                                <a href="<?php echo $canonicalS; ?>" class="image img-scaledown">
	                                      <?php echo render_img(['src' => $valPost['image'],'alt' => $valPost['title']]); ?>
	                                </a>
	                                <h4 class="title limit-line-2"><a href="<?php echo $canonicalS; ?>" title="<?php echo $titleS; ?>"><?php echo $titleS; ?></a></h4>
	                                <div class="brand">Thương hiệu: <?php echo $brand; ?></div>
	                                <div class="promotion-box uk-flex uk-flex-middle uk-flex-space-between">
	                                    <div class="price-box">
	                                        <div class="fs-price"><?php echo $price_show ?></div>
	                                        <?php if($valPost['price_promotion'] > 0){ ?>
	                                        <div class="s-price">Giá gốc: <?php echo number_format($valPost['price'], 0, ',','.') ?>đ</div>
	                                        <?php } ?>
	                                    </div>
	                                    <div class="rate-box">
	                                        <span class="rating-box" title="4,8 sao">
	                                            <span class="fa fa-star rated"></span>
	                                            <span class="fa fa-star rated"></span>
	                                            <span class="fa fa-star rated"></span>
	                                            <span class="fa fa-star rated"></span>
	                                            <span class="fa fa-star rated"></span>
	                                        </span>
	                                        <span class="rate-count">(<?php echo $valPost['rate']; ?>)</span>
	                                    </div>
	                                </div>
	                            </div>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
						<div class="panel-foot uk-text-center">
							<a href="" class="readmore" data-page="21" data-tags = "<?php echo base64_encode($tags) ?>"  data-start="2">Xem thêm sản phẩm <i style="font-size:11px;" class="fa fa-chevron-down"></i></a>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).on('click', '.readmore', function(){
        let _this = $(this);
        let nextPage = _this.attr('data-page');
        let tags = _this.attr('data-tags');
        let start = _this.attr('data-start');
        $.post('frontend/tag/tag/load_website',{
			nextPage : nextPage,tags : tags, start:start
		}, function(data){ // Success
            let json = JSON.parse(data);
            if(json.html.length > 0){
                $('.ajax-list').append(json.html)
            }
            let page = parseInt(nextPage)  + 1;
            _this.attr('data-page', page);
            start = page * 8;
            _this.attr('data-start', start);
        });
        return false;
    });
</script>
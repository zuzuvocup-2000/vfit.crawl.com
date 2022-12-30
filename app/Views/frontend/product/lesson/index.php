<div class="wrap-lesson pt50">
	<div class="uk-container uk-container-center">
		<div class="wrap-content-lesson mb30">
			<div class="lesson-catalogue mb20">
				<a href="<?php echo $detailCatalogue['cat_canonical'].HTSUFFIX ?>" title="<?php echo $detailCatalogue['cat_title'] ?>">
					<h3><?php echo $detailCatalogue['cat_title'] ?></h3>
				</a>
			</div>
			<h1 class="lesson-title-detail">
				<?php echo $object['title'] ?>
			</h1>
			<div class="author-lesson mb20">
				<div class="uk-flex uk-flex-middle">
					<div class="wrap-image-author mr15">
						<a href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>" title="<?php echo $detailCatalogue['title'] ?>" class="image img-cover">
							<?php echo render_img(['src' => $detailCatalogue['image']]) ?>
						</a>
					</div>
					<div>
						<a class="name-author-lesson " title="<?php echo $detailCatalogue['title'] ?>"  href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>">
							<?php echo $detailCatalogue['author'] ?>
						</a>
						<div class="time-lesson">
							<?php echo $object['time'] ?>
						</div>
					</div>
				</div>
			</div>
			<div class="lesson-description">
				<?php echo $object['description'] ?>
			</div>
		</div>
		<div class="wrap-video-lesson mb30">
			<div class="video-lesson">
				<?php echo $object['video'] ?>
			</div>
			<div class="wrap-video-footer mb30">
				<div class="video-footer uk-flex uk-flex-middle uk-flex-space-between uk-flex-wrap">
					<div class="video-footer__rating-text text-white">
						Students give MasterClass an average rating of 4.7 out of 5 stars
					</div>
					<div class="video-footer__rating-stars">
						<img src="public/full-star.svg">
						<img src="public/full-star.svg">
						<img src="public/full-star.svg">
						<img src="public/full-star.svg">
						<img src="public/half-star.svg">
					</div>
				</div>
				<hr class="mc-separator">
				<div class="video-footer__topics mc-pt-4">
					<p class="mc-text-small text-white mc-text--muted mb-32">Topics include: <?php echo $detailCatalogue['title'] ?></p>
				</div>
			</div>
			<div class="wrap-lesson-like ">
			 	<?php
			        $owlInit = array('margin' => 15,'lazyload' => true,'nav' => true,'autoplay' => false,'smartSpeed' => 1000,'autoplayTimeout' => 3000,'dots' => false,'loop' => true,
			            'responsive' => array(
			                0 => array(
			                    'items' => 2,
			                    'nav' => false
			                ),
			                600 => array(
			                    'items' => 3,
			                    'nav' => false
			                ),
			                1000 => array(
			                    'items' => 4,
			                ),
			            ),
			            'navText' => ['<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.155 5.47a.75.75 0 010 1.06L9.685 12l5.47 5.47a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z" fill="currentColor"></path></svg>','<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.845 5.47a.75.75 0 011.06 0l6 6a.75.75 0 010 1.06l-6 6a.75.75 0 01-1.06-1.06l5.47-5.47-5.47-5.47a.75.75 0 010-1.06z" fill="currentColor"></path></svg>']
			        );
			    ?>
			    <div class="product-panel">
			        <div class="uk-container uk-container-center">
			            <div class="panel-head uk-flex uk-flex-middle uk-flex-wrap">
			                <h2 class="heading-1"><span>Explore other classes</span></h2>
			                <ul class="uk-list uk-clearfix" data-uk-switcher="{connect:'#productList', animation: 'uk-animation-fade, uk-animation-slide-left',swiping : false}">
			                    <?php if(isset($productList['productFeatured']) && is_array($productList['productFeatured']) && count($productList['productFeatured'])){ ?>
			                        <li><a href="" title="">Featured</a></li>
			                    <?php } ?>
			                    <?php if(isset($productList['productViewed']) && is_array($productList['productViewed']) && count($productList['productViewed'])){ ?>
			                        <li><a href="" title="">Most Popular</a></li>
			                    <?php } ?>
			                    <?php if(isset($productList['productTrending']) && is_array($productList['productTrending']) && count($productList['productTrending'])){ ?>
			                        <li><a href="" title="">Trending</a></li>
			                    <?php } ?>
			                    <?php if(isset($productList['productNewest']) && is_array($productList['productNewest']) && count($productList['productNewest'])){ ?>
			                        <li><a href="" title="">Just Added</a></li>
			                    <?php } ?>
			                </ul>
			            </div>
			            <ul id="productList" class="uk-switcher">
			                <?php if(isset($productList) && is_array($productList) && count($productList)){
			                    foreach ($productList as $value) {
			                ?>
			                    <li>
			                        <div class="panel-body">
			                            <div class="owl-slide">
			                                <div class="owl-carousel" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>">
			                                    <?php if(isset($value) && is_array($value) && count($value)){
			                                        foreach ($value as $valueChild) {
			                                    ?>
			                                        <div>
			                                            <div class="class-item">
			                                                <div class="background"></div>
			                                                <a href="<?php echo $valueChild['canonical'].HTSUFFIX ?>" class="image img-cover">
			                                                    <img src="<?php echo $valueChild['image'] ?>" alt="<?php echo $valueChild['title'] ?>">
			                                                </a>
			                                                <div class="info">
			                                                    <a class="author-name image img-cover" href="<?php echo $valueChild['canonical'].HTSUFFIX ?>" title="<?php echo $valueChild['title'] ?>">
			                                                        <img src="<?php echo $valueChild['author_image'] ?>" alt="<?php echo $valueChild['author'] ?>">
			                                                    </a>
			                                                    <div class="title"><a href="<?php echo $valueChild['canonical'].HTSUFFIX ?>" title="<?php echo $valueChild['title'] ?>"><?php echo $valueChild['title'] ?></a></div>
			                                                </div>
			                                            </div>
			                                        </div>
			                                    <?php }} ?>
			                                </div>
			                            </div>
			                        </div>
			                    </li>
			                <?php }} ?>
			            </ul>
			        </div>
			    </div>
			</div>	
		</div>

		<div class="wrap-content-lesson">
			<div class="uk-grid uk-grid-large uk-clearfix">
				<div class="uk-width-1-1 uk-width-large-2-3">
					<div class="smooth-scroll-lesson mb30">
						<h3 class="smooth-scroll-lesson-title">On this page</h3>
						<ul class="list-smooth uk-clearfix  scroll" data-uk-scrollspy-nav="{closest:'li', smoothscroll:{offset:70}}">
							<li class="active"><a href="#preview" title="" data-uk-scrollspy="{cls:'uk-animation-fade',  delay:300}">Preview</a></li>
							<li><a href="#class-info" title="" data-uk-scrollspy="{cls:'uk-animation-fade',  delay:300}">Class Info</a></li>
						</ul>
					</div>
					<hr>
					<div class="wrap-content mb30" id="preview">
						<h3 class="smooth-scroll-lesson-title">Preview</h3>
						<?php echo $object['content'] ?>
					</div>
					<div class="class-info-content mb50" id="class-info">
						<div class="author-lesson mb20">
							<div class="uk-flex va-flex-mobile">
								<div class="wrap-image-author-info mr15">
									<a href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>" title="<?php echo $detailCatalogue['title'] ?>" class="image img-cover">
										<?php echo render_img(['src' => $detailCatalogue['image']]) ?>
									</a>
								</div>
								<div>
									<a class="catalogue-author-lesson uk-display-block" title="<?php echo $detailCatalogue['cat_title'] ?>"  href="<?php echo $detailCatalogue['cat_canonical'].HTSUFFIX ?>">
										<?php echo $detailCatalogue['cat_title'] ?>
									</a>
									<a class="name-author-lesson-info " title="<?php echo $detailCatalogue['title'] ?>"  href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>">
										<?php echo $detailCatalogue['author'] ?>
									</a>
									<div class="time-lesson mb20">
										<?php echo strip_tags(base64_decode($detailCatalogue['description'])) ?>
									</div>
									<a class="c-button c-button--tertiary va-btn" title="<?php echo $detailCatalogue['title'] ?>" href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>">Explore the Class</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="uk-width-1-1 uk-width-large-1-3">
					<div class="wrap-aside-author">
						<div class="author-lesson mb20">
							<div class="uk-flex uk-flex-middle mb20">
								<div class="wrap-image-author mr15">
									<a href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>" title="<?php echo $detailCatalogue['title'] ?>" class="image img-cover">
										<?php echo render_img(['src' => $detailCatalogue['image']]) ?>
									</a>
								</div>
								<div>
									<a class="name-author-lesson " title="<?php echo $detailCatalogue['title'] ?>"  href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>">
										<?php echo $detailCatalogue['author'] ?>
									</a>
									<div class="time-lesson">
										<?php echo $detailCatalogue['title'] ?>
									</div>
								</div>
							</div>
							<div class="aside-author-content">
								<?php echo strip_tags(base64_decode($detailCatalogue['description'])) ?>
							</div>
							<a class="va-continue" title="<?php echo $detailCatalogue['title'] ?>" href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>">Continue</a>
						</div>
					</div>
					<div class="list-lesson-plan">
						<div class="list-lesson-plan-title">LESSON PLAN</div>
						<ul class="uk-list list-lesson-detail">
							<?php $dem = 1; ?>
							<?php if(isset($lessonList) && is_array($lessonList) && count($lessonList)){
							foreach ($lessonList as $value) { ?>
								<li class="<?php echo ($value['canonical'] == $object['canonical'] ? 'active' : '') ?>"><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['article_title'] ?>"><?php echo $dem ?>. <?php echo$value['article_title'] ?></a></li>
							<?php $dem ++;}} ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
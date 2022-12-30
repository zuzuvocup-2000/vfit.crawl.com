<?php
	helper(['mydatafrontend','mydata']);
	$baseController = new App\Controllers\FrontendController();
    $language = $baseController->currentLanguage();
?>

<div id="product">
	<div class="product-banner">
		<div class="va-img img-cover">
			<?php 
				if(isset($object['album'][0])) {
					echo render_img(['src' => $object['album'][0]]);
				}
			?>
		</div>
		<div class="overlay"></div>
		<div class="product-information">
			<div class="author">
				<?php echo render_img(['src' => $object['author_image']]) ?>
			</div>
			<div class="title"><?php echo $object['title'] ?></div>
			<div class="uk-text-center">
				<div class="uk-flex uk-flex-middle uk-flex-center">
					<a href="#video-modal" data-iframe="<?php echo base64_encode($object['video']) ?>" class="btn-item btn-modal-iframe" data-uk-modal>
						<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon"><path d="M8.653 6.117A.75.75 0 007.5 6.75v10.5a.75.75 0 001.153.633l8.25-5.25a.75.75 0 000-1.266l-8.25-5.25z" fill="currentColor"></path></svg>
						<p>Trailer</p>
					</a>
					<a href="#video-modal" data-iframe="<?php echo base64_encode($object['video_2']) ?>" class="btn-item ml30 mr30 btn-modal-iframe" data-uk-modal>
						<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.16 5.429a.647.647 0 00-.651.642V6.5c0 .394-.345.714-.77.714-.424 0-.769-.32-.769-.714v-.429C6.97 4.947 7.93 4 9.16 4h10.65C21.04 4 22 4.947 22 6.071v6.108c0 1.124-.96 2.071-2.19 2.071h-.502c-.425 0-.77-.32-.77-.714 0-.395.345-.715.77-.715h.503c.338 0 .65-.268.65-.642V6.07a.647.647 0 00-.65-.642H9.16zM2 10.82c0-1.124.96-2.071 2.19-2.071h10.65c1.23 0 2.19.947 2.19 2.071v6.108c0 1.124-.96 2.071-2.19 2.071H4.19C2.96 19 2 18.053 2 16.929V10.82zm2.19-.642a.647.647 0 00-.652.642v6.108c0 .374.313.642.651.642H14.84c.339 0 .651-.268.651-.642V10.82a.647.647 0 00-.65-.642H4.188z" fill="currentColor"></path></svg>
						<p>Sample</p>
					</a>
					<a href="#share-link" data-uk-modal class="btn-item">
						<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon"><path fill-rule="evenodd" clip-rule="evenodd" d="M6 15a.75.75 0 01.75.75v.75c0 .414.336.75.75.75h9a.75.75 0 00.75-.75v-.75a.75.75 0 011.5 0v.75a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-.75A.75.75 0 016 15zM8.47 9.53a.75.75 0 001.06 0L12 7.06l2.47 2.47a.75.75 0 101.06-1.06l-3-3a.75.75 0 00-1.06 0l-3 3a.75.75 0 000 1.06z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M12 15a.75.75 0 00.75-.75V6.375a.75.75 0 00-1.5 0v7.875c0 .414.336.75.75.75z" fill="currentColor"></path></svg>
						<p>Share</p>
					</a>
					
				</div>
			</div>
			<?php if(empty($object['accept']) == true || $object['accept'] != 1){ ?>
				<div class="btn get-stated">
					<a href="buy-lesson.html?id=<?php echo $object['id'] ?>" class="button btn-submit get-started" >Get Started</a>
				</div>
				<div class="small-text uk-text-center">
					Starting at $<?php echo $object['price'] ?> (billed annually)
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="uk-container uk-container-center">
		<div class="panel-body-product">
			<div class="uk-flex uk-flex-center">
				<ul class="uk-list uk-clearfix uk-flex uk-flex-middle scroll uk-flex-wrap" data-uk-scrollspy-nav="{closest:'li', smoothscroll:{offset:70}}">
					<li class="active"><a href="#class-info" title="" data-uk-scrollspy="{cls:'uk-animation-fade',  delay:300}">Class Info</a></li>
					<li><a href="#related" title="" data-uk-scrollspy="{cls:'uk-animation-fade',  delay:300}">Related</a></li>
					<li><a href="#faq" data-uk-scrollspy="{cls:'uk-animation-fade', delay:300}" title="">Faq</a></li>
				</ul>
			</div>
			<div class="class-information">
				<div class="uk-grid uk-grid-medium">
					<div class="uk-width-large-1-3">
						<div class="class-info-item">
							<div class="subtitle">Class Length</div>
							<div class="maintitle"><?php echo $object['time'] ?></div>
						</div>
					</div>
					<div class="uk-width-large-1-3">
						<div class="class-info-item">
							<div class="subtitle">Category</div>
							<div class="maintitle"><a href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>" title="<?php echo $detailCatalogue['title'] ?>"><?php echo $detailCatalogue['title'] ?></a></div>
						</div>
					</div>
				</div>
			</div>
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
							'items' => 6,
						),
					),
					'navText' => ['<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.155 5.47a.75.75 0 010 1.06L9.685 12l5.47 5.47a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z" fill="currentColor"></path></svg>','<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.845 5.47a.75.75 0 011.06 0l6 6a.75.75 0 010 1.06l-6 6a.75.75 0 01-1.06-1.06l5.47-5.47-5.47-5.47a.75.75 0 010-1.06z" fill="currentColor"></path></svg>']
				);
			?>
			<div class="class-wrapper " id="class-info">
				<div class="uk-grid uk-grid-medium">
					<div class="uk-width-large-2-3">
						<div class="main-screen main-screen-video">
							<?php echo $object['video'] ?>
						</div>
					</div>
					<div class="uk-width-large-1-3">
						<div class="lession-list">
							<div class="trailer-list">
								<div class="trailer-item uk-flex uk-flex-middle" data-video="<?php echo base64_encode($object['video']) ?>">
									<div class="icon">
										<svg fill="none" height="2em" viewBox="0 0 25 25" width="2em" class="mc-mr-3 mc-icon--3 play-icon"><circle cx="12.938" cy="12.938" fill="#191c21" opacity="0.6" r="12.063"></circle><path clip-rule="evenodd" d="M17.294 12.774l-5.67-3.679a.634.634 0 00-.57-.05c-.186.075-.304.23-.304.401v7.358c0 .17.118.326.304.401a.636.636 0 00.57-.05l5.67-3.68a.423.423 0 00.206-.35.423.423 0 00-.206-.35z" fill="#fff" fill-rule="evenodd"></path></svg>
									</div>
									<span>Class Trailer</span>
								</div>
								<div class="trailer-item uk-flex uk-flex-middle" data-video="<?php echo base64_encode($object['video_2']) ?>">
									<div class="icon">
										<svg fill="none" height="2em" viewBox="0 0 25 25" width="2em" class="mc-mr-3 mc-icon--3 play-icon"><circle cx="12.938" cy="12.938" fill="#191c21" opacity="0.6" r="12.063"></circle><path clip-rule="evenodd" d="M17.294 12.774l-5.67-3.679a.634.634 0 00-.57-.05c-.186.075-.304.23-.304.401v7.358c0 .17.118.326.304.401a.636.636 0 00.57-.05l5.67-3.68a.423.423 0 00.206-.35.423.423 0 00-.206-.35z" fill="#fff" fill-rule="evenodd"></path></svg>
									</div>
									<span>Class Sample</span>
								</div>
							</div>
							<div class="main-lesssion">
								<h3 class="heading">Browse Lesson Plan</h3>
								<div class="main-lession-list"  id="style-2">
									<ul class="uk-list uk-clearfix">
										<?php if(isset($lessonList) && is_array($lessonList) && count($lessonList)){
											$dem = 1;
											foreach ($lessonList as $value) {
										 ?>
										<li>
											<div class="lession-item">
												<div class="lession-title uk-flex uk-flex-middle uk-flex-space-between">
													<span><?php echo $dem; ?>. <?php echo $value['article_title'] ?></span>
													<div class="icon">
														<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.47 8.845a.75.75 0 011.06 0l5.47 5.47 5.47-5.47a.75.75 0 111.06 1.06l-6 6a.75.75 0 01-1.06 0l-6-6a.75.75 0 010-1.06z" fill="currentColor"></path></svg>
													</div>
												</div>
												<div class="lession-description">
													<div class="time"><?php echo $value['time'] ?></div>
													<p><?php echo strip_tags(base64_decode($value['description'])) ?></p>
													<a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['article_title'] ?>" class="see-more">See more</a>
												</div>
											</div>
										</li>
										<?php $dem ++;}} ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="class-description">
					<div class="uk-grid uk-grid-medium">
						<div class="uk-width-large-2-3">
							<div class="class-entry">
								<?php echo $object['description'] ?>
								<?php echo $object['content'] ?>
							</div>
						</div>
						<div class="uk-width-large-1-3">
							<?php if(isset($object_next) && is_array($object_next) && count($object_next)){ ?>
								<div class="next-lession uk-clearfix">
									<a href="<?php echo $object_next['canonical'].HTSUFFIX ?>" title="<?php echo $object_next['title'] ?>" class="image img-cover">
										<?php echo render_img(['src' => $object_next['image']]) ?>
									</a>
									<div class="info">
										<div class=""><a href="<?php echo $object_next['canonical'].HTSUFFIX ?>" title="<?php echo $object_next['title'] ?>" class="next-1">Up Next</a></div>
										<div class=""><a href="<?php echo $object_next['canonical'].HTSUFFIX ?>" title="<?php echo $object_next['title'] ?>" class="next-2"><?php echo $object_next['author'] ?></a></div>
										<div class="title"><a href="<?php echo $object_next['canonical'].HTSUFFIX ?>" title="<?php echo $object_next['title'] ?>"><?php echo $object_next['title'] ?></a></div>
									</div>
									<div class="icon">
										<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3 mc-ml-1 bulk-banner-pointer"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.845 5.47a.75.75 0 011.06 0l6 6a.75.75 0 010 1.06l-6 6a.75.75 0 11-1.06-1.06l5.47-5.47-5.47-5.47a.75.75 0 010-1.06z" fill="currentColor"></path><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" d="M17.75 12.023H6.25"></path></svg>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php if(isset($panel['liked']['data']) && is_array($panel['liked']['data']) && count($panel['liked']['data'])){ ?>
				<div class="member mt30 " id="related">
					<div class="uk-text-center mb30">
						<div class="heading-1"><span><?php echo $panel['liked']['title'] ?></span></div>
					</div>
					<div class="owl-slide">
	                    <div class="owl-carousel" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>">
	                        <?php foreach ($panel['liked']['data'] as $value) { ?>
		                        <div>
		                            <div class="member-item">
		                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="image img-cover"><img src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>"></a>
		                                <div class="info">
											<div class="author"><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['author'] ?></a></div>
		                                    <div class="title"><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></div>
		                                </div>
		                            </div>
		                        </div>
	                        <?php } ?>
	                    </div>
	                </div>
				</div>
			<?php } ?>
			<?php echo view('frontend/homepage/common/form') ?>
		    <?php if(isset($panel['faq']['data']) && is_array($panel['faq']['data']) &&count($panel['faq']['data']) > 1){ 
		        unset($panel['faq']['data'][0]);
		    ?>
		        <?php $data['faq'] = (isset($panel['faq']) ? $panel['faq'] : []) ?>
		        <?php echo view('frontend/homepage/common/faq', $data) ?>
		    <?php } ?>
		</div>
	</div>
	<?php if(isset($connect_post) && is_array($connect_post) && count($connect_post)){ ?>
		<div class="articles-related">
			<div class="uk-container uk-container-center container-1">
				<div class="panel-head uk-text-center mb30">
					<div class="heading-1"><span>Browse related articles</span></div>
				</div>
				<ul class="uk-list uk-clearfix uk-grid uk-grid-medium uk-grid-width-large-1-2">
					<?php foreach ($connect_post as $value) { ?>
						<li><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	<?php } ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.scroll li').click(function(){
			$('.scroll li').removeClass('active');
			$(this).addClass('active');
			return false;
		});

		$('.lession-title').click(function(){
			$('.lession-description').hide();
			let _this = $(this);
			_this.siblings('.lession-description').toggleClass('active');
		});
	});
</script>


<?php $actual_link = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<div id="share-link" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="mc-background--color-light row justify-content-center" data-ba="share-modal">
        	<div class="mc-invert col-11 col-md-10 mc-text--center mc-my-9">
	        	<p class="text-modal-share uk-width-large-3-4">Share this class with your friends</p>
	        	<div class="uk-flex uk-flex-middle uk-flex-space-between uk-width-large-3-4 mb20" style="margin:auto">
	        		<a target="_blank" href="https://www.facebook.com/share.php?title=<?php echo $object['title'] ?>&u=<?php echo $actual_link ?>" title="social" class="c-button c-button--facebook c-button--md mc-px-5" data-ba="facebook"><svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class=""><path d="M19.117 4H4.877A.883.883 0 004 4.883v14.24a.883.883 0 00.883.877h7.664v-6.187h-2.08V11.39h2.08V9.61c0-2.066 1.263-3.2 3.106-3.2a16.73 16.73 0 011.862.096v2.166h-1.28c-1 0-1.193.48-1.193 1.176v1.542h2.398l-.32 2.423h-2.08V20h4.077a.883.883 0 00.883-.883V4.877A.883.883 0 0019.117 4z" fill="currentColor"></path></svg></a>
	        		<a target="_blank" href="https://www.facebook.com/dialog/send?link=<?php echo $actual_link ?>%3Futm_source%3D<?php echo $object['title'] ?>%26utm_medium%3Dweb%26utm_content%3DShare_Messenger&redirect_uri=<?php echo $actual_link ?>%3Futm_source%3D<?php echo $object['title'] ?>%26utm_medium%3Dweb%26utm_content%3DShare_Messenger" title="social" class="c-button c-button--messenger c-button--md mc-px-5" data-ba="messenger"><svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class=""><path fill-rule="evenodd" clip-rule="evenodd" d="M7.447 20.838v-2.871C5.648 16.598 4.5 14.514 4.5 12.18c0-4.123 3.582-7.465 8-7.465 4.419 0 8 3.342 8 7.465 0 4.122-3.581 7.464-8 7.464-.824 0-1.62-.116-2.368-.332l-2.685 1.526zm-.116-6.135l4.315-4.568 2.07 2.117 3.883-2.117-4.29 4.568-2.051-2.154-3.927 2.154z" fill="currentColor"></path></svg></a>
	        		<a target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $actual_link ?>%3Futm_source%3D<?php echo $object['title'] ?>%26utm_medium%3Dweb%26utm_content%3DShare_Linkedin" title="social" class="c-button c-button--linked-in c-button--md mc-px-5" data-ba="linked-in"><svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class=""><path fill-rule="evenodd" clip-rule="evenodd" d="M18.814 4H5.186C4.542 4 4 4.508 4 5.153v13.695C4 19.49 4.525 20 5.186 20h13.628c.66 0 1.186-.525 1.186-1.152V5.152C20 4.525 19.475 4 18.814 4zM8.767 9.979v7.633h-2.4V9.979h2.4zm-1.2-3.8c.771 0 1.388.61 1.388 1.374 0 .763-.617 1.374-1.388 1.374-.771 0-1.388-.61-1.388-1.374 0-.763.617-1.374 1.388-1.374zm4.929 3.828h-2.287v7.665h2.372V13.89c0-1 .186-1.966 1.423-1.966 1.22 0 1.236 1.136 1.236 2.017v3.714h2.372v-4.189c0-2.068-.44-3.645-2.846-3.645-1.152 0-1.914.644-2.236 1.238h-.034v-1.052z" fill="currentColor"></path></svg></a>
	        		<a target="_blank" href="https://twitter.com/intent/tweet?source=webclient&text=&url=<?php echo $actual_link ?>%3Futm_source%3D<?php echo $object['title'] ?>%26utm_medium%3Dweb%26utm_content%3DShare_Twitter" title="social" class="c-button c-button--twitter c-button--md mc-px-5" data-ba="twitter"><svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class=""><path d="M8.654 19c6.793 0 10.51-5.388 10.51-10.052 0-.152 0-.303-.008-.455A7.351 7.351 0 0021 6.66a7.752 7.752 0 01-2.125.558 3.588 3.588 0 001.628-1.956 7.553 7.553 0 01-2.348.854A3.767 3.767 0 0015.46 5c-2.038 0-3.695 1.585-3.695 3.534 0 .276.036.545.094.807-3.069-.145-5.792-1.558-7.614-3.693a3.416 3.416 0 00-.497 1.777c0 1.227.656 2.308 1.642 2.942a3.865 3.865 0 01-1.67-.44v.047c0 1.71 1.274 3.142 2.96 3.466-.31.083-.634.124-.973.124-.237 0-.468-.02-.691-.062.468 1.405 1.837 2.425 3.45 2.453a7.624 7.624 0 01-4.588 1.516c-.296 0-.59-.014-.879-.049A10.856 10.856 0 008.654 19z" fill="currentColor"></path></svg></a>
	        		<a target="_blank" href="mailto:?subject=&body=<?php echo $actual_link ?>%3Futm_source%3D<?php echo $object['title'] ?>%26utm_medium%3Dweb%26utm_content%3DShare_Email" title="social" class="c-button c-button--tertiary c-button--md mc-px-5" data-ba="mail"><svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class=""><path d="M6 16.5v-5.25l5.205 3.253a1.5 1.5 0 001.59 0L18 11.25v5.25H6z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M5.636 10.594a.75.75 0 01.761.02l5.205 3.253a.75.75 0 00.796 0l5.204-3.253a.75.75 0 011.148.636v5.25a.75.75 0 01-.75.75H6a.75.75 0 01-.75-.75v-5.25a.75.75 0 01.386-.656zm11.614 2.01l-4.057 2.535a2.25 2.25 0 01-2.386 0L6.75 12.603v3.147h10.5v-3.147z" fill="currentColor"></path><path d="M11.801 11.126L6 7.5h12l-5.801 3.626a.375.375 0 01-.398 0z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M5.279 7.293a.75.75 0 01.72-.543h12a.75.75 0 01.398 1.386l-5.8 3.626a1.125 1.125 0 01-1.193 0L5.602 8.136a.75.75 0 01-.323-.843zm3.336.957L12 10.366l3.385-2.116h-6.77z" fill="currentColor"></path></svg></a>
	        	</div>
	        	<div class="uk-flex uk-width-large-3-4" style="margin:auto">
	        		<div class="mc-form-input mc-form-element mc-form-element--disabled mc-form-element--default">
	        			<input type="text" class="mc-form-element__element input_link_share" readonly="" value="<?php echo $actual_link ?>">
	        			<div class="mc-form-append">
	        				<a href="#" class="share_link mc-text-h7 mc-text--capitalize gIOfZZXyT72uVOcnq-yB2">Copy</a>
	        			</div>
	        		</div>
	        	</div>
        	</div>
    	</div>
    </div>
</div>
<div id="video-modal" class="uk-modal" aria-hidden="true">
    <div class="uk-modal-dialog">
        <a href="" class="uk-modal-close uk-close"></a>
        <div class=" modal-iframe">

        </div>
    </div>
</div> 
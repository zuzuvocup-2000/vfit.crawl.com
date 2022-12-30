<?php $gallery = get_slide(['keyword' => 'gallery' , 'language' => $language, ]) ?>
<section class="intro-panel pt50 ">
	<header class="header mb40">
		<h2 class="main-heading uk-text-uppercase">
			<?php echo $detailCatalogue['title'] ?>
		</h2>
	</header>
	<?php if(isset($panel['tong-quan']['data']) && is_array($panel['tong-quan']['data']) && count($panel['tong-quan']['data'])){ ?>
		<div class="overview-panel mb50">
			<div class="container-1 uk-container-center">
				<header class="header">
					<h2 class="intro-heading">
						<?php echo $panel['tong-quan']['title'] ?>
					</h2>
				</header>
				<div class="overview-body">
					<?php foreach ($panel['tong-quan']['data'] as $key => $value) { ?>
						<div class="overview-row">
							<div class="uk-grid uk-grid-medium">
								<?php if($key % 2== 0){ ?>
									<div class="uk-width-large-1-2">
										<div class="overview-pic overview-side">
											<div class="img img-cover">
												<?php echo render_img(['src' => $value['image']]) ?>
											</div>
										</div>
									</div>
									<div class="uk-width-large-1-2">
										<div class="overview-description overview-side">
											<?php echo base64_decode($value['description']) ?>
										</div>
									</div>
								<?php }else{ ?>
									<div class="uk-width-large-1-2">
										<div class="overview-description overview-side">
											<?php echo base64_decode($value['description']) ?>
										</div>
									</div>
									<div class="uk-width-large-1-2">
										<div class="overview-pic overview-side">
											<div class="img img-cover">
												<?php echo render_img(['src' => $value['image']]) ?>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if(isset($panel['under-tong-quan']['data']) && is_array($panel['under-tong-quan']['data']) && count($panel['under-tong-quan']['data'])){ ?>
		<div class="our-view-panel mb50">
			<div class="container-1 uk-container-center">
				<div class="our-view-body">
					<div class="uk-grid uk-grid-medium">
						<?php foreach ($panel['under-tong-quan']['data'] as $value) { ?>
							<div class="uk-width-large-1-2">
								<div class="our-view-side">
									<header class="header mb20">
										<h2 class="intro-heading">
											<?php echo $value['title'] ?>
										</h2>
									</header>
									<div class="our-view-text mb20">
										<?php echo base64_decode($value['description']) ?>
									</div>
									<div class="our-view-pic pic-1 mb20">
										<div class="img img-cover">
											<?php echo render_img(['src' => $value['image']]) ?>
										</div>
									</div>
									<div class="our-view-text">
										<?php echo base64_decode($value['content']) ?>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if(isset($panel['linh-vuc']['data']) && is_array($panel['linh-vuc']['data']) && count($panel['linh-vuc']['data'])){ ?>
		<div class="activity-panel">
			<div class="container-1 uk-container-center">
				<div class="activity-body">
					<header class="header mb20">
						<h2 class="intro-heading">
							<?php echo $panel['linh-vuc']['title'] ?>
						</h2>
					</header>
					<?php foreach ($panel['linh-vuc']['data'] as $key => $value) { ?>
						<?php if($key == 0){ ?>
							<?php if(isset($value['post']) && is_array($value['post']) && count($value['post'])){ ?>
								<div class="activity-1 mb40">
									<h3 class="intro-heading-2">
										<?php echo $value['title'] ?>
									</h3>
									<div class="activity-1-body">
										<div class="uk-grid uk-grid-medium">
											<?php foreach ($value['post'] as $valuePost) { ?>
												<div class="uk-width-large-1-3">
													<div class="activity-1-item">
														<div class="item-pic intro-phanphoi">
															<a href="<?php echo $valuePost['canonical'].HTSUFFIX ?>" title="<?php echo $valuePost['title'] ?>" class="img img-cover">
																<?php echo render_img(['src' => $valuePost['image']]) ?>
															</a>
														</div>
														<div class="item-text wrap-text-phanphoi">
															<a href="<?php echo $valuePost['canonical'].HTSUFFIX ?>" title="<?php echo $valuePost['title'] ?>" class="">
																<?php echo $valuePost['title'] ?>
															</a>
														</div>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } ?>
						<?php }else{ ?>
							<?php if(isset($value['post']) && is_array($value['post']) && count($value['post'])){ ?>
							<div class="activity-2 mb40">
								<h3 class="intro-heading-2">
									<?php echo $value['title'] ?>
								</h3>
								<div class="teach-program mb40">
									
									<div class="uk-grid uk-grid-medium">
										<?php foreach ($value['post'] as $valuePost) { ?>
												<div class="uk-width-large-1-3">
													<div class="activity-2-item">
														<div class="item-pic">
															<a href="<?php echo $valuePost['canonical'].HTSUFFIX ?>" title="<?php echo $valuePost['title'] ?>" class="img img-cover">
																<?php echo render_img(['src' => $valuePost['image']]) ?>
															</a>
														</div>
														<div class="our-view-text">
															<?php echo base64_decode($valuePost['description']) ?>
														</div>
													</div>
												</div>
												
										<?php } ?>
									</div>
								</div>
								
							</div>
					<?php }}} ?>
					
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if(isset($panel['learn']['data']) && is_array($panel['learn']['data']) && count($panel['learn']['data'])){ ?>
		<div class="wrap-learn-intro pt30 pb30">
			<div class="uk-container uk-container-center">
				<div class="teach-lesson">
					<h3 class="intro-heading-2">
						<?php echo $panel['learn']['title'] ?>
					</h3>
					<ul class="teach-lesson-list">
						<?php foreach ($panel['learn']['data'] as $key => $value) { ?>
							<li>
								<a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="img-scaledown img">
									<?php echo render_img(['src' => $value['icon']]) ?>
								</a>
								<a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>">
									<h3 class="intro-heading-3"><?php echo $value['title'] ?></h3>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if(isset($panel['cho-thue']['data']) && is_array($panel['cho-thue']['data']) && count($panel['cho-thue']['data'])){ ?>
		<div class="rent-panel  pt30 pb30">
			<div class="uk-container uk-container-center">
				<div class="hide-service">
					<h3 class="intro-heading-2">
						<?php echo $panel['cho-thue']['title'] ?>
					</h3>
					<div class="hide-service-body">
						<?php foreach ($panel['cho-thue']['data'] as $key => $value) { ?>
							<?php if($key %2 == 0){ ?>
							<div class="row">
								<div class="uk-grid">
									<div class="uk-width-large-1-3">
										<?php echo render_img(['src' => $value['image'], 'class' => 'img-responsive img_thongtinhethongamnhacvtdvchothue']) ?>
									</div>
									<div class="uk-width-large-2-3">
										<div class="noidung_thongtinhethongamnhacvtdvchothue1">
											<p>
												<a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><strong><?php echo $value['title'] ?></strong></a><br>
												<?php echo strip_tags(base64_decode($value['description'])) ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						<?php }else{ ?>
							<div class="row">
								<div class="uk-grid dt-reverse">
									<div class="uk-width-large-2-3">
										<div class="noidung_thongtinhethongamnhacvtdvchothue2">
											<p>
												<a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><strong><?php echo $value['title'] ?></strong></a><br>
												<?php echo strip_tags(base64_decode($value['description'])) ?>
											</p>
										</div>
									</div>
									<div class="uk-width-large-1-3">
										<?php echo render_img(['src' => $value['image'], 'class' => 'img-responsive img_thongtinhethongamnhacvtdvchothue']) ?>
									</div>
								</div>
							</div>
						<?php }} ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if(isset($panel['vi-sao']['data']) && is_array($panel['vi-sao']['data']) && count($panel['vi-sao']['data'])){ ?>
		<div class="why-us-panel">
			<div class="container-1 uk-container-center">
				<header class="header mb20">
					<h2 class="intro-heading">
					<?php echo $panel['vi-sao']['title'] ?>
					</h2>
				</header>
				<div class="why-us-body ">
					<div class="uk-grid uk-grid-medium uk-clearfix">
						<?php echo base64_decode($panel['vi-sao']['data']['0']['content'])  ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
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
</section>
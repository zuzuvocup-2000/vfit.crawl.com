<section class="lesson-panel  pb50">
	<?php if(isset($object['album'][0]) && $object['album'][0] != ''){ ?>
		<div class="banner-panel mb50">
			<div class="img img-cover">
				<?php echo render_img(['src' => $object['album'][0]]) ?>
			</div>
		</div>
	<?php } ?>
	<div class="main-lesson ">
		<div class="container-1 uk-container-center">
			<header class="header mb40">
				<h2 class="main-heading uk-text-uppercase">
					<?php echo $object['title'] ?>
				</h2>
				<span class="small-line">
					<?php echo $object['description'] ?>
				</span>
			</header>
			<?php if(isset($object['sub_title']) && is_array($object['sub_title']) && count($object['sub_title'])){ ?>
				<div class="main-lesson-body ">
					<div class="uk-grid uk-grid-medium" data-uk-grid>
						<?php foreach ($object['sub_title'] as $key => $value) { ?>
							<div class="uk-width-1-1 <?php echo ($key % 2 == 0) ? 'uk-width-large-2-3' : 'uk-width-large-1-3' ?> mb30">
								<div class="main-lesson-side">
									<header class="header mb20">
										<h2 class="heading-3">
											<?php echo $value ?>
										</h2>
									</header>
									<div class="description side-1">
										<?php echo $object['sub_content'][$key] ?>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="lesson-table lesson-table-body">
		<div class="container-1 uk-container-center">
			<?php echo $object['content'] ?>
		</div>
	</div>
</section>
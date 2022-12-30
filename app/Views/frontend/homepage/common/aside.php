<?php
	helper(['mydatafrontend','mydata']);
	$baseController = new App\Controllers\FrontendController();
	$model = new App\Models\AutoloadModel();
    $language = $baseController->currentLanguage();
?>

<aside class="aside">
	<?php if(isset($cat_aside) && is_array($cat_aside) && count($cat_aside)){ ?>
	<div class="aside-category">
		<div class="heading-4"><span><?php echo $detailCatalogue['title'] ?></span></div>
		<ul class="uk-list uk-clearfix">
			<?php foreach($cat_aside as $key => $val){ ?>
			<?php
				$icon = (isset($val['icon']) && $val['icon'] != '' ) ? $val['icon'] : ((!empty($val['image'])) ? $val['image'] : 'https://meta.vn/icons/cats/382.png');
			?>
			<li class="uk-flex uk-flex-middle">
				<span class="icon"><img src="<?php echo $icon; ?>" alt="<?php echo $val['title'] ?>"></span>
				<a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title']; ?></a>
			</li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>
	<?php echo view('frontend/homepage/common/support') ?>
	<div class="aside-support">
		<div class="heading-4"><span>Fanpage Facebook</span></div>
		<div class="fanpage">
			<div class="fb-page" data-href="<?php echo $general['social_facebook'] ?>" data-tabs="timeline" data-width="" data-height="70" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"></div>
		</div>
	</div>
	<?php
		$media = $model->_get_where([
			'select' => 'tb1.id, tb2.title, tb2.iframe',
			'table' => 'media as tb1',
			'join' => [
				['media_translate as tb2','tb2.id = tb1.id','inner']
			],
			'where' => [
				'tb1.publish' => 1,
				'tb1.deleted_at' => 0,
				'tb2.module' => 'media',
				'tb1.catalogueid' => 1
			],
		]);
	?>
	<div class="aside-video">
		<?php echo $media['iframe']; ?>
		<div class="aside-video-foot">
			<a href="<?php echo $general['social_youtube'] ?>" class="Xem toàn bộ kênh">Xem toàn bộ kênh</a>
		</div>
	</div>
</aside>

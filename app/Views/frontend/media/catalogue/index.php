<?php $color = explode('|', $general['parameter_color']); ?>

<div class="wrap-media-panel pt50 pb50">
	<div class="uk-container uk-container-center">
		<div class="article-realtionship uk-text-uppercase"><?php echo $detailCatalogue['title'] ?></div>
		<?php if(isset($articleList) && is_array($articleList) && count($articleList)){ ?>
            <div class="uk-grid uk-grid-medium uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 uk-clearfix">
                <?php foreach ($articleList as $value) { ?>
                    <?php $new_color = $color[array_rand($color)] ?> 
                    <div class="wrap-grid">
                        <div class="box_cackhoahocchild" style="background-color:<?php echo $new_color ?>;">
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="img-cover">
                                <?php echo render_img(['src' => $value['image']]) ?>
                                <div class="p15 bg-white">
                                    <h3 class="tieude_cackhoahoc limit-line-2" style="color:<?php echo $new_color ?>;"><?php echo $value['title'] ?></h3>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
	    <?php } ?>
	    <div id="pagination">
            <?php echo (isset($pagination)) ? $pagination : ''; ?>
        </div>
	</div>
</div>
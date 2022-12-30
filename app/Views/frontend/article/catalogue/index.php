<section class="news-panel">
    <div class="uk-container-center uk-container">
        <header class="header mb40">
            <h2 class="main-heading uk-text-uppercase">
                <?php echo $detailCatalogue['title'] ?>
            </h2>
        </header>
        <div class="news-body">
            <?php if(isset($articleList) && is_array($articleList) && count($articleList)){
                foreach ($articleList as $value) {
            ?>
                <div class="news-item mb50">
                    <div class="uk-grid uk-grid-medium">
                        <div class="uk-width-large-1-4">
                            <div class="item-pic">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="img img-cover">
                                    <?php echo render_img(['src' => $value['image']]) ?>
                                </a>
                            </div>
                        </div>
                        <div class="uk-width-large-3-4">
                            <div class="item-description">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="news-item-title">
                                    <?php echo $value['title'] ?>
                                </a>
                                <div class="news-date">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    <?php echo date('d/m/Y', strtotime($value['created_at'])) ?>
                                    <i class="fa fa-eye ml20"></i> <?php echo $value['viewed'] ?>
                                </div>
                                <div class="description mb10 limit-line-4">
                                    <?php echo strip_tags(base64_decode($value['description'])) ?>
                                </div>
                                <div class="more">
                                    <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>">
                                        Chi tiết →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }} ?>
        </div>
        <div id="pagination">
            <?php echo (isset($pagination)) ? $pagination : ''; ?>
        </div>
    </div>
</section>
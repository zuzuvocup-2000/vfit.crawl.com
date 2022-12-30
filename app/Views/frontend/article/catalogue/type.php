<section class="n-service-panel">
    <div class="n-breadcum-top" style="background-image: url('<?php echo $detailCatalogue['image'] ?>'); ">
        <div class="uk-container uk-container-center">
            <div class="n-breadcum-content">
                <header class="header">
                    <h2 class="n-main-title">
                        <?php echo $detailCatalogue['title'] ?>
                    </h2>
                    <h4 class="n-secondary-title">
                       <?php echo strip_tags(base64_decode($detailCatalogue['description'])) ?>
                    </h4>
                </header>
                <ul class="uk-breadcrumb uk-flex uk-flex-center">
                    <li>
                        <a href="" title="home">Home</a>
                    </li>
                    <li >
                        <a href="<?php echo $detailCatalogue['canonical'].HTSUFFIX ?>" title="<?php echo $detailCatalogue['title'] ?>"><?php echo $detailCatalogue['title'] ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="n-service-body">
        <div class="uk-grid uk-grid-medium">
            <?php if(isset($articleList) && is_array($articleList) && count($articleList)){
                foreach ($articleList as $key => $value) {
            ?>
                <div class="uk-width-large-1-3">
                    <div class="n-service-item">
                        <div class="item-pic">
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="img img-cover">
                                <?php echo render_img(['src' => $value['image']]) ?>
                            </a>
                            <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>" class="img-icon img-scaledown">
                                <?php echo $value['icon'] ?>
                            </a>
                        </div>
                        <div class="item-content">
                            <div class="item-title">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>">
                                    <?php echo $value['title'] ?>
                                </a>
                            </div>
                            <div class="item-description line-4">
                                <?php echo base64_decode($value['description']) ?>
                            </div>
                            <div class="more-infor">
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>">
                                    Read more
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }} ?>
        </div>
    </div>
    <div class="n-contact-us-secondary" style="background-image: url(resources/img/ctac_bg.jpg); background-position: center center">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="left-side">
                    <div class="line-1">
                        DELIVERING INNOVATION
                    </div>
                    <div class="line-2">
                        SUSTAINABILITY <span>GOALS</span>
                    </div>
                    <div class="line-3">
                        We are focused on building a long-term, sustainable business.
                    </div>
                </div>
                <div class="right-side">
                    <div class="contact-us-btn">
                        <a href="" title="" class="hvr-sweep-to-right">
                            Contact us today
                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
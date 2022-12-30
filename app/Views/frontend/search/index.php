<div id="catalogue">
    <div class="uk-container uk-container-center">
        <h1 class="title-catalogue">
            <?php echo $detailCatalogue['title'] ?>
        </h1>
        <div class="uk-grid uk-grid-medium uk-clearfix mb50">
            <div class="uk-width-1-1 uk-width-large-1-4">
                <div class="list-classes">
                    <ul class="uk-list">
                        <?php if(isset($panel['all-classes']['data']) && is_array($panel['all-classes']['data']) && count($panel['all-classes']['data']) > 1){ ?>
                            <?php unset($panel['all-classes']['data'][0]) ?>
                            <?php foreach ($panel['all-classes']['data'] as $value) { ?>
                            <li class="<?php echo ($value['canonical'] == $detailCatalogue['canonical']) ? 'active' : '' ?>"> 
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a>
                            </li>
                        <?php }} ?>
                    </ul>
                </div>
            </div>
            <div class="uk-width-1-1 uk-width-large-3-4">
                <?php if(isset($productList) && is_array($productList) && count($productList)){ ?>
                <div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-3 uk-clearfix uk-grid-medium">
                    <?php foreach ($productList as $value) { ?>
                        <div class="wrap-grid">
                            <div class="class-item">
                                <div class="background"></div>
                                <a href="<?php echo $value['canonical'].HTSUFFIX ?>" class="image img-cover">
                                    <img src="<?php echo $value['image'] ?>" alt="<?php echo $value['title'] ?>">
                                </a>
                                <div class="info">
                                    <a class="author-name image img-cover" href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>">
                                        <img src="<?php echo $value['author_image'] ?>" alt="<?php echo $value['author'] ?>">
                                    </a>
                                    <div class="title mb20"><a href="<?php echo $value['canonical'].HTSUFFIX ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></div>
                                    <a class="uk-flex mb15 uk-flex-middle btn-modal-iframe watch-sample-catalogue" href="#video-modal" data-iframe="<?php echo base64_encode($value['video']) ?>" data-uk-modal>
                                        <svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon"><path d="M8.653 6.117A.75.75 0 007.5 6.75v10.5a.75.75 0 001.153.633l8.25-5.25a.75.75 0 000-1.266l-8.25-5.25z" fill="currentColor"></path></svg>
                                        <span>Watch Sample</span>
                                    </a>
                                    <a class="uk-flex uk-flex-middle view-class-info" href="<?php echo $value['canonical'].HTSUFFIX ?>" >
                                        <svg width="2em" height="2em" viewBox="0 0 24 25" fill="none" class="mc-mr-3"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.849c-3.007 0-5.444 2.418-5.444 5.4 0 2.983 2.437 5.4 5.444 5.4s5.444-2.417 5.444-5.4c0-2.982-2.437-5.4-5.444-5.4zm-7 5.4c0-3.835 3.134-6.943 7-6.943s7 3.108 7 6.943c0 3.835-3.134 6.944-7 6.944s-7-3.109-7-6.944z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M12 11.877c.414 0 .75.333.75.744v1.86c0 .41-.336.744-.75.744a.747.747 0 01-.75-.744v-1.86c0-.41.336-.744.75-.744z" fill="currentColor"></path><path d="M12.75 10.017c0 .411-.336.744-.75.744a.747.747 0 01-.75-.744c0-.41.336-.743.75-.743s.75.333.75.743z" fill="currentColor"></path></svg>
                                        <span>View Class Info</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php }else{ ?>
                    <div class="text-danger">
                        No courses to show!
                    </div>
                <?php } ?>
                <div id="pagination">
                    <?php echo (isset($pagination)) ? $pagination : ''; ?>
                </div>
            </div>
        </div>
        <?php if(isset($panel['faq']['data']) && is_array($panel['faq']['data']) &&count($panel['faq']['data']) > 1){ 
            unset($panel['faq']['data'][0]);
        ?>
            <?php $data['faq'] = (isset($panel['faq']) ? $panel['faq'] : []) ?>
            <?php echo view('frontend/homepage/common/faq', $data) ?>
        <?php } ?>
    </div>
</div>
<div id="video-modal" class="uk-modal" aria-hidden="true">
    <div class="uk-modal-dialog">
        <a href="" class="uk-modal-close uk-close"></a>
        <div class=" modal-iframe">

        </div>
    </div>
</div> 
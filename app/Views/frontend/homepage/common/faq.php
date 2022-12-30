<div class="faq-panel " id="faq">
    <div class="uk-container uk-container-center container-1">
        <div class="panel-head mb50">
            <h2 class="heading-1"><span><?php echo $faq['title'] ?></span></h2>
        </div>
        <?php foreach ($faq['data'] as $value) { ?>
            <div class="panel-body mb50">
                <div class="sub-heading"><?php echo $value['title'] ?></div>
                <?php if(isset($value['post']) && is_array($value['post']) && count($value['post'])){
                ?>
                    <div class="collapse">
                        <?php 
                            foreach ($value['post'] as $valuePost) {
                        ?>
                            <div class="collapse-item">
                                <div class="collapse-title"><?php echo $valuePost['title'] ?></div>
                                <div class="collapse-description">
                                    <?php echo strip_tags(base64_decode($valuePost['description'])) ?>
                                </div>
                                <div class="collapse-icon">
                                    <svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.47 8.845a.75.75 0 011.06 0l5.47 5.47 5.47-5.47a.75.75 0 111.06 1.06l-6 6a.75.75 0 01-1.06 0l-6-6a.75.75 0 010-1.06z" fill="currentColor"></path></svg>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        let upIcon = '<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.47 8.095a.75.75 0 011.06 0l6 6a.75.75 0 11-1.06 1.06L12 9.685l-5.47 5.47a.75.75 0 01-1.06-1.06l6-6z" fill="currentColor"></path></svg>';
        let downIcon = '<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.47 8.845a.75.75 0 011.06 0l5.47 5.47 5.47-5.47a.75.75 0 111.06 1.06l-6 6a.75.75 0 01-1.06 0l-6-6a.75.75 0 010-1.06z" fill="currentColor"></path></svg>';
        $('.collapse-description').hide();
        $('.collapse-title').click(function(){
            let _this = $(this);
            _this.siblings('.collapse-description').toggleClass('active');
            if(_this.siblings('.collapse-description').hasClass('active')){
                _this.siblings('.collapse-icon').html(upIcon);
            }else{
                _this.siblings('.collapse-icon').html(downIcon);
            }
        });
    });
</script>
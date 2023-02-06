<div class="row">
    <p class="text-sm">
        <span class="text-uppercase ">Bộ chọn HTML cho loại thu thập đánh giá plugin</span>
        <span class="text-warning text-xs">Plugin bình luận Facebook</span>
    </p>
    <div class="col-md-6">
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Bộ chọn HTML để thu thập URL plugin Facebook  </label>
            <?php echo form_input('selector[selector]', validate_input(set_value('selector', (isset($article['data']['selector']['selector'])) ? $article['data']['selector']['selector'] : '.fb-comments iframe')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Bộ chọn HTML bình luận  </label>
            <?php echo form_input('selector[comment]', validate_input(set_value('selector', (isset($article['data']['selector']['comment'])) ? $article['data']['selector']['comment'] : '._30o4')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Bộ chọn HTML tên người bình luận  </label>
            <?php echo form_input('selector[name]', validate_input(set_value('selector', (isset($article['data']['selector']['name'])) ? $article['data']['selector']['name'] : '.UFICommentActorName')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Bộ chọn HTML nút xem thêm  </label>
            <?php echo form_input('selector[selector]', validate_input(set_value('view_more', (isset($article['data']['selector']['view_more'])) ? $article['data']['selector']['view_more'] : 'div._5o4h > button')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
        </div>
    </div>
</div>
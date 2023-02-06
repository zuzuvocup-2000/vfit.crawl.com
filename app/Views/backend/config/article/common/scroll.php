<div class="row">
    <p class="text-sm">
        <span class="text-uppercase ">Bộ chọn HTML cho loại thu thập đánh giá scroll</span>
        <span class="text-warning text-xs">Scroll để xem thêm bình luận</span>
    </p>
    <div class="col-md-6">
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Bộ chọn HTML bình luận  </label>
            <?php echo form_input('selector[comment]', validate_input(set_value('selector', (isset($article['data']['selector']['comment'])) ? $article['data']['selector']['comment'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Bộ chọn HTML tên người bình luận  </label>
            <?php echo form_input('selector[name]', validate_input(set_value('selector', (isset($article['data']['selector']['name'])) ? $article['data']['selector']['name'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
        </div>
    </div>
</div>
<div class="row">
    <p class="text-sm">
        <span class="text-uppercase ">Bộ chọn HTML cho loại thu thập đánh giá click</span>
        <span class="text-warning text-xs">Click để xem thêm bình luận</span>
    </p>
    <div class="col-md-6">
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Bộ chọn HTML bình luận  </label>
            <?php echo form_input('selector[comment]', validate_input(set_value('selector[comment]', (isset($selector['comment'])) ? $selector['comment'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Bộ chọn HTML tên người bình luận  </label>
            <?php echo form_input('selector[name]', validate_input(set_value('selector[name]', (isset($selector['name'])) ? $selector['name'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Bộ chọn HTML nút xem thêm  </label>
            <?php echo form_input('selector[view_more]', validate_input(set_value('selector[view_more]', (isset($selector['view_more'])) ? $selector['view_more'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Bộ chọn HTML sự kiện ẩn hoặc loại bỏ  </label>
            <?php echo form_input('selector[class_hide]', validate_input(set_value('selector[class_hide]', (isset($selector['class_hide'])) ? $selector['class_hide'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
        </div>
    </div>
</div>
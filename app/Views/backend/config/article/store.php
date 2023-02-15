<?php 
    if(isset($article['data']['dataType']) || isset($_POST['dataType'])){
        $selector = (isset($article['data']['dataType']) && $article['data']['dataType'] == 'RATE' ? json_decode($article['data']['selector'],true) : $article['data']['selector']); 
    }
?>
<div class="container-fluid py-4">
    <div class="card">
        <form action="" method="post">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <p class="mb-0"><?php echo $title ?></p>
                    <button class="btn btn-success m-0 btn-sm ms-auto">Lưu</button>
                </div>
            </div>
            <div class="card-body">
                <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
                <div class="row wrap-selector-article">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Loại thu thập <span class="text-danger">(*)</span> </label>
                            <?php  echo form_dropdown('dataType', [
                                '' => 'Chọn loại thu thập',
                                'TITLE' => 'Tiêu đề',
                                'DESCRIPTION' => 'Mô tả',
                                'CONTENT' => 'Nội dung',
                                'RATE' => 'Đánh giá',
                                'IMAGE' => 'Hình ảnh',
                                'CATALOGUE_TITLE' => 'Tiêu đề danh mục',
                            ], set_value('type', (isset($article['data']['dataType']) ? $article['data']['dataType'] : '')), 'onfocus="focused(this)" onfocusout="defocused(this)" class="form-control '.($website['data']['typeCrawl'] == 'DOM' ? 'click-change-rate-dom' : 'click-change-rate-type').'"') ; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Nhóm <span class="text-danger">(*)</span></label>
                            <?php  echo form_dropdown('group', [
                            '' => 'Chọn nhóm',
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                            '9' => '9',
                            '10' => '10',
                            ], set_value('group', (isset($article['data']['group']) ? $article['data']['group'] : '')), 'onfocus="focused(this)" onfocusout="defocused(this)" class="form-control"') ; ?>
                        </div>
                    </div>
                    <?php if(!isset($article['data']['dataType']) || $article['data']['dataType'] != 'RATE'){ ?>
                        <div class="col-md-6 wrap-selector-normal">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Bộ chọn HTML  <span class="text-danger">(*)</span></label>
                                <?php echo form_input('selector', validate_input(set_value('selector', (isset($article['data']['selector'])) ? $article['data']['selector'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if(isset($article['data']['dataType']) && $article['data']['dataType'] == 'RATE' && $website['data']['typeCrawl'] != 'DOM'){ ?>
                        <div class="col-md-6 wrap-selector-type-rate">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Loại đánh giá</label>
                                <?php  echo form_dropdown('selector[type]', [
                                    '' => 'Chọn loại đánh giá',
                                    'PLUGIN' => 'PLUGIN',
                                    'CLICK' => 'CLICK',
                                    'SCROLL' => 'SCROLL',
                                ], set_value('type', (isset($selector['type']) ? $selector['type'] : '')), 'onfocus="focused(this)" onfocusout="defocused(this)" class="form-control selector-type-rate"') ; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="js-open-plugin-rate">
                    <?php 
                        if(isset($selector['type']) && $selector['type'] == 'PLUGIN'){
                            echo view('backend/config/article/common/plugin',['selector' => $selector]);
                        } 
                    ?>
                </div>
                <div class="js-open-click-rate">
                    <?php 
                        if(isset($selector['type']) && $selector['type'] == 'CLICK'){
                            echo view('backend/config/article/common/click',['selector' => $selector]);
                        } 
                    ?>
                </div>
                <div class="js-open-scroll-rate">
                    <?php 
                        if(isset($selector['type']) && $selector['type'] == 'SCROLL'){
                            echo view('backend/config/article/common/scroll',['selector' => $selector]);
                        } 
                    ?>
                </div>
                <div class="js-open-normal-rate">
                    <?php 
                        if(isset($article['data']['dataType']) && $article['data']['dataType'] == 'RATE' && $website['data']['typeCrawl'] == 'DOM' ){
                            echo view('backend/config/article/common/normal',['selector' => $selector]);
                        } 
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>
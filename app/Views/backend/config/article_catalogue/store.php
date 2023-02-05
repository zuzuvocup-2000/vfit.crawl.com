
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Loại Website <span class="text-danger">(*)</span> </label>
                            <span class="text-warning text-xs ">Dùng để thu thập toàn bộ URL</span>
                            <?php  echo form_dropdown('type', [
                                '' => 'Chọn loại Website',
                                'SITEMAP' => 'Website có Sitemap',
                                'NORMAL' => 'Website không có Sitemap',
                            ], set_value('type', (isset($article['data']['type']) ? $article['data']['type'] : '')), 'onfocus="focused(this)" onfocusout="defocused(this)" class="form-control"') ; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Tiêu đề  <span class="text-danger">(*)</span></label>
                            <?php echo form_input('website', validate_input(set_value('url', (isset($article['data']['url'])) ? $article['data']['url'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
                            <?php echo form_hidden('website_original ', (isset($article['data']['url']) ? $article['data']['url'] : ''), 'class="form-control" '); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Kiểu danh mục<span class="text-danger">(*)</span> </label>
                            <?php  echo form_dropdown('dataType', [
                                '' => 'Chọn loại danh mục',
                                'TITLE' => 'TITLE',
                                
                            ], set_value('type', (isset($article['data']['type']) ? $article['data']['type'] : '')), 'onfocus="focused(this)" onfocusout="defocused(this)" class="form-control"') ; ?>
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
                            ], set_value('typeCrawl', (isset($article['data']['typeCrawl']) ? $article['data']['typeCrawl'] : '')), 'onfocus="focused(this)" onfocusout="defocused(this)" class="form-control"') ; ?>
                        </div>
                    </div>
                    <!--  -->
                </div>
            </div>
        </form>
    </div>
</div>
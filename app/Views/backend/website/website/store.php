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
                            <label for="example-text-input" class="form-control-label">Url Website <span class="text-danger">(*)</span></label>
                            <?php echo form_input('url', validate_input(set_value('url', (isset($website['data']['url'])) ? $website['data']['url'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
                            <?php echo form_hidden('url_original', (isset($website['data']['url']) ? $website['data']['url'] : ''), 'class="form-control" '); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Loại Website <span class="text-danger">(*)</span> </label>
                            <span class="text-warning text-xs ">Dùng để thu thập toàn bộ URL</span>
                            <?php  echo form_dropdown('type', [
                                '' => 'Chọn loại Website',
                                'SITEMAP' => 'Website có Sitemap',
                                'NORMAL' => 'Website truyền thống',
                                'JAVASCRIPT' => 'Website load bằng Javascript'
                            ], set_value('type', (isset($website['data']['type']) ? $website['data']['type'] : '')), 'onfocus="focused(this)" onfocusout="defocused(this)" class="form-control"') ; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Kiểu thu thập dữ liệu <span class="text-danger">(*)</span></label>
                            <?php  echo form_dropdown('typeCrawl', [
                                '' => 'Chọn kiểu thu thập',
                                'DOM' => 'Thu thập bằng HTML DOM',
                                'BROWSER' => 'Thu thập bằng Browser'
                            ], set_value('typeCrawl', (isset($website['data']['typeCrawl']) ? $website['data']['typeCrawl'] : '')), 'onfocus="focused(this)" onfocusout="defocused(this)" class="form-control"') ; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" value="1" type="radio" name="status" id="active" <?php echo (isset($_POST['status']) && $_POST['status'] == 1 ? 'checked' : (isset($website['data']['status']) && $website['data']['status'] == 1 ? 'checked' : '')) ?>>
                                <label class="form-check-label" for="active">
                                    Hoạt động
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" value="2" type="radio" name="status" id="inactive" <?php echo (isset($_POST['status']) && $_POST['status'] == 2 ? 'checked' : (isset($website['data']['status']) && $website['data']['status'] == 2 ? 'checked' : '')) ?>>
                                <label class="form-check-label" for="inactive">
                                    Không hoạt động
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
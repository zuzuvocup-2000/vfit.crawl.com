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
                            
                            <?php  echo form_dropdown('typeCriteria', [
                                '' => 'Chọn loại Tieu Chi',
                                'CONTENT' => 'CONTENT',
	  							'RATE' => 'RATE',
                            ], set_value('typeCriteria', (isset($website['data']['type']) ? $website['data']['type'] : '')), 'onfocus="focused(this)" onfocusout="defocused(this)" class="form-control"') ; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Tieu De <span class="text-danger">(*)</span></label>
                            <?php echo form_input('url', validate_input(set_value('url', (isset($website['data']['url'])) ? $website['data']['url'] : '')), 'class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
                            <?php echo form_hidden('url_original', (isset($website['data']['url']) ? $website['data']['url'] : ''), 'class="form-control" '); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Loai Tieu Chi <span class="text-danger">(*)</span></label>
                            <?php  echo form_dropdown('typeStatistic', [
                                '' => 'Chọn loai tieu chi',
		                               'VERY_BAD' => 'VERY BAD',
										'BAD' => 'BAD',
										'NORMAL' => 'NORMAL',
										'GOOD' => 'GOOD',
										'VERY_GOOD' => 'VERY GOOD',
                            ], set_value('typeStatistic', (isset($website['data']['typeCrawl']) ? $website['data']['typeCrawl'] : '')), 'onfocus="focused(this)" onfocusout="defocused(this)" class="form-control"') ; ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
</div>
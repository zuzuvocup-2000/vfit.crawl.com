<div class="container-fluid py-4">
    <div class="card">
        <form action="" method="post" id="form-criteria">
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
                            <label for="example-text-input" class="form-control-label">Loại tiêu chí <span class="text-danger">(*)</span> </label>
                            
                            <?php  echo form_dropdown('typeCriteria', [
                                '' => 'Chọn loại tiêu chí',
                                'CONTENT' => 'Nội dung',
	  							'RATE' => 'Đánh giá',
                            ], set_value('typeCriteria', (isset($criteria['data']['typeCriteria']) ? $criteria['data']['typeCriteria'] : '')), 'onfocus="focused(this)" disabled onfocusout="defocused(this)" class="form-control"') ; ?>

                             <?php  echo form_dropdown('typeCriteria', [
                                '' => 'Chọn loại tiêu chí',
                                'CONTENT' => 'Nội dung',
                                'RATE' => 'Đánh giá',
                            ], set_value('typeCriteria', (isset($criteria['data']['typeCriteria']) ? $criteria['data']['typeCriteria'] : '')), 'onfocus="focused(this)"  onfocusout="defocused(this)" class="form-control d-none"') ; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Mức độ đánh giá <span class="text-danger">(*)</span></label>
                            <?php  echo form_dropdown('typeStatistic', [
                                '' => 'Chọn mức độ đánh giá',
										'BAD' => 'Không tốt',
										'GOOD' => 'Tốt',
                            ], set_value('typeStatistic', (isset($criteria['data']['typeStatistic']) ? $criteria['data']['typeStatistic'] : '')), 'onfocus="focused(this)" disabled onfocusout="defocused(this)" class="form-control"') ; ?>
                            <?php  echo form_dropdown('typeStatistic', [
                                '' => 'Chọn mức độ đánh giá',
                                        'BAD' => 'Không tốt',
                                        'GOOD' => 'Tốt',
                            ], set_value('typeStatistic', (isset($criteria['data']['typeStatistic']) ? $criteria['data']['typeStatistic'] : '')), 'onfocus="focused(this)"  onfocusout="defocused(this)" class="form-control d-none"') ; ?>
                        </div>
                    </div>
                    <?php 
                        $str = '';
                        if(isset($criteria['data']['value']) && is_array($criteria['data']['value']) && count($criteria['data']['value'])){
                            foreach ($criteria['data']['value'] as $key => $value) {
                                $str.=$value. ($key + 1 == count($criteria['data']['value']) ? '' : ',');
                            }
                        }
                    ?>
                    <div class="col-md-12">
                        <div class="form-group choice-wrap">
                            <label for="example-text-input" class="form-control-label">Giá trị</label>
                            <?php echo form_input('value', validate_input(set_value('value', $str)), 'class="form-control" data-color="dark" id="choices-tags" onfocus="focused(this)" onfocusout="defocused(this)"'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="/template/assets/js/plugins/choices.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var choicesTags = document.getElementById("choices-tags");
    var color = choicesTags.dataset.color;
    if (choicesTags) {
        const example = new Choices(choicesTags, {
            delimiter: ",",
            editItems: true,
            duplicateItemsAllowed: false,
            removeItemButton: true,
            addItems: true,
            uniqueItemText: "Chỉ có thể thêm các giá trị duy nhất",
            addItemText: (value) => {
                return `Ấn Enter để thêm <b>"${value}"</b>`;
            },
            classNames: {
                item: "badge rounded-pill choices-" + color + " me-2",
            },
        });
    }
    $("#form-criteria").on("keyup keypress", function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

</script>
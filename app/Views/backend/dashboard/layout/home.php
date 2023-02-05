<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="<?php echo BASE_URL; ?>">
    <title><?php echo $title ?> | <?php echo NAME_PROJECT ?></title>
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo ASSET_BACKEND_TEMPLATE ?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?php echo ASSET_BACKEND_TEMPLATE ?>assets/img/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php  
        $css = [
            // ASSET_BACKEND.'css/bootstrap.min.css',
            // ASSET_BACKEND.'css/bootstrap.min.css',
            ASSET_BACKEND.'font-awesome/css/font-awesome.css',
            ASSET_BACKEND.'css/plugins/toastr/toastr.min.css',
            // ASSET_BACKEND.'js/plugins/gritter/jquery.gritter.css',
            // ASSET_BACKEND.'css/animate.css',
            // ASSET_BACKEND.'css/inputTags.min.css',
            // ASSET_BACKEND.'plugin/select2/dist/css/select2.min.css',
            // ASSET_BACKEND.'css/plugins/daterangepicker/daterangepicker-bs3.css',
            // ASSET_BACKEND.'plugin/jquery-ui.css', 
            // ASSET_BACKEND.'plugin/simplepicker-main/dist/simplepicker.css',
            // ASSET_BACKEND.'css/style.css', 
            // ASSET_BACKEND.'css/customize.css', 
            // ASSET_BACKEND.'css/vastyle.css', 
            ASSET_BACKEND.'css/plugins/sweetalert/sweetalert.css', 
            // ASSET_BACKEND.'css/plugins/codemirror/codemirror.css', 
            // ASSET_BACKEND.'css/plugins/codemirror/ambiance.css', 
            // ASSET_BACKEND.'uikit/css/uikit.modify.css',
            ASSET_BACKEND_TEMPLATE.'assets/css/nucleo-icons.css',
            ASSET_BACKEND_TEMPLATE.'assets/css/nucleo-svg.css',
            ASSET_BACKEND_TEMPLATE.'assets/css/argon-dashboard.css?v=2.0.4',

        ];
    ?>
    <?php foreach($css as $key => $val){
        echo '<link href="'.$val.'" rel="stylesheet">';
    } ?>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script src="public/backend/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript">
        var BASE_URL = '<?php echo BASE_URL; ?>';
        var SUFFIX = '<?php echo HTSUFFIX; ?>';
    </script>
</head>
<body>
    <div class="min-height-300 bg-primary position-absolute w-100 background-dashboard <?php echo isset($module) ? $module : '' ?>"></div>
    <?php echo view('backend/dashboard/common/sidebar') ?>
    <main class="main-content position-relative border-radius-lg">
        <?php echo view('backend/dashboard/common/nav') ?>
        <div class="container-fluid py-4">
            <?php echo view( (isset($template)) ? $template  :'' ) ?>
            <?php echo view('backend/dashboard/common/footer') ?>
        </div>

a
    </main>     
    <div class="screen screen-loading d-none">
        <div class="loader">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
    <?php echo view('backend/dashboard/common/setting') ?>
    <!-- Mainly scripts -->
    <?php  
        $script = [
            // ASSET_BACKEND.'js/jquery-3.1.1.min.js',
            // ASSET_BACKEND.'js/bootstrap.min.js',
            // ASSET_BACKEND.'js/plugins/metisMenu/jquery.metisMenu.js',
            // ASSET_BACKEND.'js/plugins/slimscroll/jquery.slimscroll.min.js',
            // ASSET_BACKEND.'js/inspinia.js',
            // ASSET_BACKEND.'js/plugins/pace/pace.min.js',
            // ASSET_BACKEND.'js/plugins/jquery-ui/jquery-ui.min.js',
            // ASSET_BACKEND.'js/plugins/gritter/jquery.gritter.min.js',
            // ASSET_BACKEND.'js/plugins/sparkline/jquery.sparkline.min.js',
            // ASSET_BACKEND.'js/plugins/nestable/jquery.nestable.js',
            // ASSET_BACKEND.'js/demo/sparkline-demo.js',
            // ASSET_BACKEND.'plugin/simplepicker-main/dist/simplepicker.js',
            // ASSET_BACKEND.'js/plugins/codemirror/codemirror.js',
            // ASSET_BACKEND.'js/plugins/fullcalendar/moment.min.js',
            // ASSET_BACKEND.'js/plugins/daterangepicker/daterangepicker.js',
            // ASSET_BACKEND.'js/plugins/codemirror/mode/javascript/javascript.js',
            ASSET_BACKEND.'js/plugins/toastr/toastr.min.js',
            // ASSET_BACKEND.'js/plugins/datapicker/bootstrap-datepicker.js',
            ASSET_BACKEND.'js/plugins/sweetalert/sweetalert.min.js',
            // ASSET_BACKEND.'plugin/jquery-ui.js',
            // ASSET_BACKEND.'plugin/timeago.js',
            // ASSET_BACKEND.'plugin/inputTags.jquery.min.js',
            // ASSET_BACKEND.'plugin/ckfinder/ckfinder.js',
            // ASSET_BACKEND.'plugin/ckeditor/ckeditor.js',
            // ASSET_BACKEND.'library/ckfinder.js',
            // ASSET_BACKEND.'plugin/select2/dist/js/select2.min.js',
            // ASSET_BACKEND.'plugin/Select-All-Checkboxes-jQuery-checkboxAll/jquery.checkboxall-1.0.min.js',
            // ASSET_BACKEND.'library/library.js',
            // ASSET_BACKEND.'uikit/js/uikit-slideshow.js',
            // ASSET_BACKEND.'uikit/js/uikit.min.js'
            ASSET_BACKEND_TEMPLATE.'assets/js/core/popper.min.js',
            ASSET_BACKEND_TEMPLATE.'assets/js/core/bootstrap.min.js',
            ASSET_BACKEND_TEMPLATE.'assets/js/plugins/perfect-scrollbar.min.js',
            ASSET_BACKEND_TEMPLATE.'assets/js/plugins/smooth-scrollbar.min.js',
            ASSET_BACKEND_TEMPLATE.'assets/js/plugins/chartjs.min.js',
            ASSET_BACKEND_TEMPLATE.'assets/js/plugins/button.js',
            ASSET_BACKEND_TEMPLATE.'assets/js/argon-dashboard.min.js?v=2.0.4',
        ];
        
        if(isset($module) && !empty($module)){
            if(file_exists(ASSET_BACKEND.'library/module/'.$module.'.js')){
                $script[count($script)+1] = ASSET_BACKEND.'library/module/'.$module.'.js';
            }
        }

        
    ?>
    <?php foreach($script as $key => $val){
        echo '<script src="'.$val.'"></script>';
    } ?>

    <script>
            var ctx1 = document.getElementById("chart-line").getContext("2d");

            var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

            gradientStroke1.addColorStop(1, "rgba(94, 114, 228, 0.2)");
            gradientStroke1.addColorStop(0.2, "rgba(94, 114, 228, 0.0)");
            gradientStroke1.addColorStop(0, "rgba(94, 114, 228, 0)");
            new Chart(ctx1, {
                type: "line",
                data: {
                    labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [
                        {
                            label: "Mobile apps",
                            tension: 0.4,
                            borderWidth: 0,
                            pointRadius: 0,
                            borderColor: "#5e72e4",
                            backgroundColor: gradientStroke1,
                            borderWidth: 3,
                            fill: true,
                            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                            maxBarThickness: 6,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: "index",
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: "#fbfbfb",
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5],
                            },
                            ticks: {
                                display: true,
                                color: "#ccc",
                                padding: 20,
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: "normal",
                                    lineHeight: 2,
                                },
                            },
                        },
                    },
                },
            });
        </script>
        <script>
            var win = navigator.platform.indexOf("Win") > -1;
            if (win && document.querySelector("#sidenav-scrollbar")) {
                var options = {
                    damping: "0.5",
                };
                Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
            }
        </script>
    
  <?php echo view('backend/dashboard/common/notification') ?>
</body>
</html>



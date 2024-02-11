<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loppekortet</title>

    <?php $this->load->view('front/include/include_styles'); ?>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/rangeslider.css">

</head>

<body class="fixed_search_bar_header_body">

    <!--================Header Menu Area =================-->
    <?php $this->load->view('front/include/header'); ?>
    <!--================Header Menu Area =================-->

    <!--================Filter Search Result Map View Area =================-->
    <div class="filter_search_map_view">
        <div class="container py-5">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto py-2">
                    <a href="#" class="btn btn_setting toggle_filter_btn">
                        <img src="<?= base_url() ?>assets/img/icons/setting.png" alt="">
                    </a>
                </div>

                <div class="col-auto py-2">
                    <h6 class="fs-12 fw-800 text_dark"><?php echo $this->lang->line('serach_results');?></h6>
                    <h5 class="fs-16 fw-600">
                        <span class="text_success"><?= count($market) ?> <?php echo $this->lang->line('results');?>, </span>
                        <span class="text_solid_black"><?php echo $this->lang->line('near_by_markets');?></span>
                    </h5>
                </div>
                <input type="hidden" id="searchTextval" value="<?=$searchText?>">
                <div class="col-auto py-2">
                    <a href="<?= base_url() ?>map-view" class="btn btn_map_view">
                        <img class="mr-1" src="<?= base_url() ?>assets/img/icons/map_view.png" alt=""> <?php echo $this->lang->line('map_view');?>
                    </a>
                </div>
            </div>
        </div>

        

        <div class="container">
            <div class="row">

                <?php
                    foreach ($market as $keys => $values) {
                ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="feature_market_card">
                            <a href="<?= base_url() ?>market/<?= $values->id ?>">
                                <div class="img_bg_card mt-0"  onclick='window.location.href="<?= base_url() ?>market/<?= $values->id ?>"' style="<?php if(count($values->images) > 0){ ?> background-image: url(<?= $values->images[0]->fullurl ?>); <?php } ?>">
                                    <div class="img_bg_card_content">
                                        <div class="d-flex-wrap justify-content-between align-items-center mb-2">
                                            <p class="fs-14 fw-600 m-0"><?= substr_replace( $values->market_name, "", 16); ?> <?php if(strlen($values->market_name) > 16){ ?> ... <?php } ?></p>
                                            <div class="d-flex align-items-center">
                                                <span class="ml-3">
                                                    <a class="favorite favorite<?=$values->id?> <?php if($values->is_fav_market==1){ echo "active"; } ?>" href="javascript:void(0)" onclick="favourite(<?= $values->id ?>)">
                                                        <img width="15" src="<?= base_url() ?>assets/img/icons/heart.png" alt="">
                                                    </a>
                                                </span>
                                                <span class="ml-3">
                                                    <a href="javascript:void(0)" onclick="sharelink(`<?= base_url() ?>share-link/<?= $values->id ?>`)">
                                                        <img width="15" src="<?= base_url() ?>assets/img/icons/share.png" alt="">
                                                    </a>
                                                </span>
                                            </div>
                                        </div>

                                        <p class="fs-12 fw-500 m-0"><img width="10" src="<?= base_url() ?>assets/img/icons/location.png" alt=""> <?= $values->address ?>, <?= $values->city ?></p>
                                        <div class="d-flex-wrap justify-content-between align-items-center">
                                            <p class="fs-12 fw-500 m-0">
                                                <span>
                                                    <img width="10" src="<?= base_url() ?>assets/img/icons/clock.png" alt="">
                                                </span><?php $date=date_create($values->start_time);echo date_format($date,"H:i"); ?> - <?php $date2=date_create($values->end_time);echo date_format($date2,"H:i"); ?>
                                                
                                            </p>
                                            <p class="fs-12 fw-500 m-0">
                                                <span>
                                                    <img width="10" src="<?= base_url() ?>assets/img/icons/calender.png" alt="">
                                                </span><?= $values->start_date ?> - <?= $values->end_date ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <!--================End Filter Search Result Map View Area =================-->













    <?php $this->load->view('front/include/modal'); ?>

    <!--================Footer Area =================-->
    <?php $this->load->view('front/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('front/include/include_script'); ?>


    <?php $this->load->view('front/include/filter'); ?>
<script></script>
    <script>
        $(function() {

            var $document = $(document),
                selector = '[data-rangeslider]',
                $element = $(selector);

            // Example functionality to demonstrate a value feedback
            function valueOutput(element) {
                var value = element.value,
                    output = element.parentNode.getElementsByTagName('output')[0];
                output.innerHTML = value;
            }
            for (var i = $element.length - 1; i >= 0; i--) {
                valueOutput($element[i]);
            };
            $document.on('change', 'input[type="range"]', function(e) {
                valueOutput(e.target);
            });

            // Example functionality to demonstrate disabled functionality
            $document.on('click', '#js-example-disabled button[data-behaviour="toggle"]', function(e) {
                var $inputRange = $('input[type="range"]', e.target.parentNode);

                if ($inputRange[0].disabled) {
                    $inputRange.prop("disabled", false);
                } else {
                    $inputRange.prop("disabled", true);
                }
                $inputRange.rangeslider('update');
            });

            // Example functionality to demonstrate programmatic value changes
            $document.on('click', '#js-example-change-value button', function(e) {
                var $inputRange = $('input[type="range"]', e.target.parentNode),
                    value = $('input[type="number"]', e.target.parentNode)[0].value;

                $inputRange.val(value).change();
            });

            // Example functionality to demonstrate destroy functionality
            $document
                .on('click', '#js-example-destroy button[data-behaviour="destroy"]', function(e) {
                    $('input[type="range"]', e.target.parentNode).rangeslider('destroy');
                })
                .on('click', '#js-example-destroy button[data-behaviour="initialize"]', function(e) {
                    $('input[type="range"]', e.target.parentNode).rangeslider({
                        polyfill: false
                    });
                });

            // Example functionality to test initialisation on hidden elements
            $document
                .on('click', '#js-example-hidden button[data-behaviour="toggle"]', function(e) {
                    var $container = $(e.target.previousElementSibling);
                    $container.toggle();
                });

            // Basic rangeslider initialization
            $element.rangeslider({

                // Deactivate the feature detection
                polyfill: false,

                // Callback function
                onInit: function() {},

                // Callback function
                onSlide: function(position, value) {
                    console.log('onSlide');
                    console.log('position: ' + position, 'value: ' + value);
                },

                // Callback function
                onSlideEnd: function(position, value) {
                    console.log('onSlideEnd');
                    console.log('position: ' + position, 'value: ' + value);
                }
            });

        });


        

        function favourite(id){
            event.preventDefault();
            event.stopPropagation();
            var is_login=0;
            <?php if($is_login){ ?>
                is_login=1;
            <?php } ?>

            if(is_login==0){
                $('#sign_in_modal').modal('show');
            }else{

                $.ajax({
                    url:'<?php echo base_url('submit_favorite') ?>',
                    method: 'post',
                    data: {id: id},
                    dataType: 'text',
                    success: function(response){
                    console.log(response);
                        if(response=='failed'){
                            alert('Something went wrong..');
                            $('.favorite'+id).removeClass("active");
                        }

                        if(response == 'upgrade'){
                            alert('<?php echo $this->lang->line('upgrade_your_package');?>');
                            $('.favorite'+id).removeClass("active");
                        }

                        if(response=='successfully removed'){
                            $('.favorite'+id).removeClass("active");
                        }
                    }
                });
            }

        }


        function sharelink(link){
            event.preventDefault();
            event.stopPropagation();
            var is_login=0;
            <?php if($is_login){ ?>
                is_login=1;
            <?php } ?>

            if(is_login==0){
                $('#sign_in_modal').modal('show');
            }else{

                window.open(link, '_blank');

            }

        }

        
    </script>

</body>

</html>
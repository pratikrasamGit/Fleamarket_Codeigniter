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
        <div class="container py-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto py-2">
                    <a href="#" class="btn btn_setting toggle_filter_btn">
                        <img src="<?= base_url() ?>assets/img/icons/setting.png" alt="">
                    </a>
                </div>

                <div class="col-auto py-2">
                    <h6 class="fs-12 fw-800 text_dark"><?php echo $this->lang->line('search_results');?></h6>
                    <h5 class="fs-16 fw-600">
                        <span class="text_success"><?=count($market)?> <?php echo $this->lang->line('results');?>, </span>
                        <span class="text_solid_black"><?php echo $this->lang->line('near_by_markets');?></span>
                    </h5>
                </div>

                <div class="col-auto py-2">
                    <a href="#" class="btn btn_map_view">
                        <img class="mr-1" src="<?= base_url() ?>assets/img/icons/map_view.png" alt=""> <?php echo $this->lang->line('map_view');?>
                    </a>
                </div>
            </div>
        </div>

        <div class="filter_container">
            <button class="filter_close_btn">
                <img width="15" src="<?= base_url() ?>assets/img/icons/close.png" alt="">
            </button>
            <h4 class="fs-30 fw-700 text-center">Filter</h4>
            <form method="post">
                <div class="row">
                    <div class="col-12 form-group">
                        <label for="" class="fs-12 fw-800"><?php echo $this->lang->line('select').' '.$this->lang->line('flea_Market');?></label>
                        <select class="form-control" id="market_id" name="market_id">
                        <option value=""><?php echo $this->lang->line('all')?></option>
                        <?php foreach($markets as $value){ ?>
                            <option value="<?=$value->id?>" <?php if($market_id==$value->id){ echo "selected"; } ?>><?=$value->market_name?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                      <input type="text" class="form-control text-center" id="zipcode" name="zipcode" placeholder="<?=$this->lang->line('zipcode');?>" value="<?=$zipcode?>">
                    </div>
                    <div class="col-sm-6 form-group">
                      <input type="text" class="form-control text-center" id="city" name="city" placeholder="<?=$this->lang->line('city');?>" value="<?=$city?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="fs-12 fw-800"><?=$this->lang->line('from');?> <?=$this->lang->line('date');?></label>
                      <input type="date" class="form-control" id="date_from" name="date_from"  value="<?=$date_from?>">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label class="fs-12 fw-800"><?=$this->lang->line('to');?> <?=$this->lang->line('date');?></label>
                      <input type="date" class="form-control" id="date_to" name="date_to"  value="<?=$date_to?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="fs-12 fw-800"><?=$this->lang->line('from');?> <?=$this->lang->line('time');?></label>
                      <input type="time" class="form-control" id="time_from" name="time_from"  value="<?=$time_from?>">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label class="fs-12 fw-800"><?=$this->lang->line('to');?> <?=$this->lang->line('time');?></label>
                      <input type="time" class="form-control" id="time_to" name="time_to"  value="<?=$time_to?>">
                    </div>
                </div>


                <hr>
                <div class="row justify-content-between">
                <div class="col-6">
                    <label class="fs-12 fw-800"><?=$this->lang->line('your_range');?></label>
                </div>
                <div class="col-auto form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="entire_denmark" name="entire_denmark" <?php if($entire_denmark==1){ echo "checked"; } ?>  value="1">
                        <label class="custom-control-label fs-12 fw-800" for="entire_denmark"><?=$this->lang->line('entire_denmark');?></label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="">
                        <input type="range" value="<?=$range?>" name="range" data-rangeslider>
                        <output></output>
                    </div>
                </div>
            </div>
                <hr>

                <div class="filter_categories_card">
                  <label class="fs-18 fw-800"><?=$this->lang->line('categories');?></label><br>
                  <?php foreach($categories as $value){ ?>
                      <div class="category_buttons">
                          <label>
                              <input type="checkbox" name="category[]" value="<?= $value->id?>" <?php if(!empty($category)){ if(in_array($value->id, $category)){ echo "checked"; } } ?>  ><span><?php if($this->session->userdata('site_lang') == 'danish'){ echo $value->dnk_name; }else{ echo $value->category_name; } ?></span>
                          </label>
                      </div>
                  <?php } ?>  
                </div>
                <input type="hidden" id="searchTextval" value="<?=$searchText?>">

                <button type="submit" class="btn btn_apply"><?=$this->lang->line('search');?></button>
            </form>

        </div>

        <div class="container-fluid px-0">
            <div class="row mx-0">
                <div class="col-12 px-0">
                    <!-- <img src="<?= base_url() ?>assets/img/dummy_map.png" alt=""> -->
                    <div id="map" class=""></div>
                </div>
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
    <script src="<?= base_url() ?>assets/js/rangeslider.min.js"></script>



    
    <script
      src=""
      async
    ></script>




    <script>
        $(document).ready(function() {

            $('.search_bar').attr('action', '');

            var st = $('#searchTextval').val(); 
            $('.searchText').val(st);
            $(".toggle_filter_btn").click(function() {
                $('.filter_container').toggleClass('show');
            });
            $(".filter_close_btn").click(function() {
                $('.filter_container').toggleClass('show');
            });
        });
    </script>
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
    </script>


<script>

        // var infoarray = 



    function initMap() {
        var mapOpts = {
            center: {lat: <?=$lat?>, lng: <?=$long?>},
            zoom: 13,
            // mapTypeId: google.maps.MapTypeId.TERRAIN,
            styles: 
            [
                {
                "featureType": "road.local",
                "stylers": [
                    {
                    // "weight": 4.5,
                    visibility: "off"
                    }
                ]
                },
                {
                featureType: "poi.business",
                stylers: [{ visibility: "off" }],
                },
                {
                featureType: "transit",
                elementType: "labels.icon",
                stylers: [{ visibility: "off" }],
                },
            ]
        };

        
        var map = new google.maps.Map(document.getElementById('map'), mapOpts);
        // var bicyclayer = new google.maps.BicyclingLayer();
        // bicyclayer.setMap(map);
// var marker =[];
var infowincontent=[];
// var i=0;
var infowindow = new google.maps.InfoWindow();

var marker;
var i= 0;
  <?php foreach ($market as $keys => $values) {  ?>
  console.log('<?=$values->market_name?>');
  console.log('<?=$values->address?>');
         infowincontent[i] = '<div style="width:300px"><div class="feature_market_card"><a href="<?= base_url() ?>/market/<?=$values->id?>"></a><div class="img_bg_card mt-0"  style="<?php if(count($values->images) > 0){ ?> background-image: url(<?= $values->images[0]->fullurl ?>); <?php } ?>"><a href="<?= base_url() ?>/market/<?=$values->id?>"></a><div class="img_bg_card_content"><a href="<?= base_url() ?>/market/<?=$values->id?>"></a><div class="d-flex-wrap justify-content-between align-items-center mb-2"><a href="<?= base_url() ?>/market/<?=$values->id?>"><p class="fs-18 fw-600"><?=substr_replace( $values->market_name, "", 12); ?> <?php if(strlen($values->market_name) > 12){ ?> ... <?php } ?></p></a><div class="d-flex align-items-center"> <span class="ml-3"> <a class="favorite favorite<?=$values->id?> <?php if($values->is_fav_market==1){ echo "active"; } ?>" href="javascript:void(0)" onclick="favourite(<?= $values->id ?>)"> <img width="15" src="<?= base_url() ?>assets/img/icons/heart.png" alt=""> </a> </span> <span class="ml-3"> <a href="javascript:void(0)" onclick="sharelink(`<?= base_url() ?>share-link/<?= $values->id ?>`)"> <img width="15" src="<?= base_url() ?>assets/img/icons/share.png" alt=""> </a> </span> </div></div><p class="fs-12 fw-500"><img class="mr-2" width="10" src="<?= base_url() ?>/assets/img/icons/location.png" alt=""> <?= trim(preg_replace('/\s\s+/', ' ', $values->address)); ?> , <?= $values->city ?></p><div class="d-flex-wrap justify-content-between align-items-center"><p class="fs-12 fw-500"><span><img class="mr-2" width="10" src="<?= base_url() ?>/assets/img/icons/clock.png" alt=""></span><?php $date=date_create($values->start_time);echo date_format($date,"H:i"); ?> - <?php $date2=date_create($values->end_time);echo date_format($date2,"H:i"); ?></p><p class="fs-12 fw-500"><span class="fs-12 fw-500"><img class="mr-2" width="10" src="<?= base_url() ?>/assets/img/icons/calender.png" alt=""></span><?= $values->start_date ?> - <?= $values->end_date ?></p></div></div></div></div></div>';
  


  marker = new google.maps.Marker({
    position: new google.maps.LatLng(<?=$values->market_lat?>, <?=$values->market_long?>),
    map: map
  });

  google.maps.event.addListener(marker, 'click', (function(marker, i) {
    return function() {
      infowindow.setContent(infowincontent[i]);
      infowindow.open(map, marker);
    }
  })(marker, i));
i++;
  <?php } ?>



}



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


<?php
    // if(!$is_login){
?>
    // $(window).on('load', function() {
    //     $('#sign_in_modal').modal('show');
    // });
<?php
    // }
?>

</script>
</body>

</html>

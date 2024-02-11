<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loppekortet</title>

    <?php $this->load->view('front/include/include_styles'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?= base_url() ?>assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/css/image-uploader.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,700|Montserrat:300,400,500,600,700|Source+Code+Pro&display=swap"
          rel="stylesheet">

</head>

<body>

    <!--================Header Menu Area =================-->
    <?php $this->load->view('front/include/header'); ?>
    <!--================Header Menu Area =================-->

    <!--================ Create Flea Market Area =================-->
    <section class="create_flea_market_page pb-5">
        <div class="container pt-4">
            <div class="section_heading justify-content-center align-items-center">
                <h5 class="fs-25 fw-800"><?php if($market_id){ echo $this->lang->line('edit_market'); }else{ echo $this->lang->line('create_market'); } ?> - <?=$this->lang->line('step');?> 1</h5>
            </div>
        </div>
        
        <div class="container pt-5">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="bdr_card">
                        <form action="" class="box_shd_frm_grp p-4" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="market_id" value="<?=$market_id?>">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="" class="fs-20 fw-700"><?php echo $this->lang->line('flea_Market').' '.$this->lang->line('name'); ?></label>
                                    <div class="form-group">
                                        <input type="text" name="market_name" class="form-control" id="" value="<?php if(!empty($marketdata)){ echo $marketdata->market_name; } ?>" placeholder="<?php echo $this->lang->line('flea_sunday_market'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="" class="fs-20 fw-700"><?php echo $this->lang->line('date'); ?></label>
                                    <div class="form-inline justify-content-between">

                                        <div class="form-group" style="width: 200px;">
                                            <div class="input-group date" id="date_from" data-target-input="nearest">
                                                <div class="input-group-prepend" data-target="#date_from" data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <img src="<?= base_url() ?>assets/img/icons/calender.png" alt="">
                                                    </div>
                                                </div>
                                                <input type="text" data-target="#date_from" data-toggle="datetimepicker" name="start_date" id="start_date" value="<?php if(!empty($marketdata)){ $date=date_create($marketdata->start_date); echo date_format($date,"m/d/Y"); } ?>" class="form-control datetimepicker-input" data-target="#date_from" placeholder="<?php echo $this->lang->line('select').' '.$this->lang->line('date'); ?>" autocomplete="off" required />
                                            </div>
                                        </div>

                                        <span class="fs-16 fw-600">
                                        <?php echo $this->lang->line('to'); ?>
                                        </span>

                                        <div class="form-group" style="width: 200px;">
                                            <div class="input-group date" id="date_to" data-target-input="nearest">
                                                <div class="input-group-prepend" data-target="#date_to" data-toggle="datetimepicker" onclick="getdate()">
                                                    <div class="input-group-text">
                                                        <img src="<?= base_url() ?>assets/img/icons/calender.png" alt="">
                                                    </div>
                                                </div>
                                                <input type="text" data-target="#date_to" data-toggle="datetimepicker" onclick="getdate()" name="end_date" id="end_date" value="<?php if(!empty($marketdata)){ $date=date_create($marketdata->end_date); echo date_format($date,"m/d/Y"); } ?>" class="form-control datetimepicker-input" data-target="#date_to" placeholder="<?php echo $this->lang->line('select').' '.$this->lang->line('date'); ?>" autocomplete="off" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6 mb-3">
                                    <label for="" class="fs-20 fw-700"><?php echo $this->lang->line('categories'); ?></label>
                                    <div class="form-group">
                                        <?php foreach($categories as $category){ ?>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" name="categories[]" value="<?= $category->id?>" <?php if(!empty($marketdata->categories)){ if(in_array($category->id, $cats)){ echo "checked"; } } ?>><span><?php if($this->session->userdata('site_lang') == 'danish'){ echo $category->dnk_name; }else{ echo $category->category_name; } ?></span>
                                            </label>
                                        </div>
                                         <?php } ?>   
                                    </div>
                                </div>


                                <div class="col-sm-6 mb-3">
                                    <label for="" class="fs-20 fw-700"><?php echo $this->lang->line('time'); ?></label>
                                    <div class="form-inline justify-content-between">
                                        <div class="form-group" style="width: 200px;">
                                            <div class="input-group date" >
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <img src="<?= base_url() ?>assets/img/icons/clock.png" alt="">
                                                    </div>
                                                </div>
                                                <input type="text" name="start_time" id="start_time"  value="<?php if(!empty($marketdata)){ echo $marketdata->start_time; } ?>"  class="form-control" placeholder="<?php echo $this->lang->line('select').' '.$this->lang->line('time'); ?>" required/>
                                            </div>
                                        </div>

                                        <span class="fs-16 fw-600">
                                            <?php echo $this->lang->line('to'); ?>
                                        </span>

                                        <div class="form-group" style="width: 200px;">
                                            <div class="input-group date" id="time_to" data-target-input="nearest">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <img src="<?= base_url() ?>assets/img/icons/clock.png" alt="">
                                                    </div>
                                                </div>
                                                <input type="text" name="end_time" id="end_time" value="<?php if(!empty($marketdata)){ echo $marketdata->end_time; } ?>" onclick="gettime()" class="form-control" placeholder="<?php echo $this->lang->line('select').' '.$this->lang->line('time'); ?>" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <!-- <div class="form-check my-4">
                                                <input class="form-check-input" type="checkbox" value="" id="its_recurring">
                                                <label class="form-check-label fs-20 fw-700" for="its_recurring">
                                                    Select Option
                                                </label>
                                            </div> -->
                                            <div class="form-group my-4">
                                                <select id="its_recurring" name="its_recurring" class="form-control" onchange="recurring(<?= $authentication['creator']['recurring_market'] ?>)">
                                                    <option value="0" <?php if(!empty($marketdata && $marketdata->recurring_type == '0')){ ?> selected <?php } ?> ><?php echo $this->lang->line('select_option'); ?></option>
                                                    <option value="1" <?php if(!empty($marketdata && $marketdata->recurring_type == '1')){ ?> selected <?php } ?>><?php echo $this->lang->line('once_a_week_on_same_day'); ?></option>
                                                    <option value="2" <?php if(!empty($marketdata && $marketdata->recurring_type == '2')){ ?> selected <?php } ?>><?php echo $this->lang->line('once_a_month_on_same_day'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="d-flex-wrap justify-content-between align-items-center">

                                        <h6 class="fs-20 fw-800"><?php echo $this->lang->line('gallery_image'); ?></h6>
                                        <div class="d-flex-wrap align-items-center">
                                            <small class="fs-14 fw-600 opacity_half  m-2"><?php echo $this->lang->line('add_upto'); ?> <?= $authentication['creator']['upload_picture'] ?> <?php echo $this->lang->line('image'); ?></small>
                                            <!-- <button class="btn btn_brand fw-600 fs-14 my-2" onclick="$('.file-upload-input').trigger( 'click' )">Upload</button> -->
                                        </div>
                                    </div>
                                    <div>
                                        <!-- <form method="POST" name="form-example-1" id="form-example-1" enctype="multipart/form-data"> -->
                                            <div class="input-field">
                                                <div class="input-images-1"></div>
                                            </div>
                                    </div>
                                    <div class="d-flex-wrap justify-content-between align-items-center">

                                        <h6 class="fs-20 fw-800"><?php echo $this->lang->line('gallery_video'); ?></h6>
                                        <div class="d-flex-wrap align-items-center">
                                            <small class="fs-14 fw-600 opacity_half  m-2"><?php echo $this->lang->line('add_upto'); ?> <?= $authentication['creator']['upload_video'] ?> <?php echo $this->lang->line('video'); ?></small>
                                            <!-- <button class="btn btn_brand fw-600 fs-14 my-2" onclick="$('.file-upload-input').trigger( 'click' )">Upload</button> -->
                                        </div>
                                    </div>
                                    <div>
                                        <!-- <form method="POST" name="form-example-1" id="form-example-1" enctype="multipart/form-data"> -->
                                            <div class="input-field">
                                                <div class="input-images-2"></div>
                                            </div>
                                            <div class="col-12 text-center">
                                                <!-- <a href="<?= base_url() ?>create-flea-market-step-2" class="btn btn_brand fw-800 fs-20 px-5 mt-4">Next</a> -->
                                                <input type="submit" class="btn btn_brand fw-800 fs-20 px-5 mt-4" value="<?php echo $this->lang->line('next'); ?>">
                                            </div>
                                        <!-- </form> -->
                                    </div>
                                </div>

                                



                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--================End Create Flea Market Area =================-->


    <?php $this->load->view('front/include/modal'); ?>
    <!--================Footer Area =================-->
    <?php $this->load->view('front/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('front/include/include_script'); ?>
    <script src="<?= base_url() ?>assets/js/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript" src="<?= base_url() ?>assets/js/image-uploader.js"></script>
                                        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="<?= base_url() ?>assets/js/mdtimepicker.js"></script>

    <script>
  
</script>

    <script type="text/javascript">
    // document.getElementsByName("start_date").onchange = function () {
        // alert(this.value);
    //     var input = document.getElementById("date_to");
    //     // input.setAttribute("min", this.value);
    //     $('#date_to').datetimepicker({
    //             format: 'L',
    //             minDate : '2022-01-27'
    //     });
    // }
    // $('#date_from').on('dp.change', function(e){ console.log(e.date); })

        var date =0;
        $(function() {

            $(document).ready(function(){

                $('#start_time').mdtimepicker({readOnly: false, is24hour: true}); //Initializes the time picker

                // $('#end_time').mdtimepicker({readOnly: false, is24hour: true}); //Initializes the time picker
            });

            $('#date_from').datetimepicker({
                // useCurrent: false,
                format: 'L',
            });

            // $('#time_from').datetimepicker({
            //     format: 'LT'
            // });



            // // $('#date_to').datetimepicker({
            // //     useCurrent: false,
            // //     minDate: moment()
            // // });
            

            // $('#date_to').datetimepicker().on('dp.change', function (e) {
            //     var decrementDay = moment(new Date(e.date));
            //     decrementDay.subtract(1, 'days');
            //     $('#date_from').data('DateTimePicker').maxDate(decrementDay);
            //      $(this).data("DateTimePicker").hide();
            // });

            // $('#date_from').datepicker({
            //     // format: 'L',
            //     dateFormat: 'dd-mm-yy'
            //     // onSelect: function(selected) {
            //     //     $("#date_to").datepicker("option","minDate", selected);
            //     //     alert(1);
            //     // }
            // });
            // $("#date_from").on("dp.change", ".date", function(e){
	        //      console.log('1');
            //     console.log(e.date); 
            //     });

            // $('#date_from').datetimepicker({ format: 'L',minDate: 0, onSelect: function(dateStr) {
            //     date = $(this).datetimepicker('getDate');
            //     if (date) {
            //             date.setDate(date.getDate() + 1);
            //     }

            //     alert(date);
            //     // $('#date_to').datetimepicker('option', 'minDate', date || 0);
            // }});
            // $('#date_to').datepicker({
            //         // format: 'L',
            //         // minDate : date
            // });

            // $('#date_from').change(function() {
                
            //     startDate = $(this).datepicker('getDate');
            //     var date = new Date(startDate),
            //     mnth = ("0" + (date.getMonth() + 1)).slice(-2),
            //     day = ("0" + date.getDate()).slice(-2);
            //     startDate=[date.getFullYear(), mnth, day].join("-");

            //     // alert(startDate);
            //     $('#date_to').datepicker({
            //         // format: 'L',
            //         dateFormat: 'dd-mm-yy',
            //         startDate : '2022-01-25'
            //     });
            // });

            //     ///////
            //     $('#date_to').change(function() {
            //     endDate = $(this).datetimepicker('getDate');
            //     $("#date_from").datetimepicker("option", "maxDate", endDate );
            //     });



            // $('#time_to').datetimepicker({
            //     format: 'LT'
            // });

            // $(document).on('click', '.delete-image', function() {
            $('.delete-image').click(function() {
                var image = $(this).parent().find('img').attr('src');
                console.log(image);


                $.ajax({
                    url:'<?php echo base_url('delete_image') ?>',
                    method: 'post',
                    data: {fullpath: image},
                    dataType: 'text',
                    success: function(response){
                    console.log(response);
                        
                    }
                });

            });

            
           
        });

        let preloaded = [];
        <?php if($market_gallery){ ?>
            preloaded = <?= $market_gallery ?>;
        <?php } ?>

        let preloaded1 = [];
        <?php if($market_gallery_video){ ?>
            preloaded1 = <?= $market_gallery_video ?>;
        <?php } ?>

        $('.input-images-1').imageUploader({
            preloaded: preloaded,
            extensions: ['.jpg','.jpeg','.png','.gif','.svg'],
            mimes: ['image/jpeg','image/png','image/gif','image/svg+xml'],
            maxFiles: <?= $authentication['creator']['upload_picture'] ?>
        });

        $('.input-images-2').imageUploader({
            preloaded: preloaded1,
            extensions: ['.3gp','.mov','.avi','.flv','.mp4','.wmv'],
            mimes: ['video/3gpp','video/quicktime','video/x-msvideo','video/mp4','video/x-ms-wmv'],
            maxFiles: <?= ($authentication['creator']['upload_video']) ? $authentication['creator']['upload_video'] : -1 ?>
        });     


        function getdate(){
            var start_date = $('#start_date').val();
            
            if(start_date!=''){

                $('#date_to').datetimepicker({
                    format: 'L',
                    minDate: start_date
                });
            }else{
                alert("Please select start date")
            }

        }

        function gettime(){
            var start_time = $('#start_time').val();
            // alert(start_time);
            if(start_time!=''){
                // $('#time_to').datetimepicker({
                //     format: 'LT',
                //     minTime: start_time
                // });

                $('#end_time').mdtimepicker({readOnly: false, is24hour: true,minTime: start_time}); //Initializes the time picker

            }else{
                alert("Please select start time")
            }
        }

        function deleteimage(id){

            if(confirm('Are you sure?')){
            var deleted = $('#deleted').val();

            deleted = deleted+','+id;

            $('#deleted').val(deleted);

            $("#imagedel_div"+id).remove();
            }
        }

        function recurring(status) {
            if(status == 0){
                $('#its_recurring').val(0);
                alert("<?php echo $this->lang->line('upgrade_your_package');?>");
            }
        }
    </script>
    <!-- <script>
        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-upload-wrap').show();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html('');
                };

                reader.readAsDataURL(input.files[0]);

            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }
        $('.image-upload-wrap').bind('dragover', function() {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function() {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
    </script> -->

    <?php

        if(!$is_login){

    ?>
        <script type="text/javascript">
            $(window).on('load', function() {
                $('#sign_in_modal').modal('show');
            });
        </script>
    <?php
        }
    ?>
</body>

</html>
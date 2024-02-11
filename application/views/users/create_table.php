<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loppekortet</title>

    <?php $this->load->view('users/include/include_styles'); ?>


</head>

<body class="fixed_search_bar_header_body">

    <!--================Header Menu Area =================-->
    <?php $this->load->view('users/include/header'); ?>
    <!--================Header Menu Area =================-->


    <div class="d-inline-block w-100">
        <!--================ Left Aside Menu Area =================-->
        <?php $this->load->view('users/include/left_aside'); ?>
        <!--================ Left Aside Menu Area =================-->




        <div class="user_body_container">

            <div class="row justify-content-center">
                <div class="col-sm-12 user_bdr_container">
                    <div class="section_heading justify-content-center mb-4">
                        <h4 class="fs-30 fw-800"><?php echo $this->lang->line('rent_space');?></h4>
                    </div>

                    <?php 
                        if($table_creator_status == 1){
                    ?>
                    <div class="row">
                        <div class="col-10 mx-auto craete_rent_a_space_table_card">
                            
                        <form class="box_shd_frm_grp" method="post" enctype="multipart/form-data">

                            <div class="form-row justify-content-center align-items-center">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <select  class="form-control" name="fk_market_id" id="fk_market_id" onchange="getMarket(this.value)">
                                            <option value=""><?php echo $this->lang->line('select').' '.$this->lang->line('flea_Market');?></option>
                                            <?php foreach($markets as $market){ 
                                                 $spaces = $this->gm->get_list('*', 'rudra_rent_space', array('fk_market_id' => $market->id));
                                                    if(empty($spaces)){    ?>
                                            <option value="<?=$market->id?>"><?=$market->market_name?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="lh-1 d-flex-wrap justify-content-between align-items-center">
                                        <span class="fs-16 fw-600 mr-2"><?php echo $this->lang->line('date');?></span>
                                        <span class="fs-14 fw-600 text_success" id="start_date"></span>
                                    </p>
                                    <p class="lh-1 d-flex-wrap justify-content-between align-items-center">
                                        <span class="fs-16 fw-600 mr-2"><?php echo $this->lang->line('time');?></span>
                                        <span class="fs-14 fw-600 text_success" id="timerange"></span>
                                    </p>
                                </div>
                                <div class="col-12">
                                    <p class="lh-1"><span class="fs-16 fw-600 mr-2"><?php echo $this->lang->line('table_type');?></span></p>
                                    <fieldset class="formSlider">
                                        <div class="__range __range-step">
                                            <input value="1" type="range" max="3" min="1" step="1" list="ticks1" onchange="changeType(this.value)">
                                            <div class="datalist" id="ticks1" >
                                                <div class="option" value="1"></div>
                                                <div class="option" value="2"></div>
                                                <div class="option" value="3"></div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-row justify-content-center align-items-center mt-4">
                                <div class="col-sm-12">
                                    <label class="fs-16 fw-600"><?php echo $this->lang->line('enter_table_no');?></label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="number" class="form-control alltable_types large_type" id="no_of_table_large" onchange="noOfTable(this.value ,'large')" placeholder="<?php echo $this->lang->line('no_of_table_large');?>">
                                            <input type="number" class="form-control alltable_types medium_type" id="no_of_table_medium" onchange="noOfTable(this.value ,'medium')"  placeholder="<?php echo $this->lang->line('no_of_table_medium');?>" style="display:none">
                                            <input type="number" class="form-control alltable_types small_type" id="no_of_table_small" onchange="noOfTable(this.value ,'small')"  placeholder="<?php echo $this->lang->line('no_of_table_small');?>" style="display:none">
                                            <input type="hidden" class="form-control" id="no_of_table_hidden_large" name="table_no_large">
                                            <input type="hidden" class="form-control" id="no_of_table_hidden_medium" name="table_no_medium">
                                            <input type="hidden" class="form-control" id="no_of_table_hidden_small" name="table_no_small">
                                            <div class="input-group-append no_border">
                                                <div class="input-group-text">
                                                    <!-- <input type="checkbox" value="Checkbox for following text input"> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row justify-content-center align-items-center">
                                <div class="col-sm-6">
                                    <label class="fs-16 fw-600"><?php echo $this->lang->line('set_space_rent');?> (DKK)</label>
                                    <div class="form-group">
                                        <input type="number" class="form-control alltable_types large_type" id="table_rent_price_large"  onchange="getReceiveRent(this.value ,'large')" placeholder="<?php echo $this->lang->line('space_for_large');?>">
                                        <input type="number" class="form-control alltable_types medium_type" id="table_rent_price_medium" onchange="getReceiveRent(this.value ,'medium')" placeholder="<?php echo $this->lang->line('space_for_medium');?>" style="display:none">
                                        <input type="number" class="form-control alltable_types small_type" id="table_rent_price_small" onchange="getReceiveRent(this.value ,'small')" placeholder="<?php echo $this->lang->line('space_for_small');?>" style="display:none">
                                        <input type="hidden" class="form-control" id="table_rent_price_hidden_large" name="table_rent_price_large" value="">
                                        <input type="hidden" class="form-control" id="table_rent_price_hidden_medium" name="table_rent_price_medium" value="">
                                        <input type="hidden" class="form-control" id="table_rent_price_hidden_small" name="table_rent_price_small" value="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <label for="" class="fs-16 fw-600"><?php echo $this->lang->line('you_receive');?> (DKK)</label>
                                    <div class="form-group">
                                    <input type="hidden" name="table_rent_comission_percentage" id="table_rent_comission_percentage"  value="<?=$table_percentage?>">
                                        <input type="number" class="form-control alltable_types large_type" id="table_rent_receive_large" readonly >
                                        <input type="number" class="form-control alltable_types medium_type" id="table_rent_receive_medium" readonly  style="display:none">
                                        <input type="number" class="form-control alltable_types small_type" id="table_rent_receive_small" readonly   style="display:none">
                                        <input type="hidden" class="form-control" id="table_rent_receive_hidden_large" name="table_rent_receive_large" value="">
                                        <input type="hidden" class="form-control" id="table_rent_receive_hidden_medium" name="table_rent_receive_medium" value="">
                                        <input type="hidden" class="form-control" id="table_rent_receive_hidden_small" name="table_rent_receive_small" value="">

                                        <input type="hidden" class="form-control" id="table_rent_comission_large" name="table_rent_comission_large" value="">
                                        <input type="hidden" class="form-control" id="table_rent_comission_medium" name="table_rent_comission_medium" value="">
                                        <input type="hidden" class="form-control" id="table_rent_comission_small" name="table_rent_comission_small" value="">

                                    </div>
                                </div>
                                <div class="col-12 text-right">
                                    <a href=""><span class="fs-12 fw-600">Loperkortet <?php echo $this->lang->line('service_fee');?> - <?=$table_percentage?>% <span class="fs-12 fw-600 text_success"><?php echo $this->lang->line('explain_this');?>?</span> </span></a>
                                </div>
                            </div>
                            
                            <div class="form-row justify-content-center align-items-center">
                                <div class="col-sm-4 image_div_large">
                                    <label class="fs-16 fw-600"><?php echo $this->lang->line('image');?> (<?php echo $this->lang->line('large');?>)</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            
                                        <div class="container">
                                            <label for="" class="et_pb_contact_form_label"></label>
                                            <input type="file" id="" name="image_large" class="file-upload">
                                        </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 image_div_medium" style="visibility:hidden">
                                    <label class="fs-16 fw-600"><?php echo $this->lang->line('image');?> (Medium)</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            
                                        <div class="container">
                                            <label for="" class="et_pb_contact_form_label"></label>
                                            <input type="file" id="" name="image_medium" class="file-upload">
                                        </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 image_div_small"  style="visibility:hidden">
                                    <label class="fs-16 fw-600"><?php echo $this->lang->line('image');?> (<?php echo $this->lang->line('small');?>)</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            
                                        <div class="container">
                                            <label for="" class="et_pb_contact_form_label"></label>
                                            <input type="file" id="" name="image_small" class="file-upload">
                                        </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row justify-content-center align-items-center">
                                <div class="col-sm-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" required>
                                        <label class="custom-control-label fs-12 fw-600" for="customCheck1"><?php echo $this->lang->line('i_agree_to');?> <a target="_blank" href="<?= base_url() ?>terms-and-conditions" class="text_success"><?php echo $this->lang->line('terms');?></a> <?php echo $this->lang->line('and');?> <a href="#"class="text_success"><?php echo $this->lang->line('conditions1');?></a></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="my-4 text-center">
                                        <button type="submit" class="btn btn-block btn_brand fs-20 fw-800 px-5"><?php echo $this->lang->line('submit');?></button>
                                    </div>
                                </div>
                            </div>

                        </form>
                            
                        </div>
                    </div>
                    <?php }else{ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger text-center" role="alert">
                              <?php echo $this->lang->line('upgrade_your_package'); ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>

        </div>
    </div>




    <!--================Footer Area =================-->
    <?php $this->load->view('users/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('users/include/include_script'); ?>
<script>

function changeType(value){
    $('.alltable_types').hide();

    if(value==1){
        $('.large_type').show();
        $(".image_div_medium").css("visibility", "hidden");
        $(".image_div_small").css("visibility", "hidden");
        $(".image_div_large").css("visibility", "visible");

    }else if(value==2){
        $('.medium_type').show();
        $(".image_div_large").css("visibility", "hidden");
        $(".image_div_small").css("visibility", "hidden");
        $(".image_div_medium").css("visibility", "visible");

    }else if(value==3){
        $('.small_type').show();
        $(".image_div_large").css("visibility", "hidden");
        $(".image_div_medium").css("visibility", "hidden");
        $(".image_div_small").css("visibility", "visible");
    }


}


function noOfTable(value, type){

    $('#no_of_table_hidden_'+type).val(value);

}

function getReceiveRent(value, type){

    $('#table_rent_price_hidden_'+type).val(value);
    var table_percentage = $('#table_rent_comission_percentage').val();

    var comission = value*(table_percentage/100);
    var rent_receive =  value - comission;

    $('#table_rent_receive_'+type).val(rent_receive);
    $('#table_rent_receive_hidden_'+type).val(rent_receive);
    $('#table_rent_comission_'+type).val(comission);
}   

function getMarket(id){

    $.ajax({
     url:'<?php echo base_url('users/getMarketData') ?>',
     method: 'post',
     data: {id: id},
     dataType: 'json',
     success: function(response){
       console.log(response);
         var start_date = response.start_date;
         var timerange = response.time;
 
         $('#start_date').text(start_date);
         $('#timerange').text(timerange);
 
     }
   });

}
</script>
</body>

</html>
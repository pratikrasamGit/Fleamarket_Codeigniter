<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loppekortet</title>

    <?php $this->load->view('front/include/include_styles'); ?>


</head>

<body>

    <!--================Header Menu Area =================-->
    <?php $this->load->view('front/include/header'); ?>
    <!--================Header Menu Area =================-->

    <!--================ Details Place Area =================-->

    <?php
        if($is_login){
    ?>
    <section class="details_page pb-5">
        <div class="container pt-5" style="<?php if(count($market->images) > 0){ ?>background-image: url(<?= $market->images[0]->fullurl ?>);  background-repeat: no-repeat;
 <?php } ?>;" >
            <div class="section_heading justify-content-between align-items-center">
                <h5 class="fs-30 fw-700"><?= $market->market_name ?></h5>
                <div class="d-flex align-items-center">
                    <span class="ml-3">
                    <a class="favorite <?php if($market->is_fav_market==1){ echo "active"; } ?>" href="javascript:void(0)" onclick="favourite(<?= $market->id ?>)">
                            <img width="15" src="<?= base_url() ?>assets/img/icons/heart.png" alt="">
                        </a>
                    </span>
                    <span class="ml-3">
                    <a href="javascript:void(0)" onclick="sharelink(`<?= base_url() ?>share-link/<?= $market->id ?>`)">
                            <img width="15" src="<?= base_url() ?>assets/img/icons/share.png" alt="">
                        </a>
                    </span>
                    <?php if($this->is_login){ if($this->users_id == $market->fk_user_id){ ?>
                    <span class="ml-3">
                    <a href="<?= base_url().'create-flea-market/'.$market->id?>" class="fw-600 btn btn_brand" ><?php echo $this->lang->line('edit');?></a>
                    </span>
                    <?php } } ?>
                </div>
                
            </div>
            <!-- <div class="row">
                <div class="col-12">
                    <div class="details_main_img">
                        <img src="<?php if(count($market->images) > 0){ ?>background-image: url(<?= $market->images[0]->fullurl ?>); <?php } ?>" alt="">
                    </div>
                </div>
            </div> -->
        </div>

        <div class="container pt-4">
            <div class="section_heading justify-content-between align-items-center">
                <h5 class="fs-30 fw-700"><?php echo $this->lang->line('gallery');?></h5>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="nav gallery_img justify-content-between">
                        <?php
                            if($is_visible ==1){ 
                            foreach ($market->images as $keys => $values) {
                        ?>
                            <li class="nav-item active">
                                <a href="#">
                                    <img src="<?= $values->fullurl ?>" alt="">
                                </a>
                            </li>
                        <?php
                            } }else{
                        ?>
                            <li class="nav-item active">
                                <a href="#">
                                    <img src="<?php if(count($market->images) > 0){ echo $market->images[0]->fullurl; } ?>" alt="">
                                </a>
                            </li>

                        <?php } ?>
                        <!-- <li class="nav-item lock">
                            <a href="#">
                                <img src="<?= base_url() ?>assets/img/gallery_list_img1.png" alt="">
                            </a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>

        <div class="container pt-4">
            <div class="section_heading justify-content-between align-items-center">
                <h5 class="fs-30 fw-700"><?php echo $this->lang->line('categories');?></h5>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="nav categories_list justify-content-between">
                        <?php
                            foreach ($market->category_list as $ckeys => $cvalues) {
                        ?>
                            <li class="nav-item">
                                <a href=""><?= $cvalues->category_name ?></a>
                            </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="row justify-content-between">
                <div class="col-lg-5 pt-4">
                    <div class="section_heading justify-content-between align-items-center">
                        <h5 class="fs-30 fw-700">Information</h5>
                    </div>
                    <div class="py-3">
                        <div class="row pb-3">
                            <div class="col-12">
                                <ul class="d-flex information_list">
                                    <div class="information_list_item">
                                        <img src="<?= base_url() ?>assets/img/icons/info_location.png" alt="">
                                    </div>
                                    <div class="information_list_item"><?= $market->address ?>, <?= $market->city ?></div>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="d-flex information_list align-items-center">
                                    <div class="information_list_item">
                                        <img src="<?= base_url() ?>assets/img/icons/info_time.png" alt="">
                                    </div>
                                    <div class="information_list_item"><?= $market->start_time ?> - <?= $market->end_time ?></div>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="d-flex information_list align-items-center">
                                    <div class="information_list_item">
                                        <img src="<?= base_url() ?>assets/img/icons/info_calendar.png" alt="">
                                    </div>
                                    <div class="information_list_item"><?= $market->start_date ?> - <?= $market->end_date ?></div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 pt-4">
                    <div class="section_heading justify-content-between align-items-center">
                        <h5 class="fs-30 fw-700"><?php echo $this->lang->line('description');?></h5>
                    </div>

                    <div class="py-3">
                        <p class="fs-14 fw-400"><?= $market->description ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container pt-4">
            <div class="section_heading justify-content-between align-items-center">
                <h5 class="fs-30 fw-700"><?php echo $this->lang->line('contact');?></h5>
            </div>
            <div class="row align-items-center">
                <div class="col-sm-6 col-lg-auto">
                    <ul class="nav justify-content-start details_page_contact_list align-items-center">
                        <li class="nav-item">
                            <img width="30" src="<?=$profile_pic?>" alt="">
                        </li>
                        <li class="nav-item">
                        <?php if($is_visible ==1){ 
                                echo $market->contact_person;
                             }else{ ?>
                            ***************
                            <?php } ?>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-auto">
                    <ul class="nav justify-content-start details_page_contact_list align-items-center">
                        <li class="nav-item">
                            <img width="30" src="<?= base_url() ?>assets/img/icons/phone_dark.png" alt="">
                        </li>
                        <li class="nav-item">
                            <?php if($is_visible ==1){ 
                                echo $market->contact_number;
                             }else{ ?>
                            +45 **********
                            <?php } ?>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-auto">
                    <ul class="nav justify-content-start details_page_contact_list align-items-center">
                        <li class="nav-item">
                            <img width="30" src="<?= base_url() ?>assets/img/icons/mail_dark.png" alt="">
                        </li>
                        <li class="nav-item">
                        <?php if($is_visible ==1){ 
                                echo $market->contact_email;
                             }else{ ?>
                            ************@gmail.com
                            <?php } ?>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-auto">
                    <ul class="nav justify-content-start details_page_contact_list align-items-center">
                        <li class="nav-item">
                            <img width="40" src="<?= base_url() ?>assets/img/icons/lock_dark.png" alt="">
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <?php if($large_table || $medium_table || $small_table){ ?>
            <div class="row justify-content-between">
                <div class="col-6">
                    <span class="mr-3">Total Tables Booked</span>
                    <span><span class="text_success" id="total_tables_booked"><?=(isset($total_tables_booked) ? $total_tables_booked : 0)?></span>/100</span>
                </div>
                <div class="col-auto">
                    <button class="btn btn_xs btn_brand fw-600"  onclick="checkCart()">
                        <div class="d-flex align-items-center">
                            <img height="25" src="<?= base_url() ?>assets/img/icons/shopping_cart.png" alt=""> <span id="total_tables_in_cart">0</span>
                        </div>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-borderless fs-16">
                        <thead>
                            <tr>
                                <th class="text_dark opacity_half">Type</th>
                                <th class="text_dark opacity_half">Booked/Avail</th>
                                <th class="text_dark opacity_half">Cost</th>
                                <th class="text_dark opacity_half">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $large_rent_id = $medium_rent_id = $small_rent_id= '';
                            $table_rent_price_large = $table_rent_price_medium = $table_rent_price_small = 0;
                            if($large_table){ 
                                $large_rent_id=$large_table->id;
                               $table_rent_price_large = $large_table->table_rent_price; ?>
                            <tr>
                                <td class="fw-600">Large</td>
                                <td class="fw-600"><span class="text_success" id="total_tables_booked_large"><?=(isset($total_tables_booked_large) ? $total_tables_booked_large : 0)?></span>/<span id="max_table_no_large"><?=$large_table->table_no?></span></td>
                                <td class="fw-600"><?=$large_table->table_rent_price?>DKK</td>
                                <td>
                                    <button class="btn btn_sm btn_brand fw-600 fs-16" data-toggle="modal" data-target="#book_modal_large" <?php if($total_tables_booked_large==$large_table->table_no){ echo "disabled"; } ?>>Book</button>
                                </td>
                            </tr>
                            <?php } if($medium_table){
                                $medium_rent_id=$medium_table->id;
                                $table_rent_price_medium = $medium_table->table_rent_price; ?>
                            <tr>
                                <td class="fw-600">Medium</td>
                                <td class="fw-600"><span class="text_success" id="total_tables_booked_medium"><?=(isset($total_tables_booked_medium) ? $total_tables_booked_medium : 0)?></span>/<span id="max_table_no_medium"><?=$medium_table->table_no?></span></td>
                                <td class="fw-600"><?=$medium_table->table_rent_price?>DKK</td>
                                <td>
                                    <button class="btn btn_sm btn_brand fw-600 fs-16" data-toggle="modal" data-target="#book_modal_medium"  <?php if($total_tables_booked_medium==$medium_table->table_no){ echo "disabled"; } ?>>Book</button>
                                </td>
                            </tr>
                            <?php } if($small_table){ 
                                $small_rent_id=$small_table->id;
                                $table_rent_price_small = $small_table->table_rent_price; ?>
                            <tr>
                                <td class="fw-600">Small</td>
                                <td class="fw-600"><span class="text_success" id="total_tables_booked_small"><?=(isset($total_tables_booked_small) ? $total_tables_booked_small : 0)?></span>/<span id="max_table_no_small"><?=$small_table->table_no?></span></td>
                                <td class="fw-600"><?=$small_table->table_rent_price?>DKK</td>
                                <td>
                                    <button class="btn btn_sm btn_brand fw-600 fs-16" data-toggle="modal" data-target="#book_modal_small"  <?php if($total_tables_booked_small==$small_table->table_no){ echo "disabled"; } ?>>Book</button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                  
                    <input type="hidden" id="rent_large" value="<?=$table_rent_price_large?>" >
                    <input type="hidden" id="rent_medium" value="<?=$table_rent_price_medium?>" >
                    <input type="hidden" id="rent_small" value="<?=$table_rent_price_small?>" >

                    <input type="hidden" value="<?=$large_rent_id?>" id="large_rent_id" >
                    <input type="hidden" value="<?=$medium_rent_id?>" id="medium_rent_id" >
                    <input type="hidden" value="<?=$small_rent_id?>" id="small_rent_id" >

                </div>
            </div>
            <div class="row">
                <?php if($large_table){ if($large_table->file_name){ ?>
                <div class="col-md-3">
                    <img src="<?= base_url().$large_table->file_path.'/'.$large_table->file_name; ?>" alt="">
                </div>
                <?php } } ?>
                <?php if($medium_table){ if($medium_table->file_name){ ?>
                <div class="col-md-3">
                    <img src="<?= base_url().$medium_table->file_path.'/'.$medium_table->file_name; ?>" alt="">
                </div>
                <?php } } ?>
                <?php if($small_table){ if($small_table->file_name){ ?>
                <div class="col-md-3">
                    <img src="<?= base_url().$small_table->file_path.'/'.$small_table->file_name; ?>" alt="">
                </div>
                <?php } } ?>
            </div>
            <?php } ?>
        </div>

    </section>
    <div class="modal fade" id="book_modal_large" tabindex="-1" role="dialog" aria-labelledby="package_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content border_radius_20">
            <div class="modal-body">
                <div class="row align-items-center justify-content-center">
                   <div class="col-8">
                        <h5 class="fs-16 fw-600 m-0">No of Tables</h5>
                   </div>
                   <div class="col-4">
                        <input class="form-control border_radius_10 fs-12 fw-600" id="large_tables_no" type="number" value="" max="<?=$large_table->table_no-$total_tables_booked_large?>" onkeyup=enforceMinMax(this)>
                    </div>
                   <div class="col-12 mt-3">
                        <button class="btn border_radius_20 btn-block btn_brand fw-600 fs-16" onclick="book('large')">Add To Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="book_modal_medium" tabindex="-1" role="dialog" aria-labelledby="package_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content border_radius_20">
            <div class="modal-body">
                <div class="row align-items-center justify-content-center">
                   <div class="col-8">
                        <h5 class="fs-16 fw-600 m-0">No of Tables</h5>
                   </div>
                   <div class="col-4">
                        <input class="form-control border_radius_10 fs-12 fw-600" id="medium_tables_no" type="number" value="" max="<?=$medium_table->table_no-$total_tables_booked_medium?>" onkeyup=enforceMinMax(this)>
                    </div>
                   <div class="col-12 mt-3">
                        <button class="btn border_radius_20 btn-block btn_brand fw-600 fs-16" onclick="book('medium')">Add To Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="book_modal_small" tabindex="-1" role="dialog" aria-labelledby="package_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content border_radius_20">
            <div class="modal-body">
                <div class="row align-items-center justify-content-center">
                   <div class="col-8">
                        <h5 class="fs-16 fw-600 m-0">No of Tables</h5>
                   </div>
                   <div class="col-4">
                        <input class="form-control border_radius_10 fs-12 fw-600" id="small_tables_no" type="number" value="" max="<?=$small_table->table_no-$total_tables_booked_small?>" onkeyup=enforceMinMax(this)>
                    </div>
                   <div class="col-12 mt-3">
                        <button class="btn border_radius_20 btn-block btn_brand fw-600 fs-16" onclick="book('small')">Add To Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php }else{ ?>

        <section class="details_page pb-5">
            <div class="container pt-5">
                <div class="section_heading justify-content-between align-items-center">
                    <h5 class="fs-10 fw-700" style="margin-left: 300px;">Waiting for login</h5>
                </div>
            </div>

        </section>
    <?php } ?>


    <div class="modal fade" id="cart_payment_modal" tabindex="-1" role="dialog" aria-labelledby="package_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content border_radius_20">
            <div class="modal-body">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12">
                        <table class="table text-center table-bordered">
                            <thead>
                                <tr>
                                    <th class="opacity_half">Type</th>
                                    <th class="opacity_half">Quantity</th>
                                    <th class="opacity_half">Cost</th>
                                    <!-- <th class="opacity_half">Status</th> -->
                                </tr>
                            </thead>
                            <tbody id="cartBody">
                              
                            </tbody>
                        </table>
                        <input type="hidden" id="is_large" value="0" >
                    <input type="hidden" id="is_medium" value="0" >
                    <input type="hidden" id="is_small" value="0" >
                    </div>
                    <div class="col-12">
                        <div class="bg_brand p-3 border_radius_20">
                            <div class="row align-items-center justify-content-between">
                                    <div class="col-8">
                                    <h5 class="fs-16 fw-600 m-0">Total amount</h5>
                                </div>
                                <div class="col-auto">
                                    <h5 class="fs-16 fw-600 m-0" ><span id="totaldkk">0</span>DKK</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-12 mt-3">
                        <h4 class="fs-20 fw-bold text-center m-0">Choose Payment Method</h4>
                    </div>
                    <!-- <hr class="w-100">
                   <div class="col-12 mt-3">
                        <div class="row  align-items-center">
                            <div class="col-4 text-center">
                                <img height="45" src="<?= base_url() ?>assets/img/credit_card.png" alt="">
                            </div>
                            <div class="col-4 text-center">
                                <h4 class="fs-20 fw-bold m-0">Credit Card</h4>
                            </div>
                        </div>
                    </div>
                    <hr class="w-100">
                   <div class="col-12 mt-3">
                        <div class="row  align-items-center">
                            <div class="col-4 text-center">
                                <img height="45" src="<?= base_url() ?>assets/img/mobile_Pay.png" alt="">
                            </div>
                            <div class="col-4 text-center">
                                <h4 class="fs-20 fw-bold m-0">Mobile Pay</h4>
                            </div>
                        </div>
                    </div> -->
                    <div class="row mb-4 justify-content-center payment_detail_tab">
                        <div class="col-auto">
                            <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-for-flea-tab" data-toggle="pill" href="#pills-for-flea" role="tab" aria-controls="pills-for-flea" aria-selected="true" onclick="payType('Paypal')">
                                        <img height="50" src="<?= base_url() ?>assets/img/credit_card.png" alt="">
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" id="pills-for-flea-markets-tab" data-toggle="pill" href="#pills-for-flea-markets" role="tab" aria-controls="pills-for-flea-markets" aria-selected="false" onclick="payType('Mobile Pay')">
                                        <img height="50" src="<?= base_url() ?>assets/img/mobile_Pay.png" alt="">
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="tab-content" >
                                <div class="tab-pane fade show active" id="cartab" role="tabpanel" aria-labelledby="pills-for-flea-tab">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <!-- Display errors returned by createToken -->
                                            <div class="card-errors"></div>
                                            
                                            <!-- Payment form -->
                                            <form class="box_shd_frm_grp p-4" action="<?= base_url() ?>rentspace-payment" method="POST" id="paymentFrm">
                                                <div class="row">

                                                    <div class="col-sm-12 mb-3">
                                                        <label for="" class="fs-20 fw-700">Email</label>
                                                        <div class="form-group">
                                                            <input type="email" name="email" id="email" class="field form-control" placeholder="Enter email" value="<?= $email_id ?>" required="">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-12 mb-3">
                                                        <label for="" class="fs-20 fw-700">Enter Your Card Number</label>
                                                        <div class="form-group">
                                                            <div class="input-group date">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <img height="20" src="<?= base_url() ?>assets/img/master_card.png" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-control" id="card_number" class="field"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-12 mb-3">
                                                        <label for="" class="fs-20 fw-700">Card Holder Name</label>
                                                        <div class="form-group">                
                                                            <input type="text" name="name" id="name" class="field form-control" placeholder="Card Holder Name" required="" autofocus="">
                                                        </div>
                                                    </div>

                                                </div>

                                                
                                                <div class="row  justify-content-between">
                                                    <div class="col-sm-5 mb-3">
                                                        <label for="" class="fs-20 fw-700">Valid Until</label>
                                                        <div class="form-group">
                                                            <div id="card_expiry" class="field form-control text-center"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5 mb-3">
                                                        <label for="" class="fs-20 fw-700">CVV</label>
                                                        <div class="form-group">
                                                            <div id="card_cvc" class="field form-control text-center"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="row mb-3">
                                                    <div class="col-12">
                                                        <div class="section_heading justify-content-between align-items-center">
                                                            <p class="fs-20 fw-500">Save Card Data For Future Payment</p>
                                                            <label class="toggle_switch">
                                                                <input type="checkbox" checked>
                                                                <span class="toggle_switch_slider round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="row">
                                                    <div class="col-12">
                                                        <span id="stripePaymentMsg" style="color: red;"></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-block btn_brand fw-800 fs-20" id="payBtn">Complete Payment</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-12 text-center mt-4">
                                                        <small class="fs-10"><a href="<?= base_url() ?>" class="text-danger lh_1-2 fw-800">Flea Market</a> is required by law to collect applicable transaction taxes
                                                            for purchases made in certain tax jurisdictions. By completing your purchase you agree to these <a href="<?= base_url() ?>" class="text-danger lh_1-2 fw-800">Terms of Service.</a></small>
                                                    </div>
                                                </div>
                                                
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
    <!--================End Details Place Area =================-->

    <?php $this->load->view('front/include/modal'); ?>

    <!--================Footer Area =================-->
    <?php $this->load->view('front/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('front/include/include_script'); ?>

    <!-- Stripe JS library -->
    <script src="https://js.stripe.com/v3/"></script>


</body>

</html>
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
<script>

var large_qty = medium_qty = small_qty = 0;
var paytype = "Paypal";

function payType(ptype){
    paytype = ptype;
}

function book(type){
    
    var table_book = parseInt($('#'+type+'_tables_no').val());

    if(table_book!='' && table_book>0){
    var total_tables_booked = parseInt($('#total_tables_booked_'+type).text());
    var total_tables_booked_all = parseInt($('#total_tables_booked').text());

    var total = total_tables_booked+table_book;
    var total_all = total_tables_booked_all+table_book;

    // $('#total_tables_booked_'+type).text(total);

    // $('#total_tables_booked').text(total_all);

    var rent = parseInt($('#rent_'+type).val());

    var max_table_no = parseInt($('#max_table_no_'+type).text());

    if(type=='large'){
        large_qty = large_qty + table_book;
    }else if(type=='medium'){
        medium_qty = medium_qty + table_book;
    }else if(type=='small'){
        small_qty = small_qty + table_book;
    }

    if($('#is_'+type).val() == 1){
        
        var old = parseInt($('#cart_tables_'+type).text());

        $('#cart_tables_'+type).text(table_book+old);

        var totaldkk = parseInt($('#totaldkk').text());
        
        totaldkk = totaldkk + (rent*table_book);

        $('#totaldkk').text(totaldkk);

    }else{
        var str = type.toUpperCase();
        $('#cartBody').append('<tr><th>'+str+'</th><td><b><span class="text_success" id="cart_tables_'+type+'">'+table_book+'</span></b>  </td>   <td> <b>'+rent+'DKK</b></td></tr>');

        
        var totaldkk = parseInt($('#totaldkk').text());
        
        totaldkk = totaldkk + (rent*table_book);

        $('#totaldkk').text(totaldkk);

        $('#is_'+type).val(1);
    }

    var total_tables_in_cart = parseInt($('#total_tables_in_cart').text());

    total_tables_in_cart = total_tables_in_cart + table_book;
    $('#total_tables_in_cart').text(total_tables_in_cart);

    var maxtotal = parseInt($('#cart_tables_'+type).text()) + total_tables_booked;
    $('#'+type+'_tables_no').val('');
    var max = max_table_no - maxtotal;
    $('#'+type+'_tables_no').attr({"max" : max});
    $('#book_modal_'+type).modal('hide');

    }
}



    function enforceMinMax(el){
    if(el.value != ""){
        if(parseInt(el.value) < parseInt(el.min)){
        el.value = el.min;
        }
        if(parseInt(el.value) > parseInt(el.max)){
        el.value = el.max;
        }
    }
    }


    function favourite(id){

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
                        $('.favorite').removeClass("active");
                    }
                }
            });
        }

    }

    function sharelink(link){

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

    function checkCart(){
        var total_tables_in_cart = parseInt($('#total_tables_in_cart').text());
        if(total_tables_in_cart){

            $('#cart_payment_modal').modal('show');

        }
    }




    $(function () {
		
		$('#paymentFrm').bind('submit', function (e) {
			var $stripeForm = $("#paymentFrm");

			var large_rent_id =$('#large_rent_id').val();
            var medium_rent_id =$('#medium_rent_id').val();
            var small_rent_id =$('#small_rent_id').val();
			$stripeForm.append("<input type='hidden' name='paytype' value='" + paytype + "'/>");
            $stripeForm.append("<input type='hidden' name='large_rent_id' value='" + large_rent_id + "'/>");
            $stripeForm.append("<input type='hidden' name='medium_rent_id' value='" + medium_rent_id + "'/>");
            $stripeForm.append("<input type='hidden' name='small_rent_id' value='" + small_rent_id + "'/>");

            $stripeForm.append("<input type='hidden' name='large_qty' value='" + large_qty + "'/>");
            $stripeForm.append("<input type='hidden' name='medium_qty' value='" + medium_qty + "'/>");
            $stripeForm.append("<input type='hidden' name='small_qty' value='" + small_qty + "'/>");

            $stripeForm.append("<input type='hidden' name='market_id' value='<?= $market->id ?>'/>");

		});



		$('#cardpayment-form').bind('submit', function (e) {
			var $stripeForm = $("#cardpayment-form");
			
			var large_rent_id =$('#large_rent_id').val();
            var medium_rent_id =$('#medium_rent_id').val();
            var small_rent_id =$('#small_rent_id').val();
			$stripeForm.append("<input type='hidden' name='paytype' value='" + paytype + "'/>");
            $stripeForm.append("<input type='hidden' name='large_rent_id' value='" + large_rent_id + "'/>");
            $stripeForm.append("<input type='hidden' name='medium_rent_id' value='" + medium_rent_id + "'/>");
            $stripeForm.append("<input type='hidden' name='small_rent_id' value='" + small_rent_id + "'/>");

            $stripeForm.append("<input type='hidden' name='large_qty' value='" + large_qty + "'/>");
            $stripeForm.append("<input type='hidden' name='medium_qty' value='" + medium_qty + "'/>");
            $stripeForm.append("<input type='hidden' name='small_qty' value='" + small_qty + "'/>");
            
            $stripeForm.append("<input type='hidden' name='market_id' value='<?= $market->id ?>'/>");

           
			// $stripeForm.get(0).submit();
		});
	});


    // Create an instance of the Stripe object
    // Set your publishable API key
    var stripe = Stripe('<?php echo $this->config->item('stripe_publish_key'); ?>');

    // Create an instance of elements
    var elements = stripe.elements();
     
    var style = {
        base: {
            fontWeight: 400,
            fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
            fontSize: '16px',
            lineHeight: '1.4',
            color: '#555',
            backgroundColor: '#fff',
            '::placeholder': {
                color: '#888',
            },
        },
        invalid: {
            color: '#eb1c26',
        }
    };

    var cardElement = elements.create('cardNumber', {
        style: style
    });
    cardElement.mount('#card_number');

    var exp = elements.create('cardExpiry', {
        'style': style
    });
    exp.mount('#card_expiry');

    var cvc = elements.create('cardCvc', {
        'style': style
    });
    cvc.mount('#card_cvc');

    // Validate input of the card elements
    var resultContainer = document.getElementById('stripePaymentMsg');
    cardElement.addEventListener('change', function(event) {
        if (event.error) {
            resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
        } else {
            resultContainer.innerHTML = '';
        }
    });

    // Get payment form element
    var form = document.getElementById('paymentFrm');

    // Create a token when the form is submitted.
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        createToken();
    });

    // Create single-use token to charge the user
    function createToken() {
        stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error
                resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
            } else {
                // Send the token to your server
                stripeTokenHandler(result.token);
            }
        });
    }

    // Callback to handle the response from stripe
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        
        // Submit the form
        form.submit();
    }

</script>
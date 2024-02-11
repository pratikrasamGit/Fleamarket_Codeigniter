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
                    <div class="row">
                        <div class="col-10 mx-auto user_rent_space">
                            
                            <div class="row mb-4 align-items-center justify-content-between">
                                <div class="col-2">
                                    <a href="javascript:void(0)" class="prev m-0 back_renting_history_list_btn">
                                        <img height="15" src="<?= base_url() ?>assets/img/icons/back_btn.png" alt="">
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-renting-history-tab" data-toggle="pill" href="#pills-renting-history" role="tab" aria-controls="pills-renting-history" aria-selected="true"><?php echo $this->lang->line('rent_history');?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-payment-history-tab" data-toggle="pill" href="#pills-payment-history" role="tab" aria-controls="pills-payment-history" aria-selected="false"><?php echo $this->lang->line('etranfer');?></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-2">
                                    <a href="javascript:void(0)" class="prev m-0 renting_history_filter">
                                        <img height="20" src="<?= base_url() ?>assets/img/icons/filter.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-renting-history" role="tabpanel" aria-labelledby="pills-renting-history-tab">
                                            <div class="renting_history_card">
                                                <div class="row">

                                                    <?php 
                                                        foreach ($rentspace as $keys => $values) {
                                                    ?>
                                                        <div class="col-sm-6">
                                                            <a href="javascript:void(0)" onclick="rhlc('<?= $values->fk_market_id ?>')" class="renting_history_list_card renting_history_list">
                                                                <p class="fs-16 text_success"><?= $values->market_name ?></p>
                                                                <!-- <div class="d-flex-wrap justify-content-between">
                                                                    <p class="m-0 lh-1">
                                                                        <label class="fs-12 opacity_half">Set Space rent</label> <span class="fs-12 fw-600">30 DKK</span>
                                                                    </p>
                                                                    <p class="m-0 lh-1">
                                                                        <label class="fs-12 opacity_half">Set Space rent</label> <span class="fs-12 fw-600">30 DKK</span>
                                                                    </p>
                                                                </div>
 -->
                                                                <div class="d-flex-wrap justify-content-between">
                                                                    <p class="m-0 lh-1">
                                                                        <label class="fs-12 opacity_half"><?php echo $this->lang->line('time');?></label> <span class="fs-12 fw-600"><?= $values->start_time ?> <?php echo $this->lang->line('to');?> <?= $values->end_time ?></span>
                                                                    </p>
                                                                </div>

                                                                <div class="d-flex-wrap justify-content-between">
                                                                    <p class="m-0 lh-1">
                                                                        <label class="fs-12 opacity_half"><?php echo $this->lang->line('date');?></label> <span class="fs-12 fw-600"><?= $values->start_date ?> <?php echo $this->lang->line('to');?> <?= $values->end_date ?></span>
                                                                    </p>
                                                                </div>
                                                                
                                                                <div class="d-flex-wrap justify-content-between">
                                                                    <p class="m-0 lh-1">
                                                                        <label class="fs-12"><?php echo $this->lang->line('payment_earned');?></label> <span class="fs-12 fw-600 text_success"> <?= $values->total_earned_amount ?> DKK</span>
                                                                    </p>
                                                                </div>


                                                            </a>
                                                        </div>
                                                    <?php
                                                        }
                                                    ?>
                                                        
                                                </div>
                                            </div>

                                            <?php 
                                                foreach ($rentspace as $keys => $values) {
                                            ?>
                                                <div class="renting_history_list_active_<?= $values->fk_market_id ?>" style="display: none;">
                                                    <div class="row">
                                                        
                                                            <div class="col-sm-12">
                                                                <a href="javascript:void(0)" class="renting_history_list_card_<?= $values->fk_market_id ?>">
                                                                    <p class="fs-16 text_success"><?= $values->market_name ?></p>
                                                                    <div class="d-flex-wrap justify-content-between">
                                                                        <p class="m-0 lh-1">
                                                                            <label class="fs-14 opacity_half pr-2"><?php echo $this->lang->line('set_space_rent');?></label>
                                                                            <?php
                                                                                foreach ($values->tables as $tkeys => $tvalues) {    
                                                                            ?>
                                                                            <span class="fs-14 fw-600 pr-2"><?= substr($tvalues['type'], 0, 1)  ?> <?= $tvalues['details']->table_rent_price  ?>DKK</span>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </p>
                                                                        <p class="m-0 lh-1">
                                                                            <label class="fs-14 opacity_half pr-2"><?php echo $this->lang->line('total_booked');?></label> 
                                                                            <span class="fs-14 fw-600 text_success"><?= $values->total_table_booked_number ?></span>
                                                                            <span class="fs-14 fw-600">/<?= $values->total_table_number ?></span>
                                                                        </p>
                                                                    </div>

                                                                    <div class="d-flex-wrap justify-content-between">
                                                                        <p class="m-0 lh-1">
                                                                            <label class="fs-14 opacity_half pr-2"><?php echo $this->lang->line('date');?></label> <span class="fs-14 fw-600"><?= $values->start_date ?> <?php echo $this->lang->line('to');?> <?= $values->end_date ?></span>
                                                                        </p>
                                                                    </div>
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-auto">
                                                                            <div class="d-flex-wrap justify-content-between">
                                                                                <p class="m-0 lh-1">
                                                                                    <label class="fs-14 fw-600 pr-2"><?php echo $this->lang->line('payment_earned');?></label> <span class="fs-14 fw-600 text_success"> <?= $values->total_earned_amount?> DKK</span>
                                                                                </p>
                                                                            </div>

                                                                            <div class="d-flex-wrap justify-content-between">
                                                                                <p class="m-0 lh-1">
                                                                                    <label class="fs-14 opacity_half pr-2"><?php echo $this->lang->line('time');?></label> <span class="fs-14 fw-600"> <?= $values->start_time ?> <?php echo $this->lang->line('to');?> <?= $values->end_time ?></span>
                                                                                </p>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-sm-6 col-auto">
                                                                            <div class="row">
                                                                                <?php
                                                                                    foreach ($values->tables as $tkeys => $tvalues) {    
                                                                                ?>
                                                                                <div class="col">
                                                                                    <div class="text-left">
                                                                                        <p class="m-0 lh-1">
                                                                                            <label class="fs-14 opacity_half pr-2"><?= $tvalues['type'] ?></label> 
                                                                                        </p>
                                                                                        <p class="m-0 lh-1">
                                                                                            <span class="fs-14 fw-600 text_success"><?= $tvalues['details']->total_booked_table_no ?></span>
                                                                                            <span class="fs-14 fw-600">/<?= $tvalues['details']->table_no ?></span>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                                    }
                                                                                ?>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    


                                                                </a>
                                                            </div>

                                                            <div class="col-sm-11 col-12 mx-auto">
                                                                <div class="row">

                                                                    <?php
                                                                        foreach ($values->buy_list as $bkeys => $bvalues) {    
                                                                    ?>

                                                                    <div class="col-sm-6">
                                                                        <div class="renting_history_list_space_card">
                                                                            <div class="d-flex-wrap align-items-center justify-content-between">
                                                                                <div class="d-flex-wrap align-items-center">
                                                                                    <img class="renting_history_list_space_user_img" width="45" height="45" src="<?= $bvalues['details']['profile_pic'] ?>" alt="">
                                                                                    <span class="fs-14 fw-600"><?= $bvalues['details']['user_name'] ?></span>
                                                                                </div>
                                                                                <div class="renting_history_list_space_badge">
                                                                                    <b class="fs-14"><?= $bvalues['details']['price'] ?>DKK</b> <br>
                                                                                    <span class="fs-12"><?= $bvalues['details']['date'] ?></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mt-2">

                                                                                <?php
                                                                                    foreach ($bvalues['list'] as $blkeys => $blvalues) {    
                                                                                ?>
                                                                                <p class="m-0 lh-1">
                                                                                    <label class="fs-12 fw-600"><?= $blvalues['table_type'] ?></label> <span class="fs-12 fw-600 text_success"><?= $blvalues['table_sequence_no'] ?></span>
                                                                                </p>
                                                                                <?php
                                                                                    }
                                                                                ?>
                                                                                
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <?php
                                                                        }
                                                                    ?>      

                                                                </div>
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>

                                            <input type="hidden" id="back_btn_id">

                                            <div class="col-12 text-center mt-4">
                                                <a href="<?= base_url() ?>users/rent-space/create-table" class="btn btn_brand fw-600 fs-14 px-5 craete_rent_a_space_table_btn"><?php echo $this->lang->line('create_space');?></a>
                                            </div>
                                            
                                        </div>
                                        <div class="tab-pane fade" id="pills-payment-history" role="tabpanel" aria-labelledby="pills-payment-history-tab">
                                            <div class="row">
                                                <div class="col-12 text-center mt-4">
                                                <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist"  style="float:left" >
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="" data-toggle="pill" href="#" role="tab" aria-controls="" aria-selected="true" onclick="showBankTab()"><?php echo $this->lang->line('your_bank_acc');?></a>
                                                    </li>
                                                </ul>
                                                <a id="bank-tab-id" class="btn btn_brand fw-600 fs-14 px-5 nav-link" style="float:right" data-toggle="pill" href="#bank-tab" role="tab" aria-controls="bank-tab" aria-selected="true" onclick="showBankTab()"><?php echo $this->lang->line('add');?></a>
                                                </div>
                                                <div  class="col-12 mt-4 " id="bank-tab" style="display:none">
                                                <form class="box_shd_frm_grp" action="<?=base_url()?>users/rent-space/addbank" method="post" enctype="multipart/form-data">

                                                    <div class="row">
                                                    <div class="col-sm-12 col-auto">
                                                    <div class="form-row justify-content-center align-items-center mt-4">
                                                        <div class="col-sm-6">
                                                            <label class="fs-16 fw-600"><?php echo $this->lang->line('bank_holder');?></label>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control " name="bank_holder_name"  placeholder="<?php echo $this->lang->line('bank_holder');?>" value="<?php if($bank_details){ echo $bank_details->bank_holder_name; } ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="fs-16 fw-600"><?php echo $this->lang->line('bank_name');?></label>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control " name="bank_name"  placeholder="<?php echo $this->lang->line('bank_name');?>" value="<?php if($bank_details){ echo $bank_details->bank_name; } ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="fs-16 fw-600"><?php echo $this->lang->line('acc_num');?></label>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control " name="account_number"  placeholder="<?php echo $this->lang->line('acc_num');?>" value="<?php if($bank_details){ echo $bank_details->account_number; } ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="fs-16 fw-600"><?php echo $this->lang->line('reg_num');?></label>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control " name="registration_number"  placeholder="<?php echo $this->lang->line('reg_num');?>" value="<?php if($bank_details){ echo $bank_details->registration_number; } ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-row justify-content-center align-items-center">
                                    
                                                        <div class="col-sm-3">
                                                            <div class="my-4 text-center">
                                                                <button type="submit" class="btn btn-block btn_brand fs-20 fw-800 px-5"><?php echo $this->lang->line('update');?></button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form>
                                                </div>




                                            </div>
                                                
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-12">
                                                    <table class="table text-center dash_table mt-3">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col"><?php echo $this->lang->line('payment_status');?></th>
                                                                <th scope="col"><?php echo $this->lang->line('transaction');?> ID</th>
                                                                <th scope="col"><?php echo $this->lang->line('payment_method');?></th>
                                                                <th scope="col"><?php echo $this->lang->line('amount');?></th>
                                                                <th scope="col"><?php echo $this->lang->line('date');?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach($bank_transfer_details as $data){ ?>
                                                        <tr>
                                                            <th class="fs-16 fw-700 text_success">Paid <i class="fa fa-check-square-o"></i></th>
                                                            <td class="fs-14"><?=$data->transaction_id?></td>
                                                            <td class="fs-14 fw-700"><?= $data->payment_method?></td>
                                                            <td class="fs-16 fw-700"><?=$data->table_total_price?></td>
                                                            <td class="fs-14"><?=date("d/m/Y", strtotime($data->created_at))?>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    </table>
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

        </div>
    </div>




    <!--================Footer Area =================-->
    <?php $this->load->view('users/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('users/include/include_script'); ?>

</body>

</html>

<script>
    function showBankTab(){
        // $('#bank-tab').show();
        var x = document.getElementById("bank-tab");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

</script>
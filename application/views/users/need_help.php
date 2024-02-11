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
                <div class="col-sm-12 user_bdr_container mx_h_fix">
                    <div class="section_heading justify-content-center">
                        <h4 class="fs-30 fw-800"><?php echo $this->lang->line('need_help');?> ?</h4>
                    </div>
                    <div class="section_heading justify-content-center">
                        <h4 class="fs-30 fw-800"><?php echo $this->lang->line('contact_us_here');?> : info@loppekortet.dk</h4>
                    </div>
<!-- 
                    <div class="row align-items-center justify-content-center">
                        <div class="col-12">
                            <table class="table dash_table mt-3 no_bdr_table">
                                <tbody>
                                    <?php foreach($need_help_message as $message){ ?>
                                    <tr>
                                        <th width="70">
                                            <img src="<?=$profile_pic?>" alt="">
                                        </th>
                                        <td class="fs-14 fw-600">
                                            <div class="d-flex-wrap w-100 justify-content-between">
                                                <p class="fs-30"><?=$message->name; ?></p>
                                                <div>
                                                    <span class="fs-20 fw-600 mr-2"><?php $created_at=date_create($message->created_at);
        echo date_format($created_at,"d M Y");$message->message?></span> , <span class="fs-20 fw-600"><?= date("h:iA", strtotime($message->created_at))?></span>
                                                </div>
                                            </div>
                                            <p class="fs-20 fw-300"><?=$message->message?></p>
                                        </td>
                                    </tr>
                                   <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> -->

                    <form class="search_bar" method="post" enctype="multipart/form-data">

                        <!-- <div class="form-row  write_something">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <select  class="form-control" name="fk_help_type_id" id="fk_help_type_id" required>
                                            <option value=""><?php echo $this->lang->line('select_helptype');?></option>
                                            <?php foreach($need_help_types as $type){   ?>
                                            <option value="<?=$type->id?>"><?php if($this->session->userdata('site_lang') == 'danish'){ echo $type->dnk_name; }else{ echo $type->name; }?></option>
                                            <?php } ?>
                                    </select>
                                    </div>
                                </div>      
                        </div> -->

                        

                        <!-- <div class="form-row write_something">
                            <div class="col-sm-12">

                               
                                <div class="form-group">
                                    <input type="text" name="message" class="form-control" id="" placeholder="<?php echo $this->lang->line('write_something');?>..." required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row write_something">
                                <div class="col-sm-12 image_div_large">
                                    <label class="fs-16 fw-600"><?php echo $this->lang->line('image');?></label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            
                                        <div class="container">
                                            <label for="" class="et_pb_contact_form_label"></label>
                                            <input type="file" id="" name="message_image" class="file-upload">
                                        </div>

                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn_write_something_submit">
                                    <img width="20" src="<?= base_url() ?>assets/img/icons/arrow_up.png" alt="">
                                </button>
                        </div> -->
                        
                    </form>

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
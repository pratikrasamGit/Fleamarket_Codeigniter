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
                <div class="col-sm-9 user_bdr_container">
                    <div class="section_heading justify-content-center">
                        <h4 class="fs-30 fw-800"><?php echo $this->lang->line('personal_details');?></h4>
                    </div>

                    <form id="profile_update_frm" class="box_shd_frm_grp">
                        <div class="form-row justify-content-center align-items-center">
                            <label for="" class="col-sm-4 col-lg-2 col-form-label"><?php echo $this->lang->line('name');?></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="pu_name" name="pu_name" value="<?= $users->first_name ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-row justify-content-center align-items-center">
                            <label for="" class="col-sm-4 col-lg-2 col-form-label"><?php echo $this->lang->line('phone_no');?></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-default">+45</span>
                                        </div>
                                        <input type="text" class="form-control" id="pu_phone" name="pu_phone" aria-label="" value="<?= $users->mobile ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row justify-content-center align-items-center">
                            <label for="" class="col-sm-4 col-lg-2 col-form-label"><?php echo $this->lang->line('birthday');?></label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control  text-center" id="pu_dob_day" name="pu_dob_day" value="<?= $users->birth_date[2] ?>">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control  text-center" id="pu_dob_month" name="pu_dob_month" value="<?= $users->birth_date[1] ?>">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control  text-center" id="pu_dob_year" name="pu_dob_year" value="<?= $users->birth_date[0] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row justify-content-center align-items-center">
                            <label for="" class="col-sm-4 col-lg-2 col-form-label"><?php echo $this->lang->line('gender');?></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control text-center" id="pu_dob_gender" name="pu_dob_gender" value="<?= $users->gender ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-row justify-content-center align-items-center">
                            <label for="" class="col-sm-4 col-lg-2 col-form-label"><?php echo $this->lang->line('location');?></label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control text-center" id="pu_dob_location" name="pu_dob_location" value="<?= $users->location ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-row justify-content-center align-items-center">
                            <div id="message"></div>
                        </div>
                        <div class="form-row justify-content-center align-items-center">
                            <div class="col-sm-12">
                                <div class="my-4 text-center">
                                    <button type="submit" id="pu_btn" class="btn btn_brand fs-20 fw-800 px-5"><?php echo $this->lang->line('update');?></button>
                                </div>
                            </div>
                        </div>

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

    <script type="text/javascript">
        $("#profile_update_frm").submit(function(e) {
            e.preventDefault();
        }).validate({
            rules: {
                pu_name: {
                    required: true
                },
                pu_phone: {
                    required: true,
                    number: true
                },
                pu_dob_day: {
                   required: true,
                   number: true 
                },
                pu_dob_month: {
                   required: true,
                   number: true 
                },
                pu_dob_year: {
                   required: true,
                    number: true 
                },
                pu_dob_gender: {
                   required: true
                },
                pu_dob_location: {
                   required: true
                }
            },
            messages: {
                pu_name: {
                    required: "Please enter name"
                },
                pu_phone: {
                    required: "Please enter phone",
                    number: "Please enter valid phone"
                },
                pu_dob_day: {
                   required: "Please enter dob day",
                   number: "Please enter valid dob day" 
                },
                pu_dob_month: {
                   required: "Please enter dob month",
                   number: "Please enter valid dob month" 
                },
                pu_dob_year: {
                   required: "Please enter dob year",
                    number: "Please enter valid dob year" 
                },
                pu_dob_gender: {
                   required: "Please select gender"
                },
                pu_dob_location: {
                   required: "Please enter location"
                }
            },
            submitHandler: function(form) {
                $('#pu_btn').prop('disabled',true);            
                $("#pu_btn").html("Please wait ...");
                $("#message").html('');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url()?>users/profile_update",
                    data:  $(form).serialize(),
                    success: function(response) {
                        $("#pu_btn").html("Update");
                        $("#pu_btn").prop('disabled', false);
                        response = JSON.parse(response);
                        if(response.response)
                        {
                            $("#message").html('<span class="text-success font-weight-bold">'+response.msg+'</span>').delay(3000).fadeOut();                   
                        }
                        else{
                            $("#message").html('<span class="text-danger font-weight-bold">'+response.msg+'</span>').delay(3000).fadeOut();
                        }
                    }
                });
                return false; 
            }
        });
    </script>


</body>

</html>
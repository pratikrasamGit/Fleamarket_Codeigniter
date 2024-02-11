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
    <section class="faqs_page pb-5">
        <div class="container pt-5">
            <div class="section_heading justify-content-center align-items-center pb-3">
                <h5 class="fs-30 fw-700"><?php echo $this->lang->line('reset_password'); ?></h5>
            </div>
            <div class="row">
                <div class="col-4 pb-3">&nbsp;</div>
                <div class="col-4 pb-3">
                    <div class="accordion" id="accordionExample">

                        <div class="faq_card">
                            <form id="reset_password" class="mb-5">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="fw_reset_password" name="fw_reset_password" placeholder="<?php echo $this->lang->line('password'); ?>">
                                </div>
                                <div id="reset_password_message"></div>
                                <div class="form-group">
                                    <input type="hidden" name="token" id="token" value="<?= $token ?>">
                                    <button class=" btn_brand fw-600 fs14 mt-4 btn-block" type="submit" id="reset_password_submit"><?php echo $this->lang->line('reset_submit'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <!--================End Details Place Area =================-->

    <?php $this->load->view('front/include/modal'); ?>

    <!--================Footer Area =================-->
    <?php $this->load->view('front/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('front/include/include_script'); ?>


</body>

</html>
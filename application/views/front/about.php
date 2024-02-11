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

    <!--================ About Area =================-->
    <section class="pb-5 about_bg" id="wo_we_are">
        <div class="container pt-5">
            <div class="section_heading justify-content-center align-items-center pb-3">
                <h5 class="fs-30 fw-700"><?php echo $this->lang->line('about');?></h5>
            </div>
            <div class="row">
                <div class="col-sm-6 pb-3">
                    <h5 class="fs-30 fw-800 text-center"><?php echo $this->lang->line('who_we_are');?></h5>
                </div>
            </div>
            <div class="row">
                <?php if($this->session->userdata('site_lang') == 'danish'){ echo $aboutus->dnk_meta; }else{ echo $aboutus->st_meta; }?>
                
            </div>
        </div>

    </section>


    <!--<section class="pb-5 why_flea_market" id="why_flea_market">
        <div class="container pt-5">
            <div class="section_heading justify-content-center align-items-center pb-3">
                <div>
                    <h5 class="fs-30 fw-700 text-center"><?php echo $this->lang->line('questions');?>?</h5>
                    <h6 class="fs-14 fw-500" style = "line-height: 24px;font-size: 14px;"><?=$questions_data?></h6>
                </div>
            </div>
        </div>
    </section>-->
    <!--================End About Area =================-->


    <!--================ Why flea market Area =================-->
    <section class="pb-5 why_flea_market" id="why_flea_market">
        <div class="container pt-5">
            <div class="section_heading justify-content-center align-items-center pb-3">
                <div>
                    <h5 class="fs-30 fw-700 text-center"><?php echo $this->lang->line('why_flea_market');?></h5>
                    <!-- <h6 class="fs-20 fw-600">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</h6> -->
                    <h6 class="fs-14 fw-500" style = "line-height: 24px;font-size: 14px;"><?=$flea_data?></h6>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-sm-12">
                    <ul class="ml-3">
                        <li>Our vision to be able to gather all recycling on one platform, so it will be as easy as possible to navigate the many fantastic flea markets, recycled stores and vintage shops located around the country.</li>
                        <li>Markets and shops that give used things new life, so these things are not just thrown away, but recycled again and again.</li>
                        <li>With every recycling purchase, we can save nature for new production!</li>
                        <li>The textile industry is a major culprit, especially in poor countries, where unimaginable amounts of toxic substances are flushed directly out in the nature to produce clothing.</li>
                        <li>Therefore, recycled clothes are a huge help to nature, but also to you as a consumer, it takes a long time before the chemicals are out of the clothes.</li>
                        <li>This can provide some thought about clothes for our children, which we would like to take care of, not be exposed to chemicals and other harmful things.</li>
                        <li>We hope that with this platform we can help increase recycling and help the nature!</li>
                    </ul>
                </div>
            </div> -->
        </div>
    </section>
    <!--================End Why flea market Area =================-->




    <!--================ How its Work Area =================-->
    <section class="pb-5 how_it_work" id="how_it_work">
        <div class="container pt-5">
            <div class="section_heading justify-content-center align-items-center pb-3">
                <div>
                    <h5 class="fs-30 fw-700 text-center"><?php echo $this->lang->line('how_it_works');?></h5>
                    <h6 class="fs-14 fw-500" style = "line-height: 24px;font-size: 14px;"><?=$howitworks?></h6>

                    <!-- <h6 class="fs-20 fw-600">Here you can see how to use the different options in the Flea Card.</h6> -->
                    <!-- <h6 class="fs-20 fw-600">The functions in the flea card will be available in the various packages you can subscribe to. </h6> -->
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <img src="<?= base_url() ?>assets/img/how_it_work.png" alt="">
                    <p class="text-center fs-30 fw-700 my-4"><?php echo $this->lang->line('three_step');?></p>
                </div>
            </div>
        </div>
    </section>
    <!--================End How its Work Area =================-->



    <!--================ How its Work Area =================-->
    <section class="pb-5 " id="timeline_step">
        <div class="container pt-5">
            <div class="timeline_step">
                <span>01</span>
                <div class="row justify-content-between">
                    <div class="col-md-5">
                        <p class="fs-20 fw-700 my-4"><?php echo $this->lang->line('search_find');?></p>
                        <div class="timeline_step_card_bg">
                            <p><?php echo $this->lang->line('step1_line1');?></p>
                            <p><?php echo $this->lang->line('step1_line2');?></p>
                            <p><?php echo $this->lang->line('step1_line3');?></p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="text-center">
                            <img src="<?= base_url() ?>assets/img/timeline_step1.png" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline_step">
                <span>02</span>
                <div class="row justify-content-between">
                    <div class="col-md-5">
                        <div class="text-center">
                            <img src="<?= base_url() ?>assets/img/timeline_step2.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <p class="fs-30 fw-700 my-4"><?php echo $this->lang->line('details');?></p>
                        <div class="timeline_step_card_bg">
                            <p><?php echo $this->lang->line('step2_line1');?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline_step">
                <span>03</span>
                <div class="row justify-content-between">
                    <div class="col-md-5">
                        <p class="fs-30 fw-700 my-4"><?php echo $this->lang->line('step3');?></p>
                        <div class="timeline_step_card_bg">
                            <p><?php echo $this->lang->line('step3_line1');?></p>
                            <p><?php echo $this->lang->line('step3_line2');?></p>
                            <p><?php echo $this->lang->line('step3_line3');?></p>
                            <p><?php echo $this->lang->line('step3_line4');?></p>
                            <p><?php echo $this->lang->line('step3_line5');?></p>
                            <!-- <p>The more information you write about your market, the more interested customers you can attract.</p> -->
                            <!-- <p>There are general categories you can choose, so it fits to your market, you also can describe in a text field what you have and other information.</p> -->
                            <!-- <p>Since customers can search in everything you write, as much information as possible will give more interested.</p> -->
                            <!-- <p>It is possible to upload pictures and video, so you can easily show which market you have, so your customers can see how much children's clothes or toys you have for sale.</p> -->
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="text-center">
                            <img src="<?= base_url() ?>assets/img/timeline_step3.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End How its Work Area =================-->

    <?php $this->load->view('front/include/modal'); ?>
    <!--================Footer Area =================-->
    <?php $this->load->view('front/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('front/include/include_script'); ?>


</body>

</html>
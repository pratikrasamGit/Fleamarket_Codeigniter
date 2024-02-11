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
                <h5 class="fs-30 fw-700">FAQ</h5>
            </div>
            <div class="row">
                <div class="col-12 pb-3">
                    <div class="accordion" id="accordionExample">

                    <?php foreach($faq as $value){ 
                       // print_r($value);?>
                        <div class="faq_card">
                            <div class="" id="headingOne">
                                <button class="fs-25 btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><?=$value->title?></button>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="faq_faq_card_body">
                                <p class="fs-20 fw-500"><?=$value->details?></p>
                                    <!-- <p class="fs-20 fw-500">You must choose what you need, if you want to see the markets there are right around you, then you can do it for free and can cycle there and buy some good things.</p> -->
                                    <!-- <p class="fs-20 fw-500">If you have a greater need, would like the opportunity to be able to make favorites and search for e.g., vinyl records throughout the country, then you can expand to either the package to 9DKK or 19DKK per month.</p> -->
                                    <!-- <p class="fs-20 fw-500">And of course, there is no binding!</p> -->
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                        <!-- <div class="faq_card">
                            <div class="" id="headingOne">
                                <button class="fs-25 btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">How do I choose a package when I want to buy?</button>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="faq_faq_card_body">
                                    <p class="fs-20 fw-500">You must choose what you need, if you want to see the markets there are right around you, then you can do it for free and can cycle there and buy some good things.</p>
                                    <p class="fs-20 fw-500">If you have a greater need, would like the opportunity to be able to make favorites and search for e.g., vinyl records throughout the country, then you can expand to either the package to 9DKK or 19DKK per month.</p>
                                    <p class="fs-20 fw-500">And of course, there is no binding!</p>
                                </div>
                            </div>
                        </div>
                        <div class="faq_card">
                            <div class="" id="headingTwo">
                                <button class="fs-25 btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Do I have to buy a package to sell?</button>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="faq_faq_card_body">
                                    <p class="fs-20 fw-500">No, you don’t have to. </p>
                                    <p class="fs-20 fw-500">You can create both your market and your store on the Flea Card for free.</p>
                                    <p class="fs-20 fw-500">The packages you can buy as a seller, allow for a lot of initiatives that give increased attention around you, which gives more customers. There is also a repeat function, pictures, video and much more.</p>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="faq_card">
                            <div class="" id="headingThree">
                                <button class="fs-25 btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Lorem Ipsum is simply dummy text of the printing and type
                                </button>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="faq_faq_card_body">
                                    <p class="fs-20 fw-500">has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release</p>
                                </div>
                            </div>
                        </div> -->
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
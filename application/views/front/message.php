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

        <section class="share_link py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <div class="alert alert-warning" role="alert">
                          <?= $message ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php $this->load->view('front/include/modal'); ?>
    <!--================Footer Area =================-->
    <?php $this->load->view('front/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('front/include/include_script'); ?>


</body>

</html>
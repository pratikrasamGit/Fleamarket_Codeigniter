<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loppekortet</title>

    <?php $this->load->view('front/include/include_styles'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />

</head>

<body>

    <!--================Header Menu Area =================-->
    <?php $this->load->view('front/include/header'); ?>
    <!--================Header Menu Area =================-->

    <!--================ Create Flea Market Area =================-->
    <section class="create_flea_market_page pb-5">
        <div class="container pt-5">
            <div class="section_heading justify-content-center align-items-center">
                <h5 class="fs-25 fw-800">Create Flea Market</h5>
            </div>
        </div>


        <div class="container pt-4">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="bdr_card">
                        <form action="" class="box_shd_frm_grp p-4">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="" class="fs-20 fw-700">Flea Market Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="" placeholder="Flea Sunday Market">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="" class="fs-20 fw-700">Date</label>
                                    <div class="form-inline justify-content-between">

                                        <div class="form-group" style="width: 200px;">
                                            <div class="input-group date" id="date_from" data-target-input="nearest">
                                                <div class="input-group-prepend" data-target="#date_from" data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <img src="<?= base_url() ?>assets/img/icons/calender.png" alt="">
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#date_from" placeholder="Select Date" />
                                            </div>
                                        </div>

                                        <span class="fs-16 fw-600">
                                            To
                                        </span>

                                        <div class="form-group" style="width: 200px;">
                                            <div class="input-group date" id="date_to" data-target-input="nearest">
                                                <div class="input-group-prepend" data-target="#date_to" data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <img src="<?= base_url() ?>assets/img/icons/calender.png" alt="">
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#date_to" placeholder="Select Date" />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6 mb-3">
                                    <label for="" class="fs-20 fw-700">Categories</label>
                                    <div class="form-group">
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Antiques</span>
                                            </label>
                                        </div>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Danish design</span>
                                            </label>
                                        </div>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Collectibles</span>
                                            </label>
                                        </div>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Furniture</span>
                                            </label>
                                        </div>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Lamps</span>
                                            </label>
                                        </div>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Art</span>
                                            </label>
                                        </div>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Fabric & textiles</span>
                                            </label>
                                        </div>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Clothes</span>
                                            </label>
                                        </div>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Toy</span>
                                            </label>
                                        </div>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Electronics</span>
                                            </label>
                                        </div>
                                        <div class="category_buttons">
                                            <label>
                                                <input type="checkbox" value="1"><span>Tool</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6 mb-3">
                                    <label for="" class="fs-20 fw-700">Time</label>
                                    <div class="form-inline justify-content-between">
                                        <div class="form-group" style="width: 200px;">
                                            <div class="input-group date" id="time_from" data-target-input="nearest">
                                                <div class="input-group-prepend" data-target="#time_from" data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <img src="<?= base_url() ?>assets/img/icons/clock.png" alt="">
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#time_from" placeholder="Select Time" />
                                            </div>
                                        </div>

                                        <span class="fs-16 fw-600">
                                            To
                                        </span>

                                        <div class="form-group" style="width: 200px;">
                                            <div class="input-group date" id="time_to" data-target-input="nearest">
                                                <div class="input-group-prepend" data-target="#time_to" data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <img src="<?= base_url() ?>assets/img/icons/clock.png" alt="">
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-input" data-target="#time_to" placeholder="Select Time" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check my-4">
                                                <input class="form-check-input" type="checkbox" value="" id="its_recurring">
                                                <label class="form-check-label fs-20 fw-700" for="its_recurring">
                                                    Its Recurring
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <select id="inputState" class="form-control">
                                                    <option>Select Option</option>
                                                    <option selected>Once a Week on Same Day</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="d-flex-wrap justify-content-between align-items-center">
                                        <h6 class="fs-20 fw-800">Gallery</h6>
                                        <button class="btn btn_brand fw-600 fs-14 mt-4" onclick="$('.file-upload-input').trigger( 'click' )">Upload</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 my-3 uploaded_img">
                                            <img src="<?= base_url() ?>assets/img/dummy_img.png" alt="">
                                        </div>
                                        <div class="col-4 my-3 uploaded_img">
                                            <img src="<?= base_url() ?>assets/img/dummy_img.png" alt="">
                                        </div>
                                        <div class="col-4 my-3 uploaded_img">
                                            <img src="<?= base_url() ?>assets/img/dummy_img.png" alt="">
                                        </div>
                                        <div class="col-4 my-3 uploaded_img">
                                            <img src="<?= base_url() ?>assets/img/dummy_img.png" alt="">
                                        </div>
                                        <div class="col-4 my-3 uploaded_img">
                                            <img src="<?= base_url() ?>assets/img/dummy_img.png" alt="">
                                        </div>
                                        <div class="col-4 my-3 uploaded_img">
                                            <img src="<?= base_url() ?>assets/img/dummy_img.png" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 uploaded_img">
                                    <img src="<?= base_url() ?>assets/img/dummy_img.png" alt="">
                                </div>
                                <div class="col-12 text-center">
                                    <a href="<?= base_url() ?>create-flea-market-step-3" class="btn btn_brand fw-800 fs-20 px-5 mt-4">Next</a>
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

    <script type="text/javascript">
        $(function() {
            $('#date_from').datetimepicker({
                format: 'L'
            });
            $('#date_to').datetimepicker({
                format: 'L'
            });

            $('#time_to').datetimepicker({
                format: 'LT'
            });
            $('#time_from').datetimepicker({
                format: 'LT'
            });
        });
    </script>
</body>

</html>
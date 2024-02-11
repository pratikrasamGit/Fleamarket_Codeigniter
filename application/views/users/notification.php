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
                    <div class="section_heading justify-content-center">
                        <h4 class="fs-30 fw-800"><?php echo $this->lang->line('notifications');?></h4>
                    </div>

                    <div class="row align-items-center justify-content-center">
                        <div class="col-12">
                            <table class="table dash_table mt-3">
                                <tbody>
                                    <?php foreach($notifications as $values){ ?>
                                    <tr>
                                        <th width="70">
                                        <img src="<?=$profile_pic?>" alt="">
                                        </th>
                                        <td class="fs-14 fw-600">
                                            <p class="fs-30 lh_1-2 mb-2"><?=$values->message?></p>
                                            <span class="fs-16 fw-600"><?= date("h:iA", strtotime($values->created_at))?></span><span class="fs-16 fw-600"> <?php $created_at=date_create($values->created_at);
        echo date_format($created_at,"d/m/Y");?></span>
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




    <!--================Footer Area =================-->
    <?php $this->load->view('users/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('users/include/include_script'); ?>


</body>

</html>
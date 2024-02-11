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
                        <h4 class="fs-30 fw-800"><?php echo $this->lang->line('purchase_history');?></h4>
                    </div>
                    <form method="post" >
                    <ul class="nav nav-pills justify-content-between">

                        <li class="nav-item dropdown bx_sd_dropdown">
                            <!-- <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Month</a>
                            <div class="dropdown-menu">
                                
                                <a class="dropdown-item" href="#" name="month"></a>
                              
                            </div> -->
                            <select class="form-control" name="month" onchange="this.form.submit()">
                                <option value=""><?php echo $this->lang->line('month');?></option>
                            <?php foreach($months as $monthd){ ?>
                                <option <?php if($month==$monthd['name']){ echo "selected"; } ?>><?=$monthd['name']?></option>
                               <?php } ?>
                            </select>
                        </li>
                        <li class="nav-item dropdown bx_sd_dropdown">
                            <!-- <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Package Type</a> -->
                            <!-- <div class="dropdown-menu"> -->
                                
                                <select class="form-control" name="fk_type" onchange="this.form.submit()">
                                <!-- <option value="">Package Type</option> -->
                                <option <?php if($fk_type=='Package'){ echo "selected"; }?> ><?php echo $this->lang->line('for_fleamarkets');?></option>
                                <option  <?php if($fk_type=='Plan'){ echo "selected"; }?>><?php echo $this->lang->line('plan');?></option>
                            </select>
                            <!-- </div> -->
                        </li>
                    </ul>
                    </form>
                    <div class="row align-items-center justify-content-center">
                        <div class="col-12">
                            <table class="table text-center dash_table mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col"><?php echo $this->lang->line('payment_status');?></th>
                                        <th scope="col"><?php echo $this->lang->line('transaction');?> ID</th>
                                        <th scope="col"><?php echo $this->lang->line('package');?></th>
                                        <th scope="col"><?php echo $this->lang->line('payment_method');?></th>
                                        <th scope="col"><?php echo $this->lang->line('amount');?></th>
                                        <th scope="col"><?php echo $this->lang->line('date');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($purchaseData as $data){ ?>
                                    <tr>
                                        <th class="fs-16 fw-700 text_success"><?php echo $this->lang->line('paid');?> <i class="fa fa-check-square-o"></i></th>
                                        <td class="fs-14"><?=$data['transaction_id']?></td>
                                        <td class="fs-14"><?= $data['plan_name']?></td>
                                        <td class="fs-14 fw-700"><?= $data['payment_method']?></td>
                                        <td class="fs-16 fw-700"><?=$data['plan_price']?></td>
                                        <td class="fs-14"><?=$data['paid_date']?>
                                            <!-- <span><br> <b>Next Pay</b>05/09/2021</span> -->
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
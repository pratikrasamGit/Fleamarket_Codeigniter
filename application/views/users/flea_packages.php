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
                        <h4 class="fs-30 fw-800"><?php echo $this->lang->line('flea_packages');?></h4>
                    </div>

                    <div class="row align-items-center justify-content-center">
                        <?php
                            foreach ($plan as $keys => $values) {
                                // $description = json_decode($values->plan_description);
                                if($this->session->userdata('site_lang') == 'danish'){
                                    $description = json_decode($values->dnk_description);
                                }else{
                                    $description = json_decode($values->plan_description);
                                }
                                $is_selected = 0;
                                $query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $this->users_id AND fk_plan_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                $details = $this->db->query($query)->row();
                                $is_auto = '0';
                                $expire_date = '';
                                if($details && ($last_plan->id == $details->id) ) {
                                    if($details->is_auto == '1'){
                                        $is_selected = 1;
                                        $expire = strtotime($details->expire_date);
                                        $today = strtotime("today");
                                        if($today >= $expire){
                                            $is_selected = 0;
                                        }
                                    } 

                                    if($details->is_auto == '0'){
                                        $expire = strtotime($details->expire_date);
                                        $today = strtotime("today");
                                        if($today <= $expire){
                                            $is_selected = 1;
                                        }
                                    }
                                    
                                    $is_auto = $details->is_auto;  
                                    $expire_date = $details->expire_date;               
                                }
                        ?>
                            <div class=" col-xl-5 col-sm-6">
                                <div class="package_card current_pkg">
                                    <?php if($is_selected==1){ ?>
                                    <span class="badge fs-9 fw-600"><?php echo $this->lang->line('current_package');?></span>
                                    <?php } ?>
                                    <div class="package_card_body">
                                        <h5 class="fs-20 fw-800 text-center"><?php if($this->session->userdata('site_lang') == 'danish'){ echo $values->dnk_name; }else{ echo $values->plan_name; }?></h5>
                                        <ul style="margin-left: 20px;" class="">
                                            <?php 
                                                foreach ($description as $dkeys => $dvalues) {
                                            ?>
                                                <li class=""><?= $dvalues ?></li>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                        <div class="text-center mt-3">
                                            <!-- <h5 class="fs-20 fw-800 "><?= $values->price ?>DKK- Per Month</h5> -->
                                            <?php
                                                if($values->discount_price > 0){
                                            ?>
                                                <del><h5 class="fs-20 fw-800 "><?= $values->price ?> DKK- <?php echo $this->lang->line('per_month');?></h5></del>
                                                <h5 class="fs-20 fw-800 text_success"><?= $values->discount_price ?> DKK- <?php echo $this->lang->line('per_month');?></h5>
                                            <?php
                                                }else{
                                            ?>
                                                <h5 class="fs-20 fw-800 "><?= $values->price ?> DKK- <?php echo $this->lang->line('per_month');?></h5>
                                            <?php
                                                }
                                            ?>
                                            
                                            <?php if($values->discount_msg){ 
														if($this->session->userdata('site_lang') == 'danish'){ ?>
														<p >(<?=$values->dnk_discount_msg?>)</p>
													<?php }else{ ?>
														<p >(<?=$values->discount_msg?>)</p>
													<?php } } ?>
                                            <?php if($is_selected!=1){ ?>
                                            <button type="button" class="btn" onclick="packagetype('Plan',<?= $values->id ?>,<?= $values->price ?>)"><?php echo $this->lang->line('buy_now');?></button>
                                            <?php } ?>
                                            <!-- <h6 class="fs-16 fw-600">No binding</h6> -->
                                        </div>
                                    </div>
                                </div>
                                <?php if($is_selected==1 && $details->is_auto ==1){ ?>
                                <a href="<?php echo base_url().'user/cancel_package'; ?>" onclick="return confirm('Are you sure?');" class="text-center fs-16 fw-600 d-block py-2"><?php echo $this->lang->line('cancel_now');?></a>
                                <?php } ?>
                            </div>
                        <?php
                            }
                        ?>
                        <!-- <div class=" col-xl-5 col-sm-6">
                            <div class="package_card">
                                <div class="package_card_body">
                                    <h5 class="fs-20 fw-800 text-center">Gold</h5>
                                    <ol>
                                        <li>Search market</li>
                                        <li>See whole Denmark</li>
                                        <li>See pictures + videos</li>
                                        <li>Favorite</li>
                                        <li>Specific search option</li>
                                    </ol>
                                    <div class="text-center mt-3">
                                        <h5 class="fs-20 fw-800 ">9DKK- Per Month</h5>
                                        <button class="btn">Pay Now</button>
                                        <h6 class="fs-16 fw-600">No binding</h6>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="package_detail_modal" tabindex="-1" role="dialog" aria-labelledby="package_detail_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <button type="button" class="modal_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <div class="text-center">
                        <h5 class="fs-40 fw-600">Payment Detail</h5>
                        <p class="fs-16 fw-500">Choose Your Payment Method</p>
                    </div>
                    <div class="row mb-4 justify-content-center payment_detail_tab">
                        <div class="col-auto">
                            <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-for-flea-tab" data-toggle="pill" href="#cartab" role="tab" aria-controls="pills-for-flea" aria-selected="true" onclick="payType('Paypal')">
                                        <img height="50" src="<?= base_url() ?>assets/img/credit_card.png" alt="">
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" id="pills-for-flea-markets-tab" data-toggle="pill" href="#mobilepaytab" role="tab" aria-controls="pills-for-flea-markets" aria-selected="false" onclick="payType('Mobile Pay')">
                                        <img height="50" src="<?= base_url() ?>assets/img/mobile_Pay.png" alt="">
                                    </a>
                                </li> -->
                            </ul>
                            <div class="row">
                                <div class="col-12">
                                    <!-- <a class="btn btn-block btn_brand fw-800 fs-20">Complete Payment</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="tab-content" >
                                <div class="tab-pane fade show active" id="cartab" role="tabpanel" aria-labelledby="pills-for-flea-tab">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <!-- Display errors returned by createToken -->
                                            <div class="card-errors"></div>
                                            
                                            <!-- Payment form -->
                                            <form class="box_shd_frm_grp p-4" action="<?= base_url() ?>payment" method="POST" id="paymentFrm">
                                                <div class="row">

                                                    <div class="col-sm-12 mb-3">
                                                        <label for="" class="fs-20 fw-700">Email</label>
                                                        <div class="form-group">
                                                            <input type="text" name="email" id="email" class="field form-control" placeholder="Enter email" value="<?= $email_id ?>" required="">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12 mb-3">
                                                        <label for="" class="fs-20 fw-700">Enter Your Card Number</label>
                                                        <div class="form-group">
                                                            <div class="input-group date">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <img height="20" src="<?= base_url() ?>assets/img/master_card.png" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="form-control" id="card_number" class="field"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12 mb-3">
                                                        <label for="" class="fs-20 fw-700">Card Holder Name</label>
                                                        <div class="form-group">                
                                                            <input type="text" name="name" id="name" class="field form-control" placeholder="Card Holder Name" required="" autofocus="">
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </div>

                                                
                                                <div class="row  justify-content-between">
                                                    <div class="col-sm-5 mb-3">
                                                        <label for="" class="fs-20 fw-700">Valid Until</label>
                                                        <div class="form-group">
                                                            <div id="card_expiry" class="field form-control text-center"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5 mb-3">
                                                        <label for="" class="fs-20 fw-700">CVV</label>
                                                        <div class="form-group">
                                                            <div id="card_cvc" class="field form-control text-center"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="row mb-3">
                                                    <div class="col-12">
                                                        <div class="section_heading justify-content-between align-items-center">
                                                            <p class="fs-20 fw-500">Save Card Data For Future Payment</p>
                                                            <label class="toggle_switch">
                                                                <input type="checkbox" checked>
                                                                <span class="toggle_switch_slider round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="row">
                                                    <div class="col-12">
                                                        <span id="stripePaymentMsg" style="color: red;"></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-block btn_brand fw-800 fs-20" id="payBtn">Complete Payment</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-12 text-center mt-4">
                                                        <small class="fs-10"><a href="<?= base_url() ?>" class="text-danger lh_1-2 fw-800">Flea Market</a> is required by law to collect applicable transaction taxes
                                                            for purchases made in certain tax jurisdictions. By completing your purchase you agree to these <a href="<?= base_url() ?>" class="text-danger lh_1-2 fw-800">Terms of Service.</a></small>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="purchased_type" id="purchased_type" >
                                                <input type="hidden" name="purchased_id" id="purchased_id" >

                                                
                                            </form>
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

    <!-- Stripe JS library -->
    <script src="https://js.stripe.com/v3/"></script>


</body>

</html>

<script>

    var plan_type ='Plan';
	var pid='';
	var pprice=0;
	var paytype='Paypal';
    function packagetype(type,id,price){
         plan_type = type;
         pid = id;
         pprice = price;
         $("#purchased_type").val(type);
         $("#purchased_id").val(id);
         $("#package_detail_modal").modal('show');
    }


    function payType(ptype){
		paytype = ptype;
	}
    
	$(function () {
		
		$('#mobilepayment-form').bind('submit', function (e) {
			var $stripeForm = $("#mobilepayment-form");
			
			$stripeForm.append("<input type='hidden' name='package_id' value='" + pid + "'/>");
			$stripeForm.append("<input type='hidden' name='paytype' value='" + paytype + "'/>");
			
			// $stripeForm.get(0).submit();
		});



		$('#cardpayment-form').bind('submit', function (e) {
			var $stripeForm = $("#cardpayment-form");
			
			$stripeForm.append("<input type='hidden' name='package_id' value='" + pid + "'/>");
			$stripeForm.append("<input type='hidden' name='paytype' value='" + paytype + "'/>");
			
			// $stripeForm.get(0).submit();
		});
	});

    // Create an instance of the Stripe object
    // Set your publishable API key
    var stripe = Stripe('<?php echo $this->config->item('stripe_publish_key'); ?>');

    // Create an instance of elements
    var elements = stripe.elements();
     
    var style = {
        base: {
            fontWeight: 400,
            fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
            fontSize: '16px',
            lineHeight: '1.4',
            color: '#555',
            backgroundColor: '#fff',
            '::placeholder': {
                color: '#888',
            },
        },
        invalid: {
            color: '#eb1c26',
        }
    };

    var cardElement = elements.create('cardNumber', {
        style: style
    });
    cardElement.mount('#card_number');

    var exp = elements.create('cardExpiry', {
        'style': style
    });
    exp.mount('#card_expiry');

    var cvc = elements.create('cardCvc', {
        'style': style
    });
    cvc.mount('#card_cvc');

    // Validate input of the card elements
    var resultContainer = document.getElementById('stripePaymentMsg');
    cardElement.addEventListener('change', function(event) {
        if (event.error) {
            resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
        } else {
            resultContainer.innerHTML = '';
        }
    });

    // Get payment form element
    var form = document.getElementById('paymentFrm');

    // Create a token when the form is submitted.
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        createToken();
    });

    // Create single-use token to charge the user
    function createToken() {
        stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error
                resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
            } else {
                // Send the token to your server
                stripeTokenHandler(result.token);
            }
        });
    }

    // Callback to handle the response from stripe
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        
        // Submit the form
        form.submit();
    }

</script>
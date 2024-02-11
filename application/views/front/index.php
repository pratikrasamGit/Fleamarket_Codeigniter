<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Loppekortet</title>

	<?php $this->load->view('front/include/include_styles'); ?>
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/rangeslider.css">

	<script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="7b9023df-0d32-4e87-8a5d-bea0531498e3" data-blockingmode="auto" type="text/javascript"></script>
</head>

<body class="">

	<!--================Header Menu Area =================-->
	<?php $this->load->view('front/include/header'); ?>
	<!--================Header Menu Area =================-->

	<!--================Home Banner Area =================-->
	<div class="home_banner_area">
		<div class="container-big banner_inner">
			<div class="row align-items-center">
				<div class="col-lg-5">
					<img src="<?= base_url() ?>assets/img/banner_img.png" alt="">
				</div>
				<div class="col-lg-7">
					<h2 class="fs-60 fw-700 text-center"><?php echo $this->lang->line('discover_around'); ?></h2>
					<div class="banner_inner_search ">
						<?php $this->load->view('front/include/search_bar'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--================End Home Banner Area =================-->

	<!--================Home About Area =================-->
	<section class="section_pd ">
		<div class="container about_home">
			<div class="row">
				<div class="col-md-6">
					<div class="img_over_card">
						<!-- <img src="<?= base_url() ?>assets/img/about1.png" alt=""> -->
						<!-- <img src="<?= base_url() ?>assets/img/about2.png" alt=""> -->
					<img src="<?= base_url() ?>assets/img/banner_img.png" alt="">
						<!-- <img src="<?= base_url() ?>assets/" alt=""> -->
					</div>
				</div>
				<div class="col-md-6 my-3">
					<h6 class="fs-16 fw-500 text_success"><?php echo $this->lang->line('about'); ?></h6>
					<h3 class="fs-36 fw-600"><?php echo $this->lang->line('about_line1'); ?></h3>
					<p class="fs-14 fw-400"><?php echo $this->lang->line('about_line2'); ?></p>
					<p class="fs-14 fw-400"><?php echo $this->lang->line('about_line3'); ?>.</p>
					<p class="fs-14 fw-400"><?php echo $this->lang->line('about_line4'); ?>.</p>
					<p class="fs-14 fw-400"><?php echo $this->lang->line('about_line5'); ?>.</p>
					<p class="fs-14 fw-400"><?php echo $this->lang->line('about_line6'); ?>.</p>
					<p class="fs-14 fw-400"><?php echo $this->lang->line('about_line7'); ?>.</p>
					<a class="btn btn_brand fw-600 fs-14 mt-4" href="<?= base_url() ?>about"><?php echo $this->lang->line('read_more'); ?></a>
				</div>
			</div>
		</div>
	</section>
	<!--================End Home About Area =================-->

	<!--================Home Explore Nearby Area ============-->
	<section class="section_pd bg_light">
		<div class="container">
			<div class="section_heading mb-4 justify-content-start align-items-center">
				<h5 class="fs-30 fw-700"><?php echo $this->lang->line('explore_nearby');?></h5>
			</div>
			<div class="row">
				<?php
					foreach ($discover['explore_nearby'] as $enkeys => $envalues) {
				?>
					<div class="col-xl-3 col-md-6">
						<div class="explore_nearby_card img_bg_card" style="background-image: url(<?= $envalues['image'] ?>); cursor: pointer;" onclick="findNearby('<?= $envalues['city'] ?>')">
							<div class="img_bg_card_content">
								<p class="fs-14 fw-600 m-0"><?= $envalues['city'] ?></p>
							</div>
						</div>
					</div>
				<?php
					}
				?>
			</div>
		</div>
	</section>
	<!--================End Home Explore Nearby Area ========-->

	<!--==============Home Feature Market Area ==============-->
	<section class="section_pd feature_market_home">
		<div class="container">
			<div class="section_heading mb-4 justify-content-between align-items-center">
				<h5 class="fs-30 fw-700"><?php echo $this->lang->line('feature_market');?></h5>
				<!-- <a href="btn btn-link">View All</a> -->
			</div>

			<div class="row">
				<?php
					foreach ($discover['market'] as $mkeys => $mvalues) {
						$is_fav_market=0;
						if($this->is_login){
							$chk_data_fav = $this->db->get_where("rudra_user_fav_markets",array('fk_user_id' => $this->users_id, 'fk_market_id' => $mvalues->id, 'status'=>1,'is_deleted'=>0))->row();
							if(!empty($chk_data_fav)){
								$is_fav_market=1;
							}
						}
				?>
					<div class="col-xl-3 col-md-6">
						<div class="feature_market_card">
							<a href="<?= base_url() ?>market/<?= $mvalues->id ?>">
								<div class="img_bg_card mt-0"  onclick='window.location.href="<?= base_url() ?>market/<?= $mvalues->id ?>"' <?php if(!empty($mvalues->images)){ ?>style="background-image: url(<?= $mvalues->images[0]->fullurl ?>);" <?php } ?>>
									<div class="img_bg_card_content">
										<div class="d-flex-wrap justify-content-between align-items-center mb-2">
											<p class="fs-18 fw-600 m-0"><?= substr_replace( $mvalues->market_name, "", 12); ?> <?php if(strlen($mvalues->market_name) > 12){ ?> ... <?php } ?></p>
											<div class="d-flex align-items-center">
												<span class="ml-3">
													<a class="favorite favorite<?=$mvalues->id?> <?php if($is_fav_market==1){ echo "active"; } ?>" href="javascript:void(0)" onclick="favourite(<?= $mvalues->id ?>)">
														<img width="15" src="<?= base_url() ?>assets/img/icons/heart.png" alt="">
													</a>
												</span>
												<span class="ml-3">
													<a href="javascript:void(0)" onclick="sharelink(`<?= base_url() ?>share-link/<?= $mvalues->id ?>`)">
														<img width="15" src="<?= base_url() ?>assets/img/icons/share.png" alt="">
													</a>
												</span>
											</div>
										</div>

										<p class="fs-12 fw-500 m-0"><img width="10" src="<?= base_url() ?>assets/img/icons/location.png" alt=""> <?= $mvalues->address ?>, <?= $mvalues->city ?></p>
										<div class="d-flex-wrap justify-content-between align-items-center">
											<p class="fs-12 fw-500 m-0">
												<span>
													<img width="10" src="<?= base_url() ?>assets/img/icons/clock.png" alt="">
												</span>
												<?php $date=date_create($mvalues->start_time);echo date_format($date,"H:i"); ?> - <?php $date2=date_create($mvalues->end_time);echo date_format($date2,"H:i"); ?>
											</p>
											<p class="fs-12 fw-500 m-0">
												<span>
													<img width="10" src="<?= base_url() ?>assets/img/icons/calender.png" alt="">
												</span><?= $mvalues->start_date ?> - <?= $mvalues->end_date ?>
											</p>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>   
				<?php
					}
				?>                
			</div>
		</div>
	</section>
	<!--============End Home Feature Market Area ============-->

	<!--============Home Create Flea Mmarket Area ===========-->
	<section class="section_pd bg_light">
		<!-- create_flea_market_bg -->
		<div class="container home_create_flea_market">
			<div class="row align-items-center">
				<div class="col-xl-7">
					<img class="create_flea_market_img" src="<?= base_url() ?>assets/img/create_flea_market_bg.png" alt="">
				</div>
				<div class="col-xl-5">
					<div class="create_flea_market_content">
						<h6 class="fs-16 fw-500 text-white"><?php echo $this->lang->line('create_market');?></h6>
						<h4 class="fs-34 fw-700 text-white"><?php echo $this->lang->line('create_market_line1');?></h4>
						<p class="fs-16 fw-500 text-white opacity_half my-4"><?php echo $this->lang->line('create_market_line2');?></p>
						<p class="fs-16 fw-500 text-white opacity_half my-4"><?php echo $this->lang->line('create_market_line3');?></p>
						<a class="btn btn_brand" href="<?= base_url() ?>create-flea-market"><?php echo $this->lang->line('create_market_btn');?></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--============End Home Create Flea Mmarket Area ========-->




	<!--================Home Packages Area =================-->
	<section class="section_pd home_packages" id="home_packages">
		<!-- create_flea_market_bg -->
		<div class="container">
			<div class="section_heading mb-4 justify-content-center align-items-center">
				<h5 class="fs-30 fw-700"><?php echo $this->lang->line('packages');?></h5>
			</div>
			<div class="row mb-4 justify-content-center">
				<div class="col-auto">
					<ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="pills-for-flea-tab" data-toggle="pill" href="#pills-for-flea" role="tab" aria-controls="pills-for-flea" aria-selected="true" onclick="checkType('Plan')"><?php echo $this->lang->line('for_flea');?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-for-flea-markets-tab" data-toggle="pill" href="#pills-for-flea-markets" role="tab" aria-controls="pills-for-flea-markets" aria-selected="false" onclick="checkType('Package')"><?php echo $this->lang->line('for_fleamarkets');?></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-12">
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-for-flea" role="tabpanel" aria-labelledby="pills-for-flea-tab">
							<div class="row align-items-end justify-content-center">
								<?php
		                            foreach ($plan as $keys => $values) {
										if($this->session->userdata('site_lang') == 'danish'){
											$description = json_decode($values->dnk_description);
										}else{
		                                	$description = json_decode($values->plan_description);
										}										$is_selected = 0;
										if($is_login){
											$last_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $this->users_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        									$last_plan = $this->db->query($last_query)->row();

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
											            
											}
										}	
		                        ?>
									<div class=" col-xl-3 col-sm-6">
										<div class="package_card current_pkg">
										<?php if($is_selected==1){ ?>
											<span class="badge fs-9 fw-600"><?php echo $this->lang->line('current_package');?></span>
										<?php } ?>
											<div class="package_card_body">
												<h5 class="fs-20 fw-800 text-center"><?php if($this->session->userdata('site_lang') == 'danish'){ echo $values->dnk_name; }else{ echo $values->plan_name; } ?></h5>
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
													<?php
								                        if($is_login)
								                        { if($is_selected!=1){ 
								                    ?>
														<button class="btn" onclick="packagetype('Plan',<?= $values->id ?>,<?= $values->price ?>)"><?php echo $this->lang->line('buy_now');?></button>
													<?php
														} }
														else
														{
													?>
														<button class="btn" data-toggle="modal" data-target="#sign_in_modal" ><?php echo $this->lang->line('buy_now');?></button>
													
													<?php
														}
													?>
													<!-- <h6 class="fs-16 fw-600">No binding</h6> -->
												</div>
											</div>
										</div>
									</div>
								<?php
		                            }
		                        ?>
							</div>
						</div>
						<div class="tab-pane fade" id="pills-for-flea-markets" role="tabpanel" aria-labelledby="pills-for-flea-markets-tab">
							<div class="row align-items-end justify-content-center">
								<?php
		                            foreach ($package as $keys => $values) {
										if($this->session->userdata('site_lang') == 'danish'){
											$description = json_decode($values->dnk_description);
										}else{
		                                	$description = json_decode($values->package_description);
										}
										$is_selected = 0;
										if($is_login){

											$last_query = "SELECT * FROM rudra_purchased_package where fk_user_id = $this->users_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        									$last_package = $this->db->query($last_query)->row();
											
											$query = "SELECT * FROM rudra_purchased_package where fk_user_id = $this->users_id AND fk_package_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
											$details = $this->db->query($query)->row();
											$is_auto = '0';
											$expire_date = '';
											if($details  && ($last_package->id == $details->id) ) {
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
												
											}

										}
		                        ?>
									<div class=" col-xl-3 col-sm-6">
										<div class="package_card current_pkg">
										<?php if($is_selected==1){ ?>
											<span class="badge fs-9 fw-600"><?php echo $this->lang->line('current_package');?></span>
										<?php } ?>
											<div class="package_card_body">
												<h5 class="fs-20 fw-800 text-center"><?php if($this->session->userdata('site_lang') == 'danish'){ echo $values->dnk_name; }else{ echo $values->package_name; } ?></h5>
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
													<?php
								                        if($is_login)
								                        { if($is_selected!=1){ 
								                    ?>
														<button class="btn" data-toggle="modal" data-target="#package_detail_modal"  onclick="packagetype('Package',<?= $values->id ?>,<?= $values->price ?>)"><?php echo $this->lang->line('buy_now');?></button>
													<?php
														} }
														else
														{
													?>
														<button class="btn" data-toggle="modal" data-target="#sign_in_modal" ><?php echo $this->lang->line('buy_now');?></button>
													
													<?php
														}
													?>
													<!-- <h6 class="fs-16 fw-600">No binding</h6> -->
												</div>
											</div>
										</div>
									</div>
								<?php
		                            }
		                        ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Home Packages Area =================-->


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
															<input type="email" name="email" id="email" class="field form-control" placeholder="Enter email" value="<?= $email_id ?>" required="">
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




	<?php $this->load->view('front/include/modal'); ?>

	<!--================Footer Area =================-->
	<?php $this->load->view('front/include/footer'); ?>
	<!--================End Footer Area =================-->

	<!-- Optional JavaScript -->
	<?php $this->load->view('front/include/include_script'); ?>

	<?php $this->load->view('front/include/filter'); ?>
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

	function checkType(type){
		plan_type = type;
	}

	function favourite(id){
		event.preventDefault();
            event.stopPropagation();
		var is_login=0;
		<?php if($is_login){ ?>
			is_login=1;
		<?php } ?>

		if(is_login==0){
			$('#sign_in_modal').modal('show');
		}else{

			$.ajax({
				url:'<?php echo base_url('submit_favorite') ?>',
				method: 'post',
				data: {id: id},
				dataType: 'text',
				success: function(response){
				console.log(response);
				if(response=='failed'){
                            alert('Something went wrong..');
                            $('.favorite'+id).removeClass("active");
                        }

                        if(response == 'upgrade'){
                            alert('<?php echo $this->lang->line('upgrade_your_package');?>');
                            $('.favorite'+id).removeClass("active");
                        }


                        if(response=='successfully removed'){
                            $('.favorite'+id).removeClass("active");
                        }
				}
			});
		}

	} 


	function sharelink(link){
		event.preventDefault();
            event.stopPropagation();
		var is_login=0;
		<?php if($is_login){ ?>
			is_login=1;
		<?php } ?>

		if(is_login==0){
			$('#sign_in_modal').modal('show');
		}else{

			window.open(link, '_blank');

		}

	}




	$(function () {
		
		$('#mobilepayment-form').bind('submit', function (e) {
			var $stripeForm = $("#mobilepayment-form");
			
			$stripeForm.append("<input type='hidden' name='package_id' value='" + pid + "'/>");
			$stripeForm.append("<input type='hidden' name='plan_type' value='" + plan_type + "'/>");
			$stripeForm.append("<input type='hidden' name='paytype' value='" + paytype + "'/>");
			
			// $stripeForm.get(0).submit();
		});



		$('#cardpayment-form').bind('submit', function (e) {
			var $stripeForm = $("#cardpayment-form");
			
			$stripeForm.append("<input type='hidden' name='package_id' value='" + pid + "'/>");
			$stripeForm.append("<input type='hidden' name='plan_type' value='" + plan_type + "'/>");
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

	$(function() {

		var $document = $(document),
			selector = '[data-rangeslider]',
			$element = $(selector);

		// Example functionality to demonstrate a value feedback
		function valueOutput(element) {
			var value = element.value,
				output = element.parentNode.getElementsByTagName('output')[0];
			output.innerHTML = value;
		}
		for (var i = $element.length - 1; i >= 0; i--) {
			valueOutput($element[i]);
		};
		$document.on('change', 'input[type="range"]', function(e) {
			valueOutput(e.target);
		});

		// Example functionality to demonstrate disabled functionality
		$document.on('click', '#js-example-disabled button[data-behaviour="toggle"]', function(e) {
			var $inputRange = $('input[type="range"]', e.target.parentNode);

			if ($inputRange[0].disabled) {
				$inputRange.prop("disabled", false);
			} else {
				$inputRange.prop("disabled", true);
			}
			$inputRange.rangeslider('update');
		});

		// Example functionality to demonstrate programmatic value changes
		$document.on('click', '#js-example-change-value button', function(e) {
			var $inputRange = $('input[type="range"]', e.target.parentNode),
				value = $('input[type="number"]', e.target.parentNode)[0].value;

			$inputRange.val(value).change();
		});

		// Example functionality to demonstrate destroy functionality
		$document
			.on('click', '#js-example-destroy button[data-behaviour="destroy"]', function(e) {
				$('input[type="range"]', e.target.parentNode).rangeslider('destroy');
			})
			.on('click', '#js-example-destroy button[data-behaviour="initialize"]', function(e) {
				$('input[type="range"]', e.target.parentNode).rangeslider({
					polyfill: false
				});
			});

		// Example functionality to test initialisation on hidden elements
		$document
			.on('click', '#js-example-hidden button[data-behaviour="toggle"]', function(e) {
				var $container = $(e.target.previousElementSibling);
				$container.toggle();
			});

		// Basic rangeslider initialization
		$element.rangeslider({

			// Deactivate the feature detection
			polyfill: false,

			// Callback function
			onInit: function() {},

			// Callback function
			onSlide: function(position, value) {
				console.log('onSlide');
				console.log('position: ' + position, 'value: ' + value);
			},

			// Callback function
			onSlideEnd: function(position, value) {
				console.log('onSlideEnd');
				console.log('position: ' + position, 'value: ' + value);
			}
		});

	});

	function findNearby(city) {
		var form = $(document.createElement('form'));
		$(form).attr("action", "<?= base_url() ?>explore");
		$(form).attr("method", "POST");

		var input = $("<input>")
		    .attr("type", "hidden")
		    .attr("name", "searchText")
		    .val(city);


		$(form).append($(input));

		form.appendTo( document.body )

		$(form).submit();
	}
</script>
<script id="CookieDeclaration" src="https://consent.cookiebot.com/7b9023df-0d32-4e87-8a5d-bea0531498e3/cd.js" type="text/javascript" async></script>
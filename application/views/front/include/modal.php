<?php
    $mainMenu = $this->uri->segment(1);
?>

<?php
    if($mainMenu == 'create-flea-market' || $mainMenu == 'market')
    {

?>

    <!-- Modal -->
    <div class="modal fade" id="sign_in_modal" tabindex="-1" role="dialog" aria-labelledby="sign_in_modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content login_signup_content">
            <div class="modal-header">
            </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h5 class="fs-40 fw-600"><?php echo $this->lang->line('welcome_to_market'); ?>!</h5>
                        <p class="fs-16 fw-500"><?php echo $this->lang->line('sign_n_find'); ?></p>
                    </div>
                    <div class="d-flex-wrap justify-content-center mt-4">
                        <!-- <button class="apple_btn">
                            <img src="<?= base_url() ?>assets/img/icons/apple.png" alt="">
                        </button> -->
                        <button class="fb_btn">
                            <a href="javascript:void(0);" onclick="fbLogin();" ><img src="<?= base_url() ?>assets/img/icons/blue_fb.png" alt=""></a>
                        </button>
                        <button class="google_btn">
                            <a href="<?php echo $loginURL; ?>"><img src="<?= base_url() ?>assets/img/icons/google.png" alt=""></a>
                        </button>
                    </div>
                    <div class="divider text-center">
                        <span><?php echo $this->lang->line('or'); ?></span>
                    </div>
                    <form id="login" class="mb-5">
                        <div class="form-group">
                            <input type="email" class="form-control" id="fw_lg_email" name="fw_lg_email" placeholder="<?php echo $this->lang->line('enter_email'); ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="fw_lg_password" name="fw_lg_password" placeholder="<?php echo $this->lang->line('password'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text view_password">
                                    <img src="<?= base_url() ?>assets/img/icons/eye.png" alt="">
                                </span>
                            </div>
                        </div>
                        <div id="login_message"></div>
                        <div class="form-group">
                            <button class="btn btn_brand fw-600 fs14 mt-4 btn-block" type="submit" id="login_submit"><?php echo $this->lang->line('sign_in1'); ?></button>
                        </div>
                    </form>
                    <div class="text-center fs-16 py-4"><?php echo $this->lang->line('new_to_flea'); ?> <a href="javascript:void(0)" class="fw-600 btn btn_brand" data-toggle="modal" data-target="#sign_up_modal" data-dismiss="modal"><?php echo $this->lang->line('sign_up_here'); ?></a></div>
                    <div class="text-center fs-16">
                    <?php echo $this->lang->line('by_cont_agree'); ?> <a target="_blank" href="<?= base_url() ?>terms-and-conditions" class="fw-600"><?php echo $this->lang->line('terms_of'); ?> <br> <?php echo $this->lang->line('condition'); ?></a>  <a target="_blank" href="<?= base_url() ?>priacy-policy" class="fw-600"><?php echo $this->lang->line('and_privacy'); ?> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    }
    else{
?>

    <!-- Modal -->
    <div class="modal fade" id="sign_in_modal" tabindex="-1" role="dialog" aria-labelledby="sign_in_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content login_signup_content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h5 class="fs-40 fw-600"><?php echo $this->lang->line('welcome_to_market'); ?>!</h5>
                        <p class="fs-16 fw-500"><?php echo $this->lang->line('sign_n_find'); ?></p>
                    </div>
                    <div class="d-flex-wrap justify-content-center mt-4">
                        <!-- <button class="apple_btn">
                            <img src="<?= base_url() ?>assets/img/icons/apple.png" alt="">
                        </button> -->
                        <button class="fb_btn">
                            <a href="javascript:void(0);" onclick="fbLogin();" ><img src="<?= base_url() ?>assets/img/icons/blue_fb.png" alt=""></a>
                        </button>
                        <button class="google_btn">
                            <a href="<?php echo $loginURL; ?>"><img src="<?= base_url() ?>assets/img/icons/google.png" alt=""></a>
                        </button>
                    </div>
                    <div class="divider text-center">
                        <span><?php echo $this->lang->line('or'); ?></span>
                    </div>
                    <form id="login" class="mb-5">
                        <div class="form-group">
                            <input type="email" class="form-control" id="fw_lg_email" name="fw_lg_email" placeholder="<?php echo $this->lang->line('enter_email'); ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="fw_lg_password" name="fw_lg_password" placeholder="<?php echo $this->lang->line('password'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text view_password">
                                    <img src="<?= base_url() ?>assets/img/icons/eye.png" alt="">
                                </span>
                            </div>
                        </div>
                        <div id="login_message"></div>
                        <div class="form-group">
                            <button class="btn btn_brand fw-600 fs14 mt-4 btn-block" type="submit" id="login_submit"><?php echo $this->lang->line('sign_in1'); ?></button>
                        </div>
                        <div class="form-group text-center">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#fogot_up_modal" data-dismiss="modal" class="fs-16 fw-600"><?php echo $this->lang->line('forgot_pass'); ?></a>
                        </div>
                    </form>
                    <div class="text-center fs-16 py-4"><?php echo $this->lang->line('new_to_flea'); ?> <a href="javascript:void(0)" class="fw-600 btn btn_brand" data-toggle="modal" data-target="#sign_up_modal" data-dismiss="modal"><?php echo $this->lang->line('sign_up_here'); ?></a></div>
                    <div class="text-center fs-16">
                    <?php echo $this->lang->line('by_cont_agree'); ?> <a target="_blank" href="<?= base_url() ?>terms-and-conditions" class="fw-600"><?php echo $this->lang->line('terms_of'); ?> <br> <?php echo $this->lang->line('condition'); ?></a>  <a target="_blank" href="<?= base_url() ?>priacy-policy" class="fw-600"><?php echo $this->lang->line('and_privacy'); ?> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    
    }
?>

<div class="modal fade" id="fogot_up_modal" tabindex="-1" role="dialog" aria-labelledby="fogot_up_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content login_signup_content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h5 class="fs-40 fw-600"><?php echo $this->lang->line('welcome_to_market'); ?>!</h5>
                        <p class="fs-16 fw-500"><?php echo $this->lang->line('sign_n_find'); ?></p>
                    </div>
                    <form id="reset_password_link" class="mb-5">
                        <div class="form-group">
                            <input type="email" class="form-control" id="fw_reset_password_link_email" name="fw_reset_password_link_email" placeholder="<?php echo $this->lang->line('enter_email'); ?>">
                        </div>
                        <div id="reset_password_link_message"></div>
                        <div class="form-group">
                            <button class="btn btn_brand fw-600 fs14 mt-4 btn-block" type="submit" id="reset_password_link_submit">Send</button>
                        </div>
                    </form>
                    <?php echo $this->lang->line('by_cont_agree'); ?> <a target="_blank" href="<?= base_url() ?>terms-and-conditions" class="fw-600"><?php echo $this->lang->line('terms_of'); ?> <br> <?php echo $this->lang->line('condition'); ?></a>  <a target="_blank" href="<?= base_url() ?>priacy-policy" class="fw-600"><?php echo $this->lang->line('and_privacy'); ?> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



<div class="modal fade" id="sign_up_modal" tabindex="-1" role="dialog" aria-labelledby="sign_in_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content login_signup_content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h5 class="fs-40 fw-600"><?php echo $this->lang->line('welcome_to_market'); ?>!</h5>
                    <p class="fs-16 fw-500"><?php echo $this->lang->line('sign_n_find'); ?></p>
                </div>
                <div class="d-flex-wrap justify-content-center mt-4">
                    <!-- <button class="apple_btn">
                        <img src="<?= base_url() ?>assets/img/icons/apple.png" alt="">
                    </button> -->
                    <button class="fb_btn">
                        <a href="javascript:void(0);" onclick="fbLogin();" ><img src="<?= base_url() ?>assets/img/icons/blue_fb.png" alt=""></a>
                    </button>
                    <button class="google_btn">
                        <a href="<?php echo $loginURL; ?>"><img src="<?= base_url() ?>assets/img/icons/google.png" alt=""></a>
                    </button>
                </div>
                <div class="divider text-center">
                    <span><?php echo $this->lang->line('or'); ?></span>
                </div>
                <form id="registration" class="mb-5">
                    <div class="form-group">
                        <input type="email" class="form-control" name="fw_sg_email" id="fw_sg_email" placeholder="<?php echo $this->lang->line('enter_email'); ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="fw_sg_password" id="fw_sg_password" placeholder="<?php echo $this->lang->line('password'); ?>">
                        <div class="input-group-append">
                            <span class="input-group-text view_password">
                                <img src="<?= base_url() ?>assets/img/icons/eye.png" alt="">
                            </span>
                        </div>
                    </div>
                    <div id="register_message"></div>
                    <div class="form-group">
                        <button class="btn btn_brand fw-600 fs14 mt-4 btn-block" type="submit" id="register_submit"><?php echo $this->lang->line('sign_up'); ?></button>
                    </div>
                </form>
                <div class="text-center fs-16 py-4"><?php echo $this->lang->line('already_acc'); ?> <a href="javascript:void(0)" class="fw-600" data-toggle="modal" data-target="#sign_in_modal" data-dismiss="modal"> <?php echo $this->lang->line('sign_in1'); ?></a></div>
                <div class="text-center fs-16">
                <?php echo $this->lang->line('by_cont_agree'); ?> <a target="_blank" href="<?= base_url() ?>terms-and-conditions" class="fw-600"><?php echo $this->lang->line('terms_of'); ?> <br> <?php echo $this->lang->line('condition'); ?></a>  <a target="_blank" href="<?= base_url() ?>priacy-policy" class="fw-600"><?php echo $this->lang->line('and_privacy'); ?> </a>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="package_modal" tabindex="-1" role="dialog" aria-labelledby="package_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <button type="button" class="modal_close_btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="text-center">
                    <h5 class="fs-40 fw-600">Package</h5>
                    <p class="fs-16 fw-500">Choose Your Package</p>
                </div>
                <div class="row mb-4 justify-content-center home_packages">
                    <div class="col-auto">
                        <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-for-flea-tab" data-toggle="pill" href="#pills-for-flea" role="tab" aria-controls="pills-for-flea" aria-selected="true">For Flea</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-for-flea-markets-tab" data-toggle="pill" href="#pills-for-flea-markets" role="tab" aria-controls="pills-for-flea-markets" aria-selected="false">For Flea Markets</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-for-flea" role="tabpanel" aria-labelledby="pills-for-flea-tab">
                                <div class="row align-items-end justify-content-center">
                                    <div class="col-sm-6">
                                        <div class="package_card">
                                            <div class="package_card_body">
                                                <h5 class="fs-20 fw-800 text-center">Silver</h5>
                                                <ol>
                                                    <li class="my-3">Search market</li>
                                                    <li class="my-3">See whole Denmark</li>
                                                    <li class="my-3">See pictures + videos</li>
                                                </ol>
                                                <div class="text-center mt-3">
                                                    <h5 class="fs-20 fw-800 ">9DKK- Per Month</h5>
                                                    <button class="btn">Pay Now</button>
                                                    <h6 class="fs-16 fw-600">No binding</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
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
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-for-flea-markets" role="tabpanel" aria-labelledby="pills-for-flea-markets-tab">
                                <div class="row align-items-end justify-content-center">
                                    <div class="col-sm-6">
                                        <div class="package_card">
                                            <div class="package_card_body">
                                                <h5 class="fs-20 fw-800 text-center">Silver</h5>
                                                <ol>
                                                    <li class="my-3">Search market</li>
                                                    <li class="my-3">See whole Denmark</li>
                                                    <li class="my-3">See pictures + videos</li>
                                                </ol>
                                                <div class="text-center mt-3">
                                                    <h5 class="fs-20 fw-800 ">9DKK- Per Month</h5>
                                                    <button class="btn">Pay Now</button>
                                                    <h6 class="fs-16 fw-600">No binding</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
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




<div class="modal fade" id="book_modal" tabindex="-1" role="dialog" aria-labelledby="package_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content border_radius_20">
            <div class="modal-body">
                <div class="row align-items-center justify-content-center">
                   <div class="col-8">
                        <h5 class="fs-16 fw-600 m-0">No of Tables</h5>
                   </div>
                   <div class="col-4">
                        <input class="form-control border_radius_10 fs-12 fw-600" type="text" value="10">
                    </div>
                   <div class="col-12 mt-3">
                        <button class="btn border_radius_20 btn-block btn_brand fw-600 fs-16">Add To Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

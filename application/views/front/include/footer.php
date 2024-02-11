<footer>
    <div class="container ">
        <div class="row footer_header align-items-center justify-content-between">
            <div class="col-sm-6">
            <h6 class="my-3 fs-22 fw-400"><?php echo $this->lang->line('follow_us_here'); ?></h6>
                <div class="row align-items-center">
                    <?php
                        if(!$is_login)
                        {
                    ?>
                        <div class="col-auto">
                            <h6 class="m-0 fs-22 fw-400"><?php echo $this->lang->line('ready_to_start'); ?></h6>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn_success_gradiant fw-500 px-4" data-toggle="modal" data-target="#sign_in_modal"><?php echo $this->lang->line('sign_up_here'); ?></button>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="col-sm-6">
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.facebook.com/profile.php?id=100076365755450">
                            <img height="15" src="<?= base_url() ?>assets/img/icons/facebook.png" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.instagram.com/loppekortet/">
                            <img height="17" src="<?= base_url() ?>assets/img/icons/instagram.png" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.instagram.com/loppekortet/">
                            <img height="15" src="<?= base_url() ?>assets/img/icons/twitter.png" alt="">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <hr>
    </div>
    <div class="container ">
        <div class="row footer_body align-items-start justify-content-between">

            <div class="col-lg-5">
                <h6 class="my-3 fs-22 fw-400">Download App <?php echo $this->lang->line('on'); ?></h6>
                <ul class="footer_link">
                    <li class="d-block">
                        <a href="https://play.google.com/store/apps/details?id=com.fleamarket">
                            <img width="120" src="<?= base_url() ?>assets/img/icons/google_pay.png" alt="">
                        </a>
                    </li>
                    <li class="d-block">
                        <a href="https://apps.apple.com/in/app/loppekortet/id1588266658">
                            <img width="120" src="<?= base_url() ?>assets/img/icons/play_store.png" alt="">
                        </a>
                    </li>
                </ul>

            </div>
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-sm-4">
                        <h6 class="my-3 fs-17 fw-600"><?php echo $this->lang->line('services'); ?></h6>
                        <ul class="footer_link">
                            <li>
                                <a href="<?= base_url() ?>explore"><?php echo $this->lang->line('explore'); ?></a>
                            </li>
                            <!-- <li>
                                <a href="<?= base_url() ?>">Package</a>
                            </li> -->
                            <li>
                                <a href="<?= base_url() ?>create-flea-market"><?php echo $this->lang->line('create_market'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="my-3 fs-17 fw-600"><?php echo $this->lang->line('about'); ?></h6>
                        <ul class="footer_link">
                            <li>
                                <a  href="<?= base_url() ?>about/#wo_we_are"><?php echo $this->lang->line('who_we_are'); ?></a>
                            </li>
                            <li>
                                <a  href="<?= base_url() ?>about/#why_flea_market"><?php echo $this->lang->line('why_flea_market'); ?></a>
                            </li>
                            <li>
                                <a  href="<?= base_url() ?>about/#how_it_work"><?php echo $this->lang->line('how_it_works'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="my-3 fs-17 fw-600"><?php echo $this->lang->line('help'); ?></h6>
                        <ul class="footer_link">
                            <li>
                                <a  href="<?= base_url() ?>faqs">FAQs</a>
                            </li>
                            <li>
                                <a  href="javascript:void(0)" onclick="openlink(`<?= base_url() ?>users/need-help`)"><?php echo $this->lang->line('need_help'); ?></a>
                            </li>
                            <li>
                                <a  href="<?= base_url() ?>priacy-policy"><?php echo $this->lang->line('privacy'); ?></a>
                            </li>
                            <li>
                                <a  href="<?= base_url() ?>terms-and-conditions"><?php echo $this->lang->line('terms'); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container position-relative">
        <!-- <div class="language_dropdown dropdown dropdown-sm">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown_language" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            <?php if($this->session->userdata('site_lang') == 'danish'){ echo 'DK'; }else{ echo "EN"; } ?>

            </button>
            <div class="dropdown-menu" aria-labelledby="dropdown_language">
                <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/english';">EN</a>
                <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/danish';" selected>DK</a>
            </div>
        </div> -->
        <hr>
        <div class="row align-items-center justify-content-between">
            <div class="col-12 text-center">
                <!-- <h6 class="m-0">All rights reserved © Flea market 2021</h6> -->
                <h6 class="m-0"><?php echo $this->lang->line('all_rights'); ?></h6>
            </div>
        </div>
    </div>
</footer>
<!-- <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->

<script>
function openlink(link){

        var is_login=0;
        <?php if($is_login){ ?>
            is_login=1;
        <?php } ?>

        if(is_login==0){
            $('#sign_in_modal').modal('show');
        }else{

            window.open(link,'_self');

        }

}



// function googleTranslateElementInit() {
        // new google.translate.TranslateElement({
        //     pageLanguage: 'en', 
        //     includedLanguages: 'da-DK', 
        //     autoDisplay: false
        // }, 'google_translate_element');
        // var a = document.querySelector("#google_translate_element select");
        // a.selectedIndex=1;
        // a.dispatchEvent(new Event('change'));
    // }
</script>
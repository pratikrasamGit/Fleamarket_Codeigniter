<header class="header_area">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="<?= base_url() ?>">
                    <img src="<?= base_url() ?>assets/img/logo.png" alt="">
                </a>
                <div class="mob_top_search_bar">
                    <?php $this->load->view('front/include/search_bar'); ?>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav justify-content-center topbar_menu">
                        <li class="nav-item active"><a class="nav-link" href="<?= base_url() ?>explore"><?php echo $this->lang->line('explore'); ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>about"><?php echo $this->lang->line('about'); ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>#home_packages"><?php echo $this->lang->line('packages'); ?></a>
                            <!-- <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Blog</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Blog Details</a></li>
                            </ul>
                        </li> -->
                        <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>create-flea-market"><?php echo $this->lang->line('create_market'); ?></a></li>
                    </ul>
                    <div class="top_search_bar">
                        <?php $this->load->view('front/include/search_bar'); ?>
                    </div>
                    <ul class=" nav navbar-nav navbar-right navbar_right">

                        <button class="menu_toggler" type="button">
                            <i class="" aria-hidden="true"></i>
                        </button>

                        <?php
                            if($is_login)
                            {
                        ?>
                                <li class="nav-item submenu dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img class="logged_user_img" src="<?=$profile_pic ?>" alt="">
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>users"><?php echo $this->lang->line('profile'); ?></a></li>
                                        <!-- <li class="nav-item"><a class="nav-link" href="javascript:void(0)"><?php echo $this->lang->line('settings'); ?></a></li> -->
                                        <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>users/logout"><?php echo $this->lang->line('log_out'); ?></a></li>
                                    </ul>
                                </li>
                        <?php
                            }
                            else
                            {
                        ?>
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="primary_btn" data-toggle="modal" data-target="#sign_in_modal"><?php echo $this->lang->line('sign_in_up'); ?></a>
                                </li>
                        <?php
                            }
                        ?>
                        <li class="nav-item">
                            
                            <div class="language_dropdown dropdown dropdown-sm">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown_language" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <?php if($this->session->userdata('site_lang') == 'danish'){ echo 'DK'; }else{ echo "EN"; } ?>

                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdown_language">
                                    <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/english';">EN</a>
                                    <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/danish';" selected>DK</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
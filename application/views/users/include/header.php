<header class="header_area">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <div class="language_dropdown dropdown dropdown-sm">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown_language" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <?php if($this->session->userdata('site_lang') == 'danish'){ echo 'DK'; }else{ echo "EN"; } ?>

                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown_language">
                        <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/english';">EN</a>
                        <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/danish';" selected>DK</a>
                    </div>
                </div>
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="<?= base_url() ?>users">
                    <img src="<?= base_url() ?>assets/img/logo.png" alt="">
                </a>
                <div class="mob_top_search_bar">
                    <?php $this->load->view('front/include/search_bar'); ?>
                </div>
                <button class="navbar-toggler dsah_nav_toggler">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <div class="top_search_bar">
                        <?php $this->load->view('front/include/search_bar'); ?>
                    </div>
                    <ul class=" nav navbar-nav navbar-right navbar_right">
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img class="logged_user_img" src="<?= base_url().$profile_pic ?>" alt="">
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>users/logout"><?php echo $this->lang->line('log_out');?></a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>"><?php echo $this->lang->line('settings');?></a></li> -->
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
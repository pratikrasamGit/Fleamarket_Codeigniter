<?php
    $mainMenu = $this->uri->segment(1);
    $subMenu = $this->uri->segment(2);
?>

<div class="user_aside_container active">

    <div class="aside_menu">
    <a class="btn btn_brand" href="<?= base_url() ?>" style="margin-left: 24px;margin-bottom: 10px;"><?php echo $this->lang->line('backtohome');?></a>

        <ul class="">
            
            <li>
                <a href="<?= base_url() ?>users" <?php if($mainMenu == 'users' && $subMenu == ''){ ?> class="active" <?php } ?> >
                    <span>
                        <img class="white_menu_icon" src="<?= base_url() ?>assets/users/img/icons/user_white.png" alt="">
                        <img class="dark_menu_icon" src="<?= base_url() ?>assets/users/img/icons/user_dark.png" alt="">
                    </span>
                    <span class="aside_menu_text"><?php echo $this->lang->line('personal_details');?></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>users/plan" <?php if($subMenu == 'plan'){ ?> class="active" <?php } ?> >
                    <span>
                        <img class="white_menu_icon" src="<?= base_url() ?>assets/users/img/icons/package_white.png" alt="">
                        <img class="dark_menu_icon" src="<?= base_url() ?>assets/users/img/icons/package_dark.png" alt="">
                    </span>
                    <span class="aside_menu_text"><?php echo $this->lang->line('flea_packages');?></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>users/favorite" <?php if($subMenu == 'favorite'){ ?> class="active" <?php } ?> >
                    <span>
                        <img class="white_menu_icon" src="<?= base_url() ?>assets/users/img/icons/fav_white.png" alt="">
                        <img class="dark_menu_icon" src="<?= base_url() ?>assets/users/img/icons/fav_dark.png" alt="">
                    </span>
                    <span class="aside_menu_text"><?php echo $this->lang->line('Favorite');?></span>
                </a>
            </li>

            <li>
                <label>
                    <?php echo $this->lang->line('for_flea_marketer');?>
                </label>
            </li>
            <li>
                <a href="<?= base_url() ?>users/my-market" <?php if($subMenu == 'my-market'){ ?> class="active" <?php } ?> >
                    <span>
                        <img class="white_menu_icon" src="<?= base_url() ?>assets/users/img/icons/market_white.png" alt="">
                        <img class="dark_menu_icon" src="<?= base_url() ?>assets/users/img/icons/market_dark.png" alt="">
                    </span>
                    <span class="aside_menu_text"><?php echo $this->lang->line('my_market');?></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>users/packages" <?php if($subMenu == 'packages'){ ?> class="active" <?php } ?> >
                    <span>
                        <img class="white_menu_icon" src="<?= base_url() ?>assets/users/img/icons/user_white.png" alt="">
                        <img class="dark_menu_icon" src="<?= base_url() ?>assets/users/img/icons/user_dark.png" alt="">
                    </span>
                    <span class="aside_menu_text"><?php echo $this->lang->line('headpackage');?></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>users/rent-space" <?php if($subMenu == 'rent-space'){ ?> class="active" <?php } ?> >
                    <span>
                        <img class="white_menu_icon" src="<?= base_url() ?>assets/users/img/icons/package_white.png" alt="">
                        <img class="dark_menu_icon" src="<?= base_url() ?>assets/users/img/icons/package_dark.png" alt="">
                    </span>
                    <span class="aside_menu_text"><?php echo $this->lang->line('rent_space');?></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>users/purchase-history" <?php if($subMenu == 'purchase-history'){ ?> class="active" <?php } ?> >
                    <span>
                        <img class="white_menu_icon" src="<?= base_url() ?>assets/users/img/icons/history_white.png" alt="">
                        <img class="dark_menu_icon" src="<?= base_url() ?>assets/users/img/icons/history_dark.png" alt="">
                    </span>
                    <span class="aside_menu_text"><?php echo $this->lang->line('purchase_history');?></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>users/notification" <?php if($subMenu == 'notification'){ ?> class="active" <?php } ?> >
                    <span>
                        <img class="white_menu_icon" src="<?= base_url() ?>assets/users/img/icons/notify_white.png" alt="">
                        <img class="dark_menu_icon" src="<?= base_url() ?>assets/users/img/icons/notify_dark.png" alt="">
                    </span>
                    <span class="aside_menu_text"><?php echo $this->lang->line('notifications');?></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>users/need-help" <?php if($subMenu == 'need-help'){ ?> class="active" <?php } ?> >
                    <span>
                        <img class="white_menu_icon" src="<?= base_url() ?>assets/users/img/icons/help_white.png" alt="">
                        <img class="dark_menu_icon" src="<?= base_url() ?>assets/users/img/icons/help_dark.png" alt="">
                    </span>
                    <span class="aside_menu_text"><?php echo $this->lang->line('need_help');?></span>
                </a>
            </li>
            <ul>
                <li>
                    <a href="<?= base_url() ?>users/logout" class="user_aside_logout_btn">
                        <span>
                            <img class="white_menu_icon" src="<?= base_url() ?>assets/users/img/icons/logout_white.png" alt="">
                            <img class="dark_menu_icon" src="<?= base_url() ?>assets/users/img/icons/logout_dark.png" alt="">
                        </span> <?php echo $this->lang->line('log_out');?>
                    </a>
                </li>
            </ul>
        </ul>
    </div>
</div>
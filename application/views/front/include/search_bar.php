<form class="search_bar" method="post" action="<?=base_url()?>explore">
    <div class="form-row search_place">
        <div class="form-inline w-100">
            <a href="#" class="btn btn_setting toggle_filter_btn">
                <img src="<?= base_url() ?>assets/img/icons/setting.png" alt="">
            </a>
            <input type="text" class="form-control searchText" id="searchText" name="searchText" placeholder="<?php echo $this->lang->line('search_here'); ?>..." >
            <button type="submit" class="btn btn_search">
                <img src="<?= base_url() ?>assets/img/icons/search.png" alt="">
            </button>
        </div>
    </div>
</form>
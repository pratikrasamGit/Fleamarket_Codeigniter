    <div class="filter_container">
        <button class="filter_close_btn">
            <img width="15" src="<?= base_url() ?>assets/img/icons/close.png" alt="">
        </button>
        <h4 class="fs-30 fw-700 text-center">Filter</h4>
        <form  method="post" action="<?=base_url()?>explore" >
            <div class="row">
                <div class="col-12 form-group">
                    <label for=""><?php echo $this->lang->line('select').' '.$this->lang->line('flea_Market');?></label>
                    <select class="form-control" id="market_id" name="market_id">
                        <option value=""><?php echo $this->lang->line('select')?></option>
                        <?php foreach($markets as $value){ ?>
                            <option value="<?=$value->id?>" <?php if($market_id==$value->id){ echo "selected"; } ?>><?=$value->market_name?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <input type="text" class="form-control text-center" id="zipcode" name="zipcode" placeholder="<?=$this->lang->line('zipcode');?>" value="<?=$zipcode?>">
                </div>
                <div class="col-sm-6 form-group">
                    <input type="text" class="form-control text-center" id="city" name="city" placeholder="<?=$this->lang->line('city');?>" value="<?=$city?>">
                </div>
            </div>
            <hr>
            <div class="row justify-content-between">
                <div class="col-6">
                    <label class="fs-12 fw-800"><?=$this->lang->line('your_range');?></label>
                </div>
                <div class="col-auto form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="entire_denmark" name="entire_denmark" <?php if($entire_denmark==1){ echo "checked"; } ?>  value="1">
                        <label class="custom-control-label fs-12 fw-800" for="entire_denmark"><?=$this->lang->line('entire_denmark');?></label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="">
                        <input type="range" value="<?=$range?>" name="range" data-rangeslider>
                        <output></output>
                    </div>
                </div>
            </div>
            <hr>

            <div class="filter_categories_card">
                <label class="fs-18 fw-800"><?=$this->lang->line('categories');?></label><br>
                <?php foreach($categories as $value){ ?>
                    <div class="category_buttons">
                        <label>
                            <input type="checkbox" name="category[]" value="<?= $value->id?>" <?php if(!empty($category)){ if(in_array($value->id, $category)){ echo "checked"; } } ?>  ><span><?php if($this->session->userdata('site_lang') == 'danish'){ echo $value->dnk_name; }else{ echo $value->category_name; }?></span>
                        </label>
                    </div>
                <?php } ?>  
            </div>

            <div class="row">
                <div class="col-sm-6 form-group">
                    <label class="fs-18 fw-800"><?=$this->lang->line('from_date');?></label>
                    <input type="date" class="form-control text-center" id="from_date" name="from_date" placeholder="<?=$this->lang->line('from_date');?>" value="<?=$from_date?>">
                </div>
                <div class="col-sm-6 form-group">
                    <label class="fs-18 fw-800"><?=$this->lang->line('to_date');?></label>
                    <input type="date" class="form-control text-center" id="to_date" name="to_date" placeholder="<?=$this->lang->line('to_date');?>" value="<?=$to_date?>">
                </div>
            </div>


            <button type="submit" class="btn btn_apply"><?=$this->lang->line('search');?></button>
        </form>
    </div>


    <script src="<?= base_url() ?>assets/js/rangeslider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" ></script>

    <script>
        $(document).ready(function() {
            $('#market_id').select2();


            var st = $('#searchTextval').val(); 
            $('.searchText').val(st);
            // alert($('#searchTextval').val());
            $(".toggle_filter_btn").click(function() {
                $('.filter_container').toggleClass('show');
                // $('#market_id').select2();
            });
            $(".filter_close_btn").click(function() {
                $('.filter_container').toggleClass('show');
            });
        });
    </script>
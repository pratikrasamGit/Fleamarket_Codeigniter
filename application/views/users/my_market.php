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
                    <div class="section_heading justify-content-center mb-4">
                        <h4 class="fs-30 fw-800"><?php echo $this->lang->line('my_market');?></h4>
                    </div>


                    <div class="row">
                        <?php $today = date("Y-m-d h:i:s");
                            foreach ($market as $keys => $values) {
                                $btn = '';
                                $start = $values->start_date.' '.$values->start_time;
                                $expire = $values->end_date.' '.$values->end_time;

                                $today_time = strtotime($today);
                                $start_time = strtotime($start);
                                $expire_time = strtotime($expire);

                                $link = base_url(). 'market/' .$values->id;
                                if($expire_time < $today_time){
                                    $link = '#';
                                }
                                if($values->status == 0){
                                    $btn = '<a href="javascript:void(0)"  class="fw-600 btn btn_brand" style="float: right;margin-right:1%;margin-top:1%;">'.$this->lang->line('pending').'</a>';
                                    $btn2 = '<a href="'.base_url().'create-flea-market/'.$values->id.'"  class="fw-600 btn btn_brand" style="float: left;margin-left:1%;margin-top:1%;">'.$this->lang->line('edit').'</a>';
                                }else if($expire_time > $today_time  && $start_time < $today_time ) {
                                    $btn = '<a href="javascript:void(0)"  class="fw-600 btn btn_brand" style="float: right;margin-right:1%;margin-top:1%;">'.$this->lang->line('opened').'</a>';
                                    $btn2 = '<a href="'.base_url().'create-flea-market/'.$values->id.'"  class="fw-600 btn btn_brand" style="float: left;margin-left:1%;margin-top:1%;">'.$this->lang->line('edit').'</a>';
                                }else if($expire_time < $today_time){
                                    $btn = '<a href="'.base_url().'create-flea-market/'.$values->id.'"  class="fw-600 btn btn_brand" style="float: right;margin-right:1%;margin-top:1%;">'.$this->lang->line('reuse').'</a>';
                                    $btn2 = ""; 
                                }else if($expire_time > $today_time  && $start_time > $today_time ){
                                    $btn = '<a href="javascript:void(0)" disabled class="fw-600 btn btn_brand" style="float: right;margin-right:1%;margin-top:1%;">'.$this->lang->line('upcoming').'</a>';
                                    $btn2 = '<a href="'.base_url().'create-flea-market/'.$values->id.'"  class="fw-600 btn btn_brand" style="float: left;margin-left:1%;margin-top:1%;">'.$this->lang->line('edit').'</a>';
                                }
                        ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="feature_market_card">
                                <a href="<?= $link?>">
                                    <div class="img_bg_card mt-0"  onclick='window.location.href="<?= $link ?>"' style="background-image: url(<?php if(count($values->images) > 0){ echo base_url() ?>uploads/market/<?= $values->images[0]->file; }else { echo base_url().'uploads/default_market.jpg'; } ?>);">
                                    <?=$btn?>
                                    <?=$btn2?>
                                    <div class="img_bg_card_content">
                                            <div class="d-flex-wrap justify-content-between align-items-center mb-2">
                                                <p class="fs-18 fw-600 m-0"><?= substr_replace( $values->market_name, "", 20); ?> <?php if(strlen($values->market_name) > 12){ ?> ... <?php } ?></p>
                                                <div class="d-flex align-items-center">
                                                    <span class="ml-3">
                                                        <a class="favorite favorite<?=$values->id?>" href="javascript:void(0)" onclick="favourite(<?= $values->id ?>)">
                                                            <img width="15" src="<?= base_url() ?>assets/img/icons/heart.png" alt="">
                                                        </a>
                                                    </span>
                                                    <span class="ml-3">
                                                        <a href="javascript:void(0)" onclick="sharelink(`<?= base_url() ?>share-link/<?= $values->id ?>`)">
                                                            <img width="15" src="<?= base_url() ?>assets/img/icons/share.png" alt="">
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="d-flex-wrap justify-content-between align-items-center">
                                                <p class="fs-12 fw-500 m-0"><img width="10" src="<?= base_url() ?>assets/img/icons/location.png" alt=""> <?= $values->address ?>, <?= $values->city ?></p>
                                                <?php if($values->recurring_type == '1' || $values->recurring_type == '2'){ ?>
                                                <p class="fs-12 fw-500 m-0"> <?php echo $this->lang->line('repeating_market');?></p>
                                                <?php } ?>
                                            </div>
                                            
                                            <div class="d-flex-wrap justify-content-between align-items-center">
                                                <p class="fs-12 fw-500 m-0">
                                                    <span>
                                                        <img width="10" src="<?= base_url() ?>assets/img/icons/clock.png" alt="">
                                                    </span>
                                                    <?= $values->start_time ?> - <?= $values->end_time ?>
                                                </p>
                                                <p class="fs-12 fw-500 m-0">
                                                    <span>
                                                        <img width="10" src="<?= base_url() ?>assets/img/icons/calender.png" alt="">
                                                    </span><?= $values->start_date ?> - <?= $values->end_date ?>
                                                </p>
                                            </div>
                                            <?php if($expire_time < $today_time){ ?>
                                            <div class="d-flex-wrap justify-content-between align-items-center">
                                                <p class="fs-12 fw-500 m-0" style="color: red;font-size: 11px;"><?php echo $this->lang->line('expired'); ?></p>
                                            </div>
                                            <?php } ?>
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
            </div>

        </div>
    </div>




    <!--================Footer Area =================-->
    <?php $this->load->view('users/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('users/include/include_script'); ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


</body>

</html>
<script>
function favourite(id){

    event.preventDefault();
            event.stopPropagation();
     
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



function sharelink(link){
    event.preventDefault();
            event.stopPropagation();
   
        window.open(link, '_blank');

    

}
</script>

<?php 
    if($this->session->flashdata('market_create_message')){
?>

<script type="text/javascript">
    swal("<?php echo $this->lang->line('market_create_message');?>");
</script>

<?php
    }
?>
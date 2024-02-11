<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loppekortet</title>

    <?php $this->load->view('front/include/include_styles'); ?>


</head>

<body>

    <!--================Header Menu Area =================-->
    <?php $this->load->view('front/include/header'); ?>
    <!--================Header Menu Area =================-->





    <section class="share_link py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <img width="100" src="<?= base_url() ?>assets/img/icons/shr.png" alt="">
                    <h2 class="fs-50 fw-700">Do you <span class="text-primary">share</span> this market  with your friends</h2>

                    <nav class="nav justify-content-center">
                        <a class="nav-link m-3" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=base_url()?>market/<?=$market_id?>">
                            <img width="60" src="<?= base_url() ?>assets/img/icons/facebook_big.png" alt="">
                        </a>
                        <a class="nav-link m-3"  target="_blank" href="https://twitter.com/intent/tweet?url=<?=base_url()?>market/<?=$market_id?>&text=">
                            <img width="60" src="<?= base_url() ?>assets/img/icons/twiter_big.png" alt="">
                        </a>
                        <a class="nav-link m-3" target="_blank"  href="https://www.instagram.com/direct/inbox?msg=https://www.google.com/">
                            <img width="60" src="<?= base_url() ?>assets/img/icons/instagram_big.png" alt="">
                        </a>
                        <a class="nav-link m-3"  target="_blank" href="mailto:info@example.com?&subject=&cc=&bcc=&body=<?=base_url()?>market/<?=$market_id?>%0A">
                            <img width="60" src="<?= base_url() ?>assets/img/icons/gmail_big.png" alt="">
                        </a>
                    </nav>

                    <h2 class="fs-50 fw-700">or</h2>
                    <h4 class="fs-30 fw-500">Copy the share link manualy.</h4>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-10 mx-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" id="link" value="<?=base_url()?>market/<?=$market_id?>">
                        <div class="input-group-append">
                            <button class="btn btn_brand" type="button" id="button-addon1" onclick="copy()">Copy</button>
                        </div>
                    </div>
                    <span style="float:right;display :none" id="copytext">Link copied...</span>

                </div>
                
            </div>
        </div>
    </section>
    <!--================End Details Place Area =================-->

    <?php $this->load->view('front/include/modal'); ?>

    <!--================Footer Area =================-->
    <?php $this->load->view('front/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('front/include/include_script'); ?>


</body>

</html>

<script>
function copy() {
  /* Get the text field */
  var copyText = document.getElementById("link");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

   /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText.value);

  $('#copytext').show();
}
</script>
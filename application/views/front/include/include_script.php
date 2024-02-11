<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?= base_url() ?>assets/js/jquery-3.2.1.min.js"></script>
<script src="<?= base_url() ?>assets/js/popper.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/main.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-validation/jquery.validate.min.js"></script>
<script>



    $(".favorite").click(function(){
    $(this).toggleClass("active");
    });

    $("#registration").submit(function(e) {
        e.preventDefault();
    }).validate({
        rules: {
            fw_sg_email: {
                required: true,
                email: true
            },
            fw_sg_password: {
                required: true
            }
        },
        submitHandler: function(form) {
            $('#register_submit').prop('disabled',true);            
            $("#register_submit").html("Please wait ...");
            $("#register_message").html('');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>registration",
                data:  $(form).serialize(),
                success: function(response) {
                    $("#register_submit").html("Sign Up");
                    $("#register_submit").prop('disabled', false);
                    response = JSON.parse(response);
                    if(response.response)
                    {
                        location.reload();

                        $('#registration').trigger("reset");
                        $("#register_message").html('<span class="text-success font-weight-bold">'+response.msg+'</span>').delay(3000).fadeOut();                   
                    }
                    else{
                        $("#register_message").html('<span class="text-danger font-weight-bold">'+response.msg+'</span>').delay(3000).fadeOut();
                    }
                }
            });
            return false; 
        }
    });

    $("#login").submit(function(e) {
        e.preventDefault();
    }).validate({
        rules: {
            fw_lg_email: {
                required: true,
                email: true
            },
            fw_lg_password: {
                required: true
            }
        },
        submitHandler: function(form) {
            $('#login_submit').prop('disabled',true);            
            $("#login_submit").html("Please wait ...");
            $("#login_message").html('');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>login",
                data:  $(form).serialize(),
                success: function(response) {
                    $("#login_submit").html("Sign In");
                    $("#login_submit").prop('disabled', false);
                    response = JSON.parse(response);
                    if(response.response)
                    {
                        location.reload();
                        // window.location.href = '<?php echo base_url() ?>users';
                    }
                    else{
                        $("#login_message").html('<span class="text-danger font-weight-bold">'+response.msg+'</span>').delay(3000).fadeOut();                      
                    }
                }
            });
            return false; 
        }
    });

    $("#reset_password").submit(function(e) {
        e.preventDefault();
    }).validate({
        rules: {
            fw_reset_password: {
                required: true
            }
        },
        submitHandler: function(form) {
            $('#reset_password_submit').prop('disabled',true);            
            $("#reset_password_submit").html("Please wait ...");
            $("#reset_password_message").html('');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>update-password",
                data:  $(form).serialize(),
                success: function(response) {
                    $("#reset_password_submit").html("Submit");
                    $("#reset_password_submit").prop('disabled', false);
                    response = JSON.parse(response);
                    if(response.response)
                    {
                        $("#reset_password_message").html('<span class="text-success font-weight-bold">'+response.msg+'</span>').delay(3000).fadeOut();
                        setTimeout(function() {
                           window.location.href = '<?php echo base_url() ?>';
                        }, 3000);
                    }
                    else{
                        $("#reset_password_message").html('<span class="text-danger font-weight-bold">'+response.msg+'</span>').delay(3000).fadeOut();                      
                    }
                }
            });
            return false; 
        }
    });

    $("#reset_password_link").submit(function(e) {
        e.preventDefault();
    }).validate({
        rules: {
            fw_reset_password_link_email: {
                required: true,
                email: true
            }
        },
        submitHandler: function(form) {
            $('#reset_password_link_submit').prop('disabled',true);            
            $("#reset_password_link_submit").html("Please wait ...");
            $("#reset_password_link_message").html('');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>reset-password-link",
                data:  $(form).serialize(),
                success: function(response) {
                    $("#reset_password_link_submit").html("Submit");
                    $("#reset_password_link_submit").prop('disabled', false);
                    response = JSON.parse(response);
                    if(response.response)
                    {
                       $("#reset_password_link_message").html('<span class="text-success font-weight-bold">'+response.msg+'</span>');  
                    }
                    else{
                        $("#reset_password_link_message").html('<span class="text-danger font-weight-bold">'+response.msg+'</span>');                      
                    }
                }
            });
            return false; 
        }
    });
    
</script>
<script>
    $(document).on('hidden.bs.modal', function(event) {
        if ($('.modal:visible').length) {
            $('body').addClass('modal-open');
        }
    });
</script>

<script>
window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '1130779321059532', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v3.2' // use graph api version 2.8
    });
};

// Load the JavaScript SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
function fbLogin() {
    FB.login(function (response) {
        if (response.authResponse) {
            // Get and display the user profile data
            getFbUserData();
        } else {
            document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
        }
    }, {scope: 'email'});
}

// Fetch the user profile data from facebook
function getFbUserData(){
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
    function (response) {        
        // Save user data
        saveUserData(response);
    });
}

// Save user data to the database
function saveUserData(userData){

    $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>auth_facebook",
        data:  userData,
        success: function(response) {
            window.location.href = '<?php echo base_url() ?>users';
        }
    });

}


</script>
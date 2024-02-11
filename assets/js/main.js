; (function ($) {
    "use strict"


    var nav_offset_top = $('header').height() + 50;
    /*-------------------------------------------------------------------------------
	  Navbar 
	-------------------------------------------------------------------------------*/

    //* Navbar Fixed  
    function navbarFixed() {
        if ($('.header_area').length) {
            $(window).scroll(function () {
                var scroll = $(window).scrollTop();
                if (scroll >= nav_offset_top) {
                    $(".header_area").addClass("navbar_fixed");
                } else {
                    $(".header_area").removeClass("navbar_fixed");
                }
            });
        };
    };
    navbarFixed();

    $(document).ready(function(){
        $(".menu_toggler").click(function(){
            $('.header_area ').toggleClass("remove_header_search");
            $(this).toggleClass("saerch_toggler");
        });
    });

     function showPassword() {
        var x = document.getElementById("password_signup");
        var z= document.getElementById("password_signin");
        $(".view_password").click(function(){
            $(this).toggleClass("active");

            if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
            } 
            // ==============
            if (z.type === "password") {
                z.type = "text";
            } else {
                z.type = "password";
            }
        });
    };
    showPassword();


})(jQuery)
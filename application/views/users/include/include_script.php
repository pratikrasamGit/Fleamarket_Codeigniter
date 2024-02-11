<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?= base_url() ?>assets/js/jquery-3.2.1.min.js"></script>
<script src="<?= base_url() ?>assets/js/popper.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/main.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-validation/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        $(".dsah_nav_toggler").click(function() {
            $(this).toggleClass('active');
            $('.user_aside_container').toggleClass('active');
        });
        $(".dsah_nav_toggler").click(function() {
            $('.user_body_container').toggleClass('full_body');
        });

        var alterClass = function() {
            var ww = document.body.clientWidth;
            if (ww < 992) {
                $('.user_aside_container').removeClass('active');
            } else if (ww >= 991) {
                $('.user_aside_container').addClass('active');
            };
        };
        $(window).resize(function() {
            alterClass();
        });
        $(window).width(function() {
            alterClass();
        });
    });
</script>

<script>
    $(document).ready(function(){
           
        // $(".renting_history_filter").css({ 'display' : 'block' }); 
        $(".renting_history_list_active").css({ 'display' : 'none' });
        $(".back_renting_history_list_btn").css({ 'display' : 'none' });

        // $(".renting_history_list").click (function(){
        //     $(".renting_history_card").css({ 'display' : 'none' });
        //     $(".renting_history_list_active").css({ 'display' : 'block' });
        //     $(".back_renting_history_list_btn").css({ 'display' : 'block' });
        //     $(".renting_history_filter").css({ 'display' : 'block' }); 
        //     // $(".craete_rent_a_space_table_card").css({ 'display' : 'none' }); 
        // });
        $(".back_renting_history_list_btn").click (function(){
        	var id = $("#back_btn_id").val();
            $(".renting_history_list_active_"+id).css({ 'display' : 'none' });
            $(".back_renting_history_list_btn").css({ 'display' : 'none' });
            $(".renting_history_card").css({ 'display' : 'block' });
            $(".renting_history_filter").css({ 'display' : 'block' }); 
            // $(".craete_rent_a_space_table_card").css({ 'display' : 'none' }); 
        });
        // $(".craete_rent_a_space_table_btn").click (function(){
        //     $(".renting_history_list_active").css({ 'display' : 'none' });
        //     $(".back_renting_history_list_btn").css({ 'display' : 'none' });
        //     $(".renting_history_card").css({ 'display' : 'none' });
        //     $(".renting_history_filter").css({ 'display' : 'none' });
        //     $(".craete_rent_a_space_table_card").css({ 'display' : 'block' }); 
        // });
    });

    function rhlc(id) {
    	// console.log(id);
    	$(`.renting_history_card`).css({ 'display' : 'none' });
        $(`.renting_history_list_active_`+id).css({ 'display' : 'block' });
        $(".back_renting_history_list_btn").css({ 'display' : 'block' });
        $(".renting_history_filter").css({ 'display' : 'block' }); 
        $("#back_btn_id").val(id);
    }
</script>
<script>
    document.querySelectorAll(".__range-step").forEach(function(ctrl) {
	var el = ctrl.querySelector('input');        
	var output = ctrl.querySelector('output'); 
	var newPoint, newPlace, offset;
	el.oninput =function(){ 
		// colorize step options
		ctrl.querySelectorAll(".option").forEach(function(opt) {
			if(opt.value<=el.valueAsNumber)                
				opt.style.backgroundColor = '#80BE41';
			else
				opt.style.backgroundColor = '#ffffff';
		});           
		// colorize before and after
		var valPercent = (el.valueAsNumber  - parseInt(el.min)) / (parseInt(el.max) - parseInt(el.min));            
		var style = 'background-image: -webkit-gradient(linear, 0% 0%, 100% 0%, color-stop('+
		valPercent+', #80BE41), color-stop('+
		valPercent+', #cce5b3));';
		el.style = style;

		// Popup
    if((' ' + ctrl.className + ' ').indexOf(' ' + '__range-step-popup' + ' ') > -1)
    {
			var selectedOpt=ctrl.querySelector('option[value="'+el.value+'"]');
			output.innerText= selectedOpt.text;
			output.style.left = "50%"; 
			output.style.left = ((selectedOpt.offsetLeft + selectedOpt.offsetWidth/2) - output.offsetWidth/2) + 'px'; 
    }           
	};
	el.oninput();    
});

window.onresize = function(){
	document.querySelectorAll(".__range").forEach(function(ctrl) {
		var el = ctrl.querySelector('input');    
		el.oninput();    
	});
};
</script>



<script>
    $(document).ready(function() {
$('input[type="file"]').on('click', function() {
    $(".file_names").html("");
  })
if ($('input[type="file"]')[0]) {
	var fileInput = document.querySelector('label[for="et_pb_contact_brand_file_request_0"]');
	fileInput.ondragover = function() {
		this.className = "et_pb_contact_form_label changed";
		return false;
	}
	fileInput.ondragleave = function() {
		this.className = "et_pb_contact_form_label";
		return false;
	}
	fileInput.ondrop = function(e) {
		e.preventDefault();
		var fileNames = e.dataTransfer.files;
		for (var x = 0; x < fileNames.length; x++) {
			console.log(fileNames[x].name);
			$=jQuery.noConflict();
			$('label[for="et_pb_contact_brand_file_request_0"]').append("<div class='file_names'>"+ fileNames[x].name +"</div>");
		}
	}
	$('#et_pb_contact_brand_file_request_0').change(function() {
		var fileNames = $('#et_pb_contact_brand_file_request_0')[0].files[0].name;
		$('label[for="et_pb_contact_brand_file_request_0"]').append("<div class='file_names'>"+ fileNames +"</div>");
		$('label[for="et_pb_contact_brand_file_request_0"]').css('background-color', '##eee9ff');
	});
	}
});


</script>
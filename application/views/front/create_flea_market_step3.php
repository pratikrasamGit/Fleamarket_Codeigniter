<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loppekortet</title>

    <?php $this->load->view('front/include/include_styles'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />
<style>
    #map
{
    position: unset !important; 
    height: 100% !important;
    width: 100% !important;
}

#map > div:first-child{
    overflow: hidden;
    top : 25% !important;
    height: 85% !important;
}

    </style>
</head>

<body>

    <!--================Header Menu Area =================-->
    <?php $this->load->view('front/include/header'); ?>
    <!--================Header Menu Area =================-->

    <!--================ Create Flea Market Area =================-->
    <section class="create_flea_market_page pb-5">
        <div class="container pt-5">
            <div class="section_heading justify-content-center align-items-center">
                <h5 class="fs-25 fw-800"><?php if($marketData['market_id']){ echo $this->lang->line('edit_market'); }else{ echo $this->lang->line('create_market'); } ?> - <?=$this->lang->line('step');?> 2</h5>
            </div>
        </div>

        <div class="container pt-4">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="bdr_card">
                        <form action="<?=base_url()?>create-flea-market-step-2" class="box_shd_frm_grp p-4" method="post">
                            <input type="hidden" name="fk_user_id" value="<?=$marketData['fk_user_id']?>" >
                            <input type="hidden" name="market_name" value="<?=$marketData['market_name']?>" >
                            <input type="hidden" name="categories" value="<?=$marketData['categories']?>" >
                            <input type="hidden" name="start_date" value="<?=$marketData['start_date']?>" >
                            <input type="hidden" name="end_date" value="<?=$marketData['end_date']?>" >
                            <input type="hidden" name="start_time" value="<?=$marketData['start_time']?>" >
                            <input type="hidden" name="end_time" value="<?=$marketData['end_time']?>" >
                            <input type="hidden" name="market_id" value="<?=$marketData['market_id']?>" >
                            <input type="hidden" name="recurring_type" value="<?=$marketData['recurring_type']?>" >
                            <!-- <input type="hidden" name="deleted" value="<?=$marketData['deleted']?>" > -->
                            <input type="hidden" name="imagedata" value="<?php echo htmlentities(serialize($marketData['imagedata'])); ?>" >

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="" class="fs-20 fw-700"><?php echo $this->lang->line('address'); ?></label>
                                    <div class="form-group">
                                        <input type="text" name="address" class="form-control" id="address" value="<?php if(!empty($oldmarketdata)){ echo $oldmarketdata->address; } ?>" placeholder="<?php echo $this->lang->line('address'); ?>" required>
                                    </div>

                                    <div class="row  justify-content-between">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text"  name="zipcode" class="form-control text-center" id="zipcode" value="<?php if(!empty($oldmarketdata)){ echo $oldmarketdata->zipcode; } ?>" placeholder="<?php echo $this->lang->line('zipcode'); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <!-- <select id="inputState" name="city" class="form-control">
                                                    <option>City</option>
                                                    <option selected>City</option>
                                                </select> -->
                                                <input type="text"  name="city" class="form-control" id="city" value="<?php if(!empty($oldmarketdata)){ echo $oldmarketdata->city; } ?>" placeholder="<?php echo $this->lang->line('city'); ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex-wrap w-100 justify-content-between my-2">
                                        <label for="" class="fs-20 fw-700"><?php echo $this->lang->line('locket_map'); ?></label>
                                        <span>
                                            <img width="20" src="<?= base_url() ?>assets/img/icons/location.png" alt="">
                                        </span>
                                    </div>

                                    <div class="form-group form_group_pill p-1">
                                    <!-- <div class="pac-card" id="pac-card"> -->
                                        <!-- <input type="text" class="form-control form-control-sm" id="" placeholder="Search..."> -->
                                        <input id="searchTextField" class="form-control form-control-sm" type="text" value="<?php if(!empty($oldmarketdata)){ echo $oldmarketdata->address; } ?>" placeholder="<?php echo $this->lang->line('search'); ?>..." required />
                                    <!-- </div> -->
                                       
                                        <div id="map" style=""></div>
                                        

                                        <div id="infowindow-content">
                                        <span id="place-name" class="title"></span><br />
                                        <span id="place-address"></span>
                                        </div>
                                    </div> 
                                 
    
                                    

                                  <input type="hidden" id="market_lat" name="market_lat" value="<?php if(!empty($oldmarketdata)){ echo $oldmarketdata->market_lat; } ?>"></p>
                                    <input type="hidden" id="market_long" name="market_long" value="<?php if(!empty($oldmarketdata)){ echo $oldmarketdata->market_long; } ?>"></p>
                                    <!-- <img class="w-100" src="<?= base_url() ?>assets/img/map1.png" alt=""> -->
                               
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="" class="fs-20 fw-700"><?php echo $this->lang->line('description'); ?></label>
                                    <div class="">
                                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="5" onkeyup="recurring_description(<?= $authentication['creator']['description'] ?>)" ><?php if(!empty($oldmarketdata)){ echo $oldmarketdata->description; } ?></textarea>
                                    </div>
                                <!-- </div> -->
                                <!-- <div class="col-sm-6 mb-3"> -->
                                  <!-- </div> -->

                                <!-- <div class="col-sm-6 mb-3"> -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex-wrap w-100 justify-content-between mt-2">
                                                <label for="" class="fs-20 fw-700"><?php echo $this->lang->line('contact'); ?> Person</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="contact_person" value="<?php if(!empty($oldmarketdata)){ echo $oldmarketdata->contact_person; } ?>" class="form-control" id="contact_person" placeholder="<?php echo $this->lang->line('enter_name'); ?>" onkeyup="recurring_contact_info(<?= $authentication['creator']['contact_info'] ?>)">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex-wrap w-100 justify-content-between mt-5">
                                                <label for="" class="fs-20 fw-700"><?php echo $this->lang->line('contact'); ?> <?php echo $this->lang->line('number'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text fs-16 fw-600">+45</span>
                                                    </div>
                                                    <input type="text" name="contact_number" id="contact_number" value="<?php if(!empty($oldmarketdata)){ echo $oldmarketdata->contact_number; } ?>"  class="form-control" placeholder="<?php echo $this->lang->line('enter_phone'); ?>" onkeyup="recurring_contact_info(<?= $authentication['creator']['contact_info'] ?>)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex-wrap w-100 justify-content-between mt-5">
                                                <label for="" class="fs-20 fw-700"><?php echo $this->lang->line('contact'); ?> Email</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="contact_email" id="contact_email" value="<?php if(!empty($oldmarketdata)){ echo $oldmarketdata->contact_email; } ?>" class="form-control" placeholder="<?php echo $this->lang->line('enter_email'); ?>" onkeyup="recurring_contact_info(<?= $authentication['creator']['contact_info'] ?>)">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-6 text-center"></div>
                                <div class="col-6 text-center">
                                    <button type="submit" class="btn btn_brand fw-800 fs-20 px-5 mt-4"><?php echo $this->lang->line('post_now'); ?></button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--================End Create Flea Market Area =================-->


    <?php $this->load->view('front/include/modal'); ?>
    <!--================Footer Area =================-->
    <?php $this->load->view('front/include/footer'); ?>
    <!--================End Footer Area =================-->

    <!-- Optional JavaScript -->
    <?php $this->load->view('front/include/include_script'); ?>
    <script src="<?= base_url() ?>assets/js/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUgsMTFYVt8-AISZoHsjovjufVf4cTS2U&callback=initMap&v=weekly"
      async
    ></script> -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUgsMTFYVt8-AISZoHsjovjufVf4cTS2U&callback=initMap&libraries=places&v=weekly"
      async
    ></script>
    <script type="text/javascript">
       
var previousMarker; // global variable to store previous marker
var latprev = <?=$lat?>;
    function initMap() {
        const myLatlng = { lat: <?=$lat?>, lng: <?=$long?> };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: myLatlng,
           
        });
        if(latprev!=''){
            map.setCenter(myLatlng);
            new google.maps.Marker({
                position: myLatlng,
                map
            });
        }
        if(latprev==''){
        // Create the initial InfoWindow.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };

                // console.log(pos);
                //   infoWindow.setPosition(pos);
                //   infoWindow.setContent("Location found.");
                //   infoWindow.open(map);
                map.setCenter(pos);
                },
                () => {
                //   handleLocationError(true, infoWindow, map.getCenter());
                }
            );
        } else {
        // Browser doesn't support Geolocation
        //   handleLocationError(false, infoWindow, map.getCenter());
        }
        }
        
        $("#map").css("position","unset !important");

        
        map.addListener("click", (mapsMouseEvent) => {
            
            infowindow.close();
            marker.setPosition(null);

            if (previousMarker)
                previousMarker.setMap(null);

            latLng = mapsMouseEvent.latLng.toJSON();
            
            marker.setPosition(null);

            previousMarker = new google.maps.Marker({
                position: latLng,
                map: map
            });
            
            // console.log(latLng);
            $('#market_long').val(mapsMouseEvent.latLng.toJSON().lng);
            $('#market_lat').val(mapsMouseEvent.latLng.toJSON().lat);
            document.getElementById('searchTextField').value = '';
            document.getElementById('address').value = '';
            document.getElementById('city').value = '';
            document.getElementById('zipcode').value = '';
        });

        const card = document.getElementById("pac-card");
        const input = document.getElementById("searchTextField");
        const biasInputElement = '';
        const strictBoundsInputElement = '';
        const options = {
            fields: ["formatted_address", "geometry", "name",'address_components'],
            strictBounds: false,
    // types: ["establishment"],
  };

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

  const autocomplete = new google.maps.places.Autocomplete(input, options);

  // Bind the map's bounds (viewport) property to the autocomplete object,
  // so that the autocomplete requests use the current map bounds for the
  // bounds option in the request.
  autocomplete.bindTo("bounds", map);
  const infowindow = new google.maps.InfoWindow();
  const infowindowContent = document.getElementById("infowindow-content");

  infowindow.setContent(infowindowContent);

  const marker = new google.maps.Marker({
    map,
    anchorPoint: new google.maps.Point(0, -29),
  });

  autocomplete.addListener("place_changed", () => {
    if (previousMarker)
                previousMarker.setMap(null);

    infowindow.close();
    marker.setVisible(false);

    const place = autocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }
    marker.setPosition(null);
    // console.log(place.geometry);
    $('#market_long').val(place.geometry.location.lng);
    $('#market_lat').val(place.geometry.location.lat);

    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    infowindowContent.children["place-name"].textContent = place.name;
    infowindowContent.children["place-address"].textContent =
      place.formatted_address;
    infowindow.open(map, marker);

    // console.log(place.address_components);
    var address = place.formatted_address;
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            var latlng = new google.maps.LatLng(latitude, longitude);
           
            var address =place.formatted_address;
            var pin = place.address_components[place.address_components.length - 1].long_name;
            var city = place.address_components[place.address_components.length - 4].long_name;
            document.getElementById('address').value = address;
            document.getElementById('city').value = city;
            document.getElementById('zipcode').value = pin;
             

  });

  
}


function recurring_description(status) {
    if(status == 0){
        // alert("<?php echo $this->lang->line('upgrade_your_package');?>");
        // $('#exampleFormControlTextarea1').val(' ');
    }
}

function recurring_contact_info(status) {
    if(status == 0){
        // alert("<?php echo $this->lang->line('upgrade_your_package');?>");
        // $('#contact_person').val(' ');
        // $('#contact_number').val(' ');
        // $("#contact_email").val(' ');
    }
}
   
     
    </script>
    <script src="https://cdn.tiny.cloud/1/uoehjg9e6mtefw3mm6lnetzw1xdx6w7w0b3runmvbbugkgeo/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: "#exampleFormControlTextarea1",
    plugins: "emoticons",
    toolbar: "emoticons",
    toolbar_location: "bottom",
    menubar: false,
    statusbar: false
  });
</script>
</body>

</html>
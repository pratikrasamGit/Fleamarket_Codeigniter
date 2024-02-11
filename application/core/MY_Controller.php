<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_Controller extends CI_Controller
{

	public function __construct()
    {
        parent::__construct(); 

        // Load google oauth library
        $this->load->library('google');
		
		// Load facebook oauth library
		$this->load->library('facebook');

        $language = $this->session->userdata('site_lang');
        $language = ($language != "") ? $language : "danish";
        $this->session->set_userdata('site_lang', $language);
    }

	public function checkPackage($user_id)
	{
		echo $user_id;
	}

    public function usersViewerCreator($user_id)
    {
        $viewer = array(
            'search' => 1,
            'max_redius' => 'All',
            'see_picture' => 'All',
            'see_video' => 'All',            
            'contact_visible' => 'All',
            'favorite' => 0
        );

        $creator = array(
            'max_redius' => 20,
            'description' => 0,
            'upload_video' => 0,
            'upload_picture' => 1,
            'contact_info' => 0,
            'recurring_market' => 0,
            'create_table' => 0
        );
        
        $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        $plan_details = $this->db->query($plan_query)->row();
        $is_visible = 0;
        if($plan_details) {
            $is_visible = 1; 
            $expire = strtotime($plan_details->expire_date);
            $today = strtotime("today");
            if($today >= $expire){
                $is_visible = 0;
            } 

            if($is_visible){

                if($plan_details->fk_plan_id == 1){
                    $viewer = array(
                        'search' => 1,
                        'max_redius' => 'All',
                        'see_picture' => 'All',
                        'see_video' => 'All',            
                        'contact_visible' => 'All',
                        'favorite' => 0
                    );
                }

                if($plan_details->fk_plan_id == 2){
                    $viewer = array(
                        'search' => 1,
                        'max_redius' => 'All',
                        'see_picture' => 'All',
                        'see_video' => 'All',            
                        'contact_visible' => 'All',
                        'favorite' => 1
                    );
                }

            }           
        }

        $package_query = "SELECT * FROM rudra_purchased_package where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        $package_details = $this->db->query($package_query)->row();
        $is_package_visible = 0;
        if($package_details) {
            $is_package_visible = 1; 
            $expire = strtotime($package_details->expire_date);
            $today = strtotime("today");
            if($today >= $expire){
                $is_package_visible = 0;
            } 

            if($is_package_visible){

                if($package_details->fk_package_id == 1){
                    $creator = array(
                        'max_redius' => 'All',
                        'description' => 1,
                        'upload_video' => 1,
                        'upload_picture' => 4,
                        'contact_info' => 1,
                        'recurring_market' => 1,
                        'create_table' => 1
                    );
                }

                if($package_details->fk_package_id == 2){
                    $creator = array(
                        'max_redius' => 'All',
                        'description' => 1,
                        'upload_video' => 1,
                        'upload_picture' => 10,
                        'contact_info' => 1,
                        'recurring_market' => 1,
                        'create_table' => 1
                    );
                }

            }           
        }

        return array('viewer' => $viewer, 'creator' => $creator);

    }

	public function getUserInfo($user_id)
	{
		$query = "SELECT * FROM rudra_user where id = $user_id";
        $users = $this->db->query($query)->row();

        $profile_pic = base_url('assets/users/img/noimage.png');
        $email_id = $users->email_id;

        if(!empty($users) && $users->profile_pic != ''){
            $profile_pic = $users->profile_pic;
        }  

        return array('profile_pic' => $profile_pic, 'email_id' => $email_id);
	}

	public function socialLoginLink()
	{
		$google = $this->google->loginURL();
		$facebook =  $this->facebook->login_url();
		return array('google' => $google, 'facebook' => $facebook);
	}

	public function getUserIpAddr(){
	    return $_SERVER['REMOTE_ADDR'];
	}

	public function IPtoLocation($ip){ 
	    $apiURL = 'https://api.ipgeolocation.io/ipgeo?apiKey=f92d7357674f4b44af2db80b7ff15a9e&'.$ip; 
	     
	    // Make HTTP GET request using cURL 
	    $ch = curl_init($apiURL); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	    $apiResponse = curl_exec($ch); 
	    if($apiResponse === FALSE) { 
	        $msg = curl_error($ch); 
	        curl_close($ch); 
	        return false; 
	    } 
	    curl_close($ch); 
	     
	    // Retrieve IP data from API response 
	    $ipData = json_decode($apiResponse, true); 
	     
	    // Return geolocation data 
	    return !empty($ipData)?$ipData:false; 
	}

	public function getDiscover($current_lat, $current_long)
	{
		// $current_lat = $_POST['current_lat'];
  //       $current_long = $_POST['current_long'];
        // $user_id = $_POST['user_id'];
        $current_date = date('Y-m-d');

        // $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        // $plan_details = $this->db->query($plan_query)->row();
        $is_visible = 1;
        // if($plan_details) {
        //     $is_visible = 1; 
        //     $expire = strtotime($plan_details->expire_date);
        //     $today = strtotime("today");
        //     if($today >= $expire){
        //         $is_visible = 0;
        //     }            
        // }

        $enquery = "SELECT *, (6371 * acos (cos (radians($current_lat))* cos(radians(market_lat))* cos( radians($current_long) - radians(market_long) )+ sin (radians($current_lat) )* sin(radians(market_lat)))) AS distance  FROM rudra_market where date(end_date) >= '$current_date' AND status = '1' AND is_deleted = '0' GROUP BY zipcode ORDER BY distance ASC LIMIT 8 ";

        $explore_nearby = $this->db->query($enquery)->result();

        // echo $this->db->last_query();

        $explLists = [];

        foreach ($explore_nearby as $keys => $values) {
            $current_date = date('Y-m-d');
            $exqy = "SELECT * FROM rudra_market where zipcode = '$values->zipcode' AND status = '1' AND is_deleted = '0' AND date(end_date) >= '$current_date'";
            $exlist = $this->db->query($exqy)->result();

            $image_url = '';
            if(count($exlist) > 0){
                $market_id = $exlist[0]->id;
                $query2 = "SELECT * FROM rudra_market_gallery where fk_market_id = $market_id AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $images = $this->db->query($query2)->result();

                if(count($images) == 0){
                    $query21 = "SELECT * FROM rudra_market_gallery where fk_market_id = 0 AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $images1 = $this->db->query($query21)->result();
                    foreach ($images1 as $ikeys => $ivalues) {
                        $image_url = base_url().$ivalues->path.$ivalues->file;
                    }
                }
                else{
                    $image_url = base_url().$images[0]->path.$images[0]->file;
                }
                

                $details = array(
                    'zipcode' => $values->zipcode,
                    'city' => $values->city,
                    'total_market' => count($exlist),
                    'image' => $image_url
                );
                $explLists[] = $details;
            }
            
        }

        // $mquery = "SELECT *, (6371 * acos (cos (radians($current_lat))* cos(radians(market_lat))* cos( radians($current_long) - radians(market_long) )+ sin (radians($current_lat) )* sin(radians(market_lat)))) AS distance  FROM rudra_market where status = '1' AND is_deleted = '0'  ORDER BY distance ASC LIMIT 8";

        $mquery = "SELECT *  FROM rudra_market where status = '1' AND is_deleted = '0' AND is_feature = '1'  ORDER BY updated_on ASC LIMIT 8";

        $market = $this->db->query($mquery)->result();

        $marketList = [];

        foreach ($market as $keys => $values) {

            $today = date("Y-m-d h:i:s");
            $expire = $values->end_date.' '.$values->end_time;

            $today_time = strtotime($today);
            $expire_time = strtotime($expire);

            if ($expire_time > $today_time) {

                $uquery = "SELECT * FROM rudra_user where id = $values->fk_user_id ";
                $users = $this->db->query($uquery)->row();

                if($users->profile_pic != ''){
                    $values->profile_pic = base_url().$users->profile_pic;
                }  

                if($users->profile_pic == null){
                    $values->profile_pic = '';
                } 

                $query2 = "SELECT * FROM rudra_market_gallery where fk_market_id = $values->id AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $images = $this->db->query($query2)->result();

                $image = [];
                foreach ($images as $ikeys => $ivalues) {
                    if ($ikeys == 0) {
                        $ivalues->is_visible = 1;
                    }
                    else{
                       $ivalues->is_visible = $is_visible; 
                    }
                    $ivalues->fullurl = base_url().$ivalues->path.$ivalues->file;
                    $image[] = $ivalues;
                }

                if(count($image) == 0){
                    $query21 = "SELECT * FROM rudra_market_gallery where fk_market_id = 0 AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $images1 = $this->db->query($query21)->result();
                    foreach ($images1 as $ikeys => $ivalues) {
                        $ivalues->is_visible = 1;
                        $ivalues->fullurl = base_url().$ivalues->path.$ivalues->file;
                        $image[] = $ivalues;
                    }
                }

                $query3 = "SELECT * FROM rudra_market_gallery where fk_market_id = $values->id AND  upload_type = '2' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $videos = $this->db->query($query3)->result();

                $video = [];
                foreach ($videos as $vkeys => $vvalues) {
                    $vvalues->is_visible = $is_visible; 
                    $vvalues->fullurl = base_url().$vvalues->path.$vvalues->file;
                    $video[] = $vvalues;
                }

                $query3 = "SELECT * FROM rudra_market_gallery where fk_market_id = $values->id AND  upload_type = '3' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $videosthumb = $this->db->query($query3)->result();

                $videotumb = [];
                foreach ($videosthumb as $vkeys => $vvalues) {
                    $vvalues->fullurl = base_url().$vvalues->path.$vvalues->file;
                    $videotumb[] = $vvalues;
                }

                $query3 = "SELECT * FROM rudra_user_fav_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $fav = $this->db->query($query3)->result();

                // $userId = $_POST['user_id'];
                // $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                // $is_fav = $this->db->query($query4)->row();

                $is_favs = false;

                // if(!empty($is_fav)){
                //     $is_favs = true;
                // }

                $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $share = $this->db->query($query5)->result();

                $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $values->id";
                $catList = $this->db->query($query6)->result();

                $catLists = '';
                foreach ($catList as $ckeys => $cvalues) {
                    if ($ckeys === key($catList)) {
                        $catLists = $cvalues->category_name;
                    }
                    else{
                        $catLists = $catLists .', '. $cvalues->category_name;
                    }                        
                }

                $values->total_favorite = count($fav);
                $values->is_favorite = $is_favs; 
                $values->total_share = count($share);
                $values->categories_name = $catLists;
                $values->images = $image;
                $values->videos = $video;
                $values->videostumb = $videotumb;
                $values->is_contact_show = $is_visible;
                $marketList[] = $values;
            }
        }

        $flea_data_query = "SELECT * FROM rudra_settings where st_key = 'flea_data'";
        $flea_data = $this->db->query($flea_data_query)->row();

        return array('explore_nearby' => $explLists, 'market' => $marketList, 'flea_data' => json_decode($flea_data->dnk_meta)  );
	}

}
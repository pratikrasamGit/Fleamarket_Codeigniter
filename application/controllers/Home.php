<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
	function __construct(){
		parent::__construct();
		
		$social = $this->socialLoginLink();
		$this->email_id  = '';
		$this->log_users_id = 0;
		if (!$this->session->userdata('rudra_users_logged_in'))
        {   
            $this->is_login = false;
            $this->profile_pic = '';
        }
        else
        {
            $details = $this->getUserInfo($this->session->userdata('rudra_users_id'));
            $this->profile_pic = $details['profile_pic'];
            $this->users_id = $this->session->userdata('rudra_users_id');
            $this->is_login = true; 
            $this->email_id = $details['email_id'];
            $this->log_users_id = $this->users_id;
        }

        $this->users_authentication = $this->usersViewerCreator($this->log_users_id);

        $this->ip = $this->getUserIpAddr();
		$this->google = $social['google'];
		$this->facebook =  $social['facebook'];
    }

	public function index()
	{
		$this->session->set_userdata('lang','dnk');
		$locations = $this->IPtoLocation($this->ip);
		$discover = [];

		if(!empty($locations)){
			$discover = $this->getDiscover($locations['latitude'], $locations['longitude']);
		}
		
		$data['discover'] = $discover;
        $data['package'] = $this->gm->get_list('*', 'rudra_package', array());
		$data['plan'] = $this->gm->get_list('*', 'rudra_plan', array());
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;
		$data['categories'] = $this->gm->get_list('*', 'rudra_category_details', array('status' => '1', 'is_deleted' => '0'));
		$current_date = date("Y-m-d");
		$data['markets'] = $this->gm->get_list('*', 'rudra_market', array('status' => '1', 'is_deleted' => '0', 'start_date<=' => $current_date, 'end_date>=' => $current_date));

		$data['city']=$this->input->post('city');
		$data['market_id']=$this->input->post('market_id');
		$data['zipcode']=$this->input->post('zipcode');
		$data['entire_denmark']=$this->input->post('entire_denmark');
		$data['category']=$this->input->post('category');
		$data['range']=$this->input->post('range');
		$data['email_id'] = $this->email_id;
		if($data['range']==''){
			$data['range']=0;
		}
		if($data['category']==''){
			$data['category']=array();
		}
		$this->load->view('front/index', $data);
	}

	public function explore()
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;

		$data['categories'] = $this->gm->get_list('*', 'rudra_category_details', array('status' => '1', 'is_deleted' => '0'));

		$current_date = date("Y-m-d");
		$data['markets'] = $this->gm->get_list('*', 'rudra_market', array('status' => '1', 'is_deleted' => '0', 'start_date<=' => $current_date, 'end_date>=' => $current_date));

		$where=array();
		$data['city']=$this->input->post('city');
		$data['market_id']=$this->input->post('market_id');
		$data['zipcode']=$this->input->post('zipcode');
		$data['entire_denmark']=$this->input->post('entire_denmark');
		$data['category']=$this->input->post('category');
		$data['range']=$this->input->post('range');
		$data['searchText']=$this->input->post('searchText');
		$data['from_date']=$this->input->post('from_date');
		$data['to_date']=$this->input->post('to_date');
		if($data['range']==''){
			$data['range']=0;
		}else{
			// $data['range'] *= 1000;
		}
		if($data['category']==''){
			$data['category']=array();
		}

		// $this->ip = '172.68.39.170';
		$locations = $this->IPtoLocation($this->ip);
		$market_lat = $locations['latitude'];
		$market_long = $locations['longitude'];
		// $market_lat='20.022789';
		// $market_long='79.6779241';

		$is_visible = 1;
		if($this->is_login){
			$plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $this->users_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
			$plan_details = $this->db->query($plan_query)->row();
			$is_visible = 1;
			// if($plan_details) {
			// 	// $data['range']=100;
			// 	$is_visible = 1; 
			// 	$expire = strtotime($plan_details->expire_date);
			// 	$today = strtotime("today");
			// 	if($today >= $expire){
			// 		$is_visible = 0;
			// 		// $data['range']=10;
			// 		// $data['entire_denmark'] = '';
			// 	}            
			// }
		}
		
		$query = "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance FROM rudra_market where status = '1' AND is_deleted = '0' ";


		if($_POST){
			if($this->input->post('searchText') != ""){
				$query = $query .' '. " AND (market_name LIKE '%$data[searchText]%' OR address LIKE '%$data[searchText]%' OR city LIKE '%$data[searchText]%' OR zipcode LIKE '%$data[searchText]%' OR description LIKE '%$data[searchText]%') ";
			}

			if($this->input->post('zipcode') != ""){
				$query = $query .' '. " AND zipcode = '$data[zipcode]' ";
			}

			if($this->input->post('city') != ""){
				$query = $query .' '. " AND city = '$data[city]' ";
			}

			if($this->input->post('market_id')){
					$query = $query .' '. " AND id = $data[market_id] ";
			}                     

			if($this->input->post('from_date') != ""){
				$query = $query .' '. " AND (start_date >= '$data[from_date]'  OR end_date >= '$data[from_date]')  ";
			}
			if($this->input->post('to_date') != ""){
				$query = $query .' '. " AND (start_date <= '$data[to_date]' OR end_date <= '$data[to_date]') ";
			}

			if($this->input->post('category')){
				$cats = '(';
				foreach( $data['category'] as $cat){
					$cats .= $cat.',';
				}
				
				$cats = rtrim($cats,',');
				$cats .= ')'; 
				$query = $query .' '. " AND categories IN $cats ";
			}

			if($is_visible == 1){
				if($data['entire_denmark']==''  && $data['range']>0){
					$query = $query .' '. " HAVING  distance < $data[range] ";
				}
			}
		}

		if($is_visible == 0){
			$query = $query .' '. " HAVING  distance <= 20 ";
		}

		$query = $query .' '." ORDER BY city ASC";
		$marketList = $this->db->query($query)->result();

		// $data['range'] /= 1000;

		// $marketList = $this->gm->getOrderByList('*','rudra_market',$where,array('key' => 'id', 'value' => 'DESC'));
        $marketLists = array();
        foreach ($marketList as $keys => $values) {

        	$today = date("Y-m-d h:i:s");
            $expire = $values->end_date.' '.$values->end_time;

            $today_time = strtotime($today);
            $expire_time = strtotime($expire);

			$values->is_fav_market=0;
			if($this->is_login){
				$chk_data_fav = $this->db->get_where("rudra_user_fav_markets",array('fk_user_id' => $this->users_id, 'fk_market_id' => $values->id, 'status' => '1', 'is_deleted' => '0'))->row();
				if(!empty($chk_data_fav)){
					$values->is_fav_market=1;
				}
			}

            if ($expire_time > $today_time) {
	            $market_image = $this->gm->getOrderByList('*','rudra_market_gallery',array('fk_market_id' => $values->id, 'upload_type' => '1', 'status' => '1', 'is_deleted' => '0'),array('key' => 'id', 'value' => 'DESC'));

	            if(count($market_image) == 0){
                    $query21 = "SELECT * FROM rudra_market_gallery where fk_market_id = 0 AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $images1 = $this->db->query($query21)->result();
                    $dimg = array();
                    foreach ($images1 as $ikeys => $ivalues) {
                        $ivalues->is_visible = 1;
                        $ivalues->fullurl = base_url().$ivalues->path.$ivalues->file;
                        $values->images = $ivalues;
                        $dimg[] = $ivalues;
                    }
                    $values->images = $dimg;
                }
                else{
                	$im = array();
                	foreach ($market_image as $imkeys => $imvalues) {
                		$imvalues->fullurl = base_url().$imvalues->path.$imvalues->file;
                		$im[] = $imvalues;
                	}

                	$values->images = $im;
                }
	            
	            $marketLists[] = $values;
	        }
        }
        $data['market'] = $marketLists;
		$this->load->view('front/explore', $data);
	}

	public function market($id)
	{
		$where = array('id' => $id);
		$market = $this->gm->get_details('*','rudra_market',$where);
		
		if(!empty($market)){
			$today = date("Y-m-d h:i:s");
            $expire = $market->end_date.' '.$market->end_time;

            $today_time = strtotime($today);
            $expire_time = strtotime($expire);

            if ($expire_time > $today_time) {
	            $market_image = $this->gm->getOrderByList('*','rudra_market_gallery',array('fk_market_id' => $market->id, 'upload_type' => '1', 'status' => '1', 'is_deleted' => '0'),array('key' => 'id', 'value' => 'DESC'));

	            if(count($market_image) == 0){
                    $query21 = "SELECT * FROM rudra_market_gallery where fk_market_id = 0 AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $images1 = $this->db->query($query21)->result();
                    $dimg = array();
                    foreach ($images1 as $ikeys => $ivalues) {
                        $ivalues->is_visible = 1;
                        $ivalues->fullurl = base_url().$ivalues->path.$ivalues->file;
                        $market->images = $ivalues;
                        $dimg[] = $ivalues;
                    }
                    $market->images = $dimg;
                }
                else{
                	$im = array();
                	foreach ($market_image as $imkeys => $imvalues) {
                		$imvalues->fullurl = base_url().$imvalues->path.$imvalues->file;
                		$im[] = $imvalues;
                	}

                	$market->images = $im;
                }

				$market->is_fav_market=0;
				if($this->is_login){
					$chk_data_fav = $this->db->get_where("rudra_user_fav_markets",array('fk_user_id' => $this->users_id, 'fk_market_id' => $market->id, 'status' => '1', 'is_deleted' => '0'))->row();
					if(!empty($chk_data_fav)){
						$market->is_fav_market=1;
					}
				}

                $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name, rudra_category_details.dnk_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $market->id";
                $catList = $this->db->query($query6)->result();
                
                $market->category_list = $catList;

				$data['large_table'] = $this->db->get_where("rudra_rent_space",array( 'fk_market_id' => $id, 'table_type' => 'Large'))->row();
				$data['medium_table'] = $this->db->get_where("rudra_rent_space",array( 'fk_market_id' => $id, 'table_type' => 'Medium'))->row();
				$data['small_table'] = $this->db->get_where("rudra_rent_space",array('fk_market_id' => $id, 'table_type' => 'Small'))->row();

				$query = "SELECT SUM(rudra_rent_space_purchased.table_no) as total_table FROM rudra_rent_space_purchased inner join rudra_rent_space on rudra_rent_space.id=rudra_rent_space_purchased.fk_rent_space_id where rudra_rent_space.fk_market_id = $id AND rudra_rent_space.status = '1' AND rudra_rent_space.is_deleted = '0'";
				$data['total_tables_booked'] = $this->db->query($query)->row()->total_table;

				$queryl = "SELECT SUM(rudra_rent_space_purchased.table_no) as total_table FROM rudra_rent_space_purchased inner join rudra_rent_space on rudra_rent_space.id=rudra_rent_space_purchased.fk_rent_space_id where rudra_rent_space.fk_market_id = $id AND rudra_rent_space_purchased.table_type = 'Large' AND rudra_rent_space.status = '1' AND rudra_rent_space.is_deleted = '0'";
				$data['total_tables_booked_large'] = $this->db->query($queryl)->row()->total_table;

				$querys = "SELECT SUM(rudra_rent_space_purchased.table_no) as total_table FROM rudra_rent_space_purchased inner join rudra_rent_space on rudra_rent_space.id=rudra_rent_space_purchased.fk_rent_space_id where rudra_rent_space.fk_market_id = $id AND rudra_rent_space_purchased.table_type = 'Small' AND rudra_rent_space.status = '1' AND rudra_rent_space.is_deleted = '0'";
				$data['total_tables_booked_small'] = $this->db->query($querys)->row()->total_table;

				$querym = "SELECT SUM(rudra_rent_space_purchased.table_no) as total_table FROM rudra_rent_space_purchased inner join rudra_rent_space on rudra_rent_space.id=rudra_rent_space_purchased.fk_rent_space_id where rudra_rent_space.fk_market_id = $id AND rudra_rent_space_purchased.table_type = 'Medium' AND rudra_rent_space.status = '1' AND rudra_rent_space.is_deleted = '0'";
				$data['total_tables_booked_medium'] = $this->db->query($querym)->row()->total_table;
	            
	            $data['market'] = $market;
	            $data['loginURL'] = $this->google;
				$data['authURL'] = $this->facebook;
				$data['is_login'] = $this->is_login;
				$data['profile_pic'] = base_url().$this->profile_pic;
				$data['email_id'] = $this->email_id;

				$is_visible=0;
				if($this->is_login){
					$plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $this->users_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
					$plan_details = $this->db->query($plan_query)->row();
					$is_visible = 1;
					// if($plan_details) {
					// 	$is_visible = 1; 
					// 	$expire = strtotime($plan_details->expire_date);
					// 	$today = strtotime("today");
					// 	if($today >= $expire){
					// 		$is_visible = 0;
					// 	}            
					// }
				}
				$data['is_visible'] = $is_visible;

				$fkuser = $market->fk_user_id;
				$market_user_query = "SELECT * FROM rudra_user where id = $fkuser ";
        		$data['market_user'] = $this->db->query($market_user_query)->row();
				
				$this->load->view('front/details', $data);
	        }
	        else{
				redirect(base_url(), 'refresh');
			}
		}
		else{
			redirect(base_url(), 'refresh');
		}

	}

	public function recuring()
	{
		$current_date = date('Y-m-d');
		$query = "SELECT * FROM rudra_market where (recurring_type = '1' OR recurring_type = '2') AND date(end_date) = '$current_date'";

		$market_list = $this->db->query($query)->result();

		foreach ($market_list as $mkeys => $mvalues) {
			$package = $this->packageCheck($mvalues->fk_user_id);
			if($package){
				$extend_date = date('Y-m-d', strtotime('+7 days'));
				if($mvalues->recurring_type == '2'){
					$extend_date = date('Y-m-d', strtotime('+1 months'));
				}

				$recuringHistory = array(
					'fk_user_id'       => $mvalues->fk_user_id,
					'fk_market_id'     => $mvalues->id,
					'recuring_type'    => $mvalues->recurring_type,
					'rh_previous_date' => $mvalues->end_date,
					'rh_recuring_date' => $extend_date
				);
				$this->db->insert("rudra_recuring_history",$recuringHistory);

				$recuringUpdate = array(
					'end_date' => $extend_date
				);
                
                $this->db->where('id',$mvalues->id);
                $this->db->update("rudra_market",$recuringUpdate);
			}
		}
	}

	public function packageCheck($user_id)
	{
		$package_query = "SELECT * FROM rudra_purchased_package where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        $package_details = $this->db->query($package_query)->row();
        $is_visible = 0;
        if($package_details) {
            $is_visible = 1; 
            $expire = strtotime($package_details->expire_date);
            $today = strtotime("today");
            if($today >= $expire){
                $is_visible = 0;
            }            
        }

        return $is_visible;
	}
	
	public function details()
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;
		$this->load->view('front/details', $data);
	}
	public function share_link($id=null)
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;
		$data['market_id'] = $id;
		$this->load->view('front/share_link', $data);
	}

	public function resetPassword($token)
	{
		$details = $this->gm->get_details('*', 'rudra_user', array('password_token' => $token));
        if($details) {
			$data['loginURL'] = $this->google;
			$data['authURL'] = $this->facebook;
			$data['is_login'] = $this->is_login;
			$data['profile_pic'] = $this->profile_pic;
			$data['token'] = $token;
			$this->load->view('front/reset_password', $data);
		}
		else{
			redirect(base_url(), 'refresh');
		}
	}

	public function updatePassword()
	{
		$details = $this->gm->get_details('*', 'rudra_user', array('password_token' => $_POST['token']));
        if($details){
        	$token = sha1(mt_rand(1, 90000) . 'SALT');

            $updatedata = array(
                'password'       => sha1($_POST['fw_reset_password']),
                'password_token' => $token
            );

			$this->db->where('id',$details->id);
			$this->db->update("rudra_user",$updatedata);

            echo json_encode(array('response' => true, 'msg' => 'Password changed successfully'));
            exit;
        } 
        else {
            echo json_encode(array('response' => false, 'msg' => 'Something went wrong.'));
            exit;
        }
	}

	public function resetPasswordLink()
	{
		$details = $this->gm->get_details('*', 'rudra_user', array('email_id' => $_POST['fw_reset_password_link_email'], 'social_type' => 'email'));

        if($details){

            $token = sha1(mt_rand(1, 90000) . 'SALT');
            $pass = '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'; 

            $url = 'https://api.sendgrid.com/';
            $data['token'] = $token;
            $html = $this->load->view("email/forgot", $data, TRUE);

            //remove the user and password params - no longer needed
            $params = array(
                'to'        => $_POST['fw_reset_password_link_email'],     
                'subject'   => 'Forgot Password',
                'html'      => $html,
                'from'      => 'no-reply@loppekortet.dk',
            );

            $request =  $url.'api/mail.send.json';
            $headr = array();
            // set authorization header
            $headr[] = 'Authorization: Bearer '.$pass;

            $session = curl_init($request);
            curl_setopt ($session, CURLOPT_POST, true);
            curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
            curl_setopt($session, CURLOPT_HEADER, false);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

            // add authorization header
            curl_setopt($session, CURLOPT_HTTPHEADER,$headr);

            $response = curl_exec($session);
            curl_close($session);

            $updatedata = array(
                'password_token' => $token
            );

            $this->db->where('id',$details->id);
            $this->db->update("rudra_user",$updatedata);

            $msg = 'Sent reset password link on register email';
            if($this->session->userdata('site_lang') == 'danish'){
				$msg = 'Link til nulstilling af adgangskode er sendt til den registret e-mail';
			}

            echo json_encode(array('response' => true, 'msg' => $msg));
            exit;
        }
        else{

            echo json_encode(array('response' => false, 'msg' => 'Something went wrong.'));
            exit;

        } 
	}

	public function create_flea_market($id = null)
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;

        $data['categories'] = $this->gm->get_list('*', 'rudra_category_details', array('status' => '1', 'is_deleted' => '0'));
		$data['market_id'] = $id;

		$data['marketdata'] = array();
		$data['cats'] = array();
		$data['market_gallery']	= array();
		if($id){
			if($this->is_login){
			$data['marketdata'] = $this->db->get_where("rudra_market",array('id' => $id, 'fk_user_id' => $this->users_id))->row();
			if($data['marketdata']){
				$market_gallery	 = $this->db->get_where("rudra_market_gallery",array('fk_market_id' => $id, 'is_deleted' => '0', 'status' => '1', 'upload_type' => '1'))->result();

				$market_gallerys = array();
				foreach ($market_gallery as $keys => $values) {
					$market_gallerys[] = array('id' => $keys, 'src' => base_url().'uploads/market/'.$values->file);
				}
				$data['market_gallery'] = json_encode($market_gallerys);

				$market_gallery1	 = $this->db->get_where("rudra_market_gallery",array('fk_market_id' => $id, 'is_deleted' => '0', 'status' => '1', 'upload_type' => '2'))->result();

				$market_gallerys1 = array();
				foreach ($market_gallery1 as $keys => $values) {
					$market_gallerys1[] = array('id' => $keys, 'src' => base_url().'uploads/market/'.$values->file);
				}

				$data['market_gallery_video'] = json_encode($market_gallerys1);
			
				$data['cats'] =  explode(',',$data['marketdata']->categories);
			}else{
				redirect(base_url().'market/'.$id, 'refresh');
			}
			
			}else{
				redirect(base_url().'market/'.$id, 'refresh');
			}
		} else{

			$data['market_gallery'] = json_encode(array());
			$data['market_gallery_video'] = json_encode(array());
		}


		if($_POST){
			
			$start_date=date_create($_POST['start_date']);
			$start_date = date_format($start_date,"Y-m-d");

			$end_date=date_create($_POST['end_date']);
			$end_date = date_format($end_date,"Y-m-d");

			$start_time = date("H:i", strtotime($_POST['start_time']));
			$end_time = date("H:i", strtotime($_POST['end_time']));

			$categories='';
			if(!empty($_POST['categories'])){
				foreach($_POST['categories'] as $value){
					$categories .= $value.',';
				}
			}
			$categories = rtrim($categories, ',');

			$categories_list = ($categories) ? $categories : '';

			// $deleted = rtrim($_POST['deleted'], ',');

			$market_id = $_POST['market_id'];
			$updateArray = 
				array(
				 'fk_user_id' => $this->session->userdata('rudra_users_id'),
				 'market_name' => $this->input->post('market_name',true),
				 'categories' => $categories_list,
				 'start_date' => $start_date,
				 'end_date' => $end_date,
				 'start_time' => $start_time,
				 'end_time' => $end_time,
				 'market_id' => $market_id,
				 'recurring_type' => $this->input->post('its_recurring',true)
				);
			
			$marketData = $updateArray;

                // $this->db->insert('rudra_market',$updateArray);
                // $id = $this->db->insert_id();
			
				$cnt = 1;
				$marketData['imagedata'] =array();
                    foreach($_FILES['images']['name'] as $key => $names)
					{					
						$_FILES['file']['name']     = $names; 
						$_FILES['file']['type']     = $_FILES['images']['type'][$key]; 
						$_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$key]; 
						$_FILES['file']['error']     = $_FILES['images']['error'][$key]; 
						$_FILES['file']['size']     = $_FILES['images']['size'][$key]; 
								
				        // File upload configuration 
						$uploadPath = 'uploads/market/'; 
						$config['upload_path'] = $uploadPath; 
						$config['allowed_types'] = '*';
						$config['encrypt_name'] = TRUE; 
								
						// Load and initialize upload library 
						$this->load->library('upload', $config); 
						$this->upload->initialize($config); 
						
						if(strstr($_FILES['images']['type'][$key] , "video/")){
							$upload_type=2;
						}else{
							$upload_type=1;
						}
						// Upload file to server 
						if($this->upload->do_upload('file'))
						{ 
							// Uploaded file data 
							$fileData = $this->upload->data(); 

							$insert_array = array(
                                // 'fk_market_id' => $id,
                                'file' => $fileData['file_name'],
                                'path' => $uploadPath,
                                'fullpath' => base_url().$uploadPath,
                                'upload_type' => $upload_type,
                            );

							$marketData['imagedata'][] = $insert_array;

                            $cnt++;
							// $this->db->insert('rudra_market_gallery',$insert_array);		
						}
							
					}

					if(!empty($_FILES['file']['name'])){
						$bannerpath = 'uploads/market';
	                    $thumbpath = 'uploads/market';
	                    $config['upload_path'] = $bannerpath;
	                    $config['allowed_types'] = '*';
	                    $config['encrypt_name'] = TRUE;
	                    $this->load->library('upload', $config);
	                    $this->upload->initialize($config);
	                    $upload_type=2;
							// Upload file to server 
						if($this->upload->do_upload('file'))
						{ 
							// Uploaded file data 
							$fileData = $this->upload->data(); 

							$insert_array = array(
                                // 'fk_market_id' => $id,
                                'file' => $fileData['file_name'],
                                'path' => $uploadPath,
                                'fullpath' => base_url().$uploadPath,
                                'upload_type' => $upload_type,
                            );

							// $marketData['imagedata'][] = $insert_array;

                            $cnt++;
							// $this->db->insert('rudra_market_gallery',$insert_array);		
						}
					}
					// if($id){
						// redirect(base_url("create-flea-market-step-2/".$id));
					// }
					$data['marketData'] = $marketData;
					$locations = $this->IPtoLocation($this->ip);
					$data['lat'] = $locations['latitude'];
					$data['long'] = $locations['longitude'];
					$data['oldmarketdata'] = array();
					if($market_id){
						$data['oldmarketdata'] = $this->db->get_where("rudra_market",array('id' => $market_id))->row();
						$data['lat'] = ($data['oldmarketdata']) ? $data['oldmarketdata']->market_lat : '';
						$data['long'] = ($data['oldmarketdata']) ? $data['oldmarketdata']->market_long : '';
					}
					$data['authentication'] = $this->users_authentication;

					$this->load->view('front/create_flea_market_step3', $data);
					

		}else{

			$recuring_allowed = 0;
			if($this->is_login){
				$recuring_allowed = $this->packageCheck($this->users_id);
			}
			
			$data['authentication'] = $this->users_authentication;
			$data['recuring_allowed'] = $recuring_allowed;
			$this->load->view('front/create_flea_market', $data);
		}
	}

	public function create_flea_market_step2()
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;

		if($_POST){
			$formdata=$_POST;
			$imagedata = unserialize($formdata['imagedata']);
			unset($formdata['imagedata']);
			$market_id = $formdata['market_id'];
			unset($formdata['market_id']);
			// $deleted = $formdata['deleted'];
			// unset($formdata['deleted']);

			// $updateArray =   array(
			// 	'is_deleted' => '1'
			// );

			// $this->db->where('fk_market_id',$market_id);
			// $this->db->update("rudra_market_gallery",$updateArray);

			// if($deleted){
			// 	$deleted = explode(',',$deleted);
			// 	foreach($deleted as $value){
			// 		$updateArray =   array(
			// 			'is_deleted' => '1'
			// 		);

			// 		$this->db->where('id',$value);
			// 		$this->db->update("rudra_market_gallery",$updateArray);
			// 	}
			// }

			if($market_id){
				$formdata['status'] = '0';
					$formdata['updated_on'] = date("Y-m-d h:i:sa");
					$this->db->where('id',$market_id);
					$this->db->update("rudra_market",$formdata);
					$id = $market_id;
			}else{
				
			 	$this->db->insert('rudra_market',$formdata);
                $id = $this->db->insert_id();
			}

			$categories = explode(',',$formdata['categories']);

			$common_ids = array();
			$m_cat = $this->db->get_where('rudra_market_category',array('fk_market_id' => $id))->result();
            if(!empty($categories) && empty($m_cat))
            {
                foreach($categories as $int => $intv)
                {
                    $this->db->insert('rudra_market_category',array('fk_market_id' => $id,'fk_category_id'=>$intv));
                }
            }
            elseif(!empty($m_cat))
            {
                foreach($m_cat as $uint)
                {
                    if(!in_array($uint->fk_category_id,$categories))
                    {
                        $this->db->where('id',$uint->id);
                        $this->db->delete('rudra_market_category');
                    }
                    else
                    {
                        $common_ids[] = $uint->fk_category_id;   
                    }
                }
                foreach($categories as $int => $intv)
                {
                    if(!in_array($intv,$common_ids))
                    {
                        $this->db->insert('rudra_market_category',array('fk_market_id' => $id,'fk_category_id'=>$intv));
                    }
                  
                }
            }

			foreach($imagedata as $image){

				$insert_array = array(
					'fk_market_id' => $id,
					'file' => $image['file'],
					'path' => $image['path'],
					'fullpath' => $image['fullpath'],
					'upload_type' => $image['upload_type'],
				);

				$this->db->insert('rudra_market_gallery',$insert_array);	

			}
				
			$this->session->set_flashdata('market_create_message', 'Successfully');

			redirect(base_url("users/my-market"));
		}else{

		// $this->load->view('front/create_flea_market_step2', $data);
		// $this->load->view('front/create_flea_market_step3', $data);
		redirect(base_url("create-flea-market"));
		}
	}
	public function create_flea_market_step3()
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;
		$this->load->view('front/create_flea_market_step3', $data);
	}
	public function map_view()
	{
		
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;

		$locations = $this->IPtoLocation($this->ip);
		
		$discover = $this->getDiscover($locations['latitude'], $locations['longitude']);
		$data['discover'] = $discover;
		$data['lat'] = $locations['latitude'];
		$data['long'] = $locations['longitude'];
		// $data['lat'] = '55.060661';
		// $data['long'] = '10.5974742';
		$data['categories'] = $this->gm->get_list('*', 'rudra_category_details', array('status' => '1', 'is_deleted' => '0'));

		$current_date = date("Y-m-d");
		// $data['markets'] = $this->gm->get_list('*', 'rudra_market', array('status' => '1', 'is_deleted' => '0', 'start_date<=' => $current_date, 'end_date>=' => $current_date));
		$data['markets'] = $this->gm->get_list('*', 'rudra_market', array('status' => '1', 'is_deleted' => '0'));
		$marketdata = array();
        foreach ($data['markets']  as $keys => $values) {
			$today = date("Y-m-d h:i:s");
            $expire = $values->end_date.' '.$values->end_time;

            $today_time = strtotime($today);
            $expire_time = strtotime($expire);
			if ($expire_time > $today_time) {
				$marketdata[] = $values;
	        }
		}
		$data['markets'] = $marketdata;
		$where=array();
		$data['city']=$this->input->post('city');
		$data['market_id']=$this->input->post('market_id');
		$data['zipcode']=$this->input->post('zipcode');
		$data['entire_denmark']=$this->input->post('entire_denmark');
		$data['category']=$this->input->post('category');
		$data['range']=$this->input->post('range');
		$data['searchText']=$this->input->post('searchText');
		$data['date_from']=$this->input->post('date_from');
		$data['date_to']=$this->input->post('date_to');
		$data['time_from']=$this->input->post('time_from');
		$data['time_to']=$this->input->post('time_to');
		if($data['range']==''){
			$data['range']=100;
		}else{
			// $data['range'] = 100;
		}
		if($data['category']==''){
			$data['category']=array();
		}

		$market_lat = $locations['latitude'];
		$market_long = $locations['longitude'];
		// $market_lat = '55.060661';
		// $market_long = '10.5974742';

		$is_visible = 1;
		if($this->is_login){
			$plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $this->users_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
			$plan_details = $this->db->query($plan_query)->row();
			$is_visible = 1;
			// if($plan_details) {
			// 	// $data['range']=100;
			// 	$is_visible = 1; 
			// 	$expire = strtotime($plan_details->expire_date);
			// 	$today = strtotime("today");
			// 	if($today >= $expire){
			// 		$is_visible = 0;
			// 		// $data['range']=10;
			// 		// $data['entire_denmark'] = '';
			// 	}            
			// }
		}
		
		$query = "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance FROM rudra_market where status = '1' AND is_deleted = '0' AND market_lat!='' AND  market_long!='' ";


		if($_POST){
			
			if($this->input->post('searchText') != ""){
				$query = $query .' '. " AND (market_name LIKE '%$data[searchText]%' OR address LIKE '%$data[searchText]%' OR city LIKE '%$data[searchText]%' OR zipcode LIKE '%$data[searchText]%') ";
				$data['entire_denmark']=1;
			}

			if($this->input->post('zipcode') != ""){
				$query = $query .' '. " AND zipcode = '$data[zipcode]' ";
			}

			if($this->input->post('city') != ""){
				$query = $query .' '. " AND city = '$data[city]' ";
			}

			if($this->input->post('market_id')){
					$query = $query .' '. " AND id = $data[market_id] ";
			}                    


			if($this->input->post('date_from') != ""){
				$query = $query .' '. " AND (start_date >= '$data[date_from]'  OR end_date >= '$data[date_from]')  ";
			}
			if($this->input->post('date_to') != ""){
				$query = $query .' '. " AND (start_date <= '$data[date_to]' OR end_date <= '$data[date_to]') ";
			}

			if($this->input->post('time_from') != ""){
				$query = $query .' '. " AND (start_time >= '$data[time_from]'  OR end_time >= '$data[time_from]')  ";
			}
			if($this->input->post('time_to') != ""){
				$query = $query .' '. " AND (start_time <= '$data[time_to]' OR end_time <= '$data[time_to]') ";
			}




			if($this->input->post('category')){
				$cats = '(';
				foreach( $data['category'] as $cat){
					$cats .= $cat.',';
				}
				
				$cats = rtrim($cats,',');
				$cats .= ')'; 
				$query = $query .' '. " AND categories IN $cats ";
			}

			
			if($data['entire_denmark']==''  && $data['range']>0){
					$query = $query .' '. " HAVING  distance <= $data[range] ";
			}

			
		}else{
			// $query = $query .' '. " HAVING  distance <= $data[range] ";
			$data['entire_denmark'] = 1;
		}

		if($is_visible == 0){
			$query = $query .' '. " HAVING  distance <= 20 ";
		}

		$query = $query .' '." ORDER BY distance asc"; 
		$marketList = $this->db->query($query)->result();
		// print_r($this->db->last_query());
		// exit;

		// $marketList = $this->gm->getOrderByList('*','rudra_market',$where,array('key' => 'id', 'value' => 'DESC'));
        $marketLists = array();
        foreach ($marketList as $keys => $values) {

        	$today = date("Y-m-d h:i:s");
            $expire = $values->end_date.' '.$values->end_time;

            $today_time = strtotime($today);
            $expire_time = strtotime($expire);

			$values->is_fav_market=0;
			if($this->is_login){
				$chk_data_fav = $this->db->get_where("rudra_user_fav_markets",array('fk_user_id' => $this->users_id, 'fk_market_id' => $values->id, 'status' => '1', 'is_deleted' => '0'))->row();
				if(!empty($chk_data_fav)){
					$values->is_fav_market=1;
				}
			}

            if ($expire_time > $today_time) {
	            $market_image = $this->gm->getOrderByList('*','rudra_market_gallery',array('fk_market_id' => $values->id, 'upload_type' => '1', 'status' => '1', 'is_deleted' => '0'),array('key' => 'id', 'value' => 'DESC'));

	            if(count($market_image) == 0){
                    $query21 = "SELECT * FROM rudra_market_gallery where fk_market_id = 0 AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $images1 = $this->db->query($query21)->result();
                    $dimg = array();
                    foreach ($images1 as $ikeys => $ivalues) {
                        $ivalues->is_visible = 1;
                        $ivalues->fullurl = base_url().$ivalues->path.$ivalues->file;
                        $values->images = $ivalues;
                        $dimg[] = $ivalues;
                    }
                    $values->images = $dimg;
                }
                else{
                	$im = array();
                	foreach ($market_image as $imkeys => $imvalues) {
                		$imvalues->fullurl = base_url().$imvalues->path.$imvalues->file;
                		$im[] = $imvalues;
                	}

                	$values->images = $im;
                }
	           
	            $marketLists[] = $values;
	        }
        }
		if($marketList && $_POST){
			$data['lat'] = $marketList[0]->market_lat;
			$data['long'] = $marketList[0]->market_long;
		}
        $data['market'] = $marketLists;
		$this->load->view('front/map_view', $data);
	}
	public function faqs()
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;

		$faq_query = "SELECT * FROM rudra_settings where st_key = 'faq'";
		$faq = $this->db->query($faq_query)->row();

		
		if($this->session->userdata('site_lang') == 'danish'){
			$data['faq'] =json_decode($faq->dnk_meta);
		}else{
			$data['faq'] =json_decode($faq->st_meta);
		}

		$this->load->view('front/faqs', $data);
	}
	public function terms_conditions()
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;

		$terms_query = "SELECT * FROM rudra_settings where st_key = 'termsofservices'";
		
		if($this->session->userdata('site_lang') == 'danish'){
			$data['terms'] = $this->db->query($terms_query)->row()->dnk_meta;
		}else{
			$data['terms'] = $this->db->query($terms_query)->row()->st_meta;
		}
		$this->load->view('front/terms_conditions', $data);
	}
	public function priacy_policy()
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;
		$privacypolicy_query = "SELECT * FROM rudra_settings where st_key = 'privacypolicy'";
		if($this->session->userdata('site_lang') == 'danish'){
			$data['privacypolicy'] = $this->db->query($privacypolicy_query)->row()->dnk_meta;
		}else{
			$data['privacypolicy'] = $this->db->query($privacypolicy_query)->row()->st_meta;
		}
		

		$this->load->view('front/priacy_policy', $data);
	}
	public function priacyPolicy($lang)
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;
		$langs = 'english';
		if($lang == 'dk'){
			$langs = 'danish';
		}
		$this->session->set_userdata('site_lang', $langs);
		$privacypolicy_query = "SELECT * FROM rudra_settings where st_key = 'privacypolicy'";
		if($lang == 'dk'){
			$data['heading']  = 'Fortrolighedspolitik';
			$data['privacypolicy'] = $this->db->query($privacypolicy_query)->row()->dnk_meta;
		}else{
			$data['heading']  = 'Privacy Policy';
			$data['privacypolicy'] = $this->db->query($privacypolicy_query)->row()->st_meta;
		}
		

		$this->load->view('front/priacy_policy', $data);
	}
	
	public function about()
	{
		$data['loginURL'] = $this->google;
		$data['authURL'] = $this->facebook;
		$data['is_login'] = $this->is_login;
		$data['profile_pic'] = $this->profile_pic;

		$aboutus_query = "SELECT * FROM rudra_settings where st_key = 'aboutus'";
		$data['aboutus'] = $this->db->query($aboutus_query)->row();

		$howitworks_query = "SELECT * FROM rudra_settings where st_key = 'howitworks'";
		$howitworks= $this->db->query($howitworks_query)->row();

		$flea_data_query = "SELECT * FROM rudra_settings where st_key = 'flea_data'";
		$flea_data = $this->db->query($flea_data_query)->row();

		$questions_data_query = "SELECT * FROM rudra_settings where st_key = 'questions'";
		$questions_data = $this->db->query($questions_data_query)->row();

		if($this->session->userdata('site_lang') == 'danish'){
			$st=json_decode($howitworks->dnk_meta);
		}else{
			$st=json_decode($howitworks->st_meta);
		}
		$data['howitworks'] = $st;

		if($this->session->userdata('site_lang') == 'danish'){
			$st1=json_decode($flea_data->dnk_meta);
		}else{
			$st1=json_decode($flea_data->st_meta);
		}
		$data['flea_data'] = $st1->description;

		if($this->session->userdata('site_lang') == 'danish'){
			$st3=$questions_data->dnk_meta;
		}else{
			$st3=$questions_data->st_meta;
		}
		$data['questions_data'] = $st3;
			
		$this->load->view('front/about', $data);
	} 

	function submit_favorite(){

		$market_id = $this->input->post('id');
		$users_id = $this->session->userdata('rudra_users_id');

        $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $users_id AND fk_plan_id = 2 AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        $plan_details = $this->db->query($plan_query)->row();
        $message = '';
        $is_visible = 1;
        // if($plan_details) {
        //     $is_visible = 1; 
        //     $expire = strtotime($plan_details->expire_date);
        //     $today = strtotime("today");
        //     if($today >= $expire){
        //         $is_visible = 0;   
        //     }            
        // }

        if($is_visible){
			$chk_data_own = $this->db->get_where("rudra_market",array('fk_user_id' => $users_id, 'id' => $market_id))->row();

			if(empty($chk_data_own)){

				$chk_data = $this->db->get_where("rudra_user_fav_markets",array('fk_user_id' => $users_id, 'fk_market_id' => $market_id))->row();

				if(empty($chk_data))
				{
					$updateArray =   array(
						'fk_user_id' => $users_id,
						'fk_market_id' => $market_id
					);

					$this->db->insert("rudra_user_fav_markets",$updateArray);
					echo "success";
				}
				else
				{
					if($chk_data->status == '0') {
						$updateArray =   array(
							'status' => '1'
						);

						$this->db->where('id',$chk_data->id);
						$this->db->update("rudra_user_fav_markets",$updateArray);
						echo "success";
					}
					else{
						$updateArray =   array(
							'status' => '0'
						);
		
						$this->db->where('id',$chk_data->id);
						$this->db->update("rudra_user_fav_markets",$updateArray);
						echo "successfully removed";
					}
						
				}

				// echo "success";

			}else{
				echo "failed";
			}
		}
		else{
			echo "upgrade";
		}

	}

	public function pj_privacy_policy()
	{
		echo "Privacy Policy";
	}

	public function pj_terms()
	{
		echo "Terms";
	}

	public function pj_user_data_policy()
	{
		echo "User Data Policy";
	}


	public function delete_gallery(){

		$fullpath=$this->input->post('fullpath');

		$path = base_url().'/uploads/market/';

		$file = ltrim($fullpath, $path);

		$patharray = explode('/',$fullpath);

		$myLastElement = end($patharray);


		$this->db->where('file',$myLastElement);
		$this->db->delete('rudra_market_gallery');

		echo $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/market/'.$myLastElement;

		unlink($path);

		// print_r($this->db->last_query());
	}
}

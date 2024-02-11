
<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Rudra_market_apis extends CI_Controller
{                   
    private $api_status = false;
	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->bdp = $this->db->dbprefix;
        $this->table = 'rudra_market';
		$this->msg = 'input error';
		$this->return_data = array();
        $this->chk = 0;
		//$this->load->model('global_model', 'gm');
        $this->load->model('rudra_market_rudra_model','rudram');
		$this->set_data();
	}
	public function set_data()
    {
        $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->json_output(200,array('status' => 200,'api_status' => false,'message' => 'Bad request.'));exit;
		} 
		
        /*
        $api_key = $this->db->get_where($this->bdp.'app_setting',array('meta_key' =>'rudra_key'))->row();
        $api_password =  $this->input->post('api_key',true);
        if (MD5($api_key->meta_value) == $api_password) {

            $this->api_status = true;
          
        } else {
           
		json_encode(array('status' => 505,'message' => 'Enter YourgMail@gmail.com to get access.', 'data' => array() ));
		  exit;
		  
          
        }
        */
    }

    /***********************Page Route
     //rudra_market API Routes
	$t_name = 'auto_scripts/Rudra_market_apis/';
    
	$route[$api_ver.'market/(:any)'] = $t_name.'rudra_rudra_market/$1';

    **********************************/
    function json_output($statusHeader,$response)
	{
		$ci =& get_instance();
		$ci->output->set_content_type('application/json');
		$ci->output->set_status_header($statusHeader);
		$ci->output->set_output(json_encode($response));
	}

    public function index()
	{
		$this->json_output(200,array('status' => 200,'api_status' => false,'message' => 'Bad request.'));
	}

    public function rudra_rudra_market($param1)
    {
        $call_type = $param1;
        $res = array();
        if($call_type == 'put')
        {            
            $res = $this->rudra_save_data($_POST);        
        }
        elseif($call_type == 'category_list')
        {
            $res = $this->rudra_category_list_data($_POST);        
        }
        elseif($call_type == 'final_step')
        {           
            $res = $this->rudra_update_data($_POST);        
        }
        elseif($call_type == 'get')
        {
            $res = $this->rudra_get_data($_POST);        
        }
        elseif($call_type == 'paged_data')
        {
            $res = $this->rudra_paged_data($_POST);        
        }
        elseif($call_type == 'setting_list')
        {
            $res = $this->rudra_setting_list_data($_POST);        
        }
        elseif($call_type == 'delete')
        {
            $res = $this->rudra_delete_data($_POST);        
        }
        elseif($call_type == 'list')
        {
            $res = $this->rudra_list_data($_POST);        
        }
        elseif($call_type == 'mylist')
        {
            $res = $this->rudra_mylist_data($_POST);        
        }
        elseif($call_type == 'search')
        {
            $res = $this->rudra_search_data($_POST);        
        }
        elseif($call_type == 'favorite')
        {
            $res = $this->rudra_favorite_data($_POST);        
        }
        elseif($call_type == 'share')
        {
            $res = $this->rudra_share_data($_POST);        
        }
        elseif($call_type == 'filter')
        {
            $res = $this->rudra_filter_data($_POST);        
        }
        elseif($call_type == 'market_users')
        {
            $res = $this->rudra_market_users_data($_POST);        
        }
        elseif($call_type == 'details')
        {
            $res = $this->rudra_details_data($_POST);        
        }
        elseif($call_type == 'favorite_list')
        {
            $res = $this->rudra_favorite_list_data($_POST);        
        }
        elseif($call_type == 'plan_list')
        {
            $res = $this->rudra_plan_list_data($_POST);        
        }
        elseif($call_type == 'package_list')
        {
            $res = $this->rudra_package_list_data($_POST);        
        }
        elseif($call_type == 'discover')
        {
            $res = $this->rudra_discover_data($_POST);        
        }
        elseif($call_type == 'market-explore-by-zipcode')
        {
            $res = $this->rudra_market_explore_by_zipcode_data($_POST);        
        }
        elseif($call_type == 'market-gallery-delete')
        {
            $res = $this->market_gallery_delete($_POST);        
        }

        $this->json_output(200,array('status' => 200,'message' => $this->msg,'data'=>$this->return_data,'chk' => $this->chk));

    }
    
    public function rudra_save_data()
    {   
       // print_r($_FILES['gallery_video']);
       // print_r($_FILES['gallery_image']); exit; 
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            
			$this->form_validation->set_rules('user_id', 'user_id', 'required');
			$this->form_validation->set_rules('market_name', 'market_name', 'required');
			$this->form_validation->set_rules('categories', 'categories', 'required');
            $this->form_validation->set_rules('zipcode', 'zipcode', 'required');
            $this->form_validation->set_rules('market_long', 'market_long', 'required');
            $this->form_validation->set_rules('market_lat', 'market_lat', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $user_id = $_POST['user_id'];
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
                
                $new_id = (isset($_POST['market_id']) ? $_POST['market_id'] : 0);
                $categories = explode(',',$_POST['categories']);
                $std = date('Y-m-d H:i:s');
                if($new_id == 0)
                {
                    
                    //Insert Codes goes here 
                    $updateArray = 
                        array(
                         'fk_user_id' => $this->input->post('user_id',true),
                         'market_name' => $this->input->post('market_name',true),
                         'categories' => $this->input->post('categories',true),
                         'recurring_type' => $this->input->post('recurring_type',true),
                         'start_date' => date('Y-m-d',strtotime($this->input->post('start_date',true))),
                         'end_date' => date('Y-m-d',strtotime($this->input->post('end_date',true))),
                         'start_time' => date('H:i',strtotime($this->input->post('start_time',true))),
                         'end_time' => date('H:i',strtotime($this->input->post('end_time',true))),
                         'description' => $this->input->post('description',true),
                         'address' => $this->input->post('address',true),
                         'landmark' => $this->input->post('landmark',true),
                         'zipcode' => $this->input->post('zipcode',true),
                         'city' => $this->input->post('city',true),
                         'contact_person' => $this->input->post('contact_person',true),
                         'contact_number' => $this->input->post('contact_number',true),
                         'contact_email' => $this->input->post('contact_email',true),
                         'total_shares' => 0,
                         'added_on' => $this->input->post($std,true),
                         'updated_on' => $this->input->post($std,true),
                         'market_long' => $this->input->post('market_long',true),
                         'market_lat' => $this->input->post('market_lat',true),
                        );
    
                    $this->db->insert("$this->table",$updateArray);
                    $new_id = $this->db->insert_id();
                    foreach($categories as $int => $intv)
                    {
                        $this->db->insert('rudra_market_category',array('fk_market_id' => $new_id,'fk_category_id'=>$intv));
                      
                    }

                    $notifyData = array(
                        'fk_user_id' => $this->input->post('user_id',true),
                        'message' => 'Market sent to approval'
                    );
    
                    $this->db->insert("rudra_notification",$notifyData);
                }
                elseif($new_id > 0)
                {
                    $updateArray = 
                    array(
                     'fk_user_id' => $this->input->post('user_id',true),
                     'market_name' => $this->input->post('market_name',true),
					 'categories' => $this->input->post('categories',true),
					 'recurring_type' => $this->input->post('recurring_type',true),
					 'start_date' => date('Y-m-d',strtotime($this->input->post('start_date',true))),
					 'end_date' => date('Y-m-d',strtotime($this->input->post('end_date',true))),
					 'start_time' => date('H:i',strtotime($this->input->post('start_time',true))),
					 'end_time' => date('H:i',strtotime($this->input->post('end_time',true))),
					 'description' => $this->input->post('description',true),
					 'address' => $this->input->post('address',true),
					 'landmark' => $this->input->post('landmark',true),
					 'zipcode' => $this->input->post('zipcode',true),
					 'city' => $this->input->post('city',true),
					 'contact_person' => $this->input->post('contact_person',true),
					 'contact_number' => $this->input->post('contact_number',true),
					 'contact_email' => $this->input->post('contact_email',true),
					 'total_shares' => 0,
					 'updated_on' => $this->input->post($std,true),
					 'market_long' => $this->input->post('market_long',true),
					 'market_lat' => $this->input->post('market_lat',true),
                     'is_main' => $this->input->post('main_image')
                    );
                    $this->db->where('id',$new_id);
                    $this->db->update("$this->table",$updateArray);
                    //Categories
                    $common_ids = array();
                    $m_cat = $this->db->get_where('rudra_market_category',array('fk_market_id' => $new_id))->result();
                    if(!empty($categories) && empty($m_cat))
                    {
                        foreach($categories as $int => $intv)
                        {
                            $this->db->insert('rudra_market_category',array('fk_market_id' => $new_id,'fk_category_id'=>$intv));
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
                                $this->db->insert('rudra_market_category',array('fk_market_id' => $new_id,'fk_category_id'=>$intv));
                            }
                          
                        }
                    }
                
                }

                //Files UPLOAD
                if(isset($_FILES['gallery_image']) && !empty($_FILES['gallery_image']['name'])) 
                {
                    $this->db->where('fk_market_id',$new_id);
                    $this->db->delete('rudra_market_gallery');

                    $uploadData = array();
                    $cnt = 1;
                    $main_image = $this->input->post('main_image');
                    foreach($_FILES['gallery_image']['name'] as $key => $names)
					{					
						$_FILES['file']['name']     = $names; 
						$_FILES['file']['type']     = $_FILES['gallery_image']['type'][$key]; 
						$_FILES['file']['tmp_name'] = $_FILES['gallery_image']['tmp_name'][$key]; 
						$_FILES['file']['error']     = $_FILES['gallery_image']['error'][$key]; 
						$_FILES['file']['size']     = $_FILES['gallery_image']['size'][$key]; 
								
				        // File upload configuration 
						$uploadPath = 'uploads/market/'; 
						$config['upload_path'] = $uploadPath; 
						$config['allowed_types'] = '*';
						$config['encrypt_name'] = TRUE; 
								
						// Load and initialize upload library 
						$this->load->library('upload', $config); 
						$this->upload->initialize($config); 
								
						// Upload file to server 
						if($this->upload->do_upload('file'))
						{ 
							// Uploaded file data 
							$fileData = $this->upload->data(); 
							//$uploadData[] = $fileData['file_name']; 
                            $insert_array = array(
                                'fk_market_id' => $new_id,
                                'file' => $fileData['file_name'],
                                'path' => $uploadPath,
                                'fullpath' => base_url().$uploadPath,
                                'upload_type' => 1,
                                'is_main' => ($main_image==$cnt ? 1 : 0),
                            );
                            $cnt++;
							$this->db->insert('rudra_market_gallery',$insert_array);		
						}
							
					}
                }
                if(isset($_FILES['gallery_video']) && $_FILES['gallery_video']['name'] != '') 
                {
                    $bannerpath = 'uploads/market';
                    $thumbpath = 'uploads/market';
                    $config['upload_path'] = $bannerpath;
                    $config['allowed_types'] = '*';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if(!$this->upload->do_upload('gallery_video'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                        exit('Errors');
                    }
                    else
                    {
                        $imagedata = array('image_metadata' => $this->upload->data());
                        $uploadedImage = $this->upload->data();
                    }
                   
                    $insert_array = array(
                                        'fk_market_id' => $new_id,
                                        'file' => $uploadedImage['file_name'],
                                        'path' => $bannerpath.'/',
                                        'fullpath' => base_url().$bannerpath.'/',
                                        'upload_type' => 2,
                                        'is_main' => 0,
                                    );
                    $this->db->insert('rudra_market_gallery',$insert_array);	
                }
               
                if(isset($_FILES['gallery_video_thumbnail']) && $_FILES['gallery_video_thumbnail']['name'] != '') 
                {
                    $bannerpath = 'uploads/market';
                    $thumbpath = 'uploads/market';
                    $config['upload_path'] = $bannerpath;
                    $config['allowed_types'] = '*';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if(!$this->upload->do_upload('gallery_video_thumbnail'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                        exit('Errors');
                    }
                    else
                    {
                        $imagedata = array('image_metadata' => $this->upload->data());
                        $uploadedImage = $this->upload->data();
                    }
                   
                    $insert_array = array(
                                        'fk_market_id' => $new_id,
                                        'file' => $uploadedImage['file_name'],
                                        'path' => $bannerpath.'/',
                                        'fullpath' => base_url().$bannerpath.'/',
                                        'upload_type' => 3,
                                        'is_main' => 0,
                                    );
                    $this->db->insert('rudra_market_gallery',$insert_array);    
                }

                $res = array();
                //Format Data if required
                /*********
                 $res->added_on_custom_date = date('d-M-Y',strtotime($res->added_on));
                 $res->added_on_custom_time = date('H:i:s A',strtotime($res->added_on));
                 $res->updated_on_custom_date = date('d-M-Y',strtotime($res->updated_on));
                 $res->updated_on_custom_time = date('H:i:s A',strtotime($res->updated_on));
                 ************/
                $this->chk = 1;
                if($_POST['lang'] == 'dnk'){
                    if($is_visible){
                        $res = $this->get_market_details($user_id, $new_id);
                        $this->msg = 'Marked oprettet.';
                    }
                    else{
                        $this->msg = 'Du har ingen pakke. Opgrader nu.';
                    }
                }else{
                    if($is_visible){
                        $res = $this->get_market_details($user_id, $new_id);
                        $this->msg = 'Data Stored Successfully';
                    }
                    else{
                        $this->msg = 'You dont have package. please buy the package.';
                    }
                }
                
                $this->return_data = $res;
            }
        }
       
    }
    
    public function rudra_update_data()
    {
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
			$this->form_validation->set_rules('market_id', 'market_id', 'required');
			$this->form_validation->set_rules('recurring_type', 'recurring_type', 'required');
			$this->form_validation->set_rules('start_date', 'start_date', 'required');
			$this->form_validation->set_rules('end_date', 'end_date', 'required');
			$this->form_validation->set_rules('start_time', 'start_time', 'required');
			$this->form_validation->set_rules('end_time', 'end_time', 'required');
			$this->form_validation->set_rules('address', 'address', 'required');
			$this->form_validation->set_rules('landmark', 'landmark', 'required');
			$this->form_validation->set_rules('zipcode', 'zipcode', 'required');
			$this->form_validation->set_rules('city', 'city', 'required');
			$this->form_validation->set_rules('contact_person', 'contact_person', 'required');
			$this->form_validation->set_rules('contact_number', 'contact_number', 'required');
			$this->form_validation->set_rules('contact_email', 'contact_email', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $new_id = $pk_id = $this->input->post('market_id');
                $chk_data = $this->db->get_where("$this->table",array('id' => $pk_id))->row();
                if(!empty($chk_data))
                {
                    $std = date('Y-m-d H:i:s');
                    //Update Codes goes here 
                    $updateArray = 
					array(
					 'recurring_type' => $this->input->post('recurring_type',true),
					 'start_date' => date('Y-m-d',strtotime($this->input->post('start_date',true))),
					 'end_date' => date('Y-m-d',strtotime($this->input->post('end_date',true))),
					 'start_time' => date('H:i:s',strtotime($this->input->post('start_time',true))),
					 'end_time' =>date('H:i:s',strtotime($this->input->post('end_time',true))),
					 'description' => $this->input->post('description',true),
					 'address' => $this->input->post('address',true),
					 'landmark' => $this->input->post('landmark',true),
					 'zipcode' => $this->input->post('zipcode',true),
					 'city' => $this->input->post('city',true),
					 'contact_person' => $this->input->post('contact_person',true),
					 'contact_number' => $this->input->post('contact_number',true),
					 'contact_email' => $this->input->post('contact_email',true),
                     'market_long' => $this->input->post('market_long',true),
                     'market_lat' => $this->input->post('market_lat',true),
					);

                    $this->db->where('id',$pk_id);
                    $this->db->update("$this->table",$updateArray);
                    
                    $this->chk = 1;
                    $this->msg = 'Information Updated';
                    $this->return_data = $this->db->get_where("$this->table",array('id' => $pk_id))->row();
                }
                else
                {
                    $this->chk = 0;
                    $this->msg = 'Record Not Found';   
                }
            }
        }
        
    }

    public function rudra_setting_list_data()
    {
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
            
                   
                    $this->chk = 1;
                    $this->msg = 'Small Lists';
                    $this->return_data = $list_array;
               
            }
        }
        
    }

    public function rudra_list_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('market_lat', 'market_lat', 'required');
            $this->form_validation->set_rules('market_long', 'market_long', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                
                $market_lat = $_POST['market_lat'];
                $market_long = $_POST['market_long'];
                $user_id = $_POST['user_id'];

                $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $plan_details = $this->db->query($plan_query)->row();
                $is_visible = 1;
                // if($plan_details) {
                //     $is_visible = 1; 
                //     $expire = strtotime($plan_details->expire_date);
                //     $today = strtotime("today");
                //     if($today >= $expire){
                //         $is_visible = 0;
                //     }            
                // }

                $query = "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance FROM rudra_market where status = '1' AND is_deleted = '0'";
                if($is_visible == '0'){
                    $query = $query .' '. " HAVING  distance <= 20 ";
                }
                $query = $query.' '." ORDER BY id DESC";
                $current = $this->db->query($query)->result();

                $query1 = "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance FROM rudra_market where status = '1' AND is_deleted = '0' AND is_feature = '1'";
                if($is_visible == '0'){
                    $query1 = $query1 .' '. " HAVING  distance <= 20 ";
                }
                $query1 = $query1.' '." ORDER BY id DESC";
                $feature = $this->db->query($query1)->result();
                
                $currents = array();
                foreach ($current as $keys => $values) {

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

                        $userId = $_POST['user_id'];
                        $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $is_fav = $this->db->query($query4)->row();

                        $is_favs = false;

                        if(!empty($is_fav)){
                            $is_favs = true;
                        }

                        $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $share = $this->db->query($query5)->result();

                        $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name, rudra_category_details.dnk_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $values->id";
                        $catList = $this->db->query($query6)->result();

                        $catLists = '';
                        foreach ($catList as $ckeys => $cvalues) {
                            if ($ckeys === key($catList)) {
                                $catLists = ($_POST['lang'] == 'dnk') ? $cvalues->dnk_name : $cvalues->category_name;
                            }
                            else{
                                $lang = ($_POST['lang'] == 'dnk') ? $cvalues->dnk_name : $cvalues->category_name;
                                $catLists = $catLists .', '. $lang;
                            }                        
                        }

                        $today = date("Y-m-d H:i:s");
                        $start = $values->start_date.' '.$values->start_time;

                        $today_time = strtotime($today);
                        $start_time = strtotime($start);

                        if ($start_time > $today_time) {
                            $values->is_open = 'Upcoming';
                        }


                        $values->total_favorite = count($fav);
                        $values->is_favorite = $is_favs; 
                        $values->total_share = count($share);
                        $values->categories_name = $catLists;
                        $values->images = $image;
                        $values->videos = $video;
                        $values->videostumb = $videotumb;
                        $values->is_contact_show = $is_visible;
                        // $values->description=utf8_encode($values->description);
                        $values->description=mb_convert_encoding($values->description,"UTF-8","auto");
                        $currents[] = $values;
                    }
                }
                // echo "<pre>"; print_r($currents);

                $features = array();
                foreach ($feature as $keys => $values) {

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

                        $userId = $_POST['user_id'];
                        $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $is_fav = $this->db->query($query4)->row();

                        $is_favs = false;

                        if(!empty($is_fav)){
                            $is_favs = true;
                        }

                        $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $share = $this->db->query($query5)->result();

                        $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name, rudra_category_details.dnk_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $values->id";
                        $catList = $this->db->query($query6)->result();

                        $catLists = '';
                        foreach ($catList as $ckeys => $cvalues) {
                            if ($ckeys === key($catList)) {
                                $catLists =  ($_POST['lang'] == 'dnk') ? $cvalues->dnk_name : $cvalues->category_name;
                            }
                            else{
                                $lang = ($_POST['lang'] == 'dnk') ? $cvalues->dnk_name : $cvalues->category_name;
                                $catLists = $catLists .', '.  $lang;
                            }                        
                        }

                        $today = date("Y-m-d H:i:s");
                        $start = $values->start_date.' '.$values->start_time;

                        $today_time = strtotime($today);
                        $start_time = strtotime($start);

                        if ($start_time > $today_time) {
                            $values->is_open = 'Upcoming';
                        }

                        $values->total_favorite = count($fav);
                        $values->is_favorite = $is_favs; 
                        $values->total_share = count($share);
                        $values->categories_name = $catLists;
                        $values->images = $image;
                        $values->videos = $video;
                        $values->videostumb = $videotumb;                    
                        $values->is_contact_show = $is_visible;
                        $features[] = $values;
                    }
                }

                $this->chk = 1;
                $this->msg = 'Market Lists';
                $this->return_data = array('current' => $currents, 'feature' => $features);

            }
        }
    }

    public function rudra_mylist_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $this->chk = 1;
                $this->msg = 'My Market Lists';
                $userId = $_POST['user_id'];

                $package_query = "SELECT * FROM rudra_purchased_package where fk_user_id = $userId AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $package_details = $this->db->query($package_query)->row();
                $is_visible = 1;
                $is_reuse = 0;
                if($package_details) { 
                    $is_reuse = 1;
                    if($package_details->fk_package_id == 1){
                        $is_visible = 5;
                    }
                    if($package_details->fk_package_id == 2){
                        $is_visible = 10;
                    }
                    $expire = strtotime($package_details->expire_date);
                    $today = strtotime("today");
                    if($today >= $expire){
                        $is_visible = 1;
                        $is_reuse = 0;
                    }                                
                }

                $query = "SELECT * FROM rudra_market where fk_user_id = $userId AND is_deleted = '0' ORDER BY id DESC";
                $current = $this->db->query($query)->result();

                $query1 = "SELECT * FROM rudra_market where fk_user_id = $userId AND is_deleted = '0' AND is_feature = '1' ORDER BY id DESC";
                $feature = $this->db->query($query1)->result();

                $currents = array();
                foreach ($current as $keys => $values) {

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
                        $ivalues->is_visible = 0;
                        if($ikeys < $is_visible){
                            $ivalues->is_visible = 1;
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
                        $vvalues->is_visible = 0;
                        if($is_visible > 0){
                            $vvalues->is_visible = 1;
                        }
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

                    $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $is_fav = $this->db->query($query4)->row();

                    $is_favs = false;

                    if(!empty($is_fav)){
                        $is_favs = true;
                    }

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

                    $today = date("Y-m-d H:i:s");
                    $expire = $values->end_date.' '.$values->end_time;

                    $today_time = strtotime($today);
                    $expire_time = strtotime($expire);


                    if ($expire_time < $today_time) {
                        $values->is_open = 'Close';
                    }
                    else{
                        $today = date("Y-m-d H:i:s");
                        $start = $values->start_date.' '.$values->start_time;

                        $today_time = strtotime($today);
                        $start_time = strtotime($start);

                        if ($start_time > $today_time) {
                            $values->is_open = 'Upcoming';
                        }
                    }

                    if($values->status == '0'){
                        if($_POST['lang'] == 'dnk'){
                            $values->is_open = 'Afventer';
                        }else{
                            $values->is_open = 'Pending';
                        }
                    }

                    $values->total_favorite = count($fav);
                    $values->is_favorite = $is_favs; 
                    $values->total_share = count($share);
                    $values->categories_name = $catLists;
                    $values->images = $image;
                    $values->videos = $video;
                    $values->videostumb = $videotumb;
                    $values->is_contact_show = 1;
                    $values->is_reuse = $is_reuse;
                    $currents[] = $values;
                    
                }

                $features = array();
                foreach ($feature as $keys => $values) {

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
                        $ivalues->is_visible = 0;
                        if($ikeys < $is_visible){
                            $ivalues->is_visible = 1;
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
                        $vvalues->is_visible = 0;
                        if($is_visible > 0){
                            $vvalues->is_visible = 1;
                        }
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

                    $userId = $_POST['user_id'];
                    $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $is_fav = $this->db->query($query4)->row();

                    $is_favs = false;

                    if(!empty($is_fav)){
                        $is_favs = true;
                    }

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

                    $today = date("Y-m-d H:i:s");
                    $expire = $values->end_date.' '.$values->end_time;

                    $today_time = strtotime($today);
                    $expire_time = strtotime($expire);

                    if ($expire_time < $today_time) {
                        $values->is_open = 'Close';
                    }
                    else{
                        $today = date("Y-m-d H:i:s");
                        $start = $values->start_date.' '.$values->start_time;

                        $today_time = strtotime($today);
                        $start_time = strtotime($start);

                        if ($start_time > $today_time) {
                            $values->is_open = 'Upcoming';
                        }
                    }

                    if($values->status == '0'){
                        $values->is_open = 'Pending';
                    }
                    
                    $values->total_favorite = count($fav);
                    $values->is_favorite = $is_favs; 
                    $values->total_share = count($share);
                    $values->categories_name = $catLists;
                    $values->images = $image;
                    $values->videos = $video;
                    $values->videostumb = $videotumb;
                    $values->is_contact_show = 1;
                    $values->is_reuse = $is_reuse;
                    $features[] = $values;
                    
                }

                $this->return_data = array('current' => $currents, 'feature' => $features);

            }
        }
    }

    public function rudra_search_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('search', 'search', 'required');
            $this->form_validation->set_rules('market_lat', 'market_lat', 'required');
            $this->form_validation->set_rules('market_long', 'market_long', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 

                $search = $_POST['search'];
                $is_favorite = $_POST['is_favorite'];
                $user_id = $_POST['user_id'];
                $market_lat = $_POST['market_lat'];
                $market_long = $_POST['market_long'];

                $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $plan_details = $this->db->query($plan_query)->row();
                $is_visible = 1;
                // if($plan_details) {
                //     $is_visible = 1; 
                //     $expire = strtotime($plan_details->expire_date);
                //     $today = strtotime("today");
                //     if($today >= $expire){
                //         $is_visible = 0;
                //     }            
                // }

                if($is_favorite == 0){

                    $query = $query .' '. "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance FROM rudra_market where status = '1' AND is_deleted = '0' AND (market_name LIKE '%$search%' OR description LIKE '%$search%' OR address LIKE '%$search%' OR city LIKE '%$search%') ";

                    if($is_visible == '0'){
                        $query = $query .' '. " HAVING  distance <= 20 ";
                    }
                    $query = $query.' '." ORDER BY id DESC";
                    $current = $this->db->query($query)->result();

                    $query1 = $query1 .' '. "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance  FROM rudra_market where status = '1' AND is_deleted = '0' AND is_feature = '1' AND (market_name LIKE '%$search%' OR description LIKE '%$search%' OR address LIKE '%$search%' OR city LIKE '%$search%')";

                    if($is_visible == '0'){
                        $query1 = $query1 .' '. " HAVING  distance <= 20 ";
                    }
                    $query1 = $query1.' '." ORDER BY id DESC";
                    $feature = $this->db->query($query1)->result();

                    $currents = array();
                    foreach ($current as $keys => $values) {

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

                            $userId = $_POST['user_id'];
                            $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $is_fav = $this->db->query($query4)->row();

                            $is_favs = false;

                            if(!empty($is_fav)){
                                $is_favs = true;
                            }

                            $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $share = $this->db->query($query5)->result();

                            $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name, rudra_category_details.dnk_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $values->id";
                            $catList = $this->db->query($query6)->result();

                            $catLists = '';
                            foreach ($catList as $ckeys => $cvalues) {
                                if ($ckeys === key($catList)) {
                                    if($_POST['lang'] == 'dnk'){
                                        $catLists = $cvalues->dnk_name;
                                    }
                                    else{
                                       $catLists = $cvalues->category_name; 
                                   }                                    
                                }
                                else{
                                    if($_POST['lang'] == 'dnk'){
                                        $catLists = $catLists .', '. $cvalues->dnk_name;
                                    }
                                    else{
                                        $catLists = $catLists .', '. $cvalues->category_name;
                                    }
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
                            $currents[] = $values;
                        }
                    }

                    $features = array();
                    foreach ($feature as $keys => $values) {

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

                            $userId = $_POST['user_id'];
                            $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $is_fav = $this->db->query($query4)->row();

                            $is_favs = false;

                            if(!empty($is_fav)){
                                $is_favs = true;
                            }

                            $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $share = $this->db->query($query5)->result();

                            $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name, rudra_category_details.dnk_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $values->id";
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
                            $features[] = $values;
                        }
                    }


                    $this->chk = 1;
                    $this->msg = 'Market Lists';
                    $this->return_data = array('current' => $currents, 'feature' => $features);
                }
                else{
                    $query = $query .' '. "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance FROM rudra_market where status = '1' AND is_deleted = '0' AND (market_name LIKE '%$search%' OR address LIKE '%$search%' OR city LIKE '%$search%')";
                    if($is_visible == '0'){
                        $query = $query .' '. " HAVING  distance <= 20 ";
                    }
                    $query = $query.' '." ORDER BY id DESC";
                    $current = $this->db->query($query)->result();

                    $query1 = $query1 .' '. "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance  FROM rudra_market where status = '1' AND is_deleted = '0' AND is_feature = '1' AND (market_name LIKE '%$search%' OR address LIKE '%$search%' OR city LIKE '%$search%')";
                    $query1 = $query1.' '." ORDER BY id DESC";
                    $feature = $this->db->query($query1)->result();

                    $currents = array();
                    foreach ($current as $keys => $values) {

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

                            $cquerys = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $user_id AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0'";
                            $cs = $this->db->query($cquerys)->row();
                            if($cs) {

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
                                    $vvalues->fullurl = base_url().$vvalues->path.$vvalues->file;
                                    $video[] = $vvalues;
                                }

                                $query3 = "SELECT * FROM rudra_market_gallery where fk_market_id = $values->id AND  upload_type = '3' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                $videosthumb = $this->db->query($query3)->result();

                                $videotumb = [];
                                foreach ($videosthumb as $vkeys => $vvalues) {
                                    $vvalues->is_visible = $is_visible;
                                    $vvalues->fullurl = base_url().$vvalues->path.$vvalues->file;
                                    $videotumb[] = $vvalues;
                                }

                                $query3 = "SELECT * FROM rudra_user_fav_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                $fav = $this->db->query($query3)->result();

                                $userId = $_POST['user_id'];
                                $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                $is_fav = $this->db->query($query4)->row();

                                $is_favs = false;

                                if(!empty($is_fav)){
                                    $is_favs = true;
                                }

                                $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                $share = $this->db->query($query5)->result();

                                $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name, rudra_category_details.dnk_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $values->id";
                                $catList = $this->db->query($query6)->result();

                                $catLists = '';
                                foreach ($catList as $ckeys => $cvalues) {
                                    if ($ckeys === key($catList)) {
                                        if($_POST['lang'] == 'dnk'){
                                            $catLists = $cvalues->dnk_name;
                                        }
                                        else{
                                           $catLists = $cvalues->category_name; 
                                       }                                    
                                    }
                                    else{
                                        if($_POST['lang'] == 'dnk'){
                                            $catLists = $catLists .', '. $cvalues->dnk_name;
                                        }
                                        else{
                                            $catLists = $catLists .', '. $cvalues->category_name;
                                        }
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
                                $currents[] = $values;
                            }
                        }
                    }

                    $features = array();
                    foreach ($feature as $keys => $values) {

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

                            $fquerys = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $user_id AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0'";
                            $fs = $this->db->query($fquerys)->row();

                            if($fs) {
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

                                $userId = $_POST['user_id'];
                                $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                $is_fav = $this->db->query($query4)->row();

                                $is_favs = false;

                                if(!empty($is_fav)){
                                    $is_favs = true;
                                }

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
                                $features[] = $values;
                            }
                        }
                    }


                    $this->chk = 1;
                    $this->msg = 'Market Lists';
                    $this->return_data = array('current' => $currents, 'feature' => $features);
                }

            }
        }
    }
    
    public function rudra_delete_data()
    {
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            
			$this->form_validation->set_rules('user_id', 'user_id', 'required');
			$this->form_validation->set_rules('market_id', 'market_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
			// $this->form_validation->set_rules('categories', 'categories', 'required');
			// $this->form_validation->set_rules('recurring_type', 'recurring_type', 'required');
			// $this->form_validation->set_rules('start_date', 'start_date', 'required');
			// $this->form_validation->set_rules('end_date', 'end_date', 'required');
			// $this->form_validation->set_rules('start_time', 'start_time', 'required');
			// $this->form_validation->set_rules('end_time', 'end_time', 'required');
			// $this->form_validation->set_rules('description', 'description', 'required');
			// $this->form_validation->set_rules('address', 'address', 'required');
			// $this->form_validation->set_rules('landmark', 'landmark', 'required');
			// $this->form_validation->set_rules('zipcode', 'zipcode', 'required');
			// $this->form_validation->set_rules('city', 'city', 'required');
			// $this->form_validation->set_rules('contact_person', 'contact_person', 'required');
			// $this->form_validation->set_rules('contact_number', 'contact_number', 'required');
			// $this->form_validation->set_rules('contact_email', 'contact_email', 'required');
			// $this->form_validation->set_rules('total_shares', 'total_shares', 'required');
			// $this->form_validation->set_rules('status', 'status', 'required');
			// $this->form_validation->set_rules('is_deleted', 'is_deleted', 'required');
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $market_id = $this->input->post('market_id');
                $user_id = $this->input->post('user_id');
                $chk_data = $this->db->get_where("$this->table",array('id' => $market_id, 'fk_user_id' => $user_id))->row();
                if(!empty($chk_data))
                {
                   
                   $updateArray =   array(
                        'is_deleted' => '1'
                    );

                    $this->db->where('id',$chk_data->id);
                    $this->db->update("$this->table",$updateArray);

                    $this->chk = 1;
                    $this->msg = 'Market deleted successfully';
                    
                }
                else
                {
                    $this->chk = 0;
                    $this->msg = 'Record Not Found';   
                }
            }
        }
        
    }

    public function market_gallery_delete()
    {
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('market_id', 'market_id', 'required');
            $this->form_validation->set_rules('gallery_id', 'gallery_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $market_id = $this->input->post('market_id');
                $gallery_id = $this->input->post('gallery_id');
                $user_id = $this->input->post('user_id');
                $chk_data = $this->db->get_where("rudra_market_gallery",array('id' => $gallery_id, 'fk_market_id' => $market_id))->row();
                if(!empty($chk_data))
                {
                   
                   $updateArray =   array(
                        'is_deleted' => '1'
                    );

                    $this->db->where('id',$chk_data->id);
                    $this->db->update("rudra_market_gallery",$updateArray);

                    $this->chk = 1;
                    $this->msg = 'Market gallery deleted successfully';
                    
                }
                else
                {
                    $this->chk = 0;
                    $this->msg = 'Record Not Found';   
                }
            }
        }
        
    }
    
    public function rudra_get_data()
    {     
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $pk_id = $this->input->post('id');
                $res = $this->db->get_where("$this->table",array('id' => $pk_id))->row();
                if(!empty($res))
                {
                    //Format Data if required
                    /*********
                    $res->added_on_custom_date = date('d-M-Y',strtotime($res->added_on));
                    $res->added_on_custom_time = date('H:i:s A',strtotime($res->added_on));
                    $res->updated_on_custom_date = date('d-M-Y',strtotime($res->updated_on));
                    $res->updated_on_custom_time = date('H:i:s A',strtotime($res->updated_on));
                    ************/
                    $this->chk = 1;
                    $this->msg = 'Data';
                    $this->return_data = $res;
                }
                else
                {
                    $this->chk = 0;
                    $this->msg = 'Error: ID not found';
                }
            }
        }
        
    }
    public function rudra_paged_data()
    {     
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            //$this->form_validation->set_rules('page_number', 'Page Number: default 1', 'required');
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $per_page = 50; // No. of records per page
                $page_number = $this->input->post('page_number',true);
                $page_number = ($page_number == 1 ? 0 : $page_number);
                $start_index = $page_number*$per_page;
                $query = "SELECT * FROM $this->table ORDER BY id DESC LIMIT $start_index , $per_page";
                $result = $this->db->query($query)->result();
                if(!empty($result))
                {
                    $list = array();
                    foreach($result as $res)
                    {
                        $res->added_on_custom_date = date('d-M-Y',strtotime($res->added_on));
                        $res->added_on_custom_time = date('H:i:s A',strtotime($res->added_on));
                        $res->updated_on_custom_date = date('d-M-Y',strtotime($res->updated_on));
                        $res->updated_on_custom_time = date('H:i:s A',strtotime($res->updated_on));
                        $list[] = $res;
                    }
                    $this->chk = 1;
                    $this->msg = 'Paged Data';
                    $this->return_data = $list;
                }
                else
                {
                    $this->chk = 0;
                    $this->msg = 'No recond exist';
                }
               
            }
        }
       
    }

    public function rudra_category_list_data()
    {     
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $market_id = (isset($_POST['market_id']) ? $_POST['market_id'] : 0);
                $res = $this->db->get($this->bdp."category_details")->result();
                if(!empty($res))
                {
                    $list = array();
                    $event_det = $this->db->get_where($this->bdp.'market_category',array('fk_market_id'=>$market_id))->result();
                    $m_cat_id = (!empty($event_det) ? array_column($event_det, 'fk_category_id') : array());
                    foreach($res as $rr)
                    {
                        if($_POST['lang'] == 'dnk'){
                            $rr->category_name = $rr->dnk_name;
                        }
                        $rr->is_selected = (in_array($rr->id,$m_cat_id) ? 1 : 0);
                        $list[] = $rr;
                    }
                    $this->chk = 1;
                    $this->msg = 'Category List';
                    $this->return_data = $list;
                }
                else
                {
                    $this->chk = 0;
                    $this->msg = 'Error: ID not found';
                }
            }
        }
        
    }

    public function rudra_favorite_data()
    {
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('market_id', 'market_id', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $user_id = $_POST['user_id'];

                $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND fk_plan_id = 2 AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
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

                    $market_id = $_POST['market_id'];
                    $chk_data = $this->db->get_where("rudra_user_fav_markets",array('fk_user_id' => $user_id, 'fk_market_id' => $market_id))->row();
                    $is_favorite = true;
                    if(empty($chk_data))
                    {
                        $updateArray =   array(
                            'fk_user_id' => $user_id,
                            'fk_market_id' => $market_id
                        );
        
                        $this->db->insert("rudra_user_fav_markets",$updateArray);
                    }
                    else
                    {
                        if($chk_data->status == '0') {
                            $updateArray =   array(
                                'status' => '1'
                            );

                            $this->db->where('id',$chk_data->id);
                            $this->db->update("rudra_user_fav_markets",$updateArray);
            
                        }
                        else{
                            $updateArray =   array(
                                'status' => '0'
                            );
            
                            $this->db->where('id',$chk_data->id);
                            $this->db->update("rudra_user_fav_markets",$updateArray);
                            $is_favorite = false;
                        }
                         
                    }

                    $query3 = "SELECT * FROM rudra_user_fav_markets where fk_market_id = $market_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $fav = $this->db->query($query3)->result();

                    $this->return_data = array('total_favorite' => count($fav), 'is_favorite' => $is_favorite);
                    $message = 'Successfully';
                    $this->chk = 1;
                }
                else{
                    $message = 'Please upgrade your package';
                    $this->chk = 0;
                    $this->msg = $message;  
                }               
                    
            }
        }
        
    }
    
     public function rudra_share_data()
    {
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('market_id', 'market_id', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $user_id = $_POST['user_id'];
                $market_id = $_POST['market_id'];
                $chk_data = $this->db->get_where("rudra_user_share_markets",array('fk_user_id' => $user_id, 'fk_market_id' => $market_id))->row();
                if(empty($chk_data))
                {
                    $updateArray =   array(
                        'fk_user_id' => $user_id,
                        'fk_market_id' => $market_id
                    );
    
                    $this->db->insert("rudra_user_share_markets",$updateArray);
                }

                $query3 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $market_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $share = $this->db->query($query3)->result();

                $this->return_data = array('total_share' => count($share));

                $this->chk = 1;
                $this->msg = 'Success';  
                    
            }
        }
        
    } 

    public function rudra_filter_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('market_long', 'market_long', 'required');
            $this->form_validation->set_rules('market_lat', 'market_lat', 'required');
            $this->form_validation->set_rules('is_favorite', 'is_favorite', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $zipcode = $_POST['zipcode'];
                $city = $_POST['city'];
                $fk_user_id = $_POST['fk_user_id'];
                $category_id = $_POST['category_id'];
                $market_long = $_POST['market_long'];
                $market_lat = $_POST['market_lat'];
                $market_distance = $_POST['market_distance'];
                $is_denmark = $_POST['is_denmark'];
                $is_favorite = $_POST['is_favorite'];
                $user_id = $_POST['user_id'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];

                $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $plan_details = $this->db->query($plan_query)->row();
                $is_visible = 1;
                // if($plan_details) {
                //     $is_visible = 1; 
                //     $expire = strtotime($plan_details->expire_date);
                //     $today = strtotime("today");
                //     if($today >= $expire){
                //         $is_visible = 0;
                //     }            
                // }

                if($is_visible == 0){
                    if($market_distance > 20){
                        $market_distance == 20;
                    }
                }

                $plan_query1 = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND fk_plan_id = 2 AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $plan_details1 = $this->db->query($plan_query1)->row();
                $is_another_visible = 1;
                // if($plan_details1) {
                //     $is_another_visible = 1; 
                //     $expire = strtotime($plan_details->expire_date);
                //     $today = strtotime("today");
                //     if($today >= $expire){
                //         $is_another_visible = 0;
                //     }            
                // }

                if($is_favorite == 0){
                    $query = "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance FROM rudra_market where status = '1' AND is_deleted = '0' ";
                    
                    if($zipcode != ""){
                        $query = $query .' '. " AND zipcode = '$zipcode' ";
                    }

                    if($city != ""){
                        $query = $query .' '. " AND city = '$city' ";
                    }

                    if($start_date != "" && $end_date != ""){
                        $query = $query .' '. " AND ( date(start_date) >= '$start_date' AND date(end_date) <= '$end_date' ) ";
                    }

                    if($is_another_visible){
                        if($fk_user_id != ""){
                            $query = $query .' '. " AND id IN ($fk_user_id) ";
                        }
                    }                    

                    if($is_denmark == '0'){
                        if($market_distance != ""){
                            $query = $query .' '. " HAVING  distance < $market_distance ";
                        }
                    }
                      
                    $query = $query .' '." ORDER BY distance DESC";
                    $current = $this->db->query($query)->result();

                    $query1 = "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance  FROM rudra_market where status = '1' AND is_deleted = '0' AND is_feature = '1' ";

                    if($zipcode != ""){
                        $query1 = $query1 .' '. " AND zipcode = '$zipcode' ";
                    }

                    if($city != ""){
                        $query1 = $query1 .' '. " AND city = '$city' ";
                    }

                    if($start_date != "" && $end_date != ""){
                        $query1 = $query1 .' '. " AND ( date(start_date) >= '$start_date' AND date(end_date) <= '$end_date' ) ";
                    }


                    if($is_another_visible){

                        if($fk_user_id != ""){
                            $query1 = $query1 .' '. " AND fk_user_id IN ($fk_user_id) ";
                        }

                    }
                    if($is_denmark == '0'){
                        if($market_distance != ""){
                            $query1 = $query1 .' '. " HAVING  distance < $market_distance ";
                        }
                    }
                    
                     
                    $query1 = $query1 .' '." ORDER BY distance DESC";

                    $feature = $this->db->query($query1)->result();

                    $currents = array();
                    foreach ($current as $keys => $values) {

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

                            $dcat = explode(",", $values->categories);
                            $fcat = explode(",", $category_id);

                            $cat_filter = array_intersect($dcat, $fcat);

                            if($category_id != ''){
                                if(count($cat_filter) > 0){

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

                                    $userId = $_POST['user_id'];
                                    $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                    $is_fav = $this->db->query($query4)->row();

                                    $is_favs = false;

                                    if(!empty($is_fav)){
                                        $is_favs = true;
                                    }

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
                                    $currents[] = $values;
                                }
                            }
                            else{
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

                                $userId = $_POST['user_id'];
                                $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                $is_fav = $this->db->query($query4)->row();

                                $is_favs = false;

                                if(!empty($is_fav)){
                                    $is_favs = true;
                                }

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
                                $currents[] = $values; 
                            }
                        }
                    }

                    $features = array();
                    foreach ($feature as $keys => $values) {

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

                            $dcat = explode(",", $values->categories);
                            $fcat = explode(",", $category_id);

                            $cat_filter = array_intersect($dcat, $fcat);

                            if($category_id != ''){
                                if(count($cat_filter) > 0){

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

                                    $userId = $_POST['user_id'];
                                    $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                    $is_fav = $this->db->query($query4)->row();

                                    $is_favs = false;

                                    if(!empty($is_fav)){
                                        $is_favs = true;
                                    }

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
                                    $features[] = $values;
                                }
                            }
                            else{
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

                                    $userId = $_POST['user_id'];
                                    $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                    $is_fav = $this->db->query($query4)->row();

                                    $is_favs = false;

                                    if(!empty($is_fav)){
                                        $is_favs = true;
                                    }

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
                                    $features[] = $values; 
                            }
                        }
                    }

                    $this->chk = 1;
                    $this->msg = 'Market List';
                    $this->return_data = array('current' => $currents, 'feature' => $features);
                }
                else{
                    $query = "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance FROM rudra_market where status = '1' AND is_deleted = '0' ";
                    if($fk_user_id != ""){
                        $query = $query .' '. " AND fk_user_id = '$fk_user_id' ";
                    }

                    if($zipcode != ""){
                        $query = $query .' '. " AND zipcode = '$zipcode' ";
                    }

                    if($city != ""){
                        $query = $query .' '. " AND city = '$city' ";
                    }

                    if($start_date != "" && $end_date != ""){
                        $query = $query .' '. " AND ( date(start_date) >= '$start_date' AND date(end_date) <= '$end_date' ) ";
                    }

                    if($is_denmark == '0'){
                        if($market_distance != ""){
                            $query = $query .' '. " HAVING  distance < $market_distance ";
                        }
                    }
                      
                    $query = $query .' '." ORDER BY distance DESC";
                    $current = $this->db->query($query)->result();

                    $query1 = "SELECT *, (6371 * acos (cos (radians($market_lat))* cos(radians(market_lat))* cos( radians($market_long) - radians(market_long) )+ sin (radians($market_lat) )* sin(radians(market_lat)))) AS distance  FROM rudra_market where status = '1' AND is_deleted = '0' AND is_feature = '1' ";
                    if($fk_user_id != ""){
                        $query1 = $query1 .' '. " AND fk_user_id = '$fk_user_id' ";
                    }

                    if($zipcode != ""){
                        $query1 = $query1 .' '. " AND zipcode = '$zipcode' ";
                    }

                    if($city != ""){
                        $query1 = $query1 .' '. " AND city = '$city' ";
                    }

                    if($start_date != "" && $end_date != ""){
                        $query1 = $query1 .' '. " AND ( date(start_date) >= '$start_date' AND date(end_date) <= '$end_date' ) ";
                    }

                    if($is_denmark == '0'){
                        if($market_distance != ""){
                            $query1 = $query1 .' '. " HAVING  distance < $market_distance ";
                        }
                    }
                    
                     
                    $query1 = $query1 .' '." ORDER BY distance DESC";

                    $feature = $this->db->query($query1)->result();

                    $currents = array();
                    foreach ($current as $keys => $values) {

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

                            $cquerys = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $user_id AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0'";
                            $cs = $this->db->query($cquerys)->row();
                            if($cs) {

                                $dcat = explode(",", $values->categories);
                                $fcat = explode(",", $category_id);

                                $cat_filter = array_intersect($dcat, $fcat);

                                if($category_id != ''){
                                    if(count($cat_filter) > 0){

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

                                        $userId = $_POST['user_id'];
                                        $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                        $is_fav = $this->db->query($query4)->row();

                                        $is_favs = false;

                                        if(!empty($is_fav)){
                                            $is_favs = true;
                                        }

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
                                        $currents[] = $values;
                                    }
                                }
                                else{
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

                                        $userId = $_POST['user_id'];
                                        $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                        $is_fav = $this->db->query($query4)->row();

                                        $is_favs = false;

                                        if(!empty($is_fav)){
                                            $is_favs = true;
                                        }

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
                                        $currents[] = $values; 
                                }
                            }
                        }
                    }

                    $features = array();
                    foreach ($feature as $keys => $values) {

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

                            $fquerys = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $user_id AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0'";
                            $fs = $this->db->query($fquerys)->row();
                            if($fs) {

                                $dcat = explode(",", $values->categories);
                                $fcat = explode(",", $category_id);

                                $cat_filter = array_intersect($dcat, $fcat);

                                if($category_id != ''){
                                    if(count($cat_filter) > 0){

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

                                        $userId = $_POST['user_id'];
                                        $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                        $is_fav = $this->db->query($query4)->row();

                                        $is_favs = false;

                                        if(!empty($is_fav)){
                                            $is_favs = true;
                                        }

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
                                        $features[] = $values;
                                    }
                                }
                                else{
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

                                    $userId = $_POST['user_id'];
                                    $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                    $is_fav = $this->db->query($query4)->row();

                                    $is_favs = false;

                                    if(!empty($is_fav)){
                                        $is_favs = true;
                                    }

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
                                    $features[] = $values;
                                }
                            }
                        }
                    }

                    $this->chk = 1;
                    $this->msg = 'Market List';
                    $this->return_data = array('current' => $currents, 'feature' => $features);
                }
                
            }
        }
    }

    public function rudra_market_users_data($value='')
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                
                // $query = "SELECT rudra_user.id, rudra_user.first_name, rudra_user.last_name FROM rudra_market INNER JOIN rudra_user ON rudra_market.fk_user_id=rudra_user.id where rudra_market.status = '1' AND rudra_market.is_deleted = '0'  AND rudra_user.first_name != '' GROUP BY rudra_user.id";
                // $usersList = $this->db->query($query)->result();

                $current_date = date("Y-m-d");

                $usersList = array();

                $markets = $this->gm->get_list('*', 'rudra_market', array('status' => '1', 'is_deleted' => '0', 'start_date<=' => $current_date, 'end_date>=' => $current_date));

                foreach ($markets as $keys => $values) {
                    $details = array('id' => $values->id, 'first_name' => $values->market_name, 'last_name' => '');
                    $usersList[] = $details;
                }

                $this->chk = 1;
                $this->msg = 'Market Lists';
                $this->return_data = $usersList;

            }
        }
    }

    public function get_market_details($user_id, $market_id)
    {

        $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        $plan_details = $this->db->query($plan_query)->row();
        $is_visible = 1;
        // if($plan_details) {
        //     $is_visible = 1; 
        //     $expire = strtotime($plan_details->expire_date);
        //     $today = strtotime("today");
        //     if($today >= $expire){
        //         $is_visible = 0;
        //     }            
        // }

        $query = "SELECT * FROM rudra_market where status = '1' AND is_deleted = '0' AND id = '$market_id' ";
        $details = $this->db->query($query)->row();

        if(!empty($details)) {

            $query2 = "SELECT * FROM rudra_market_gallery where fk_market_id = $details->id AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
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

            $query3 = "SELECT * FROM rudra_market_gallery where fk_market_id = $details->id AND  upload_type = '2' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
            $videos = $this->db->query($query3)->result();

            $video = [];
            foreach ($videos as $vkeys => $vvalues) {
                $vvalues->is_visible = $is_visible; 
                $vvalues->fullurl = base_url().$vvalues->path.$vvalues->file;
                $video[] = $vvalues;
            }

            $query3 = "SELECT * FROM rudra_market_gallery where fk_market_id = $details->id AND  upload_type = '3' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
            $videosthumb = $this->db->query($query3)->result();

            $videotumb = [];
            foreach ($videosthumb as $vkeys => $vvalues) {
                $vvalues->fullurl = base_url().$vvalues->path.$vvalues->file;
                $videotumb[] = $vvalues;
            }

            $query3 = "SELECT * FROM rudra_user_fav_markets where fk_market_id = $details->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
            $fav = $this->db->query($query3)->result();

            $userId = $_POST['user_id'];
            $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $details->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
            $is_fav = $this->db->query($query4)->row();

            $is_favs = false;

            if(!empty($is_fav)){
                $is_favs = true;
            }

            $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $details->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
            $share = $this->db->query($query5)->result();

            $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $details->id";
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

            $today = date("Y-m-d h:i:s");
            $expire = $details->end_date.' '.$details->end_time;

            $today_time = strtotime($today);
            $expire_time = strtotime($expire);

            if ($expire_time < $today_time) {
                $details->is_open = 'Close';
            }

            $rsqry = "SELECT * FROM rudra_rent_space where fk_market_id = $details->id AND status = '1' AND is_deleted = '0' ORDER BY id ASC";
            $rentspace = $this->db->query($rsqry)->result();

            $rsLists = [];

            $total_table = 0;
            $total_booked_table = 0;

            foreach($rentspace as $rskeys => $rsvalues) {

                $rspqry = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $rsvalues->id AND table_type = '$rsvalues->table_type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $rsp = $this->db->query($rspqry)->row();

                $bookTotal = ($rsp->total) ? $rsp->total : 0;

                $rsl = array(
                    'id' => $rsvalues->id,
                    'type' => $rsvalues->table_type,
                    'total_table_no' => $rsvalues->table_no,
                    'table_rent_price' => $rsvalues->table_rent_price,
                    'image_url' => base_url().$rsvalues->file_path.'/'.$rsvalues->file_name,
                    'total_table_booked_no' => $bookTotal
                );

                $total_booked_table = $total_booked_table + $bookTotal;
                $total_table = $total_table + $rsvalues->table_no;

                $rsLists[] = $rsl;
            }

            $rsList['list'] = $rsLists;

            $rsList['total_table'] = $total_table;
            $rsList['total_booked_table'] = $total_booked_table;

            $details->total_favorite = count($fav);
            $details->is_favorite = $is_favs; 
            $details->total_share = count($share);
            $details->categories_name = $catLists;
            $details->images = $image;
            $details->videos = $video;
            $details->videostumb = $videotumb;
            $details->rentspace = $rsList;
            
        }

        return array('details' => $details);
    }
       
    public function rudra_details_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('market_id', 'market_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $user_id = $_POST['user_id'];
                $market_id = $_POST['market_id'];

                $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $plan_details = $this->db->query($plan_query)->row();
                $is_visible = 1;
                // if($plan_details) {
                //     $is_visible = 1; 
                //     $expire = strtotime($plan_details->expire_date);
                //     $today = strtotime("today");
                //     if($today >= $expire){
                //         $is_visible = 0;
                //     }            
                // }

                $query = "SELECT * FROM rudra_market where status = '1' AND is_deleted = '0' AND id = '$market_id' ";
                $details = $this->db->query($query)->row();

                if(!empty($details)) {

                    // $details->description = utf8_encode($details->description);
                    $details->description=mb_convert_encoding($details->description,"UTF-8","auto");
                    $query2 = "SELECT * FROM rudra_market_gallery where fk_market_id = $details->id AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
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

                    if(count($image) == 0){
                        $query21 = "SELECT * FROM rudra_market_gallery where fk_market_id = 0 AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $images1 = $this->db->query($query21)->result();
                        foreach ($images1 as $ikeys => $ivalues) {
                            $ivalues->is_visible = 1;
                            $ivalues->fullurl = base_url().$ivalues->path.$ivalues->file;
                            $image[] = $ivalues;
                        }
                    }

                    $query3 = "SELECT * FROM rudra_market_gallery where fk_market_id = $details->id AND  upload_type = '2' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $videos = $this->db->query($query3)->result();

                    $video = [];
                    foreach ($videos as $vkeys => $vvalues) {
                        $vvalues->is_visible = $is_visible; 
                        $vvalues->fullurl = base_url().$vvalues->path.$vvalues->file;
                        $video[] = $vvalues;
                    }

                    $query3 = "SELECT * FROM rudra_market_gallery where fk_market_id = $details->id AND  upload_type = '3' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $videosthumb = $this->db->query($query3)->result();

                    $videotumb = [];
                    foreach ($videosthumb as $vkeys => $vvalues) {
                        $vvalues->fullurl = base_url().$vvalues->path.$vvalues->file;
                        $videotumb[] = $vvalues;
                    }

                    $query3 = "SELECT * FROM rudra_user_fav_markets where fk_market_id = $details->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $fav = $this->db->query($query3)->result();

                    $userId = $_POST['user_id'];
                    $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $details->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $is_fav = $this->db->query($query4)->row();

                    $is_favs = false;

                    if(!empty($is_fav)){
                        $is_favs = true;
                    }

                    $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $details->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $share = $this->db->query($query5)->result();

                    $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $details->id";
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

                    $today = date("Y-m-d H:i:s");
                    $expire = $details->end_date.' '.$details->end_time;

                    $today_time = strtotime($today);
                    $expire_time = strtotime($expire);

                    if ($expire_time < $today_time) {
                        $details->is_open = 'Close';
                    }
                    else{
                        $today = date("Y-m-d H:i:s");
                        $start = $details->start_date.' '.$details->start_time;

                        $today_time = strtotime($today);
                        $start_time = strtotime($start);

                        if ($start_time > $today_time) {
                            $details->is_open = 'Upcoming';
                        }
                    }

                    $rsqry = "SELECT * FROM rudra_rent_space where fk_market_id = $details->id AND status = '1' AND is_deleted = '0' ORDER BY id ASC";
                    $rentspace = $this->db->query($rsqry)->result();

                    $rsLists = [];

                    $total_table = 0;
                    $total_booked_table = 0;

                    foreach($rentspace as $rskeys => $rsvalues) {

                        $rspqry = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $rsvalues->id AND table_type = '$rsvalues->table_type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $rsp = $this->db->query($rspqry)->row();

                        $bookTotal = ($rsp->total) ? $rsp->total : 0;

                        $rsl = array(
                            'id' => $rsvalues->id,
                            'type' => $rsvalues->table_type,
                            'total_table_no' => $rsvalues->table_no,
                            'table_rent_price' => $rsvalues->table_rent_price,
                            'image_url' => base_url().$rsvalues->file_path.'/'.$rsvalues->file_name,
                            'total_table_booked_no' => $bookTotal
                        );

                        $total_booked_table = $total_booked_table + $bookTotal;
                        $total_table = $total_table + $rsvalues->table_no;

                        $rsLists[] = $rsl;
                    }

                    $rsList['list'] = $rsLists;

                    $rsList['total_table'] = $total_table;
                    $rsList['total_booked_table'] = $total_booked_table;

                    $details->total_favorite = count($fav);
                    $details->is_favorite = $is_favs; 
                    $details->total_share = count($share);
                    $details->categories_name = $catLists;
                    $details->images = $image;
                    $details->videos = $video;
                    $details->videostumb = $videotumb;
                    $details->rentspace = $rsList;
                    
                }

                $this->chk = 1;
                $this->msg = 'Market Details';
                $this->return_data = array('details' => $details);

            }
        }
    }

    public function rudra_favorite_list_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $user_id = $_POST['user_id'];
                $this->chk = 1;
                $this->msg = 'Favorite Lists';

                $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $plan_details = $this->db->query($plan_query)->row();
                $is_visible = 1;
                // if($plan_details) {
                //     $is_visible = 1; 
                //     $expire = strtotime($plan_details->expire_date);
                //     $today = strtotime("today");
                //     if($today >= $expire){
                //         $is_visible = 0;
                //     }            
                // }

                $query = "SELECT rudra_market.* FROM rudra_user_fav_markets INNER JOIN rudra_market ON rudra_user_fav_markets.fk_market_id=rudra_market.id where rudra_user_fav_markets.fk_user_id = $user_id AND rudra_user_fav_markets.is_deleted = '0' AND rudra_user_fav_markets.status = '1'";
                $list = $this->db->query($query)->result();

                $lists = array();
                foreach ($list as $keys => $values) {

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

                    $userId = $_POST['user_id'];
                    $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $is_fav = $this->db->query($query4)->row();

                    $is_favs = false;

                    if(!empty($is_fav)){
                        $is_favs = true;
                    }

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

                    $today = date("Y-m-d h:i:s");
                    $expire = $values->end_date.' '.$values->end_time;

                    $today_time = strtotime($today);
                    $expire_time = strtotime($expire);

                    if ($expire_time < $today_time) {
                        $values->is_open = 'Close';
                    }

                    $values->total_favorite = count($fav);
                    $values->is_favorite = $is_favs; 
                    $values->total_share = count($share);
                    $values->categories_name = $catLists;
                    $values->images = $image;
                    $values->videos = $video;
                    $values->videostumb = $videotumb;
                    $values->is_contact_show = $is_visible;
                    $lists[] = $values;
                }

                $this->return_data = array('list' => $lists);

            }
        }
    }
    
    public function rudra_plan_list_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 

                $userId = $_POST['user_id'];
                $last_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $userId AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $last_plan = $this->db->query($last_query)->row();

                $query = "SELECT * FROM rudra_plan ORDER BY id ASC";
                $list = $this->db->query($query)->result();

                $lists = [];
                foreach ($list as $keys => $values) {
                    $is_selected = 0;
                    $query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $userId AND fk_plan_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $details = $this->db->query($query)->row();
                    $is_auto = '0';
                    $expire_date = '';
                    if($details && ($last_plan->id == $details->id) ) {
                        if($details->is_auto == '1'){
                            $is_selected = 1;
                            $expire = strtotime($details->expire_date);
                            $today = strtotime("today");
                            if($today >= $expire){
                                $is_selected = 0;
                            }
                        } 

                        if($details->is_auto == '0'){
                            $expire = strtotime($details->expire_date);
                            $today = strtotime("today");
                            if($today <= $expire){
                                $is_selected = 1;
                            }
                        }
                        
                        $is_auto = $details->is_auto;  
                        $expire_date = $details->expire_date;               
                    }
                    $values->is_selected = $is_selected;
                    $values->is_auto = $is_auto;
                    $values->expire_date = $expire_date;
                    $values->plan_description = ($_POST['lang'] == 'dnk') ? json_decode($values->dnk_description) : json_decode($values->plan_description);
                    $values->plan_name = ($_POST['lang'] == 'dnk') ? $values->dnk_name : $values->plan_name;
                    $values->discount_msg = ($_POST['lang'] == 'dnk') ? $values->dnk_discount_msg : $values->discount_msg;
                    $lists[] = $values;                 
                }

                $this->chk = 1;
                $this->msg = 'Plan Lists';

                $this->return_data = array('list' => $lists);

            }
        }
    }   

    public function rudra_package_list_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 

                $userId = $_POST['user_id'];
                $last_query = "SELECT * FROM rudra_purchased_package where fk_user_id = $userId AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $last_package = $this->db->query($last_query)->row();

                $query = "SELECT * FROM rudra_package ORDER BY id ASC";
                $list = $this->db->query($query)->result();

                $lists = [];
                foreach ($list as $keys => $values) {
                    $is_selected = 0;
                    $query = "SELECT * FROM rudra_purchased_package where fk_user_id = $userId AND fk_package_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $details = $this->db->query($query)->row();
                    $is_auto = '0';
                    $expire_date = '';
                    if($details  && ($last_package->id == $details->id) ) {
                        if($details->is_auto == '1'){
                            $is_selected = 1;
                            $expire = strtotime($details->expire_date);
                            $today = strtotime("today");
                            if($today >= $expire){
                                $is_selected = 0;
                            } 
                        }

                        if($details->is_auto == '0'){
                            $expire = strtotime($details->expire_date);
                            $today = strtotime("today");
                            if($today <= $expire){
                                $is_selected = 1;
                            }
                        } 
                        
                        $is_auto = $details->is_auto;
                        $expire_date = $details->expire_date;
                    }
                    $values->is_selected = $is_selected;
                    $values->is_auto = $is_auto;
                    $values->expire_date = $expire_date;
                    $values->package_name = ($_POST['lang'] == 'dnk') ? $values->dnk_name : $values->package_name;
                    $values->package_description = ($_POST['lang'] == 'dnk') ? json_decode($values->dnk_description) : json_decode($values->package_description);
                    $values->discount_msg = ($_POST['lang'] == 'dnk') ? $values->dnk_discount_msg : $values->discount_msg;
                    $lists[] = $values;                 
                }

                $this->chk = 1;
                $this->msg = 'Package Lists';

                $this->return_data = array('list' => $lists);

            }
        }
    } 

    public function rudra_discover_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('current_lat', 'current_lat', 'required');
            $this->form_validation->set_rules('current_long', 'current_long', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 

                $current_lat = $_POST['current_lat'];
                $current_long = $_POST['current_long'];
                $user_id = $_POST['user_id'];
                $current_date = date('Y-m-d');

                $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $plan_details = $this->db->query($plan_query)->row();
                $is_visible = 1;
                // if($plan_details) {
                //     $is_visible = 1; 
                //     $expire = strtotime($plan_details->expire_date);
                //     $today = strtotime("today");
                //     if($today >= $expire){
                //         $is_visible = 0;
                //     }            
                // }

                $enquery = "SELECT *, (6371 * acos (cos (radians($current_lat))* cos(radians(market_lat))* cos( radians($current_long) - radians(market_long) )+ sin (radians($current_lat) )* sin(radians(market_lat)))) AS distance  FROM rudra_market where date(end_date) >= '$current_date' AND status = '1' AND is_deleted = '0' GROUP BY zipcode ORDER BY distance ASC LIMIT 4 ";

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
                        if(!empty($images)){
                            $image_url = base_url().$images[0]->path.$images[0]->file;
                        } 
                        else{
                            $query21 = "SELECT * FROM rudra_market_gallery where fk_market_id = 0 AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $images1 = $this->db->query($query21)->result();
                            foreach ($images1 as $ikeys => $ivalues) {
                                $image_url = base_url().$ivalues->path.$ivalues->file;
                            }
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

                $mquery = "SELECT *, (6371 * acos (cos (radians($current_lat))* cos(radians(market_lat))* cos( radians($current_long) - radians(market_long) )+ sin (radians($current_lat) )* sin(radians(market_lat)))) AS distance  FROM rudra_market where status = '1' AND is_deleted = '0'  ORDER BY distance ASC LIMIT 3";

                $market = $this->db->query($mquery)->result();

                $marketList = [];

                foreach ($market as $keys => $values) {

                    // $values->description = utf8_encode($values->description);
                    $values->description=mb_convert_encoding($values->description,"UTF-8","auto");

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
                            $ivalues->is_main = 0;
                            $ivalues->fullurl = base_url().$ivalues->path.$ivalues->file;
                            $image[] = $ivalues;
                        }

                        if(count($image) == 0){
                            $query21 = "SELECT * FROM rudra_market_gallery where fk_market_id = 0 AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $images1 = $this->db->query($query21)->result();
                            foreach ($images1 as $ikeys => $ivalues) {
                                $ivalues->is_visible = 1;
                                $ivalues->is_main = 0;
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

                        $userId = $_POST['user_id'];
                        $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $is_fav = $this->db->query($query4)->row();

                        $is_favs = false;

                        if(!empty($is_fav)){
                            $is_favs = true;
                        }

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
                        $values->is_main = 0;
                        $marketList[] = $values;
                    }
                }

                $flea_data_query = "SELECT * FROM rudra_settings where st_key = 'flea_data'";
                $flea_data = $this->db->query($flea_data_query)->row();

                $query1 = "SELECT * FROM rudra_market where status = '1' AND is_deleted = '0' AND is_feature = '1'";
                if($is_visible == '0'){
                    $query1 = $query1 .' '. " HAVING  distance <= 20 ";
                }
                $query1 = $query1.' '." ORDER BY id DESC";
                $feature = $this->db->query($query1)->result();

                $features = array();
                foreach ($feature as $keys => $values) {

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

                        $userId = $_POST['user_id'];
                        $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $is_fav = $this->db->query($query4)->row();

                        $is_favs = false;

                        if(!empty($is_fav)){
                            $is_favs = true;
                        }

                        $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $share = $this->db->query($query5)->result();

                        $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name, rudra_category_details.dnk_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $values->id";
                        $catList = $this->db->query($query6)->result();

                        $catLists = '';
                        foreach ($catList as $ckeys => $cvalues) {
                            if ($ckeys === key($catList)) {
                                $catLists =  ($_POST['lang'] == 'dnk') ? $cvalues->dnk_name : $cvalues->category_name;
                            }
                            else{
                                $lang = ($_POST['lang'] == 'dnk') ? $cvalues->dnk_name : $cvalues->category_name;
                                $catLists = $catLists .', '.  $lang;
                            }                        
                        }

                        $today = date("Y-m-d H:i:s");
                        $start = $values->start_date.' '.$values->start_time;

                        $today_time = strtotime($today);
                        $start_time = strtotime($start);

                        if ($start_time > $today_time) {
                            $values->is_open = 'Upcoming';
                        }

                        $values->total_favorite = count($fav);
                        $values->is_favorite = $is_favs; 
                        $values->total_share = count($share);
                        $values->categories_name = $catLists;
                        $values->images = $image;
                        $values->videos = $video;
                        $values->videostumb = $videotumb;                    
                        $values->is_contact_show = $is_visible;
                        $features[] = $values;
                    }
                }

                $this->return_data = array('explore_nearby' => $explLists, 'market' => $features, 'flea_data' => ($_POST['lang'] == 'dnk') ? json_decode($flea_data->dnk_meta) : json_decode($flea_data->st_meta) );

                $this->chk = 1;
                $this->msg = 'Discver Lists';

            }
        }
    } 

    public function rudra_market_explore_by_zipcode_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('zipcode', 'zipcode', 'required');
            $this->form_validation->set_rules('current_lat', 'current_lat', 'required');
            $this->form_validation->set_rules('current_long', 'current_long', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $zipcode = $_POST['zipcode'];
                $user_id = $_POST['user_id'];
                $current_lat = $_POST['current_lat'];
                $current_long = $_POST['current_long'];

                $plan_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $plan_details = $this->db->query($plan_query)->row();
                $is_visible = 1;
                // if($plan_details) {
                //     $is_visible = 1; 
                //     $expire = strtotime($plan_details->expire_date);
                //     $today = strtotime("today");
                //     if($today >= $expire){
                //         $is_visible = 0;
                //     }            
                // }

                $mquery = "SELECT *, (6371 * acos (cos (radians($current_lat))* cos(radians(market_lat))* cos( radians($current_long) - radians(market_long) )+ sin (radians($current_lat) )* sin(radians(market_lat)))) AS distance  FROM rudra_market where zipcode = $zipcode AND status = '1' AND is_deleted = '0'  ORDER BY distance ASC";

                $market = $this->db->query($mquery)->result();

                $marketList = [];

                foreach ($market as $keys => $values) {

                    // $values->description = utf8_encode($values->description);
                    $values->description=mb_convert_encoding($values->description,"UTF-8","auto");

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

                        $userId = $_POST['user_id'];
                        $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $is_fav = $this->db->query($query4)->row();

                        $is_favs = false;

                        if(!empty($is_fav)){
                            $is_favs = true;
                        }

                        $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $share = $this->db->query($query5)->result();

                        $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name, rudra_category_details.dnk_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $values->id";
                        $catList = $this->db->query($query6)->result();

                        $catLists = '';
                        foreach ($catList as $ckeys => $cvalues) {
                            if ($ckeys === key($catList)) {
                                if($_POST['lang'] == 'dnk'){
                                    $catLists = $cvalues->dnk_name;
                                }
                                else{
                                   $catLists = $cvalues->category_name; 
                               }                                    
                            }
                            else{
                                if($_POST['lang'] == 'dnk'){
                                    $catLists = $catLists .', '. $cvalues->dnk_name;
                                }
                                else{
                                    $catLists = $catLists .', '. $cvalues->category_name;
                                }
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

                $fquery = "SELECT *, (6371 * acos (cos (radians($current_lat))* cos(radians(market_lat))* cos( radians($current_long) - radians(market_long) )+ sin (radians($current_lat) )* sin(radians(market_lat)))) AS distance  FROM rudra_market where zipcode = $zipcode AND is_feature = '1' AND status = '1' AND is_deleted = '0'  ORDER BY distance ASC";

                $features = $this->db->query($fquery)->result();

                $featuresList = [];

                foreach ($features as $keys => $values) {

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

                        $userId = $_POST['user_id'];
                        $query4 = "SELECT * FROM rudra_user_fav_markets where fk_user_id = $userId AND fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $is_fav = $this->db->query($query4)->row();

                        $is_favs = false;

                        if(!empty($is_fav)){
                            $is_favs = true;
                        }

                        $query5 = "SELECT * FROM rudra_user_share_markets where fk_market_id = $values->id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $share = $this->db->query($query5)->result();

                        $query6 = "SELECT rudra_market_category.*, rudra_category_details.category_name, rudra_category_details.dnk_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $values->id";
                        $catList = $this->db->query($query6)->result();

                        $catLists = '';
                        foreach ($catList as $ckeys => $cvalues) {
                            if ($ckeys === key($catList)) {
                                if($_POST['lang'] == 'dnk'){
                                    $catLists = $cvalues->dnk_name;
                                }
                                else{
                                   $catLists = $cvalues->category_name; 
                               }                                    
                            }
                            else{
                                if($_POST['lang'] == 'dnk'){
                                    $catLists = $catLists .', '. $cvalues->dnk_name;
                                }
                                else{
                                    $catLists = $catLists .', '. $cvalues->category_name;
                                }
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
                        $featuresList[] = $values;
                    }
                }

                $this->return_data = array('current' => $marketList, 'feature' => $featuresList);

                $this->chk = 1;
                $this->msg = 'Discver Lists';

            }
        }
    } 

}
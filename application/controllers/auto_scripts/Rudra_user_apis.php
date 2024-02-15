
<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Rudra_user_apis extends MY_Controller
{                   
    
    private $api_status = false;
	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->bdp = $this->db->dbprefix;
        $this->table = 'rudra_user';
		$this->msg = 'input error';
		$this->return_data = array();
        $this->chk = 0;
		//$this->load->model('global_model', 'gm');
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
     //rudra_user API Routes
	$t_name = 'auto_scripts/Rudra_user_apis/';
    
	$route[$api_ver.'user/(:any)'] = $t_name.'rudra_rudra_user/$1';

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

    public function rudra_rudra_user($param1)
    {
        $call_type = $param1;
        $res = array();
        if($call_type == 'login')
        {            
            $res = $this->rudra_save_data($_POST);        
        }
        else if($call_type == 'signup')
        {            
            $res = $this->rudra_signup_data($_POST);        
        }
        elseif($call_type == 'personal_info')
        {           
            $res = $this->rudra_update_data($_POST);        
        }
        elseif($call_type == 'profile_pic')
        {           
            $res = $this->rudra_profile_pic($_POST);        
        }
        elseif($call_type == 'profile_pic_delete')
        {           
            $res = $this->rudra_profile_pic_delete($_POST);        
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
        elseif($call_type == 'category')
        {
            $res = $this->rudra_category_list_data($_POST);        
        } 
        elseif($call_type == 'forgot-sent-mail') {
            $res = $this->forgotSentMail($_POST);
        }
        elseif($call_type == 'check-package') {
            $res = $this->userAuth($_POST);
        }

        $this->json_output(200,array('status' => 200,'message' => $this->msg,'data'=>$this->return_data,'chk' => $this->chk));

    }
    
    public function rudra_save_data()
    {     
        //print_r($_POST);exit;
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            // if(isset($_POST['social_type']) && $_POST['social_type'] != 'facebook' && isset($_POST['social_type']) && $_POST['social_type'] != 'apple')
            // {
                // $this->form_validation->set_rules('email_id', 'email_id', 'required');
                //$this->form_validation->set_rules('profile_pic', 'profile_pic', 'required');
            // }
			
            if(isset($_POST['social_type']) && $_POST['social_type'] != 'google' && isset($_POST['social_type']) && $_POST['social_type'] != 'facebook' && isset($_POST['social_type']) && $_POST['social_type'] != 'apple')
            {
                $this->form_validation->set_rules('password', 'password', 'required');
            }
            else
            {
                $this->form_validation->set_rules('social_id', 'social_id', 'required');
                
               
            }			
			$this->form_validation->set_rules('social_type', 'social_type--google/facebook/email', 'required');
            //$this->form_validation->set_rules('device_token', 'device_token', 'required');
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $email_id = $_POST['email_id'];
                $std = date('Y-m-d H:i:s');
                $new_id = 0;
                $user_chk = $this->db->get_where("$this->table",array('email_id' => $email_id))->row();
                $social_id = (isset($_POST['social_id']) ? $_POST['social_id'] :'');
                $social_type = (isset($_POST['social_type']) ? $_POST['social_type'] :'');
                $user_social_chk = $this->db->get_where("$this->table",array('social_id' => $social_id,'social_type' =>$social_type))->row();
               
                if($_POST['social_type'] == 'email')
                {
                    $password = SHA1($_POST['password']);
                    $user_chk = $this->db->get_where("$this->table",array('email_id' => $email_id))->row();
                    if(!empty($user_chk))
                    {
                        $user_chk = $this->db->get_where("$this->table",array('email_id' => $email_id,'password' =>$password,'social_type' => 'email'))->row();
                        //echo $this->db->last_query();
                        if(!empty($user_chk))
                        {
                            $this->db->where('id',$user_chk->id);
                            $this->db->update($this->table,array('fcm_token'=>(isset($_POST['fcm_token']) ? $this->input->post('fcm_token',true) : '')));
                            $user_chk = $this->db->get_where($this->table,array('id'=>$user_chk->id))->row();

                            $plan = [];

                            $plan_query = "SELECT rudra_purchased_plan.*, rudra_plan.plan_name, rudra_plan.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_plan LEFT JOIN rudra_plan ON rudra_purchased_plan.fk_plan_id=rudra_plan.id LEFT JOIN rudra_payment_method ON rudra_purchased_plan.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_plan.fk_user_id = $user_chk->id AND rudra_purchased_plan.status = '1' AND rudra_purchased_plan.is_deleted = '0' ORDER BY rudra_purchased_plan.id DESC";
                            $plan_details = $this->db->query($plan_query)->row_array();

                            if(!empty($plan_details)){
                               $plan = [$plan_details];
                            }

                            $package = [];

                            $package_query = "SELECT rudra_purchased_package.*, rudra_package.package_name, rudra_package.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_package LEFT JOIN rudra_package ON rudra_purchased_package.fk_package_id=rudra_package.id LEFT JOIN rudra_payment_method ON rudra_purchased_package.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_package.fk_user_id = $user_chk->id AND rudra_purchased_package.status = '1' AND rudra_purchased_package.is_deleted = '0' ORDER BY rudra_purchased_package.id DESC";

                            $package_details = $this->db->query($package_query)->row_array();

                            if(!empty($package_details)){
                               $package = [$package_details];
                            }

                            $user_chk->plan = $plan;
                            $user_chk->package = $package;

                            if($user_chk->profile_pic != ''){
                                $user_chk->profile_pic = base_url().$user_chk->profile_pic;
                            }  

                            if($user_chk->profile_pic == null){
                                $user_chk->profile_pic = '';
                            }   

                            if($user_chk->first_name == null){
                                $user_chk->first_name = '';
                            } 
                            if($user_chk->last_name == null){
                                $user_chk->last_name = '';
                            } 
                            if($user_chk->social_id == null){
                                $user_chk->social_id = '';
                            } 
                            if($user_chk->mobile == null){
                                $user_chk->mobile = '';
                            } 
                            if($user_chk->zip_code == null){
                                $user_chk->zip_code = '';
                            } 
                            if($user_chk->city == null){
                                $user_chk->city = '';
                            }  

                            $this->chk = 1;
                            $this->msg = "Login Successful";   
                            $this->return_data = $user_chk;
                            
                        }
                        else
                        {
                            $this->chk = 0;
                            $this->msg = "Wrong Credentials";
                        }
                    }
                    else
                    {
                        $this->chk = 0;
                        $this->msg = "Please Signup first";
                    }
                  
                }
                else
                {
                    if($email_id != ''){
                        $user_chk = $this->db->get_where("$this->table",array('email_id' => $email_id))->row();
                        if(empty($user_chk))
                        {
                            $user_social_chk = $this->db->get_where("$this->table",array('social_id' => $social_id,'social_type' =>$social_type))->row();
                            if(empty($user_social_chk))
                            {
                                //Insert Codes goes here 
                                $updateArray = 
                                array(
                                'email_id' => (isset($_POST['email_id']) ? $this->input->post('email_id',true) : ''),
                                'password' => (isset($_POST['password']) ? SHA1($this->input->post('password',true)) : ''),
                                'social_id' => (isset($_POST['social_id']) ? $this->input->post('social_id',true) : ''),
                                'social_type' => (isset($_POST['social_type']) ? $this->input->post('social_type',true) : ''),
                                'device_token' => (isset($_POST['device_token']) ? $this->input->post('device_token',true) : ''),
                                'fcm_token' => (isset($_POST['fcm_token']) ? $this->input->post('fcm_token',true) : ''),

                                );

                                $this->db->insert("$this->table",$updateArray);
                                $new_id = $this->db->insert_id();
                                $user_chk = $this->db->get_where("$this->table",array('id' => $new_id))->row();

                                $plan = [];

                                $plan_query = "SELECT rudra_purchased_plan.*, rudra_plan.plan_name, rudra_plan.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_plan LEFT JOIN rudra_plan ON rudra_purchased_plan.fk_plan_id=rudra_plan.id LEFT JOIN rudra_payment_method ON rudra_purchased_plan.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_plan.fk_user_id = $user_chk->id AND rudra_purchased_plan.status = '1' AND rudra_purchased_plan.is_deleted = '0' ORDER BY rudra_purchased_plan.id DESC";
                                $plan_details = $this->db->query($plan_query)->row_array();

                                if(!empty($plan_details)){
                                   $plan = [$plan_details];
                                }

                                $package = [];

                                $package_query = "SELECT rudra_purchased_package.*, rudra_package.package_name, rudra_package.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_package LEFT JOIN rudra_package ON rudra_purchased_package.fk_package_id=rudra_package.id LEFT JOIN rudra_payment_method ON rudra_purchased_package.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_package.fk_user_id = $user_chk->id AND rudra_purchased_package.status = '1' AND rudra_purchased_package.is_deleted = '0' ORDER BY rudra_purchased_package.id DESC";

                                $package_details = $this->db->query($package_query)->row_array();

                                if(!empty($package_details)){
                                   $package = [$package_details];
                                }

                                $user_chk->plan = $plan;
                                $user_chk->package = $package;

                                if($user_chk->profile_pic != ''){
                                    $user_chk->profile_pic = base_url().$user_chk->profile_pic;
                                }

                                if($user_chk->profile_pic == null){
                                    $user_chk->profile_pic = '';
                                }   

                                $this->msg = 'Login Successfully';
                                $this->chk = 1;
                                $this->return_data = $user_chk;
                            }
                            else
                            {
                                $user_chk = $this->db->get_where("$this->table",array('id' => $user_social_chk->id))->row();
                                $this->db->where('id',$user_chk->id);
                                $this->db->update($this->table,array('fcm_token' =>(isset($_POST['fcm_token']) ? $this->input->post('fcm_token',true) : '')));
                                $user_chk = $this->db->get_where($this->table,array('id'=>$user_chk->id))->row();

                                $plan = [];

                                $plan_query = "SELECT rudra_purchased_plan.*, rudra_plan.plan_name, rudra_plan.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_plan LEFT JOIN rudra_plan ON rudra_purchased_plan.fk_plan_id=rudra_plan.id LEFT JOIN rudra_payment_method ON rudra_purchased_plan.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_plan.fk_user_id = $user_chk->id AND rudra_purchased_plan.status = '1' AND rudra_purchased_plan.is_deleted = '0' ORDER BY rudra_purchased_plan.id DESC";
                                $plan_details = $this->db->query($plan_query)->row_array();

                                if(!empty($plan_details)){
                                   $plan = [$plan_details];
                                }

                                $package = [];

                                $package_query = "SELECT rudra_purchased_package.*, rudra_package.package_name, rudra_package.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_package LEFT JOIN rudra_package ON rudra_purchased_package.fk_package_id=rudra_package.id LEFT JOIN rudra_payment_method ON rudra_purchased_package.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_package.fk_user_id = $user_chk->id AND rudra_purchased_package.status = '1' AND rudra_purchased_package.is_deleted = '0' ORDER BY rudra_purchased_package.id DESC";

                                $package_details = $this->db->query($package_query)->row_array();

                                if(!empty($package_details)){
                                   $package = [$package_details];
                                }

                                $user_chk->plan = $plan;
                                $user_chk->package = $package;

                                if($user_chk->profile_pic != ''){
                                    $user_chk->profile_pic = base_url().$user_chk->profile_pic;
                                }

                                if($user_chk->profile_pic == null){
                                    $user_chk->profile_pic = '';
                                }   

                                $this->msg = 'Login Successfully';
                                $this->chk = 1;
                                $this->return_data = $user_chk;
                            }
                        } 
                        else{

                            $this->db->where('id',$user_chk->id);
                            $this->db->update($this->table,array('fcm_token'=>(isset($_POST['fcm_token']) ? $this->input->post('fcm_token',true) : '')));
                            $user_chk = $this->db->get_where($this->table,array('id'=>$user_chk->id))->row();

                            $plan = [];

                            $plan_query = "SELECT rudra_purchased_plan.*, rudra_plan.plan_name, rudra_plan.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_plan LEFT JOIN rudra_plan ON rudra_purchased_plan.fk_plan_id=rudra_plan.id LEFT JOIN rudra_payment_method ON rudra_purchased_plan.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_plan.fk_user_id = $user_chk->id AND rudra_purchased_plan.status = '1' AND rudra_purchased_plan.is_deleted = '0' ORDER BY rudra_purchased_plan.id DESC";
                            $plan_details = $this->db->query($plan_query)->row_array();

                            if(!empty($plan_details)){
                               $plan = [$plan_details];
                            }

                            $package = [];

                            $package_query = "SELECT rudra_purchased_package.*, rudra_package.package_name, rudra_package.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_package LEFT JOIN rudra_package ON rudra_purchased_package.fk_package_id=rudra_package.id LEFT JOIN rudra_payment_method ON rudra_purchased_package.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_package.fk_user_id = $user_chk->id AND rudra_purchased_package.status = '1' AND rudra_purchased_package.is_deleted = '0' ORDER BY rudra_purchased_package.id DESC";

                            $package_details = $this->db->query($package_query)->row_array();

                            if(!empty($package_details)){
                               $package = [$package_details];
                            }

                            $user_chk->plan = $plan;
                            $user_chk->package = $package;

                            if($user_chk->profile_pic != ''){
                                $user_chk->profile_pic = base_url().$user_chk->profile_pic;
                            }

                            if($user_chk->profile_pic == null){
                                $user_chk->profile_pic = '';
                            }  

                            $this->chk = 1;
                            $this->msg = "Login Successful";   
                            $this->return_data = $user_chk;
                        }  
                    }
                    else{
                        $user_social_chk = $this->db->get_where("$this->table",array('social_id' => $social_id,'social_type' =>$social_type))->row();
                        if(empty($user_social_chk))
                        {
                            //Insert Codes goes here 
                            $updateArray = 
                            array(
                            'email_id' => (isset($_POST['email_id']) ? $this->input->post('email_id',true) : ''),
                            'password' => (isset($_POST['password']) ? SHA1($this->input->post('password',true)) : ''),
                            'social_id' => (isset($_POST['social_id']) ? $this->input->post('social_id',true) : ''),
                            'social_type' => (isset($_POST['social_type']) ? $this->input->post('social_type',true) : ''),
                            'device_token' => (isset($_POST['device_token']) ? $this->input->post('device_token',true) : ''),
                            'fcm_token' => (isset($_POST['fcm_token']) ? $this->input->post('fcm_token',true) : ''),

                            );

                            $this->db->insert("$this->table",$updateArray);
                            $new_id = $this->db->insert_id();
                            $user_chk = $this->db->get_where("$this->table",array('id' => $new_id))->row();

                            $plan = [];

                            $plan_query = "SELECT rudra_purchased_plan.*, rudra_plan.plan_name, rudra_plan.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_plan LEFT JOIN rudra_plan ON rudra_purchased_plan.fk_plan_id=rudra_plan.id LEFT JOIN rudra_payment_method ON rudra_purchased_plan.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_plan.fk_user_id = $user_chk->id AND rudra_purchased_plan.status = '1' AND rudra_purchased_plan.is_deleted = '0' ORDER BY rudra_purchased_plan.id DESC";
                            $plan_details = $this->db->query($plan_query)->row_array();

                            if(!empty($plan_details)){
                               $plan = [$plan_details];
                            }

                            $package = [];

                            $package_query = "SELECT rudra_purchased_package.*, rudra_package.package_name, rudra_package.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_package LEFT JOIN rudra_package ON rudra_purchased_package.fk_package_id=rudra_package.id LEFT JOIN rudra_payment_method ON rudra_purchased_package.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_package.fk_user_id = $user_chk->id AND rudra_purchased_package.status = '1' AND rudra_purchased_package.is_deleted = '0' ORDER BY rudra_purchased_package.id DESC";

                            $package_details = $this->db->query($package_query)->row_array();

                            if(!empty($package_details)){
                               $package = [$package_details];
                            }

                            $user_chk->plan = $plan;
                            $user_chk->package = $package;

                            if($user_chk->profile_pic != ''){
                                $user_chk->profile_pic = base_url().$user_chk->profile_pic;
                            }

                            if($user_chk->profile_pic == null){
                                $user_chk->profile_pic = '';
                            }    

                            $this->msg = 'Login Successfully';
                            $this->chk = 1;
                            $this->return_data = $user_chk;
                        }
                        else
                        {
                            $user_chk = $this->db->get_where("$this->table",array('id' => $user_social_chk->id))->row();
                            $this->db->where('id',$user_chk->id);
                            $this->db->update($this->table,array('fcm_token' =>(isset($_POST['fcm_token']) ? $this->input->post('fcm_token',true) : '')));
                            $user_chk = $this->db->get_where($this->table,array('id'=>$user_chk->id))->row();

                            $plan = [];

                            $plan_query = "SELECT rudra_purchased_plan.*, rudra_plan.plan_name, rudra_plan.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_plan LEFT JOIN rudra_plan ON rudra_purchased_plan.fk_plan_id=rudra_plan.id LEFT JOIN rudra_payment_method ON rudra_purchased_plan.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_plan.fk_user_id = $user_chk->id AND rudra_purchased_plan.status = '1' AND rudra_purchased_plan.is_deleted = '0' ORDER BY rudra_purchased_plan.id DESC";
                            $plan_details = $this->db->query($plan_query)->row_array();

                            if(!empty($plan_details)){
                               $plan = [$plan_details];
                            }

                            $package = [];

                            $package_query = "SELECT rudra_purchased_package.*, rudra_package.package_name, rudra_package.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_package LEFT JOIN rudra_package ON rudra_purchased_package.fk_package_id=rudra_package.id LEFT JOIN rudra_payment_method ON rudra_purchased_package.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_package.fk_user_id = $user_chk->id AND rudra_purchased_package.status = '1' AND rudra_purchased_package.is_deleted = '0' ORDER BY rudra_purchased_package.id DESC";

                            $package_details = $this->db->query($package_query)->row_array();

                            if(!empty($package_details)){
                               $package = [$package_details];
                            }

                            $user_chk->plan = $plan;
                            $user_chk->package = $package;

                            if($user_chk->profile_pic != ''){
                                $user_chk->profile_pic = base_url().$user_chk->profile_pic;
                            }

                            if($user_chk->profile_pic == null){
                                $user_chk->profile_pic = '';
                            }    

                            $this->msg = 'Login Successfully';
                            $this->chk = 1;
                            $this->return_data = $user_chk;
                        }
                    }    
                }

            }
        }
       
    }


    public function rudra_signup_data()
    {     
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('email_id', 'email_id', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
			$this->form_validation->set_rules('social_type', 'social_type--google/facebook/email', 'required');
            $this->form_validation->set_rules('device_token', 'device_token', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $email_id = $_POST['email_id'];
                $std = date('Y-m-d H:i:s');
                $new_id = 0;
                $user_chk = $this->db->get_where("$this->table",array('email_id' => $email_id))->row();
                if(empty($user_chk))
                {
                    //Insert Codes goes here 
                    $updateArray = 
                    array(
                    'email_id' => (isset($_POST['email_id']) ? $this->input->post('email_id',true) : ''),
                    'password' => (isset($_POST['password']) ? SHA1($this->input->post('password',true)) : ''),
                    'social_type' => (isset($_POST['social_type']) ? $this->input->post('social_type',true) : ''),
                    'device_token' => (isset($_POST['device_token']) ? $this->input->post('device_token',true) : ''),
                    'fcm_token' => (isset($_POST['fcm_token']) ? $this->input->post('fcm_token',true) : ''),

                    );

                    $this->db->insert("$this->table",$updateArray);
                    $new_id = $this->db->insert_id();
                    $this->msg = 'Signup Successfully';
                    $this->chk = 1;
                }
                else
                { 
                     $new_id = $user_chk->id;
                     $this->msg = 'User Exists';
                     $this->chk = 0;
                }
              
                
                $res = $this->db->get_where("$this->table",array('id' => $new_id ))->row();
                
                 $res->added_on_custom_date = date('d-M-Y',strtotime($res->added_on));
                 $res->added_on_custom_time = date('H:i:s A',strtotime($res->added_on));
                 $res->updated_on_custom_date = date('d-M-Y',strtotime($res->updated_on));
                 $res->updated_on_custom_time = date('H:i:s A',strtotime($res->updated_on));
                 $res->profile_pic = ($res->is_social_image == 1 ? $res->profile_pic : base_url().$res->profile_pic);
                
                 if($res->profile_pic == null){
                    $res->profile_pic = '';
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
			$this->form_validation->set_rules('user_id', 'user_id', 'required');
			$this->form_validation->set_rules('first_name', 'first_name', 'required');
			$this->form_validation->set_rules('birth_date', 'birth_date', 'required');
			$this->form_validation->set_rules('gender', 'gender', 'required');
			$this->form_validation->set_rules('location', 'location', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $new_id = $pk_id = $this->input->post('user_id');
                $chk_data = $this->db->get_where("$this->table",array('id' => $pk_id))->row();
                if(!empty($chk_data))
                {
                    $std = date('Y-m-d H:i:s');
                    //Update Codes goes here 
                    $updateArray = 
					array(
					 'first_name' => $this->input->post('first_name',true),
					 'birth_date' => date('Y-m-d',strtotime($this->input->post('birth_date',true))),
					 'gender' => ucfirst($this->input->post('gender',true)),
					 'location' => $this->input->post('location',true),
                     'mobile' => $this->input->post('mobile',true),
                     'is_complete' => 1,
                     'user_long' => (isset($_POST['user_long']) ? $_POST['user_long'] :'' ),
                     'user_lat' => (isset($_POST['user_lat']) ? $_POST['user_lat'] :'' ),
                     'zip_code' => (isset($_POST['user_lat']) ? $_POST['zip_code'] :'' ),
                     'city' => (isset($_POST['city']) ? $_POST['city'] :'' ),
					);

                    $this->db->where('id',$pk_id);
                    $this->db->update("$this->table",$updateArray);
                    
                    $this->chk = 1;
                    $this->msg = 'Information Updated';
                    $res = $this->db->get_where("$this->table",array('id' => $pk_id))->row();
                    $res->added_on_custom_date = date('d-M-Y',strtotime($res->added_on));
                    $res->added_on_custom_time = date('H:i:s A',strtotime($res->added_on));
                    $res->updated_on_custom_date = date('d-M-Y',strtotime($res->updated_on));
                    $res->updated_on_custom_time = date('H:i:s A',strtotime($res->updated_on));
                    $res->profile_pic = ($res->is_social_image == 1 ? $res->profile_pic : base_url().$res->profile_pic);

                    $plan = [];

                    $plan_query = "SELECT rudra_purchased_plan.*, rudra_plan.plan_name, rudra_plan.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_plan LEFT JOIN rudra_plan ON rudra_purchased_plan.fk_plan_id=rudra_plan.id LEFT JOIN rudra_payment_method ON rudra_purchased_plan.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_plan.fk_user_id = $pk_id AND rudra_purchased_plan.status = '1' AND rudra_purchased_plan.is_deleted = '0' ORDER BY rudra_purchased_plan.id DESC";
                    $plan_details = $this->db->query($plan_query)->row_array();

                    if(!empty($plan_details)){
                       $plan = [$plan_details];
                    }

                    $package = [];

                    $package_query = "SELECT rudra_purchased_package.*, rudra_package.package_name, rudra_package.price, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_package LEFT JOIN rudra_package ON rudra_purchased_package.fk_package_id=rudra_package.id LEFT JOIN rudra_payment_method ON rudra_purchased_package.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_package.fk_user_id = $pk_id AND rudra_purchased_package.status = '1' AND rudra_purchased_package.is_deleted = '0' ORDER BY rudra_purchased_package.id DESC";

                    $package_details = $this->db->query($package_query)->row_array();

                    if(!empty($package_details)){
                       $package = [$package_details];
                    }

                    $res->plan = $plan;
                    $res->package = $package;

                    if($res->profile_pic == null){
                        $res->profile_pic = '';
                     }
                    $this->return_data = $res;
                }
                else
                {
                    $this->chk = 0;
                    $this->msg = 'Record Not Found';   
                }
            }
        }
        
    }

    public function rudra_profile_pic()
    {
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if(!isset($_FILES['profile_pic'])) 
            {
                $this->form_validation->set_rules('profile_pic', 'profile_pic', 'required');
            }
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $user_id = $_POST['user_id'];
                if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name'] != '') 
                {
                    $bannerpath = 'uploads/user';
                    $thumbpath = 'uploads/user';
                    $config['upload_path'] = $bannerpath;
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|PNG|JPG|JPEG';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if(!$this->upload->do_upload('profile_pic'))
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
                    $up_array = array(
                                    'profile_pic' => $bannerpath . '/' . $uploadedImage['file_name'],
                                    'is_social_image' => 0
                                    );
                    $this->db->where('id', $user_id);
                    $this->db->update($this->table, $up_array);
                    $res = $this->db->get_where("$this->table",array('id' => $user_id))->row();
                    $res->added_on_custom_date = date('d-M-Y',strtotime($res->added_on));
                    $res->added_on_custom_time = date('H:i:s A',strtotime($res->added_on));
                    $res->updated_on_custom_date = date('d-M-Y',strtotime($res->updated_on));
                    $res->updated_on_custom_time = date('H:i:s A',strtotime($res->updated_on));
                    $res->profile_pic = ($res->is_social_image == 1 ? $res->profile_pic : base_url().$res->profile_pic);
                    $this->return_data = $res;
                    $this->chk = 1;
                    $this->msg = 'User Details';
                }
                else
                {
                    $this->msg = "Please upload Profile Pic";
                }
                
               
            }
        }
        
    }

    public function rudra_profile_pic_delete()
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
                $up_array = array('profile_pic' => null);
                $this->db->where('id', $user_id);
                $this->db->update($this->table, $up_array);

                $user_chk = $this->db->get_where($this->table,array('id'=>$user_id))->row();

                $plan = 0;

                $plan_query = "SELECT rudra_plan.* FROM rudra_purchased_plan INNER JOIN rudra_plan ON rudra_purchased_plan.fk_plan_id=rudra_plan.id where rudra_purchased_plan.fk_user_id = $user_id";
                $plan_chk = $this->db->query($plan_query)->row();

                if(!empty($plan_chk)){
                    if($plan_chk->plan_name == 'Silver'){
                        $plan = 1;
                    }
                    else{
                        $plan = 2;
                    }
                }

                $user_chk->plan = $plan;
                if($user_chk->profile_pic != ''){
                    $user_chk->profile_pic = base_url().$user_chk->profile_pic;
                }
                $this->chk = 1; 
                $this->return_data = $user_chk;
                $this->msg = 'Profile pic successfully deleted';
            }
        }
        
    }
    
    public function rudra_delete_data()
    {
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            
			$this->form_validation->set_rules('first_name', 'first_name', 'required');
			$this->form_validation->set_rules('last_name', 'last_name', 'required');
			$this->form_validation->set_rules('birth_date', 'birth_date', 'required');
			$this->form_validation->set_rules('gender', 'gender', 'required');
			$this->form_validation->set_rules('location', 'location', 'required');
			$this->form_validation->set_rules('email_id', 'email_id', 'required');
			$this->form_validation->set_rules('password', 'password', 'required');
			$this->form_validation->set_rules('social_id', 'social_id', 'required');
			$this->form_validation->set_rules('social_type', 'social_type', 'required');
			$this->form_validation->set_rules('profile_pic', 'profile_pic', 'required');
			$this->form_validation->set_rules('forgot_code', 'forgot_code', 'required');
			$this->form_validation->set_rules('forgot_expiry_time', 'forgot_expiry_time', 'required');
			$this->form_validation->set_rules('mobile', 'mobile', 'required');
			$this->form_validation->set_rules('status', 'status', 'required');
			$this->form_validation->set_rules('is_delete', 'is_delete', 'required');
			$this->form_validation->set_rules('created_at', 'created_at', 'required');
			$this->form_validation->set_rules('updated_at', 'updated_at', 'required');
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
                $chk_data = $this->db->get_where("$this->table",array('id' => $pk_id))->row();
                if(!empty($chk_data))
                {
                   
                   // $this->db->where('id',$pk_id);
                   // $this->db->delete("$this->table");
                    $this->chk = 1;
                    $this->msg = 'Information deleted';
                    
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
                $flea_id = (isset($_POST['flea_id']) ? $_POST['flea_id'] : 0);
                $res = $this->db->get($this->bdp."category_details")->result();
                if(!empty($res))
                {
                    $list = array();
                    $event_det = $this->db->get_where($this->bdp.'event',array('id'=>$flea_id))->row();
                    $event_cat_id = (!empty($event_det) ? $event_det->fk_category_id : 0);
                    foreach($res as $rr)
                    {
                        $rr->is_selected = ($event_cat_id == $rr->id ? 1 : 0);
                        $list[] = $rr;
                    }
                    $this->chk = 1;
                    $this->msg = 'Event Category List';
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

    public function userAuth()
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
                $authorized = $this->usersViewerCreator($user_id);
                // $package_query = "SELECT * FROM rudra_purchased_package where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                // $package_details = $this->db->query($package_query)->row();
                // $is_visible = 0;
                // if($package_details) {
                //     $is_visible = 1; 
                //     $expire = strtotime($package_details->expire_date);
                //     $today = strtotime("today");
                //     if($today >= $expire){
                //         $is_visible = 0;
                //     }            
                // }

                // $msg = "Success";
                // $chk = 1;
                // if($is_visible == 0){
                //    $msg = "Upgrade your package.";
                //     if($_POST['lang'] == 'dnk'){
                //         $msg = "Opgrader din pakke.";
                //     } 
                //     $chk = 0;
                // }

                $msg = "Upgrade your package.";

                if($_POST['lang'] == 'dnk'){
                    $msg = "Opgrader din pakke.";
                } 

                $authorized['msg'] = $msg;
                
                $this->chk = 1;
                $this->msg = $msg;
                $this->return_data = $authorized;
            }
        }
    }
    public function forgotSentMail()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_email', 'user_email', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 

                $details = $this->gm->get_details('*', 'rudra_user', array('email_id' => $_POST['user_email'], 'social_type' => 'email'));

                if($details){

                    $token = sha1(mt_rand(1, 90000) . 'SALT');
                    $pass = ''; 

                    $url = 'https://api.sendgrid.com/';
                    $data['token'] = $token;
                    $html = $this->load->view("email/forgot", $data, TRUE);

                    //remove the user and password params - no longer needed
                    $params = array(
                        'to'        => $_POST['user_email'],     
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

                    $this->chk = 1;
                    $this->msg = "Send reset password link";
                    $this->return_data = array();
                }
                else{

                    $this->chk = 1;
                    $this->msg = "emailid is not register";
                    $this->return_data = array();

                }                

            }
        }
    }
      
                    
}

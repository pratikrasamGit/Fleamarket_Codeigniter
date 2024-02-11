
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Rudra_user_apis extends CI_Controller
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
        elseif($call_type == 'update')
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

        $this->json_output(200,array('status' => 200,'message' => $this->msg,'data'=>$this->return_data,'chk' => $this->chk));

    }
    
    public function rudra_save_data()
    {     
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
			$this->form_validation->set_rules('email_id', 'email_id', 'required');
            if(isset($_POST['social_type']) && $_POST['social_type'] == 'email')
            {
                $this->form_validation->set_rules('password', 'password', 'required');
            }
            else
            {
                $this->form_validation->set_rules('social_id', 'social_id', 'required');
                $this->form_validation->set_rules('profile_pic', 'profile_pic', 'required');
               
            }			
			$this->form_validation->set_rules('social_type', 'social_type--google/facebook/email', 'required');
            $this->form_validation->set_rules('device_token', 'device_token', 'required');
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
                    'social_id' => (isset($_POST['social_id']) ? $this->input->post('social_id',true) : ''),
                    'social_type' => (isset($_POST['social_type']) ? $this->input->post('social_type',true) : ''),
                    'profile_pic' => (isset($_POST['profile_pic']) ? $this->input->post('profile_pic',true) : ''),
                    'device_token' => (isset($_POST['device_token']) ? $this->input->post('device_token',true) : ''),

                    );

                    $this->db->insert("$this->table",$updateArray);
                    $new_id = $this->db->insert_id();
                }
                else
                { 
                     $new_id = $user_chk->id;
                }
              
                
                $res = $this->db->get_where("$this->table",array('id' => $new_id ))->row();
                //Format Data if required
                /*********
                 $res->added_on_custom_date = date('d-M-Y',strtotime($res->added_on));
                 $res->added_on_custom_time = date('H:i:s A',strtotime($res->added_on));
                 $res->updated_on_custom_date = date('d-M-Y',strtotime($res->updated_on));
                 $res->updated_on_custom_time = date('H:i:s A',strtotime($res->updated_on));
                 ************/
                $this->chk = 1;
                $this->msg = 'Data Stored Successfully';
                $this->return_data = $res;
            }
        }
       
    }
    
    public function rudra_update_data()
    {
       if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            
			$this->form_validation->set_rules('id', 'id', 'required');
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
            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $new_id = $pk_id = $this->input->post('id');
                $chk_data = $this->db->get_where("$this->table",array('id' => $pk_id))->row();
                if(!empty($chk_data))
                {
                    $std = date('Y-m-d H:i:s');
                    //Update Codes goes here 
                    $updateArray = 
					array(
					 'first_name' => $this->input->post('first_name',true),
					 'last_name' => $this->input->post('last_name',true),
					 'birth_date' => $this->input->post('birth_date',true),
					 'gender' => $this->input->post('gender',true),
					 'location' => $this->input->post('location',true),
					 'email_id' => $this->input->post('email_id',true),
					 'password' => $this->input->post('password',true),
					 'social_id' => $this->input->post('social_id',true),
					 'social_type' => $this->input->post('social_type',true),
					 'profile_pic' => $this->input->post('profile_pic',true),
					 'forgot_code' => $this->input->post('forgot_code',true),
					 'forgot_expiry_time' => $this->input->post('forgot_expiry_time',true),
					 'mobile' => $this->input->post('mobile',true),
					 'status' => $this->input->post('status',true),
					 'is_delete' => $this->input->post('is_delete',true),
					 'created_at' => $this->input->post('created_at',true),
					 'updated_at' => $this->input->post('updated_at',true),
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
      
                    
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Rudra_needhelp_apis extends CI_Controller
{                   
    
    private $api_status = false;
	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->bdp = $this->db->dbprefix;
        $this->table = 'rudra_need_help_type';
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
    }

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

    public function rudra_rudra_needhelp($param1)
    {
        $call_type = $param1;
        $res = array();
        if($call_type == 'list')
        {            
            $res = $this->rudra_list_data($_POST);        
        }
        elseif($call_type == 'message')
        {
            $res = $this->rudra_message_data($_POST);        
        }
        elseif($call_type == 'message_list')
        {
            $res = $this->rudra_message_list_data($_POST);        
        }

        $this->json_output(200,array('status' => 200,'message' => $this->msg,'data'=>$this->return_data,'chk' => $this->chk));

    }

    public function rudra_list_data()
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

                $query = "SELECT * FROM $this->table";
                $list = $this->db->query($query)->result();

                $lists = [];
                foreach ($list as $keys => $values) {
                    $values->name = ($_POST['lang'] == 'dnk') ? $values->dnk_name : $values->name;
                    $lists[] = $values; 
                }

                $this->chk = 1;
                $this->msg = 'Need Help Lists';

                $this->return_data = array('list' => $lists);

            }
        }
    } 

    public function rudra_message_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('help_type_id', 'help_type_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                
                $user_id = $this->input->post('user_id',true);
                $insert_array = array(
                    'fk_user_id' => $user_id,
                    'fk_help_type_id' => $this->input->post('help_type_id',true),
                    'message' => $this->input->post('message',true)
                );

                $this->db->insert("rudra_need_help_message",$insert_array);
                $new_id = $this->db->insert_id();
                

                if(isset($_FILES['message_image']) && $_FILES['message_image']['name'] != '') 
                {
                    $uploadPath = 'uploads/needhelp';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|PNG|JPG|JPEG';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if(!$this->upload->do_upload('message_image'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                        exit('Errors');
                    }
                    else
                    {
                        $imagedata = array('message_image' => $this->upload->data());
                        $uploadedImage = $this->upload->data();
                    }

                    $update_array = array(
                        'file' => $uploadedImage['file_name'],
                        'path' => $uploadPath,
                        'fullpath' => base_url().$uploadPath.'/'.$uploadedImage['file_name']
                    );
                    $this->db->where('id',$new_id);
                    $this->db->update("rudra_need_help_message",$update_array);

                }

                /************/
                $this->chk = 1;
                $this->msg = 'Need Help Saved Successfully';

                $query = "SELECT * FROM rudra_need_help_message where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $list = $this->db->query($query)->result();

                $this->return_data = $list;
            }
        }
    }
    
    public function rudra_message_list_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('help_type_id', 'help_type_id', 'required');
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
                $help_type_id = $_POST['help_type_id'];

                /************/
                $this->chk = 1;
                $this->msg = 'Need Help List';

                $query = "SELECT * FROM rudra_need_help_message where fk_user_id = $user_id AND fk_help_type_id = $help_type_id AND status = '1' AND is_deleted = '0' ORDER BY id ASC";
                $list = $this->db->query($query)->result();

                $uquery = "SELECT * FROM rudra_user where id = $user_id";
                $udetails = $this->db->query($uquery)->row();

                $lists = array();
                foreach ($list as $keys => $values) {
                    $user_name = 'Admin';
                    $user_pic = 'https://www.loppekortet.dk/uploads/extra/logo.png';
                    if($values->fk_admin_id == null){
                        $user_name = $udetails->first_name.' '.$udetails->last_name;
                        if($udetails->profile_pic != ''){
                            if (strpos($udetails->profile_pic, "http") === 0) {
                                $user_pic = $udetails->profile_pic;
                            } else {
                                $user_pic = base_url().$udetails->profile_pic;
                            }
                        } 
                        else{
                            $user_pic = '';
                        }
                    }
                    if($values->fk_admin_id == null){
                        $values->fk_admin_id = '';
                    }
                    $values->user_name = $user_name;
                    $values->user_pic = $user_pic;
                    $lists[] = $values;
                }

                $this->return_data = $lists;
            }
        }
    }
}
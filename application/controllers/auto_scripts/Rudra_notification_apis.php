
<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Rudra_notification_apis extends CI_Controller
{                   
    
    private $api_status = false;
	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->bdp = $this->db->dbprefix;
        $this->table = 'rudra_notification';
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

    public function rudra_rudra_notification($param1)
    {
        $call_type = $param1;
        $res = array();
        if($call_type == 'list')
        {            
            $res = $this->rudra_list_data($_POST);        
        }

        $this->json_output(200,array('status' => 200,'message' => $this->msg,'data'=>$this->return_data,'chk' => $this->chk));

    }

    public function rudra_list_data()
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

                $user_id = $this->input->post('user_id',true);
                $query = "SELECT * FROM $this->table where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY created_at DESC";
                $list = $this->db->query($query)->result();

                $lists = [];
                foreach ($list as $keys => $values) {
                    $date = '';
                    if (strtotime($values->created_at) >= strtotime("today")){
                        $date = 'Today';
                    }
                    else if (strtotime($values->created_at) >= strtotime("yesterday")){
                        $date ='Yesterday';
                    }
                    else{
                        $date = date("d M", strtotime($values->created_at));
                    }
                    $values->header = $date;
                    $values->time = date("h:i a", strtotime($values->created_at));

                    if($_POST['lang'] == 'dnk'){
                        if($values->message == 'Market sent to approval'){
                           $values->message = 'Marked sendt til godkendelse'; 
                        }

                        if($values->message == 'Your market has been approved'){
                           $values->message = 'Dit marked er nu godkendt'; 
                        }

                        if($values->message == 'Tables sent to approval'){
                           $values->message = 'Borde er sent til godkendelse'; 
                        }

                        if($values->message == 'Your tables has been approved'){
                           $values->message = 'Dine stadepladser er godkendt'; 
                        }
                    }

                    $lists[] = $values;
                }

                $this->chk = 1;
                $this->msg = 'Notification Lists';

                $this->return_data = array('list' => $list);

            }
        }
    } 

    
}
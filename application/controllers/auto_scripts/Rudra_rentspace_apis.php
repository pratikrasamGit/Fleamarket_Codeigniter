
<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);

require_once dirname(__FILE__).'/../../../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class Rudra_rentspace_apis extends CI_Controller
{                   
    
    private $api_status = false;
	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->bdp = $this->db->dbprefix;
        $this->table = 'rudra_rent_space';
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

    public function rudra_rudra_rentspace($param1)
    {
        $call_type = $param1;
        $res = array();
        if($call_type == 'create')
        {            
            $res = $this->rudra_create_data($_POST);        
        }
        elseif($call_type == 'payment')
        {
            $res = $this->rudra_payment_data($_POST);        
        }
        elseif($call_type == 'list')
        {
            $res = $this->rudra_list_data($_POST);        
        }
        elseif($call_type == 'bank_update')
        {
            $res = $this->rudra_bank_update_data($_POST);        
        }
        elseif($call_type == 'market_list')
        {
            $res = $this->rudra_market_list_data($_POST);        
        }        
        elseif ($call_type == 'payment_history_list') {
            $res = $this->rudra_payment_history_list_data($_POST);
        }
        elseif($call_type == 'buy_market_list')
        {
            $res = $this->rudra_buy_market_list_data($_POST);        
        }  
        elseif($call_type == 'purchase_market_list')
        {
            $res = $this->rudra_purchase_market_list_data($_POST);        
        } 
        elseif($call_type == 'invoice')
        {
            $res = $this->invoice($_POST);        
        } 
        $this->json_output(200,array('status' => 200,'message' => $this->msg,'data'=>$this->return_data,'chk' => $this->chk));

    }

    public function rudra_create_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('market_id', 'market_id', 'required');
            $this->form_validation->set_rules('type_l', 'type_l', 'required');
            $this->form_validation->set_rules('type_m', 'type_m', 'required');
            $this->form_validation->set_rules('type_s', 'type_s', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $save_l = 1;
                // if($_POST['type_l'] == 1){
                //     if(isset($_FILES['image_l']) && $_FILES['image_l']['name'] != '') 
                //     {
                //         $save_l = 1;
                //     }
                //     else{
                //         $save_l = 0;
                //     }
                // }
                $save_m = 1;
                // if($_POST['type_m'] == 1){
                //     if(isset($_FILES['image_m']) && $_FILES['image_m']['name'] != '') 
                //     {
                //         $save_m = 1;
                //     }
                //     else{
                //         $save_m = 0;
                //     }
                // }
                $save_s = 1;
                // if($_POST['type_s'] == 1) {
                //     if(isset($_FILES['image_s']) && $_FILES['image_s']['name'] != '') 
                //     {
                //         $save_s = 1;
                //     }
                //     else{
                //         $save_s = 0;
                //     }
                // }
                
                if($save_l == 1 && $save_m == 1 && $save_s == 1){
                    $user_id = $_POST['user_id'];
                    $market_id = $_POST['market_id'];
                    $query = "SELECT * FROM rudra_market where id = $market_id AND fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $details = $this->db->query($query)->row();

                    if($details){

                        $rsqry = "SELECT * FROM $this->table where fk_market_id = $market_id AND fk_user_id = $user_id AND is_deleted = '0' ORDER BY id DESC";
                        $rs = $this->db->query($rsqry)->row();

                        if(empty($rs)){

                            if($_POST['type_l'] == 1){

                                $type = 'Large';

                                $chkqry = "SELECT * FROM $this->table where fk_market_id = $market_id AND fk_user_id = $user_id AND table_type = '$type' AND is_deleted = '0' ORDER BY id DESC";
                                $chk = $this->db->query($chkqry)->row();

                                if(empty($chk)){
                                    $stqry = "SELECT * FROM rudra_settings where st_key = 'table_percentage' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                    $settings = $this->db->query($stqry)->row();

                                    $table_price = $_POST['tbl_price_l'];

                                    $table_number = $_POST['tbl_no_l'];

                                    $commission = $table_price*($settings->st_meta/100);

                                    $receive_price = $table_price - $commission;

                                    $insert_array = array(
                                        'fk_user_id' => $user_id,
                                        'fk_market_id' => $market_id,
                                        'table_type' => $type,
                                        'table_no' => $table_number,
                                        'table_rent_price' => $table_price,
                                        'table_rent_receive' => $receive_price,
                                        'table_rent_comission' => $commission,
                                        'table_rent_comission_percentage' => $settings->st_meta
                                    );

                                    $this->db->insert($this->table,$insert_array);

                                    $insert_id = $this->db->insert_id();

                                    if(isset($_FILES['image_l']) && $_FILES['image_l']['name'] != '') 
                                    {
                                        $path = 'uploads/market';
                                        $thumbpath = 'uploads/market';
                                        $config['upload_path'] = $path;
                                        $config['allowed_types'] = '*';
                                        $config['encrypt_name'] = TRUE;
                                        $this->load->library('upload', $config);
                                        $this->upload->initialize($config);
                                        if(!$this->upload->do_upload('image_l'))
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

                                        $updateArray = array(
                                            'file_name' => $uploadedImage['file_name'],
                                            'file_path' => $path
                                        );  

                                        $this->db->where('id', $insert_id);
                                        $this->db->update($this->table, $updateArray);     
                                    }

                                }

                            }

                            if($_POST['type_m'] == 1){

                                $type = 'Medium';

                                $chkqry = "SELECT * FROM $this->table where fk_market_id = $market_id AND fk_user_id = $user_id AND table_type = '$type' AND is_deleted = '0' ORDER BY id DESC";
                                $chk = $this->db->query($chkqry)->row();

                                if(empty($chk)){
                                    $stqry = "SELECT * FROM rudra_settings where st_key = 'table_percentage' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                    $settings = $this->db->query($stqry)->row();

                                    $table_price = $_POST['tbl_price_m'];

                                    $table_number = $_POST['tbl_no_m'];

                                    $commission = $table_price*($settings->st_meta/100);

                                    $receive_price = $table_price - $commission;

                                    $insert_array = array(
                                        'fk_user_id' => $user_id,
                                        'fk_market_id' => $market_id,
                                        'table_type' => $type,
                                        'table_no' => $table_number,
                                        'table_rent_price' => $table_price,
                                        'table_rent_receive' => $receive_price,
                                        'table_rent_comission' => $commission,
                                        'table_rent_comission_percentage' => $settings->st_meta
                                    );

                                    $this->db->insert($this->table,$insert_array);

                                    $insert_id = $this->db->insert_id();

                                    if(isset($_FILES['image_m']) && $_FILES['image_m']['name'] != '') 
                                    {
                                        $path = 'uploads/market';
                                        $thumbpath = 'uploads/market';
                                        $config['upload_path'] = $path;
                                        $config['allowed_types'] = '*';
                                        $config['encrypt_name'] = TRUE;
                                        $this->load->library('upload', $config);
                                        $this->upload->initialize($config);
                                        if(!$this->upload->do_upload('image_m'))
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

                                        $updateArray = array(
                                            'file_name' => $uploadedImage['file_name'],
                                            'file_path' => $path
                                        );  

                                        $this->db->where('id', $insert_id);
                                        $this->db->update($this->table, $updateArray);     
                                    }

                                }

                            }

                            if($_POST['type_s'] == 1){

                                $type = 'Small';

                                $chkqry = "SELECT * FROM $this->table where fk_market_id = $market_id AND fk_user_id = $user_id AND table_type = '$type' AND is_deleted = '0' ORDER BY id DESC";
                                $chk = $this->db->query($chkqry)->row();

                                if(empty($chk)){
                                    $stqry = "SELECT * FROM rudra_settings where st_key = 'table_percentage' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                    $settings = $this->db->query($stqry)->row();

                                    $table_price = $_POST['tbl_price_s'];

                                    $table_number = $_POST['tbl_no_s'];

                                    $commission = $table_price*($settings->st_meta/100);

                                    $receive_price = $table_price - $commission;

                                    $insert_array = array(
                                        'fk_user_id' => $user_id,
                                        'fk_market_id' => $market_id,
                                        'table_type' => $type,
                                        'table_no' => $table_number,
                                        'table_rent_price' => $table_price,
                                        'table_rent_receive' => $receive_price,
                                        'table_rent_comission' => $commission,
                                        'table_rent_comission_percentage' => $settings->st_meta
                                    );

                                    $this->db->insert($this->table,$insert_array);

                                    $insert_id = $this->db->insert_id();

                                    if(isset($_FILES['image_s']) && $_FILES['image_s']['name'] != '') 
                                    {
                                        $path = 'uploads/market';
                                        $thumbpath = 'uploads/market';
                                        $config['upload_path'] = $path;
                                        $config['allowed_types'] = '*';
                                        $config['encrypt_name'] = TRUE;
                                        $this->load->library('upload', $config);
                                        $this->upload->initialize($config);
                                        if(!$this->upload->do_upload('image_s'))
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

                                        $updateArray = array(
                                            'file_name' => $uploadedImage['file_name'],
                                            'file_path' => $path
                                        );  

                                        $this->db->where('id', $insert_id);
                                        $this->db->update($this->table, $updateArray);     
                                    }

                                }

                            }

                            $query = "SELECT * FROM $this->table where fk_user_id = $user_id AND is_deleted = '0' ORDER BY id DESC";
                            $list = $this->db->query($query)->result();

                            $notifyData = array(
                                'fk_user_id' => $user_id,
                                'message' => 'Tables sent to approval'
                            );
            
                            $this->db->insert("rudra_notification",$notifyData);

                            $this->chk = 1;
                            $this->msg = 'Successfully created';
                            $this->return_data = $list; 

                        }
                        else{

                            $this->chk = 0;
                            $this->msg = 'Allready Register';
                            $this->return_data = [];
                            
                        }   
                    }
                    else{

                        $this->chk = 0;
                        $this->msg = 'Invalid market id';
                        $this->return_data = [];

                    }   
                }
                else{

                    $this->chk = 0;
                    $this->msg = 'Please select image file';
                    $this->return_data = [];

                }          
            }
        }
    }

    public function rudra_payment_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('rentspace', 'rentspace', 'required');
            $this->form_validation->set_rules('purchased_key', 'purchased_key', 'required');
            $this->form_validation->set_rules('payment_method_id', 'payment_method_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $rentspace = json_decode($_POST['rentspace']);

                $tansaction_number = "T".strtoupper(uniqid());

                $invoice_number = rand(1000,9999);

                foreach ($rentspace as $keys => $values) {
                    $rent_space_id = $values->rent_space_id;
                    $type = $values->rent_space_type;
                    $rsqry = "SELECT * FROM rudra_rent_space where id = $rent_space_id AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                    $rs = $this->db->query($rsqry)->row();

                    if(!empty($rs)){

                        $rentId = $rs->id;
                        $rspqry = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $rentId AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                        $rsp = $this->db->query($rspqry)->row();

                        $bookTotal = ($rsp->total) ? $rsp->total : 0;
                        $avblTotal = $rs->table_no - $bookTotal;

                        $rent_space_no = $values->rent_space_no;

                        if($rent_space_no <= $avblTotal){

                            $user_id = $this->input->post('user_id',true);
                        
                            $purchased_key = $this->input->post('purchased_key',true);
                            $payment_method_id = $this->input->post('payment_method_id',true);

                            $payData = array(
                                'table_type' => $type,
                                'fk_rent_space_id' => $rent_space_id,
                                'table_no' => $rent_space_no,
                                'table_price' => $rs->table_rent_price,
                                'table_total_price' => $rs->table_rent_price*$rent_space_no,
                                'fk_user_id' => $user_id,
                                'transaction_id' => $tansaction_number,
                                'invoice_number' => $invoice_number,
                                'purchased_key' => $purchased_key,
                                'fk_payment_method_id' => $payment_method_id,
                                'purchased_date' => date('Y-m-d')
                            );

                            $this->db->insert('rudra_rent_space_purchased',$payData);
                            $payment_id = $this->db->insert_id();

                            $query = "SELECT * FROM rudra_rent_space_purchased where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $list = $this->db->query($query)->result();
                        }
                        
                    }
                }
                
                $this->chk = 1;
                $this->msg = 'Payment done successfully';
                $this->return_data = array();

            }
        }
    }

    public function rudra_list_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('type', 'type', 'required');
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

                $list = [];

                if($_POST['type'] == '0'){

                    $rs_query = "SELECT rudra_market.market_name, rudra_market.start_date, rudra_market.end_date, rudra_market.start_time, rudra_market.end_time, rudra_rent_space.added_on, rudra_rent_space.fk_market_id FROM  rudra_rent_space INNER JOIN rudra_market ON  rudra_rent_space.fk_market_id=rudra_market.id where rudra_rent_space.fk_user_id = $user_id ";

                    if($_POST['filter_market_id'] > 0){
                        $filter_market_id = $_POST['filter_market_id'];
                        $rs_query = $rs_query . " AND rudra_rent_space.fk_market_id = $filter_market_id ";
                    }

                    if($_POST['filter_from'] != '' && $_POST['filter_to'] != ''){
                        $filter_from = $_POST['filter_from'];
                        $filter_to = $_POST['filter_to'];
                        $rs_query = $rs_query . " AND date(rudra_rent_space.added_on) >= '$filter_from' AND date(rudra_rent_space.added_on) <= '$filter_to' ";
                    }
                        
                    $rs_query = $rs_query . " AND rudra_rent_space.is_deleted = '0' GROUP BY rudra_rent_space.fk_market_id ORDER BY rudra_rent_space.id DESC";

                    $list = $this->db->query($rs_query)->result();

                    foreach ($list as $keys => $values) {

                        $rs_total_amount = 0;
                        $rs_total_earned_amount = 0;

                        $total_table_number = 0;
                        $total_table_booked_number = 0;
                        
                        $large = array();

                        $lrgqry = "SELECT rudra_rent_space.id, rudra_rent_space.table_type, rudra_rent_space.table_no, rudra_rent_space.table_rent_price, rudra_rent_space.table_rent_receive FROM rudra_rent_space where fk_user_id = $user_id AND fk_market_id = $values->fk_market_id AND table_type = 'Large'";
                        $lrgdetails = $this->db->query($lrgqry)->row();

                        if($lrgdetails){

                            $rspqry = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $lrgdetails->id AND table_type = 'Large' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $rsp = $this->db->query($rspqry)->row();

                            $bookTotal = ($rsp->total) ? $rsp->total : 0;

                            $lrgdetails->total_booked_table_no = $bookTotal;
                            $lrgdetails->total_amount = $bookTotal * $lrgdetails->table_rent_price;
                            $lrgdetails->total_earned = $bookTotal * $lrgdetails->table_rent_receive;
                            $rs_total_amount = $rs_total_amount + $lrgdetails->total_amount;
                            $rs_total_earned_amount = $rs_total_earned_amount + $lrgdetails->total_earned;
                            $total_table_number = $total_table_number + $lrgdetails->table_no;
                            $total_table_booked_number = $total_table_booked_number + $bookTotal;
                            $values->large = $lrgdetails;
                        }

                        $mdqry = "SELECT rudra_rent_space.id, rudra_rent_space.table_type, rudra_rent_space.table_no, rudra_rent_space.table_rent_price, rudra_rent_space.table_rent_receive FROM rudra_rent_space where fk_user_id = $user_id AND fk_market_id = $values->fk_market_id AND table_type = 'Medium'";
                        $mddetails = $this->db->query($mdqry)->row();

                        if($mddetails){

                            $rspqry = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $mddetails->id AND table_type = 'Medium' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $rsp = $this->db->query($rspqry)->row();

                            $bookTotal = ($rsp->total) ? $rsp->total : 0;

                            $mddetails->total_booked_table_no = $bookTotal;
                            $mddetails->total_amount = $bookTotal * $mddetails->table_rent_price;
                            $mddetails->total_earned = $bookTotal * $mddetails->table_rent_receive;
                            $rs_total_amount = $rs_total_amount + $mddetails->total_amount;
                            $rs_total_earned_amount = $rs_total_earned_amount + $mddetails->total_earned;
                            $total_table_number = $total_table_number + $mddetails->table_no;
                            $total_table_booked_number = $total_table_booked_number + $bookTotal;
                            $values->medium = $mddetails;
                        }

                        $smqry = "SELECT rudra_rent_space.id, rudra_rent_space.table_type, rudra_rent_space.table_no, rudra_rent_space.table_rent_price, rudra_rent_space.table_rent_receive FROM rudra_rent_space where fk_user_id = $user_id AND fk_market_id = $values->fk_market_id AND table_type = 'Small'";
                        $smdetails = $this->db->query($smqry)->row();

                        if($smdetails){

                            $rspqry = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $smdetails->id AND table_type = 'Small' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $rsp = $this->db->query($rspqry)->row();

                            $bookTotal = ($rsp->total) ? $rsp->total : 0;

                            $smdetails->total_booked_table_no = $bookTotal;

                            $smdetails->total_amount = $bookTotal * $smdetails->table_rent_price;
                            $smdetails->total_earned = $bookTotal * $smdetails->table_rent_receive;
                            $rs_total_amount = $rs_total_amount + $smdetails->total_amount;
                            $rs_total_earned_amount = $rs_total_earned_amount + $smdetails->total_earned;
                            $total_table_number = $total_table_number + $smdetails->table_no;
                            $total_table_booked_number = $total_table_booked_number + $bookTotal;
                            $values->small = $smdetails;
                        }

                        $buyLists = array();
                        $buys_query = "SELECT rudra_rent_space_purchased.*, rudra_user.first_name as user_name, rudra_user.profile_pic, rudra_rent_space.fk_market_id, rudra_rent_space.table_type, rudra_payment_method.pic as payment_method_icon, rudra_market.market_name  FROM rudra_rent_space_purchased LEFT JOIN rudra_user ON rudra_rent_space_purchased.fk_user_id=rudra_user.id LEFT JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id LEFT JOIN rudra_market ON rudra_rent_space.fk_market_id = rudra_market.id LEFT JOIN rudra_payment_method ON rudra_rent_space_purchased.fk_payment_method_id=rudra_payment_method.id where rudra_rent_space.fk_market_id = $values->fk_market_id AND rudra_rent_space_purchased.status = '1' AND rudra_rent_space_purchased.is_deleted = '0' GROUP BY rudra_rent_space_purchased.transaction_id ORDER BY rudra_rent_space_purchased.id DESC";
                        $buys_list = $this->db->query($buys_query)->result();

                        foreach ($buys_list as $bykeys => $byvalues) {
                            $buy_query = "SELECT rudra_rent_space_purchased.*, rudra_user.first_name as user_name, rudra_user.profile_pic, rudra_rent_space.fk_market_id, rudra_rent_space.table_type, rudra_payment_method.pic as payment_method_icon, rudra_market.market_name  FROM rudra_rent_space_purchased LEFT JOIN rudra_user ON rudra_rent_space_purchased.fk_user_id=rudra_user.id LEFT JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id LEFT JOIN rudra_market ON rudra_rent_space.fk_market_id = rudra_market.id LEFT JOIN rudra_payment_method ON rudra_rent_space_purchased.fk_payment_method_id=rudra_payment_method.id where rudra_rent_space.fk_market_id = $values->fk_market_id AND rudra_rent_space_purchased.transaction_id = '$byvalues->transaction_id' AND rudra_rent_space_purchased.status = '1' AND rudra_rent_space_purchased.is_deleted = '0' ORDER BY rudra_rent_space_purchased.id DESC";
                            $buy_list = $this->db->query($buy_query)->result();

                            $buysList = array(); 

                            $total_buy_price = 0;
                            $buysUsersDetails = array();

                            foreach ($buy_list as $bkeys => $bvalues) {

                                $months = date("F", strtotime($bvalues->created_at));

                                $bsrquery = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $bvalues->fk_rent_space_id AND status = '1' AND is_deleted = '0' AND id < $bvalues->id";
                                $sr = $this->db->query($bsrquery)->result();

                                $srno = ($sr[0]->total) ? $sr[0]->total+1 : 1;

                                $tableno = '';
                                for ($i=$srno; $i < $srno+$bvalues->table_no; $i++) { 
                                    if($i == $srno){
                                        $tableno = $i;
                                    }
                                    else{
                                        $tableno = $tableno. ', '. $i;
                                    }                                
                                }

                                if($bvalues->profile_pic != ''){
                                    $bvalues->profile_pic = base_url().$bvalues->profile_pic;
                                }  

                                if($bvalues->profile_pic == null){
                                    $bvalues->profile_pic = '';
                                }  

                                $blist = array(
                                    'table_type' => substr($bvalues->table_type, 0, 1),
                                    'user_name' => $bvalues->user_name,
                                    'profile_pic' => $bvalues->profile_pic,
                                    'table_sequence_no' => (string) $tableno,
                                    'month_name' => $months,
                                    'price' => $bvalues->table_total_price,
                                    'date' => $bvalues->created_at
                                );

                                $total_buy_price = $total_buy_price + $bvalues->table_total_price;
                                $buysUsersDetails = array(
                                    'user_name' => $bvalues->user_name,
                                    'profile_pic' => $bvalues->profile_pic,
                                    'date' => $bvalues->created_at             
                                );
                                $buysList[] = $blist;
                            }

                            $buysUsersDetails['price'] = $total_buy_price;
                            $buyLists[] = array('details' => $buysUsersDetails, 'list' => $buysList);
                        }

                        $values->buy_list = $buyLists;

                        $values->total_amount = $rs_total_amount;
                        $values->total_earned_amount = $rs_total_earned_amount;
                        $values->total_table_number = $total_table_number;
                        $values->total_table_booked_number = $total_table_booked_number;

                    }
                }

                if($_POST['type'] == '1'){
                    $pay_qry = "SELECT rudra_rent_space_purchased.*, rudra_market.market_name FROM rudra_rent_space_purchased INNER JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id INNER JOIN rudra_market on rudra_rent_space.fk_market_id = rudra_market.id where rudra_rent_space.fk_user_id = $user_id";
                    $pay_list = $this->db->query($pay_qry)->result();

                    $earn_qry = "SELECT sum(table_total_price) as total FROM rudra_rent_space_purchased INNER JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id INNER JOIN rudra_market on rudra_rent_space.fk_market_id = rudra_market.id where rudra_rent_space.fk_user_id = $user_id";
                    $earn_details = $this->db->query($earn_qry)->result();

                    $list = array('payment_list' => $pay_list, 'total_earn' => $earn_details[0]->total);

                }

                if($_POST['type'] == '2'){
                    $bt_qry = "SELECT rudra_market.market_name, rudra_rent_space.table_rent_receive as amount, rudra_rent_space_bank_transfer.created_at FROM rudra_rent_space_bank_transfer INNER JOIN rudra_rent_space_purchased ON rudra_rent_space_bank_transfer.fk_rent_space_purchased_id=rudra_rent_space_purchased.id INNER JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id INNER JOIN rudra_market on rudra_rent_space.fk_market_id = rudra_market.id where rudra_rent_space.fk_user_id = $user_id";
                    $bt_list = $this->db->query($bt_qry)->result();

                    $lists = array();
                    foreach ($bt_list as $keys => $values) {
                        $date = date("d-m-Y", strtotime($values->created_at));
                        $values->date = $date;
                        $values->time = date("h:i:s", strtotime($values->created_at));
                        $lists[] = $values;
                    }

                    $list = array('bank_transfer_list' => $lists);
                }

                $stqry = "SELECT * FROM rudra_settings where st_key = 'table_percentage' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $settings = $this->db->query($stqry)->row();

                $bankqry = "SELECT * FROM rudra_bank_account where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $bank_details = $this->db->query($bankqry)->row();

                $this->chk = 1;
                $this->msg = 'Lists';

                $bank = array( 'holder_name' => '', 'bank_name' => '', 'account_name' => '', 'registration_number' => '');

                if($bank_details){
                    $bank = array( 'holder_name' => $bank_details->bank_holder_name, 'bank_name' => $bank_details->bank_name, 'account_name' => $bank_details->account_number, 'registration_number' => $bank_details->registration_number);
                }

                $this->return_data = array('list' => $list, 'setting' => array( 'percentage' => $settings->st_meta, 'bank' => $bank ));

            }
        }
    } 

    public function rudra_bank_update_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('bank_holder_name', 'bank_holder_name', 'required');
            $this->form_validation->set_rules('bank_name', 'bank_name', 'required');
            $this->form_validation->set_rules('account_number', 'account_number', 'required');
            $this->form_validation->set_rules('registration_number', 'registration_number', 'required');
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

                $bankqry = "SELECT * FROM rudra_bank_account where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $bank_details = $this->db->query($bankqry)->row();

                $bank = array( 'holder_name' => '', 'bank_name' => '', 'account_name' => '', 'registration_number' => '');

                if($bank_details){
                    $bank_holder_name = $this->input->post('bank_holder_name',true);
                    $bank_name = $this->input->post('bank_name',true);
                    $account_number = $this->input->post('account_number',true);
                    $registration_number = $this->input->post('registration_number',true);
                    $upData = array(
                        'fk_user_id' => $this->input->post('user_id',true),
                        'bank_holder_name' => $bank_holder_name,
                        'bank_name' => $bank_name,
                        'account_number' => $account_number,
                        'registration_number' => $registration_number
                    );
                    
                    $this->db->where('id',$bank_details->id);
                    $this->db->update("rudra_bank_account",$upData);

                    $bank = array( 'holder_name' => $bank_holder_name, 'bank_name' => $bank_name, 'account_name' => $account_number, 'registration_number' => $registration_number);
                }
                else{
                    $bank_holder_name = $this->input->post('bank_holder_name',true);
                    $bank_name = $this->input->post('bank_name',true);
                    $account_number = $this->input->post('account_number',true);
                    $registration_number = $this->input->post('registration_number',true);
                    $newData = array(
                        'fk_user_id' => $this->input->post('user_id',true),
                        'bank_holder_name' => $bank_holder_name,
                        'bank_name' => $bank_name,
                        'account_number' => $account_number,
                        'registration_number' => $registration_number
                    );

                    $this->db->insert('rudra_bank_account',$newData);

                    $bank = array( 'holder_name' => $bank_holder_name, 'bank_name' => $bank_name, 'account_name' => $account_number, 'registration_number' => $registration_number);
                }

                $this->chk = 1;
                $this->msg = 'Successfully updated bank details';
                $this->return_data = $bank;

            }
        }
    }

    public function rudra_market_list_data()
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

                $query = "SELECT * FROM rudra_market where fk_user_id = $userId AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $list = $this->db->query($query)->result();

                $lists = array();

                foreach ($list as $keys => $values) {
                    $today = date("Y-m-d h:i:s");
                    $expire = $values->end_date.' '.$values->end_time;

                    $today_time = strtotime($today);
                    $expire_time = strtotime($expire);

                    if ($expire_time > $today_time) {
                        $values->is_open = 'Open';
                        $mquery = "SELECT * FROM rudra_rent_space where fk_market_id = $values->id AND is_deleted = '0' ORDER BY id DESC";
                        $mList = $this->db->query($mquery)->result();
                        if(count($mList) == 0){
                            $lists[] = $values;
                        }
                    }                    
                }

                $this->chk = 1;
                $this->msg = 'My Market Lists';
                $this->return_data = array('list' => $lists);

            }
        }
    }

    public function rudra_purchase_market_list_data()
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

                $query = "SELECT rudra_market.* FROM rudra_rent_space_purchased LEFT JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id = rudra_rent_space.id LEFT JOIN rudra_market ON rudra_rent_space.fk_market_id = rudra_market.id WHERE rudra_rent_space_purchased.fk_user_id = $userId GROUP BY rudra_market.id";
                $list = $this->db->query($query)->result();

                $this->chk = 1;
                $this->msg = 'Purchase Market Lists';
                $this->return_data = array('list' => $list);

            }
        }
    }

    public function rudra_payment_history_list_data()
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
                $rss_query = "";
                if($_POST['search_market_id'] > 0){
                    $search_market_id = $_POST['search_market_id'];
                    $rss_query = "SELECT rudra_rent_space_purchased.*, rudra_rent_space.fk_market_id, rudra_rent_space.table_type, rudra_payment_method.pic as payment_method_icon, rudra_market.market_name  FROM rudra_rent_space_purchased LEFT JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id LEFT JOIN rudra_market ON rudra_rent_space.fk_market_id = rudra_market.id LEFT JOIN rudra_payment_method ON rudra_rent_space_purchased.fk_payment_method_id=rudra_payment_method.id where rudra_rent_space_purchased.fk_user_id = $user_id AND rudra_rent_space.fk_market_id = $search_market_id AND rudra_rent_space_purchased.status = '1' AND rudra_rent_space_purchased.is_deleted = '0' GROUP BY rudra_rent_space_purchased.transaction_id ORDER BY rudra_rent_space_purchased.id DESC";
                }
                else{
                    $rss_query = "SELECT rudra_rent_space_purchased.*, rudra_rent_space.fk_market_id, rudra_rent_space.table_type, rudra_payment_method.pic as payment_method_icon, rudra_market.market_name  FROM rudra_rent_space_purchased LEFT JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id LEFT JOIN rudra_market ON rudra_rent_space.fk_market_id = rudra_market.id LEFT JOIN rudra_payment_method ON rudra_rent_space_purchased.fk_payment_method_id=rudra_payment_method.id where rudra_rent_space_purchased.fk_user_id = $user_id AND rudra_rent_space_purchased.status = '1' AND rudra_rent_space_purchased.is_deleted = '0' GROUP BY rudra_rent_space_purchased.transaction_id ORDER BY rudra_rent_space_purchased.id DESC";
                }
                $ssList = $this->db->query($rss_query)->result();

                $lists = array();
                foreach ($ssList as $sskeys => $ssvalues) {

                    $rs_query = "";
                    if($_POST['search_market_id'] > 0){
                        $search_market_id = $_POST['search_market_id'];
                        $rs_query = "SELECT rudra_rent_space_purchased.*, rudra_rent_space.fk_market_id, rudra_rent_space.table_rent_price, rudra_rent_space.table_type, rudra_payment_method.pic as payment_method_icon, rudra_market.market_name  FROM rudra_rent_space_purchased LEFT JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id LEFT JOIN rudra_market ON rudra_rent_space.fk_market_id = rudra_market.id LEFT JOIN rudra_payment_method ON rudra_rent_space_purchased.fk_payment_method_id=rudra_payment_method.id where rudra_rent_space_purchased.fk_user_id = $user_id AND rudra_rent_space_purchased.transaction_id = '$ssvalues->transaction_id' AND rudra_rent_space.fk_market_id = $search_market_id AND rudra_rent_space_purchased.status = '1' AND rudra_rent_space_purchased.is_deleted = '0' ORDER BY rudra_rent_space_purchased.id DESC";
                    }
                    else{
                        $rs_query = "SELECT rudra_rent_space_purchased.*, rudra_rent_space.fk_market_id, rudra_rent_space.table_rent_price, rudra_rent_space.table_type, rudra_payment_method.pic as payment_method_icon, rudra_market.market_name  FROM rudra_rent_space_purchased LEFT JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id LEFT JOIN rudra_market ON rudra_rent_space.fk_market_id = rudra_market.id LEFT JOIN rudra_payment_method ON rudra_rent_space_purchased.fk_payment_method_id=rudra_payment_method.id where rudra_rent_space_purchased.fk_user_id = $user_id AND  rudra_rent_space_purchased.transaction_id = '$ssvalues->transaction_id' AND rudra_rent_space_purchased.status = '1' AND rudra_rent_space_purchased.is_deleted = '0' ORDER BY rudra_rent_space_purchased.id DESC";
                    }
                    $list = $this->db->query($rs_query)->result();

                    $slists = array();
                    $total_buy_price = 0;
                    $buysUsersDetails = array();
                    $total_booked_table_no = 0;
                    foreach ($list as $keys => $values) {

                        $months = date("F", strtotime($values->created_at));

                        if($_POST['search_months'] != ''){

                            if($_POST['search_months'] == $months) {
                                $srquery = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $values->fk_rent_space_id AND status = '1' AND is_deleted = '0' AND id < $values->id";
                                $sr = $this->db->query($srquery)->result();

                                $srno = ($sr[0]->total) ? $sr[0]->total+1 : 1;

                                $tableno = '';
                                for ($i=$srno; $i < $srno+$values->table_no; $i++) { 
                                    $tableno = $tableno. ' '. $i;
                                }

                                $total_buy_price = $total_buy_price + $values->table_total_price;
                                $total_booked_table_no = $total_booked_table_no + $values->table_no;
                                $buysUsersDetails = array(
                                    'transaction_id' => $values->transaction_id,
                                    'invoice_number' => $values->invoice_number,
                                    'market_name' => $values->market_name,
                                    'date' => $values->created_at             
                                );

                                $blist = array(
                                    'table_type' => substr($values->table_type, 0, 1),
                                    'table_sequence_no' => (string) $tableno,
                                    'total_table_no' => $values->table_no,
                                    'month_name' => $months,
                                    'price' => $values->table_total_price,
                                    'indiviual_price' => $values->table_rent_price,
                                    'date' => $values->created_at
                                );
                                $slists[] = $blist;
                            }
                        }
                        else{

                            $srquery = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $values->fk_rent_space_id AND status = '1' AND is_deleted = '0' AND id < $values->id";
                            $sr = $this->db->query($srquery)->result();

                            $srno = ($sr[0]->total) ? $sr[0]->total+1 : 1;

                            $tableno = '';
                            for ($i=$srno; $i < $srno+$values->table_no; $i++) { 
                                $tableno = $tableno. ' '. $i;
                            }

                            $total_buy_price = $total_buy_price + $values->table_total_price;
                            $total_booked_table_no = $total_booked_table_no + $values->table_no;
                            $buysUsersDetails = array(
                                'transaction_id' => $values->transaction_id,
                                'invoice_number' => $values->invoice_number,
                                'market_name' => $values->market_name,
                                'date' => $values->created_at             
                            );

                            $blist = array(
                                'table_type' => substr($values->table_type, 0, 1),
                                'table_sequence_no' => (string) $tableno,
                                'total_table_no' => $values->table_no,
                                'month_name' => $months,
                                'price' => $values->table_total_price,
                                'indiviual_price' => $values->table_rent_price,
                                'date' => $values->created_at
                            );
                            $slists[] = $blist;
                        }
                    }

                    $buysUsersDetails['price'] = $total_buy_price;
                    $buysUsersDetails['total_booked_number'] = $total_booked_table_no;
                    if(count($slists) > 0){
                        $lists[] = array('details' => $buysUsersDetails, 'list' => $slists);
                    }                    
                }

                $this->chk = 1;
                $this->msg = 'Rent space payment lists';

                $this->return_data = array('list' => $lists);

            }
        }
    }

    public function rudra_buy_market_list_data()
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

                $query = "SELECT rudra_market.id as market_id, rudra_market.market_name FROM rudra_rent_space_purchased LEFT JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id LEFT JOIN rudra_market ON rudra_rent_space.fk_market_id = rudra_market.id where rudra_rent_space_purchased.fk_user_id = $userId AND rudra_rent_space_purchased.status = '1' AND rudra_rent_space_purchased.is_deleted = '0' GROUP BY rudra_market.id ORDER BY rudra_market.market_name";
                $list = $this->db->query($query)->result();

                $this->chk = 1;
                $this->msg = 'Buy Market Lists';
                $this->return_data = array('list' => $list);

            }
        }
    }

    public function invoice()
    {
        if(!empty($_POST))
        {

            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('invoice_id', 'invoice_id', 'required');
            $this->form_validation->set_rules('lang', 'lang', 'required');
            if($this->form_validation->run() == FALSE) 
            { 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 
                $invoice_id = $_POST['invoice_id'];
                $rs_query = "SELECT rudra_rent_space_purchased.*, rudra_rent_space.fk_market_id, rudra_rent_space.table_rent_price, rudra_rent_space.table_type, rudra_payment_method.pic as payment_method_icon, rudra_market.market_name, rudra_user.first_name, rudra_user.location  FROM rudra_rent_space_purchased LEFT JOIN rudra_rent_space ON rudra_rent_space_purchased.fk_rent_space_id=rudra_rent_space.id LEFT JOIN rudra_market ON rudra_rent_space.fk_market_id = rudra_market.id LEFT JOIN rudra_payment_method ON rudra_rent_space_purchased.fk_payment_method_id=rudra_payment_method.id LEFT JOIN rudra_user ON rudra_rent_space_purchased.fk_user_id=rudra_user.id where rudra_rent_space_purchased.invoice_number = '$invoice_id' AND rudra_rent_space_purchased.status = '1' AND rudra_rent_space_purchased.is_deleted = '0' ORDER BY rudra_rent_space_purchased.id DESC";

                $list = $this->db->query($rs_query)->result();

                $slists = array();
                $total_buy_price = 0;
                $buysUsersDetails = array();
                $total_booked_table_no = 0;
                foreach ($list as $keys => $values) {

                    $months = date("F", strtotime($values->created_at));

                    $srquery = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $values->fk_rent_space_id AND status = '1' AND is_deleted = '0' AND id < $values->id";
                    $sr = $this->db->query($srquery)->result();

                    $srno = ($sr[0]->total) ? $sr[0]->total+1 : 1;

                    $tableno = '';
                    $counter = 0;
                    for ($i=$srno; $i < $srno+$values->table_no; $i++) { 
                        if($counter == 0){
                            $tableno = $i;
                        }
                        else{
                            $tableno = $tableno. ', '. $i;
                        }  

                        $counter++;                      
                    }

                    $total_buy_price = $total_buy_price + $values->table_total_price;
                    $total_booked_table_no = $total_booked_table_no + $values->table_no;
                    $buysUsersDetails = array(
                        'user_name' => $values->first_name,
                        'user_location' => $values->location,
                        'transaction_id' => $values->transaction_id,
                        'invoice_number' => $values->invoice_number,
                        'market_name' => $values->market_name,
                        'date' => $values->created_at             
                    );

                    $blist = array(
                        'table_type' => substr($values->table_type, 0, 1),
                        'table_sequence_no' => (string) $tableno,
                        'total_table_no' => $values->table_no,
                        'month_name' => $months,
                        'price' => $values->table_total_price,
                        'indiviual_price' => $values->table_rent_price,
                        'date' => $values->created_at
                    );
                    $slists[] = $blist;
                }

                $buysUsersDetails['price'] = $total_buy_price;
                $buysUsersDetails['total_booked_number'] = $total_booked_table_no;

                $data['details'] = $buysUsersDetails;
                $data['list'] = $slists;

                // $this->load->library('pdf');

                $this->load->view('users/invoice', $data);
                
                // Get output html
                $html = $this->output->get_output();

                $html2pdf = new Html2Pdf();
                $html2pdf->writeHTML($html);
                ob_end_clean();
                $html2pdf->Output("/customers/4/9/8/loppekortet.dk/httpd.www/assets/invoice/".$invoice_id.".pdf", 'F');

                $this->chk = 1;
                $this->msg = 'Successfully invoice generated';

                $this->return_data = array('invoice_link' => base_url().'assets'.'/invoice/'.$invoice_id.".pdf");
            }

            

        }
    }

}
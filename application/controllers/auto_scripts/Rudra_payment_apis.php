
<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Rudra_payment_apis extends CI_Controller
{                   
    
    private $api_status = false;
	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->bdp = $this->db->dbprefix;
        $this->table = 'rudra_purchased_plan';
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

    public function rudra_rudra_payment($param1)
    {
        $call_type = $param1;
        $res = array();
        if($call_type == 'list')
        {            
            $res = $this->rudra_list_data($_POST);        
        }
        elseif($call_type == 'create')
        {
            $res = $this->rudra_create_data($_POST);        
        }
        elseif($call_type == 'token')
        {
            $res = $this->rudra_token_data($_POST);        
        }        
        elseif($call_type == 'method_list')
        {
            $res = $this->rudra_method_list_data($_POST);        
        }
        elseif($call_type == 'orderid')
        {
            $res = $this->rudra_orderid_data($_POST);        
        }
        elseif($call_type == 'plan-auto-cancel')
        {
            $res = $this->rudra_plan_auto_cancel_data($_POST);        
        }  
        elseif($call_type == 'package-create')
        {
            $res = $this->rudra_package_create_data($_POST);        
        }  
        elseif($call_type == 'package-list')
        {
            $res = $this->rudra_package_list_data($_POST);        
        } 
        elseif($call_type == 'package-auto-cancel')
        {
            $res = $this->rudra_package_auto_cancel_data($_POST);        
        }  
        elseif($call_type == 'purchased-history')
        {
            $res = $this->rudra_purchased_history_data($_POST);        
        } 
        elseif($call_type == 'mobilepay'){
            $res = $this->mobilepay_init($_POST);
        }
        elseif($call_type == 'paymentrequests'){
            $res = $this->paymentrequests($_POST);
        }
        elseif($call_type == 'paymentstatus'){
            $res = $this->paymentstatus($_POST);
        }
        elseif($call_type == 'agreementstatus'){
            $res = $this->checkAgreement($_POST);
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
                $plan_query = "SELECT $this->table.*, $this->table.payment_price as price,  rudra_plan.plan_name,rudra_payment_method.pic as payment_method_icon FROM $this->table LEFT JOIN rudra_plan ON $this->table.fk_plan_id=rudra_plan.id LEFT JOIN rudra_payment_method ON $this->table.fk_payment_method_id=rudra_payment_method.id where $this->table.fk_user_id = $user_id AND $this->table.status = '1' AND $this->table.is_deleted = '0' ORDER BY $this->table.id DESC";
                $list = $this->db->query($plan_query)->result();

                $this->chk = 1;
                $this->msg = 'Payment Lists';

                $this->return_data = array('list' => $list);

            }
        }
    } 

    public function rudra_create_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('plan_id', 'plan_id', 'required');
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
                $payment_method = $this->input->post('payment_method_id',true);

                if($payment_method == '3'){
                    $expire_date = date('Y-m-d', strtotime('+32 days'));
                }else{
                    $expire_date = date('Y-m-d', strtotime('+30 days'));
                }

                $user_id = $this->input->post('user_id',true);
                $external_id = $this->input->post('external_id',true);
                $payment_id = $this->input->post('payment_id',true);
                $upData = array(
                    'is_auto' => '0'
                );

                $this->db->where('fk_user_id', $user_id);
                $this->db->update("rudra_purchased_plan",$upData);

                $planId = $this->input->post('plan_id',true);
                $plan_details = $this->db->get_where("rudra_plan",array('id' => $planId))->row();

                $payment_price = ($plan_details->discount_price > 0) ? $plan_details->discount_price : $plan_details->price;
                
                $user_id = $this->input->post('user_id',true);
                if($payment_method == '3'){
                    $insert_array = array(
                        'fk_plan_id' => $planId,
                        'fk_user_id' => $user_id,
                        'transaction_id' => "T".strtoupper(uniqid()),
                        'purchased_key' => $this->input->post('purchased_key',true),
                        'fk_payment_method_id' => $this->input->post('payment_method_id',true),
                        'payment_price' => $payment_price,
                        'purchased_date' => date('Y-m-d'),
                        'expire_date' => $expire_date,
                        'external_id' => $this->input->post('external_id',true),
                        'payment_id' => $this->input->post('payment_id',true),
                        'agreement_id' => $this->input->post('agreement_id',true),
                        'is_subscription' => 1,
                        'due_date' => $this->input->post('due_date',true),
                    );
                }else{
                    $insert_array = array(
                        'fk_plan_id' => $planId,
                        'fk_user_id' => $user_id,
                        'transaction_id' => "T".strtoupper(uniqid()),
                        'purchased_key' => $this->input->post('purchased_key',true),
                        'fk_payment_method_id' => $this->input->post('payment_method_id',true),
                        'payment_price' => $payment_price,
                        'purchased_date' => date('Y-m-d'),
                        'expire_date' => $expire_date
                    );
                }

                $this->db->insert($this->table,$insert_array);
                $new_id = $this->db->insert_id();

                if($payment_method == '3'){
                    $upData = array(
                        'is_auto' => '0'
                    );
    
                    $this->db->where('id', $new_id);
                    $this->db->update("rudra_purchased_plan",$upData);    
                }

                $purchasedHistory = array(
                    'fk_user_id' => $user_id,
                    'fk_purchased_id' => $new_id,
                    'fk_type' => 'Plan'
                );

                $this->db->insert('rudra_purchased_history',$purchasedHistory);

                $query = "SELECT * FROM $this->table where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $list = $this->db->query($query)->result();

                $this->chk = 1;
                $this->msg = 'Payment done successfully';
                $this->return_data = $list;
            }
        }
    }

    public function rudra_token_data()
    {
        $this->form_validation->set_rules('api_key', 'API KEY', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('amount', 'amount', 'required');
        if($this->form_validation->run() == FALSE) 
        { 
            $this->chk = 0;
            $this->msg = 'Input Error, Please check Params';
            $this->return_data = $this->form_validation->error_array();
        }
        else
        { 
            $amount = $_POST['amount'];

            $user = $this->db->get_where('rudra_user', array('id' => $_POST['user_id']))->row_array();
            $name = $user['first_name'];
            
            if($user['location']){
                $location = $user['location'];
            }else{
                $location = 'Denmark';
            }

            require_once('application/libraries/stripe-php/init.php');
        
            \Stripe\Stripe::setApiKey('');

            // Use an existing Customer ID if this is a returning customer.
            $customer = \Stripe\Customer::create(
                 [
                    'name' => $name,
                    'address' => [
                      'line1' => $location,
                    //   'postal_code' => '98140',
                    //   'city' => 'San Francisco',
                    //   'state' => 'CA',
                    //   'country' => 'US',
                    ],
                  ]
            );

            $ephemeralKey = \Stripe\EphemeralKey::create(
                ['customer' => $customer->id],
                // ['stripe_version' => '2020-08-27']
                ['stripe_version' => '2022-08-01']
            );

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount*100,
                'currency' => 'dkk',
                'description' => 'Market Service',
                'customer' => $customer->id,
                'automatic_payment_methods' => [
                  'enabled' => 'true',
                ]
            ]);
            $this->chk = 1;
            $this->msg = 'Token generate successfully';

            $paymentIntent->amount = $amount/100;

            $result = array(
                'paymentIntent' => $paymentIntent->client_secret,
                'ephemeralKey' => $ephemeralKey->secret,
                'customer' => $customer->id,
                'publishableKey' => 'pk_live_51KKqN2Bqk2bdo0puJ3Vkh8yQvAi0swoupTWKPsajhbhAHppTZ7HdW2My4TKMRTFWALU1hAlVcRZLt1gHWxvjhphD00a888jBd5'
                // 'publishableKey' => 'pk_test_51KKqN2Bqk2bdo0puonsfb73evDMb04Nwfq1w1YJ5VdOC1Mue4v3KvW4ZcGPAZD9N8ZtuQ3JAOutIWP72XLfobVf500vhU8VIS2'
            );

            $this->return_data = $result;
        }
    }  
    

    public function rudra_method_list_data()
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

                $query = "SELECT * from rudra_payment_method";
                $list = $this->db->query($query)->result();

                $this->chk = 1;
                $this->msg = 'Payment Method Lists';

                $this->return_data = array('list' => $list);

            }
        }
    } 

    public function rudra_orderid_data()
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
                $this->msg = 'Orderid generated';
                $this->return_data = array('orderid' => "T".strtoupper(uniqid()));
            }
        }
    }

    public function rudra_plan_auto_cancel_data()
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
                $upData = array(
                    'is_auto' => '0'
                );

                $this->db->where('fk_user_id', $user_id);
                $this->db->update("rudra_purchased_plan",$upData);

                $this->chk = 1;
                if($_POST['lang'] == 'dnk'){
                    $this->msg = 'Automatisk fornyelse er annulleret';
                }
                else{
                   $this->msg = 'Auto payment cancel'; 
                }
                $this->return_data = [];
            }
        }
    }

    public function rudra_package_create_data()
    {
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('package_id', 'package_id', 'required');
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
                $payment_method = $this->input->post('payment_method_id',true);

                if($payment_method == '3'){
                    $expire_date = date('Y-m-d', strtotime('+32 days'));
                }else{
                    $expire_date = date('Y-m-d', strtotime('+30 days'));
                }

                $user_id = $this->input->post('user_id',true);
                $upData = array(
                    'is_auto' => '0'
                );

                $this->db->where('fk_user_id', $user_id);
                $this->db->update("rudra_purchased_package",$upData);

                $packageId = $this->input->post('package_id',true);
                $package_details = $this->db->get_where("rudra_package",array('id' => $packageId))->row();

                $payment_price = ($package_details->discount_price > 0) ? $package_details->discount_price : $package_details->price;

                if($payment_method == '3'){
                    $insert_array = array(
                        'fk_package_id' => $packageId,
                        'fk_user_id' => $user_id,
                        'transaction_id' => "T".strtoupper(uniqid()),
                        'purchased_key' => $this->input->post('purchased_key',true),
                        'fk_payment_method_id' => $this->input->post('payment_method_id',true),
                        'payment_price' => $payment_price,
                        'purchased_date' => date('Y-m-d'),
                        'expire_date' => $expire_date,
                        'external_id' => $this->input->post('external_id',true),
                        'payment_id' => $this->input->post('payment_id',true),
                        'agreement_id' => $this->input->post('agreement_id',true),
                        'is_subscription' => 1,
                        'due_date' => $this->input->post('due_date',true),
                    );
                }else{
                    $insert_array = array(
                        'fk_package_id' => $packageId,
                        'fk_user_id' => $user_id,
                        'transaction_id' => "T".strtoupper(uniqid()),
                        'purchased_key' => $this->input->post('purchased_key',true),
                        'fk_payment_method_id' => $this->input->post('payment_method_id',true),
                        'payment_price' => $payment_price,
                        'purchased_date' => date('Y-m-d'),
                        'expire_date' => $expire_date
                    );
                }    
                $this->db->insert("rudra_purchased_package",$insert_array);
                $new_id = $this->db->insert_id();

                if($payment_method == '3'){
                    $upData = array(
                        'is_auto' => '0'
                    );
    
                    $this->db->where('id', $new_id);
                    $this->db->update("rudra_purchased_package",$upData);    
                }

                $purchasedHistory = array(
                    'fk_user_id' => $user_id,
                    'fk_purchased_id' => $new_id,
                    'fk_type' => 'Package'
                );

                $this->db->insert('rudra_purchased_history',$purchasedHistory);

                $query = "SELECT * FROM rudra_purchased_package where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $list = $this->db->query($query)->result();

                $this->chk = 1;
                $this->msg = 'Payment done successfully';
                $this->return_data = $list;
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

                $user_id = $this->input->post('user_id',true);
                $package_query = "SELECT rudra_purchased_package.*, rudra_purchased_package.payment_price as price, rudra_package.package_name, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_package INNER JOIN rudra_package ON rudra_purchased_package.fk_package_id=rudra_package.id INNER JOIN rudra_payment_method ON rudra_purchased_package.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_package.fk_user_id = $user_id AND rudra_purchased_package.status = '1' AND rudra_purchased_package.is_deleted = '0' ORDER BY rudra_purchased_package.id DESC";
                $list = $this->db->query($package_query)->result();

                $this->chk = 1;
                $this->msg = 'Package Payment Lists';

                $this->return_data = array('list' => $list);

            }
        }
    } 
    
    public function rudra_package_auto_cancel_data()
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
                $upData = array(
                    'is_auto' => '0'
                );

                $this->db->where('fk_user_id', $user_id);
                $this->db->update("rudra_purchased_package",$upData);

                $this->chk = 1;
                if($_POST['lang'] == 'dnk'){
                    $this->msg = 'Automatisk fornyelse er annulleret';
                }
                else{
                   $this->msg = 'Auto payment cancel'; 
                }
                $this->return_data = [];
            }
        }
    }

    public function rudra_purchased_history_data()
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
                $history_query = "SELECT * FROM rudra_purchased_history WHERE fk_user_id = $user_id ORDER BY id DESC";
                $hlist = $this->db->query($history_query)->result();

                $lists = [];

                foreach ($hlist as $keys => $values) {
                    if($values->fk_type == 'Package'){
                        $query = "SELECT rudra_purchased_package.*, rudra_purchased_package.payment_price as price, rudra_package.package_name, rudra_package.dnk_name, rudra_payment_method.pic as payment_method_icon FROM rudra_purchased_package LEFT JOIN rudra_package ON rudra_purchased_package.fk_package_id=rudra_package.id LEFT JOIN rudra_payment_method ON rudra_purchased_package.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_package.fk_user_id = $user_id AND rudra_purchased_package.id = $values->fk_purchased_id AND rudra_purchased_package.status = '1' AND rudra_purchased_package.is_deleted = '0' ORDER BY rudra_purchased_package.id DESC";

                        $details = $this->db->query($query)->row();
                        if($details){

                            $filter_month = $this->input->post('months',true);
                            $filter_package_type = $this->input->post('package_type',true);
                            
                            $months = date("F", strtotime($details->purchased_date));
                            if($filter_month != '' || $filter_package_type != ''){
                                if($filter_month != '' && $filter_package_type != ''){
                                    if($filter_month == $months && $filter_package_type == $details->package_name){
                                        $hst = array(
                                            'id' => $details->id,
                                            'fk_user_id' => $details->fk_user_id,
                                            'plan_name' => ($_POST['lang'] == 'dnk') ? $details->dnk_name : $details->package_name,
                                            'plan_price' => $details->price,
                                            'transaction_id' => $details->transaction_id,
                                            'payment_method_icon' => $details->payment_method_icon,
                                            'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                            'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                            'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                            'is_auto' => $details->is_auto
                                        );
                                        $lists[] = $hst;
                                    }
                                }
                                elseif ($filter_month != ''){
                                    if($filter_month == $months){
                                        $hst = array(
                                            'id' => $details->id,
                                            'fk_user_id' => $details->fk_user_id,
                                            'plan_name' => ($_POST['lang'] == 'dnk') ? $details->dnk_name : $details->package_name,
                                            'plan_price' => $details->price,
                                            'transaction_id' => $details->transaction_id,
                                            'payment_method_icon' => $details->payment_method_icon,
                                            'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                            'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                            'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                            'is_auto' => $details->is_auto
                                        );
                                        $lists[] = $hst;
                                    }
                                }
                                elseif ($filter_package_type != ''){
                                    if($filter_package_type == $details->package_name){
                                        $hst = array(
                                            'id' => $details->id,
                                            'fk_user_id' => $details->fk_user_id,
                                            'plan_name' => ($_POST['lang'] == 'dnk') ? $details->dnk_name : $details->package_name,
                                            'plan_price' => $details->price,
                                            'transaction_id' => $details->transaction_id,
                                            'payment_method_icon' => $details->payment_method_icon,
                                            'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                            'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                            'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                            'is_auto' => $details->is_auto
                                        );
                                        $lists[] = $hst;
                                    }
                                }
                            }
                            else{
                                $hst = array(
                                    'id' => $details->id,
                                    'fk_user_id' => $details->fk_user_id,
                                    'plan_name' => ($_POST['lang'] == 'dnk') ? $details->dnk_name : $details->package_name,
                                    'plan_price' => $details->price,
                                    'transaction_id' => $details->transaction_id,
                                    'payment_method_icon' => $details->payment_method_icon,
                                    'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                    'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                    'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                    'is_auto' => $details->is_auto
                                );
                                $lists[] = $hst;
                            }
                        }
                    }
                    
                    if($values->fk_type == 'Plan'){
                        $query = "SELECT $this->table.*, $this->table.payment_price as price, rudra_plan.plan_name, rudra_plan.dnk_name, rudra_payment_method.pic as payment_method_icon FROM $this->table LEFT JOIN rudra_plan ON $this->table.fk_plan_id=rudra_plan.id LEFT JOIN rudra_payment_method ON $this->table.fk_payment_method_id=rudra_payment_method.id where $this->table.fk_user_id = $user_id AND $this->table.id = $values->fk_purchased_id AND $this->table.status = '1' AND $this->table.is_deleted = '0' ORDER BY $this->table.id DESC";
                        $details = $this->db->query($query)->row();
                        if($details){

                            $filter_month = $this->input->post('months',true);
                            $filter_package_type = $this->input->post('package_type',true);
                            
                            $months = date("F", strtotime($details->purchased_date));
                            if($filter_month != '' || $filter_package_type != ''){
                                if($filter_month != '' && $filter_package_type != ''){
                                    if($filter_month == $months && $filter_package_type == $details->plan_name){
                                        $hst = array(
                                            'id' => $details->id,
                                            'fk_user_id' => $details->fk_user_id,
                                            'plan_name' => ($_POST['lang'] == 'dnk') ? $details->dnk_name : $details->plan_name,
                                            'plan_price' => $details->price,
                                            'transaction_id' => $details->transaction_id,
                                            'payment_method_icon' => $details->payment_method_icon,
                                            'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                            'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                            'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                            'is_auto' => $details->is_auto
                                        );
                                        $lists[] = $hst;
                                    }
                                }
                                elseif ($filter_month != ''){
                                    if($filter_month == $months){
                                        $hst = array(
                                            'id' => $details->id,
                                            'fk_user_id' => $details->fk_user_id,
                                            'plan_name' => ($_POST['lang'] == 'dnk') ? $details->dnk_name : $details->plan_name,
                                            'plan_price' => $details->price,
                                            'transaction_id' => $details->transaction_id,
                                            'payment_method_icon' => $details->payment_method_icon,
                                            'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                            'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                            'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                            'is_auto' => $details->is_auto
                                        );
                                        $lists[] = $hst;
                                    }
                                }
                                elseif ($filter_package_type != ''){
                                    if($filter_package_type == $details->plan_name){
                                        $hst = array(
                                            'id' => $details->id,
                                            'fk_user_id' => $details->fk_user_id,
                                            'plan_name' => ($_POST['lang'] == 'dnk') ? $details->dnk_name : $details->plan_name,
                                            'plan_price' => $details->price,
                                            'transaction_id' => $details->transaction_id,
                                            'payment_method_icon' => $details->payment_method_icon,
                                            'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                            'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                            'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                            'is_auto' => $details->is_auto
                                        );
                                        $lists[] = $hst;
                                    }
                                }
                            }
                            else{
                                $hst = array(
                                    'id' => $details->id,
                                    'fk_user_id' => $details->fk_user_id,
                                    'plan_name' => ($_POST['lang'] == 'dnk') ? $details->dnk_name : $details->plan_name,
                                    'plan_price' => $details->price,
                                    'transaction_id' => $details->transaction_id,
                                    'payment_method_icon' => $details->payment_method_icon,
                                    'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                    'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                    'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                    'is_auto' => $details->is_auto
                                );
                                $lists[] = $hst;
                            }
                        }
                    }
                }

                

                $this->chk = 1;
                $this->msg = 'Purchased History Lists';

                $this->return_data = array('list' => $lists);

            }
        }

    }

    public function mobilepay_init(){

        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
			$this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('type', 'type', 'required');
            $this->form_validation->set_rules('plan_id', 'plan_id', 'required');

            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 

            $user_id = $this->input->post('user_id');
            $type = $this->input->post('type');
            $external_id = "Loppe_".$user_id."_".time();

            if($type =='1'){
                $planId = $this->input->post('plan_id',true);
                $plan_details = $this->db->get_where("rudra_plan",array('id' => $planId))->row();

                $payment_price = ($plan_details->discount_price > 0) ? $plan_details->discount_price : $plan_details->price;
            }else{   

                $planId = $this->input->post('plan_id',true);
                $package_details = $this->db->get_where("rudra_package",array('id' => $planId))->row();

                $payment_price = ($package_details->discount_price > 0) ? $package_details->discount_price : $package_details->price;
            }

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.mobilepay.dk/merchant-authentication-openidconnect/connect/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token=77AD9247D8D1AF31068D277005E342E25014957EA7EFFA29F49C2F72179CDA37&client_id=loppekortet&client_secret=ECUl7LWFugQOdeeEFSvlkcRm733hQbEXNGwAQcZgAY',
                CURLOPT_HTTPHEADER => array(
                  'Content-Type: application/x-www-form-urlencoded'
                ),
              ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;

            $response =(json_decode($response));
            $access_token = $response->access_token;
            // exit;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mobilepay.dk/subscriptions/api/providers/749e92fe-9c11-4b38-b56d-de6f8596e60e/agreements',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "external_id": "'.$external_id.'",
            "amount": "'.$payment_price.'",
            "currency": "DKK",
            "description": "Monthly subscription",
            "frequency": 12,
            "links": [
                {
                "rel": "user-redirect",
                "href": "https://www.loppekortet.dk/callback"
                },
                {
                "rel": "success-callback",
                "href": "https://www.loppekortet.dk/callback"
                },
                {
                "rel": "cancel-callback",
                "href": "https://www.loppekortet.dk/callback"
                },
                {
                "rel": "cancel-redirect",
                "href": "https://www.loppekortet.dk/callback"
                }
            ],
            "country_code": "DK",
            "plan": "Basic",
            "expiration_timeout_minutes": 5,
            "retention_period_hours": 0,
            "disable_notification_management": false,
            "notifications_on": true
            }',
            CURLOPT_HTTPHEADER => array(
                'content-type: application/json',
                'x-ibm-client-id: 5a9fa165-5f4e-483d-a7e7-053df09ce519',
                'x-ibm-client-secret: P4iU3rH1dQ5sJ2iW5pX3eC6kC8kV0hQ3aU5bU4pV3sN5nY2oX4',
                'authorization: '.$access_token.'',
                'accept: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo "<pre>";
            // echo $response;
            // exit;
            $response =(json_decode($response));
            $agreement_id = $response->id;
            $link = $response->links[0]->href;
            
            $this->chk = 1;
            $this->msg = 'Agreement id generated';
            $this->return_data = array('agreement_id' => $agreement_id, 'link' => $link, 'external_id' => $external_id);

            }
            
        }

    }

    public function paymentrequests(){

        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
			$this->form_validation->set_rules('agreement_id', 'agreement_id', 'required');
            $this->form_validation->set_rules('plan_id', 'plan_id', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('external_id', 'external_id', 'required');
            $this->form_validation->set_rules('type', 'type', 'required');

            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 

                $user_id = $this->input->post('user_id');
                $agreement_id = $this->input->post('agreement_id');
                $external_id = $this->input->post('external_id');
                $plan_id = $this->input->post('plan_id');
                $type = $this->input->post('type');
                if($type =='1'){
                    $planId = $this->input->post('plan_id',true);
                    $plan_details = $this->db->get_where("rudra_plan",array('id' => $planId))->row();
    
                    $payment_price = ($plan_details->discount_price > 0) ? $plan_details->discount_price : $plan_details->price;
                }else{   
    
                    $planId = $this->input->post('plan_id',true);
                    $package_details = $this->db->get_where("rudra_package",array('id' => $planId))->row();
    
                    $payment_price = ($package_details->discount_price > 0) ? $package_details->discount_price : $package_details->price;
                }

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.mobilepay.dk/merchant-authentication-openidconnect/connect/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token=77AD9247D8D1AF31068D277005E342E25014957EA7EFFA29F49C2F72179CDA37&client_id=loppekortet&client_secret=ECUl7LWFugQOdeeEFSvlkcRm733hQbEXNGwAQcZgAY',
                CURLOPT_HTTPHEADER => array(
                  'Content-Type: application/x-www-form-urlencoded'
                ),
              ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;

            $response =(json_decode($response));
            $access_token = $response->access_token;
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mobilepay.dk/subscriptions/api/providers/749e92fe-9c11-4b38-b56d-de6f8596e60e/paymentrequests',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'[
                {
                    "agreement_id": "'.$agreement_id.'",
                    "amount": "'.$payment_price.'",
                    "due_date": "'.date('Y-m-d', strtotime('+2 days')).'",
                    "external_id": "'.$external_id.'",
                    "description": "Monthly payment",
                    "grace_period_days": 3
                }
            ]',
            CURLOPT_HTTPHEADER => array(
                'content-type: application/json',
                'x-ibm-client-id: 5a9fa165-5f4e-483d-a7e7-053df09ce519',
                'x-ibm-client-secret: P4iU3rH1dQ5sJ2iW5pX3eC6kC8kV0hQ3aU5bU4pV3sN5nY2oX4',
                'authorization: '.$access_token.'',
                'accept: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;

            $this->chk = 1;
            $this->msg = 'Payment id generated';
            $this->return_data = json_decode($response);

            }
        }

    }


    public function paymentstatus(){

        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
			$this->form_validation->set_rules('agreement_id', 'agreement_id', 'required');
            $this->form_validation->set_rules('payment_id', 'payment_id', 'required');

            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            { 

                $payment_id = $this->input->post('payment_id');
                $agreement_id = $this->input->post('agreement_id');

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.mobilepay.dk/merchant-authentication-openidconnect/connect/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token=77AD9247D8D1AF31068D277005E342E25014957EA7EFFA29F49C2F72179CDA37&client_id=loppekortet&client_secret=ECUl7LWFugQOdeeEFSvlkcRm733hQbEXNGwAQcZgAY',
                CURLOPT_HTTPHEADER => array(
                  'Content-Type: application/x-www-form-urlencoded'
                ),
              ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;

            $response =(json_decode($response));
            $access_token = $response->access_token;
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mobilepay.dk/subscriptions/api/providers/749e92fe-9c11-4b38-b56d-de6f8596e60e/agreements/'.$agreement_id.'/'.'paymentrequests/'.$payment_id.'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => "<file contents here>",
            CURLOPT_HTTPHEADER => array(
                'content-type: application/json',
                'x-ibm-client-id: 5a9fa165-5f4e-483d-a7e7-053df09ce519',
                'x-ibm-client-secret: P4iU3rH1dQ5sJ2iW5pX3eC6kC8kV0hQ3aU5bU4pV3sN5nY2oX4',
                'authorization: '.$access_token.'',
                'accept: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;

            $this->chk = 1;
            $this->msg = 'Payment information';
            $this->return_data = json_decode($response);

            }
        }



    }


    public function checkAgreement(){

        if(!empty($_POST))
        {
            $this->form_validation->set_rules('api_key', 'API KEY', 'required');
			$this->form_validation->set_rules('agreement_id', 'agreement_id', 'required');

            if($this->form_validation->run() == FALSE) 
			{ 
                $this->chk = 0;
                $this->msg = 'Input Error, Please check Params';
                $this->return_data = $this->form_validation->error_array();
            }
            else
            {
                $agreement_id = $this->input->post('agreement_id');

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.mobilepay.dk/merchant-authentication-openidconnect/connect/token',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token=77AD9247D8D1AF31068D277005E342E25014957EA7EFFA29F49C2F72179CDA37&client_id=loppekortet&client_secret=ECUl7LWFugQOdeeEFSvlkcRm733hQbEXNGwAQcZgAY',
                    CURLOPT_HTTPHEADER => array(
                      'Content-Type: application/x-www-form-urlencoded'
                    ),
                  ));

                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response;

                $response =(json_decode($response));
                $access_token = $response->access_token;

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.mobilepay.dk/subscriptions/api/providers/749e92fe-9c11-4b38-b56d-de6f8596e60e/agreements/'.$agreement_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'content-type: application/json',
                    'x-ibm-client-id: 5a9fa165-5f4e-483d-a7e7-053df09ce519',
                    'x-ibm-client-secret: P4iU3rH1dQ5sJ2iW5pX3eC6kC8kV0hQ3aU5bU4pV3sN5nY2oX4',
                    'authorization: '.$access_token.'',
                    'accept: application/json'
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $this->chk = 1;
                $this->msg = 'Agreement information';
                $this->return_data = json_decode($response);
            }
        }

    }

}

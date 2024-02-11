<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rentspace extends MY_Controller
{
    function __construct(){
        parent::__construct();
        if (!$this->session->userdata('rudra_users_logged_in'))
        {   
            redirect(base_url(), 'refresh');
        }
        else
        {
            $details = $this->getUserInfo($this->session->userdata('rudra_users_id'));
            $this->profile_pic = $details['profile_pic'];
            $this->email_id = ($details['email_id']) ? $details['email_id'] : 'payment@fleemarket.com';
            $this->users_id = $this->session->userdata('rudra_users_id');
            $this->is_login = true;
        }

        $this->users_authentication = $this->usersViewerCreator($this->users_id);
        
        $this->load->library('stripe_lib');
    }

    public function list()
    {
        // echo "<pre>";
        $select = "rudra_market.market_name, rudra_market.start_date, rudra_market.end_date, rudra_market.start_time, rudra_market.end_time, rudra_rent_space.added_on, rudra_rent_space.fk_market_id";
        $where = array('rudra_rent_space.fk_user_id' => $this->users_id);
        $rentspace = $this->gm->get_groupby_join_list($select, 'rudra_market', $where, 'rudra_rent_space', 'rudra_rent_space.fk_market_id = rudra_market.id','LEFT', 'rudra_rent_space.fk_market_id');

        $rentspaceList = array();

        $rs_total_amount = 0;
        $rs_total_earned_amount = 0;

        $total_table_number = 0;
        $total_table_booked_number = 0;

        foreach ($rentspace as $keys => $values) {
            $select_large = "rudra_rent_space.id, rudra_rent_space.table_type, rudra_rent_space.table_no, rudra_rent_space.table_rent_price, rudra_rent_space.table_rent_receive";
            $where_large = array('fk_user_id' => $this->users_id, 'fk_market_id' => $values->fk_market_id, 'table_type' => 'Large');
            $lrgdetails = $this->gm->get_details($select_large, 'rudra_rent_space', $where_large);

            if($lrgdetails){

                $select_rsp = "sum(table_no) as total";
                $where_rsp = array('fk_rent_space_id' => $lrgdetails->id, 'table_type' => 'Large', 'status' => '1', 'is_deleted' => '0');

                $rsp = $this->gm->get_details($select_rsp, 'rudra_rent_space_purchased', $where_rsp);

                $bookTotal = ($rsp->total) ? $rsp->total : 0;

                $lrgdetails->total_booked_table_no = $bookTotal;
                $lrgdetails->total_amount = $bookTotal * $lrgdetails->table_rent_price;
                $lrgdetails->total_earned = $bookTotal * $lrgdetails->table_rent_receive;
                $rs_total_amount = $rs_total_amount + $lrgdetails->total_amount;
                $rs_total_earned_amount = $rs_total_earned_amount + $lrgdetails->total_earned;
                $total_table_number = $total_table_number + $lrgdetails->table_no;
                $total_table_booked_number = $total_table_booked_number + $bookTotal;
                $values->tables[] = array('type' => 'Large', 'details' => $lrgdetails);
            }

            $select_medium = "rudra_rent_space.id, rudra_rent_space.table_type, rudra_rent_space.table_no, rudra_rent_space.table_rent_price, rudra_rent_space.table_rent_receive";
            $where_medium = array('fk_user_id' => $this->users_id, 'fk_market_id' => $values->fk_market_id, 'table_type' => 'Medium');
            $mddetails = $this->gm->get_details($select_medium, 'rudra_rent_space', $where_medium);

            if($mddetails){

                $select_rsp = "sum(table_no) as total";
                $where_rsp = array('fk_rent_space_id' => $mddetails->id, 'table_type' => 'Large', 'status' => '1', 'is_deleted' => '0');

                $rsp = $this->gm->get_details($select_rsp, 'rudra_rent_space_purchased', $where_rsp);

                $bookTotal = ($rsp->total) ? $rsp->total : 0;

                $mddetails->total_booked_table_no = $bookTotal;
                $mddetails->total_amount = $bookTotal * $mddetails->table_rent_price;
                $mddetails->total_earned = $bookTotal * $mddetails->table_rent_receive;
                $rs_total_amount = $rs_total_amount + $mddetails->total_amount;
                $rs_total_earned_amount = $rs_total_earned_amount + $mddetails->total_earned;
                $total_table_number = $total_table_number + $mddetails->table_no;
                $total_table_booked_number = $total_table_booked_number + $bookTotal;
                $values->tables[] = array('type' => 'Medium', 'details' => $mddetails);
            }

            $select_small = "rudra_rent_space.id, rudra_rent_space.table_type, rudra_rent_space.table_no, rudra_rent_space.table_rent_price, rudra_rent_space.table_rent_receive";
            $where_small = array('fk_user_id' => $this->users_id, 'fk_market_id' => $values->fk_market_id, 'table_type' => 'Small');
            $smdetails = $this->gm->get_details($select_small, 'rudra_rent_space', $where_small);

            if($smdetails){

                $select_rsp = "sum(table_no) as total";
                $where_rsp = array('fk_rent_space_id' => $smdetails->id, 'table_type' => 'Large', 'status' => '1', 'is_deleted' => '0');

                $rsp = $this->gm->get_details($select_rsp, 'rudra_rent_space_purchased', $where_rsp);

                $bookTotal = ($rsp->total) ? $rsp->total : 0;

                $smdetails->total_booked_table_no = $bookTotal;
                $smdetails->total_amount = $bookTotal * $smdetails->table_rent_price;
                $smdetails->total_earned = $bookTotal * $smdetails->table_rent_receive;
                $rs_total_amount = $rs_total_amount + $smdetails->total_amount;
                $rs_total_earned_amount = $rs_total_earned_amount + $smdetails->total_earned;
                $total_table_number = $total_table_number + $smdetails->table_no;
                $total_table_booked_number = $total_table_booked_number + $bookTotal;
                $values->tables[] = array('type' => 'Small', 'details' => $smdetails);
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

            $rentspaceList[] = $values;
        }

        $data['rentspace'] = $rentspaceList;
        
        $data['profile_pic'] = $this->profile_pic;

        $bankqry = "SELECT * FROM rudra_bank_account where fk_user_id = $this->users_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        $data['bank_details'] = $this->db->query($bankqry)->row();
        $data['bank_transfer_details'] = array();
        if($data['bank_details']){
            $bank_id=$data['bank_details']->id;
            $banktqry = "SELECT rudra_rent_space_purchased.*,rudra_payment_method.name as payment_method FROM rudra_rent_space_bank_transfer inner join rudra_rent_space_purchased on rudra_rent_space_purchased.id=rudra_rent_space_bank_transfer.fk_rent_space_purchased_id LEFT JOIN rudra_payment_method ON rudra_rent_space_purchased.fk_payment_method_id=rudra_payment_method.id where rudra_rent_space_bank_transfer.fk_bank_account_id = $bank_id AND rudra_rent_space_bank_transfer.status = '1' AND rudra_rent_space_bank_transfer.is_deleted = '0' ORDER BY rudra_rent_space_bank_transfer.id DESC";
            $data['bank_transfer_details'] = $this->db->query($banktqry)->result();
        }
        $this->load->view('users/rent_space', $data);
    }

    public function createTable()
    {
        $data['profile_pic'] = $this->profile_pic;

        $data['markets'] = $this->gm->get_list('*', 'rudra_market', array('fk_user_id'=>$this->session->userdata('rudra_users_id'),'status' => '1', 'is_deleted' => '0'));

        $data['table_percentage'] = $this->db->get_where("rudra_settings",array('st_key' => 'table_percentage'))->row()->st_meta;
        
        if($_POST){
           
            $types =array("1"=>"large", "2"=>"medium", "3"=>"small");

            for($i=1;$i<=3;$i++){
                $type = $types[$i];
                if($_POST['table_no_'.$type] && $_POST['table_rent_price_'.$type]){

                    $bannerpath = 'uploads/market';
                    $thumbpath = 'uploads/market';
                    $config['upload_path'] = $bannerpath;
                    $config['allowed_types'] = '*';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    $filename='';
                    if($this->upload->do_upload('image_'.$type))
                    {
                        $imagedata = array('image_metadata' => $this->upload->data());
                        $uploadedImage = $this->upload->data();
                        $filename = $uploadedImage['file_name'];
                    }

                    $updateArray = 
                    array(
                    'fk_user_id' => $this->session->userdata('rudra_users_id'),
                    'fk_market_id' => $this->input->post('fk_market_id',true),
                    'table_type' => $types[$i],
                    'table_no' => $this->input->post('table_no_'.$type,true),
                    'table_rent_price' => $this->input->post('table_rent_price_'.$type,true),
                    'table_rent_receive' => $this->input->post('table_rent_receive_'.$type,true),
                    'table_rent_comission' => $this->input->post('table_rent_comission_'.$type,true),
                    'table_rent_comission_percentage' => $this->input->post('table_rent_comission_percentage',true),
                    'file_name' => $filename,
                    'file_path' => $bannerpath,
                    );

                    $this->db->insert('rudra_rent_space',$updateArray);
                    $id = $this->db->insert_id();

                }

            }

            redirect(base_url("users/rent-space"));
        
        }

        $data['table_creator_status'] = $this->users_authentication['creator']['create_table'];

        $this->load->view('users/create_table', $data);
    }

    public function getMarketData(){

        $id = $this->input->post('id');

        $market = $this->db->get_where("rudra_market",array('id' => $id))->row();

        $start_date=date_create($market->start_date);
        $start_date = date_format($start_date,"d M Y");


        $start_time = date("h:iA", strtotime($market->start_time));
        $end_time = date("h:iA", strtotime($market->end_time));

        $timerange=$start_time." to ".$end_time;

        $data = array(
            'start_date' => $start_date,
            'time' => $timerange
        );
        echo json_encode($data);
    }

    public function handlePayment()
    {
        if(!empty($_POST)){ 
            $market_id = $this->input->post('market_id');

            $large_qty = $this->input->post('large_qty');
            $medium_qty = $this->input->post('medium_qty');
            $small_qty = $this->input->post('small_qty');

            $data['is_login'] = $this->is_login;
            $data['profile_pic'] = $this->profile_pic; 

            $total_amount = 0;

            if($large_qty > 0){
                $rent_space_id = $this->input->post('large_rent_id');
                $type = 'Large';
                $rsqry = "SELECT * FROM rudra_rent_space where id = $rent_space_id AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $rs = $this->db->query($rsqry)->row();

                if(!empty($rs)){

                    $total_amount = $total_amount + $rs->table_rent_price*$large_qty;

                }

            }

            if($medium_qty > 0){
                $rent_space_id = $this->input->post('medium_rent_id');
                $type = 'Medium';
                $rsqry = "SELECT * FROM rudra_rent_space where id = $rent_space_id AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $rs = $this->db->query($rsqry)->row();

                if(!empty($rs)){

                    $total_amount = $total_amount + $rs->table_rent_price*$medium_qty;

                }

            }

            if($small_qty > 0){
                $rent_space_id = $this->input->post('small_rent_id');
                $type = 'Small';
                $rsqry = "SELECT * FROM rudra_rent_space where id = $rent_space_id AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $rs = $this->db->query($rsqry)->row();

                if(!empty($rs)){

                    $total_amount = $total_amount + $rs->table_rent_price*$small_qty;

                }

            }

            // Retrieve stripe token and user info from the submitted form data 
            $token  = $_POST['stripeToken']; 
            $name = $_POST['name']; 
            $email = $this->email_id; 
             
            // Add customer to stripe 
            $customers = $this->stripe_lib->addCustomer($email, $token); 
             
            if($customers['status']){ 

                $customer = $customers['data'];
                // Charge a credit or a debit card 
                $charges = $this->stripe_lib->createCharge($customer->id, 'rentspce', $total_amount); 
                 
                if($charges['status']){ 
                    $charge = $charges['data'];
                    // Check whether the charge is successful 
                    if($charge['amount_refunded'] == 0 && empty($charge['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1){ 
                        // Transaction details  
                        $transactionID = $charge['balance_transaction']; 
                        $paidAmount = $charge['amount']; 
                        $paidAmount = ($paidAmount/100); 
                        $paidCurrency = $charge['currency']; 
                        $payment_status = $charge['status']; 
                         
                        // Insert tansaction data into the database 
                        // $orderData = array( 
                        //     'product_id' => 1, 
                        //     'buyer_name' => $name, 
                        //     'buyer_email' => $email, 
                        //     'paid_amount' => $paidAmount, 
                        //     'paid_amount_currency' => $paidCurrency, 
                        //     'txn_id' => $transactionID, 
                        //     'payment_status' => $payment_status 
                        // ); 
                         
                        // If the order is successful 

                        $tansaction_number = "T".strtoupper(uniqid());
                        $invoice_number = rand(1000,9999);

                        $payment_method_id = 2;
                        $user_id = $this->users_id;

                        if($large_qty > 0){
                            $rent_space_id = $this->input->post('large_rent_id');
                            $type = 'Large';
                            $rsqry = "SELECT * FROM rudra_rent_space where id = $rent_space_id AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $rs = $this->db->query($rsqry)->row();

                            if(!empty($rs)){

                                $rentId = $rs->id;
                                $rspqry = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $rentId AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                $rsp = $this->db->query($rspqry)->row();

                                $bookTotal = ($rsp->total) ? $rsp->total : 0;
                                $avblTotal = $rs->table_no - $bookTotal;

                                $rent_space_no = $large_qty;

                                if($rent_space_no <= $avblTotal){

                                    $payData = array(
                                        'table_type' => $type,
                                        'fk_rent_space_id' => $rent_space_id,
                                        'table_no' => $rent_space_no,
                                        'table_price' => $rs->table_rent_price,
                                        'table_total_price' => $rs->table_rent_price*$rent_space_no,
                                        'fk_user_id' => $user_id,
                                        'transaction_id' => $tansaction_number,
                                        'invoice_number' => $invoice_number,
                                        'purchased_key' => $transactionID,
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

                        if($medium_qty > 0){
                            $rent_space_id = $this->input->post('medium_rent_id');
                            $type = 'Medium';
                            $rsqry = "SELECT * FROM rudra_rent_space where id = $rent_space_id AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $rs = $this->db->query($rsqry)->row();

                            if(!empty($rs)){

                                $rentId = $rs->id;
                                $rspqry = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $rentId AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                $rsp = $this->db->query($rspqry)->row();

                                $bookTotal = ($rsp->total) ? $rsp->total : 0;
                                $avblTotal = $rs->table_no - $bookTotal;

                                $rent_space_no = $medium_qty;

                                if($rent_space_no <= $avblTotal){

                                    $payData = array(
                                        'table_type' => $type,
                                        'fk_rent_space_id' => $rent_space_id,
                                        'table_no' => $rent_space_no,
                                        'table_price' => $rs->table_rent_price,
                                        'table_total_price' => $rs->table_rent_price*$rent_space_no,
                                        'fk_user_id' => $user_id,
                                        'transaction_id' => $tansaction_number,
                                        'invoice_number' => $invoice_number,
                                        'purchased_key' => $transactionID,
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

                        if($small_qty > 0){
                            $rent_space_id = $this->input->post('small_rent_id');
                            $type = 'Small';
                            $rsqry = "SELECT * FROM rudra_rent_space where id = $rent_space_id AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                            $rs = $this->db->query($rsqry)->row();

                            if(!empty($rs)){

                                $rentId = $rs->id;
                                $rspqry = "SELECT sum(table_no) as total FROM rudra_rent_space_purchased where fk_rent_space_id = $rentId AND table_type = '$type' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                                $rsp = $this->db->query($rspqry)->row();

                                $bookTotal = ($rsp->total) ? $rsp->total : 0;
                                $avblTotal = $rs->table_no - $bookTotal;

                                $rent_space_no = $small_qty;

                                if($rent_space_no <= $avblTotal){

                                    $payData = array(
                                        'table_type' => $type,
                                        'fk_rent_space_id' => $rent_space_id,
                                        'table_no' => $rent_space_no,
                                        'table_price' => $rs->table_rent_price,
                                        'table_total_price' => $rs->table_rent_price*$rent_space_no,
                                        'fk_user_id' => $user_id,
                                        'transaction_id' => $tansaction_number,
                                        'invoice_number' => $invoice_number,
                                        'purchased_key' => $transactionID,
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

                        redirect(base_url().'market/'.$market_id, 'refresh');
                        
                    } 
                    else{
                        $data['message'] = $charges['msg'];
                        $this->load->view('front/message', $data);
                    }
                } 
                else{
                    $data['message'] = $charges['msg'];
                    $this->load->view('front/message', $data);
                }
            } 
            else{
                $data['message'] = $customers['msg'];
                $this->load->view('front/message', $data);
            }
        }

    }

    public function addbank(){

        $user_id = $this->users_id;

        $bankqry = "SELECT * FROM rudra_bank_account where fk_user_id = $user_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        $bank_details = $this->db->query($bankqry)->row();

        if($bank_details){
            $bank_holder_name = $this->input->post('bank_holder_name',true);
            $bank_name = $this->input->post('bank_name',true);
            $account_number = $this->input->post('account_number',true);
            $registration_number = $this->input->post('registration_number',true);
            $upData = array(
                'fk_user_id' => $user_id,
                'bank_holder_name' => $bank_holder_name,
                'bank_name' => $bank_name,
                'account_number' => $account_number,
                'registration_number' => $registration_number
            );
            
            $this->db->where('id',$bank_details->id);
            $this->db->update("rudra_bank_account",$upData);

        }
        else{
            $bank_holder_name = $this->input->post('bank_holder_name',true);
            $bank_name = $this->input->post('bank_name',true);
            $account_number = $this->input->post('account_number',true);
            $registration_number = $this->input->post('registration_number',true);
            $newData = array(
                'fk_user_id' => $user_id,
                'bank_holder_name' => $bank_holder_name,
                'bank_name' => $bank_name,
                'account_number' => $account_number,
                'registration_number' => $registration_number
            );

            $this->db->insert('rudra_bank_account',$newData);

        }

        redirect(base_url("users/rent-space"));

    }
}
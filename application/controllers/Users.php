<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    function __construct(){
        parent::__construct();
        
        // Load google oauth library
        $this->load->library('google');
        
        // Load facebook oauth library
        $this->load->library('facebook');
    }

    public function test_realgame()
    {
       echo "<pre>";
       $users = $this->gm->get_unique_list('user_id, SUM(bid_coins) as bid_coins','user_game_bids_realtime',array('user_id > ' => 1),'user_id');

       foreach ($users as $keys => $values) {

            $details = $this->db->get_where('user_game_bids_realtime_data', array('user_id' => $values->user_id))->row_array();
            if (empty($details)) {

                $tot_plyd = $this->gm->get_unique_list('IFNULL(COUNT(id),0) as total_played','user_game_bids_realtime',array('user_id' => $values->user_id),'user_id');

                $tot_won = $this->gm->get_unique_list('IFNULL(COUNT(id),0) as total_won','user_game_bids_realtime',array('user_id' => $values->user_id, 'is_win' => 1),'user_id');

                $data = array(
                    'user_id'                => $values->user_id,
                    'game_id'                => 2,
                    'total_game_played'      => ($tot_plyd[0]->total_played) ? $tot_plyd[0]->total_played : 0,
                    'total_game_won'         => ($tot_won[0]->total_won) ? $tot_won[0]->total_won : 0,
                    'total_user_bet'         => $values->bid_coins                       
                );
                $res = $this->gm->insert_data('user_game_bids_realtime_data',$data);

                print_r($values);

            }

       }
    }

    public function auth_google()
    {        
        if(isset($_GET['code'])){
            
            // Authenticate user with google
            if($this->google->getAuthenticate()){
            
                // Get user info from google
                $gpInfo = $this->google->getUserInfo();

                $login_response = $this->db->get_where('rudra_user', array('email_id' => $gpInfo['email']))->row_array();
                if (!empty($login_response)) {
                    if ($login_response['status'] == 1) {  
                        $userslogin = array(
                            'rudra_users_id'        => $login_response['id'],
                            'rudra_users_name'      => $login_response['first_name'],
                            'rudra_users_logged_in' => TRUE
                        );
                        $this->session->set_userdata($userslogin);
                        header("Location: users");
                        echo json_encode(array('response' => true, 'msg' => 'Login Successfully.'));
                        exit;
                    } else {
                        echo json_encode(array('response' => false, 'msg' => 'Your account is deactivated'));
                        exit;
                    }
                } 
                else {
                    $data = array(
                        'social_id'   => $gpInfo['id'],
                        'social_type' => 'google',
                        'email_id'    => $gpInfo['email'],
                        'first_name'  => $gpInfo['given_name'].' '.$gpInfo['family_name'],
                        'gender'      => !empty($gpInfo['gender'])?$gpInfo['gender']:'',
                        'profile_pic' => !empty($gpInfo['picture'])?$gpInfo['picture']:'',
                        'device_type' => 'Computer'
                    );
                    $insert_id = $this->gm->insert_data('rudra_user', $data);
                    if ($insert_id > 0) {
                        $login_response = $this->db->get_where('rudra_user', array('id' => $insert_id))->row_array();
                        $userslogin = array(
                            'rudra_users_id'        => $login_response['id'],
                            'rudra_users_name'      => $login_response['first_name'],
                            'rudra_users_logged_in' => TRUE
                        );
                        $this->session->set_userdata($userslogin);
                        header("Location: users");
                        echo json_encode(array('response' => true, 'msg' => 'You have Registered Successfully.'));
                        exit;
                    } else {
                        echo json_encode(array('response' => false, 'msg' => 'Somthing went wrong.'));
                        exit;
                    }
                }                
            }
            else{
                echo "Unauthorized";
            }
        }
        else{
            echo "Something went wrong!";
        }
    }

    public function auth_facebook()
    {
        $login_response = $this->db->get_where('rudra_user', array('social_id' => $_POST['id']))->row_array();
        if (!empty($login_response)) {
            if ($login_response['status'] == 1) {  
                $userslogin = array(
                    'rudra_users_id'        => $login_response['id'],
                    'rudra_users_name'      => $login_response['first_name'],
                    'rudra_users_logged_in' => TRUE
                );
                $this->session->set_userdata($userslogin);
                header("Location: users");
                echo json_encode(array('response' => true, 'msg' => 'Login Successfully.'));
                exit;
            } else {
                echo json_encode(array('response' => false, 'msg' => 'Your account is deactivated'));
                exit;
            }
        } 
        else {
            $data = array(
                'social_id'   => $_POST['id'],
                'social_type' => 'facebook',
                'email_id'    => !empty($_POST['email'])?$_POST['email']:'',
                'first_name'  => $_POST['first_name'].' '.$_POST['last_name'],
                'gender'      => !empty($_POST['gender'])?$_POST['gender']:'',
                'profile_pic' => !empty($_POST['picture']['data'])?$_POST['picture']['data'][0]['url']:'',
                'device_type' => 'Computer'
            );
            $insert_id = $this->gm->insert_data('rudra_user', $data);
            if ($insert_id > 0) {
                $login_response = $this->db->get_where('rudra_user', array('id' => $insert_id))->row_array();
                $userslogin = array(
                    'rudra_users_id'        => $login_response['id'],
                    'rudra_users_name'      => $login_response['first_name'],
                    'rudra_users_logged_in' => TRUE
                );
                $this->session->set_userdata($userslogin);
                header("Location: users");
                echo json_encode(array('response' => true, 'msg' => 'You have Registered Successfully.'));
                exit;
            } else {
                echo json_encode(array('response' => false, 'msg' => 'Somthing went wrong.'));
                exit;
            }
        }   
    }

    public function logout()
    {
        session_destroy();
        redirect(base_url(), 'refresh');
    }

    public function registration()
    {
      
        $list = $this->gm->countList('*', 'rudra_user', array('email_id' => $_POST['fw_sg_email']));
        if ($list == 0) {
            $data = array(
                'email_id'  => $_POST['fw_sg_email'],
                'password'  => sha1($_POST['fw_sg_password'])
            );
            $insert_id = $this->gm->insert_data('rudra_user', $data);
            if ($insert_id > 0) {
                $login_response = $this->db->get_where('rudra_user', array('email_id' => $_POST['fw_sg_email'], 'password' => sha1($_POST['fw_sg_password'])))->row_array();

                $userslogin = array(
                    'rudra_users_id'        => $login_response['id'],
                    'rudra_users_name'      => $login_response['first_name'],
                    'rudra_users_logged_in' => TRUE
                );
                $this->session->set_userdata($userslogin);
                echo json_encode(array('response' => true, 'msg' => 'You have Registered Successfully.'));
                exit;
            } else {
                echo json_encode(array('response' => false, 'msg' => 'Somthing went wrong.'));
                exit;
            }
        } 
        else {
            echo json_encode(array('response' => false, 'msg' => 'E-Mail id already exists.'));
            exit;
        }

    }

    public function login()
    {
        $login_response = $this->db->get_where('rudra_user', array('email_id' => $_POST['fw_lg_email'], 'password' => sha1($_POST['fw_lg_password'])))->row_array();
        // $login_response = $this->db->get_where('rudra_user', array('email_id' => 'swapnillengure333@gmail.com'))->row_array();
        if (!empty($login_response)) {
            if ($login_response['status'] == 1) {
                $userslogin = array(
                    'rudra_users_id'        => $login_response['id'],
                    'rudra_users_name'      => $login_response['first_name'],
                    'rudra_users_logged_in' => TRUE
                );
                $this->session->set_userdata($userslogin);
                echo json_encode(array('response' => true, 'msg' => 'Login Successfully.'));
                exit;
            } else {
                echo json_encode(array('response' => false, 'msg' => 'Your account is deactivated'));
                exit;
            }
        } 
        else {
            echo json_encode(array('response' => false, 'msg' => "Invalid username and password."));
            exit;
        }
    }


    public function callback(){
        //echo json_encode($_POST, true);
   //exit;
       //        echo json_encode(array('response' => true, 'msg' => "Proceed to create payment request if agreement is accepted."));
       //echo "<center>Wait until we check agreement status..</center>";
       echo "<center>Vent til vi tjekker aftalestatus..</center>";
   }


    public function success_callback(){
        echo "<pre>";
        echo json_encode($_REQUEST, true);
    }


    public function cancel_callback(){
        echo "Agreement was canceled, please try again..";

    }


    public function checkMobilepayStatus(){

        $dues = $this->db->get_where('rudra_purchased_package', array('due_date' => date('Y-m-d'), 'is_subscription' => '1', 'is_auto' => '0'))->result_array();

        $plandues = $this->db->get_where('rudra_purchased_plan', array('due_date' => date('Y-m-d'), 'is_subscription' => '1', 'is_auto' => '0'))->result_array();

    //    echo "<pre>"; print_r($dues);
        foreach($dues as $due){
            $payment_id = $due['payment_id'];
            $agreement_id = $due['agreement_id'];
            $external_id = $due['external_id'];
            $user_id = $due['fk_user_id'];

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

            $response =(json_decode($response));
            echo $status = $response->status;
            if($status == 'Executed'){

                $upData = array(
                    'is_auto' => '0'
                );

                $this->db->where('fk_user_id', $user_id);
                $this->db->update("rudra_purchased_plan",$upData);

                $upData = array(
                    'is_auto' => '1'
                );

                $this->db->where('id', $due['id']);
                $this->db->update("rudra_purchased_package",$upData);

            }
        }


        foreach($plandues as $due){
            $payment_id = $due['payment_id'];
            $agreement_id = $due['agreement_id'];
            $external_id = $due['external_id'];
            $user_id = $due['fk_user_id'];

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
    
                $response =(json_decode($response));
                $status = $response->status;

                if($status == 'Executed'){

                    $upData = array(
                        'is_auto' => '0'
                    );
    
                    $this->db->where('fk_user_id', $user_id);
                    $this->db->update("rudra_purchased_plan",$upData);

                    $upData = array(
                        'is_auto' => '1'
                    );
    
                    $this->db->where('id', $due['id']);
                    $this->db->update("rudra_purchased_package",$upData);
    
                }
        }

    }



    public function paymentRequest(){


        $dues = $this->db->get_where('rudra_purchased_package', array('expire_date' => date('Y-m-d', strtotime('+2 days')), 'is_subscription' => '1', 'is_auto' => '1'))->result_array();

        $plandues = $this->db->get_where('rudra_purchased_plan', array('expire_date' => date('Y-m-d', strtotime('+2 days')), 'is_subscription' => '1', 'is_auto' => '1'))->result_array();

        foreach($dues as $due){
            $payment_id = $due['payment_id'];
            $agreement_id = $due['agreement_id'];
            $external_id = $due['external_id'];
            $user_id = $due['fk_user_id'];
            $payment_price = $due['payment_price'];
            $fk_package_id = $due['fk_package_id'];
            $expire_date = date('Y-m-d', strtotime('+32 days'));

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
            $response =(json_decode($response));
            $payment_id = $response->pending_payments[0]->payment_id;

            if($payment_id){

                $insert_array = array(
                    'fk_package_id' => $fk_package_id,
                    'fk_user_id' => $user_id,
                    'transaction_id' => "T".strtoupper(uniqid()),
                    'purchased_key' => $agreement_id,
                    'fk_payment_method_id' => '3',
                    'payment_price' => $payment_price,
                    'purchased_date' => date('Y-m-d'),
                    'expire_date' => $expire_date,
                    'external_id' => $external_id,
                    'payment_id' => $payment_id,
                    'agreement_id' => $agreement_id,
                    'is_subscription' => 1,
                    'due_date' => date('Y-m-d', strtotime('+2 days')),
                    'is_auto' => '0'
                );

                $this->db->insert('rudra_purchased_package',$insert_array);
                $new_id = $this->db->insert_id();

            }
   
            
        }



        foreach($plandues as $due){
            $payment_id = $due['payment_id'];
            $agreement_id = $due['agreement_id'];
            $external_id = $due['external_id'];
            $user_id = $due['fk_user_id'];
            $payment_price = $due['payment_price'];
            $fk_plan_id = $due['fk_plan_id'];
            $expire_date = date('Y-m-d', strtotime('+32 days'));

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
            $response =(json_decode($response));
            $payment_id = $response->pending_payments[0]->payment_id;

            if($payment_id){

                $insert_array = array(
                    'fk_plan_id' => $fk_plan_id,
                    'fk_user_id' => $user_id,
                    'transaction_id' => "T".strtoupper(uniqid()),
                    'purchased_key' => $agreement_id,
                    'fk_payment_method_id' => '3',
                    'payment_price' => $payment_price,
                    'purchased_date' => date('Y-m-d'),
                    'expire_date' => $expire_date,
                    'external_id' => $external_id,
                    'payment_id' => $payment_id,
                    'agreement_id' => $agreement_id,
                    'is_subscription' => 1,
                    'due_date' => date('Y-m-d', strtotime('+2 days')),
                    'is_auto' => '0'
                );

                $this->db->insert('rudra_purchased_plan',$insert_array);
                $new_id = $this->db->insert_id();

            }
   
            
        }


    }


    public function crontest(){

        // echo $this->config->item('stripe_currency');
        // $upData = array(
        //     'is_delete' => '1'
        // );

        // $this->db->where('email_id', 'webophp2@gmail.com');
        // $this->db->update("rudra_user",$upData);



    }



    public function purchase_rec(){



        $html = "<!doctype html>
        <html lang='en'>
        
        <head><title>Loppekortet</title>
        
        
        </head>
        
        <body><h3>Purchased Plans:</h3>
            <table><thead>
            <th>Plan</th>
            <th>Payment method</th>
            <th>Purchase date</th>
            <th>Amount</th></thead><tbody>";

        $total_price = 0;

        $purchased_plans = $this->db->order_by('id', 'desc')->get_where('rudra_purchased_history', array('fk_user_id'=>'3','fk_type'=>'plan'))->result_array();

        foreach($purchased_plans as $row){

// print_r($row);

            $plan = $this->db->get_where('rudra_purchased_plan', array('id'=> $row['fk_purchased_id']))->row_array();
            
            $plandata = $this->db->get_where('rudra_plan', array('id'=> $plan['fk_plan_id']))->row_array();

            $paymethod = $this->db->get_where('rudra_payment_method', array('id'=> $plan['fk_payment_method_id']))->row_array();

            $html .= "<tr><td>".$plandata['plan_name']."</td>";

            $html .= "<td>".$paymethod['name']."</td>";
            $html .= "<td>".date('d M, Y',strtotime($plan['purchased_date']))."</td>";
            $html .= "<td style='float:right'>".$plan['payment_price']."</td></tr>";

            $total_price = $total_price + $plan['payment_price']; 


        }
        
         $html .= "<tr><td colspan='3' style='float:right'>Total Amount:</td><td style='float:right'>".$total_price."</td></tr></tbody></table>";
        
        
        $html .="<h3>Purchased Packages:</h3>
        <table><thead>
        <th>Package</th>
        <th>Payment method</th>
        <th>Purchase date</th>
        <th>Amount</th></thead><tbody>";
        $purchased_packages = $this->db->order_by('id', 'desc')->get_where('rudra_purchased_history', array('fk_user_id'=>'3','fk_type'=>'Package'))->result_array();

        foreach($purchased_packages as $row){

// print_r($row);

            $package = $this->db->get_where('rudra_purchased_package', array('id'=> $row['fk_purchased_id']))->row_array();
            
            $packagedata = $this->db->get_where('rudra_package', array('id'=> $package['fk_package_id']))->row_array();

            $paymethod = $this->db->get_where('rudra_payment_method', array('id'=> $package['fk_payment_method_id']))->row_array();

            $html .= "<tr><td>".$packagedata['package_name']."</td>";

            $html .= "<td>".$paymethod['name']."</td>";
            $html .= "<td>".date('d M, Y',strtotime($package['purchased_date']))."</td>";
            $html .= "<td style='float:right'>".$package['payment_price']."</td></tr>";

            $total_price = $total_price + $package['payment_price']; 


        }
        
        
        
        
       echo $html .= "<tr><td colspan='3' style='float:right'>Total Amount:</td><td style='float:right'>".$total_price."</td></tr></tbody></table>";

        
        
        
        // echo $total_price;

            // $sendgrid_apikey = getenv('YOUR_SENDGRID_APIKEY');
            // $sendgrid = new SendGrid($sendgrid_apikey);
            // $url = 'https://api.sendgrid.com/';
            // $pass = $sendgrid_apikey;
            // $template_id = '<your_template_id>';
            // $js = array(
            // 'sub' => array(':name' => array('Elmer')),
            // 'filters' => array('templates' => array('settings' => array('enable' => 1, 'template_id' => $template_id)))
            // );

            // $params = array(
            //     'to'        => "test@example.com",
            //     'toname'    => "Example User",
            //     'from'      => "you@youremail.com",
            //     'fromname'  => "Your Name",
            //     'subject'   => "PHP Test",
            //     'text'      => "I'm text!",
            //     'html'      => "<strong>I'm HTML!</strong>",
            //     'x-smtpapi' => json_encode($js),
            // );

            // $request =  $url.'api/mail.send.json';

            // // Generate curl request
            // $session = curl_init($request);
            // // Tell PHP not to use SSLv3 (instead opting for TLS)
            // curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            // curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
            // // Tell curl to use HTTP POST
            // curl_setopt ($session, CURLOPT_POST, true);
            // // Tell curl that this is the body of the POST
            // curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
            // // Tell curl not to return headers, but do return the response
            // curl_setopt($session, CURLOPT_HEADER, false);
            // curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

            // // obtain response
            // $response = curl_exec($session);
            // curl_close($session);

            // // print everything out
            // print_r($response);
    }



    public function rent_space_purchased(){

        $html = "<!doctype html>
        <html lang='en'>
        
        <head><title>Loppekortet</title>
        
        
        </head>
        
        <body><h3>Purchased Spaces:</h3>
            <table><thead>
            <th>Market</th>
            <th>Table type</th>
            <th>No. of tables</th>
            <th>Payment method</th>
            <th>Purchase date</th>
            <th>Total Amount</th></thead><tbody>";

        $total_price = 0;

        $rentspaces = $this->db->order_by('id', 'desc')->get_where('rudra_rent_space_purchased', array('fk_user_id'=>'3'))->result_array();

        foreach($rentspaces as $row){

            $paymethod = $this->db->get_where('rudra_payment_method', array('id'=> $row['fk_payment_method_id']))->row_array();

            $rent = $this->db->get_where('rudra_rent_space', array('id'=> $row['fk_rent_space_id']))->row_array();
            $market = $this->db->get_where('rudra_market', array('id'=> $row['fk_market_id']))->row_array();

            $html .= "<tr><td>".$market['market_name']."</td>";

            $html .= "<tr><td>".$row['table_type']."</td>";
            $html .= "<tr><td>".$row['table_no']."</td>";

            $html .= "<td>".$paymethod['name']."</td>";
            $html .= "<td>".date('d M, Y',strtotime($row['purchased_date']))."</td>";
            $html .= "<td style='float:right'>".$row['table_total_price']."</td></tr>";

            $total_price = $total_price + $row['table_total_price']; 



        }

        echo $html .= "<tr><td colspan='3' style='float:right'>Total Amount:</td><td style='float:right'>".$total_price."</td></tr></tbody></table>";


    }
}

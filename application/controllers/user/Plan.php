<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plan extends MY_Controller
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
            $this->email_id = $details['email_id'];
        }

        $this->load->library('stripe_lib');
    }

    public function index()
    {
        $data['plan'] = $this->gm->get_list('*', 'rudra_plan', array());
        $data['profile_pic'] = $this->profile_pic;

        $last_query = "SELECT * FROM rudra_purchased_plan where fk_user_id = $this->users_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        $data['last_plan'] = $this->db->query($last_query)->row();
        $data['email_id'] = $this->email_id;

        $this->load->view('users/flea_packages', $data);
    }

    public function handlePayment()
    {
		if(!empty($_POST)){ 
            // Retrieve stripe token and user info from the submitted form data 
            $token  = $_POST['stripeToken']; 
            $name = $_POST['name']; 
            $email = $this->email_id;
            $data['is_login'] = $this->is_login;
            $data['profile_pic'] = $this->profile_pic; 
             
            // Add customer to stripe 
            // echo $email;
            // echo $token;
            $customers = $this->stripe_lib->addCustomer($email, $token); 
             
            if($customers['status']){ 

                $customer = $customers['data'];
                $amount = 0;
                $purchased_id = $_POST['purchased_id'];
                $description = '';
                if($_POST['purchased_type'] != 'Plan'){
                    $package_query = "SELECT * FROM rudra_package where id = $purchased_id";
                    $package = $this->db->query($package_query)->row();
                    if($package->discount_price > 0){
                        $amount = $package->discount_price;
                    }
                    else{
                        $amount = $package->price;
                    }  
                    $description =  $package->package_name;                 
                }
                else{
                    $plan_query = "SELECT * FROM rudra_plan where id = $purchased_id";
                    $plan = $this->db->query($plan_query)->row();
                    // $amount = $plan->price;
                    if($plan->discount_price > 0){
                        $amount = $plan->discount_price;
                    }
                    else{
                        $amount = $plan->price;
                    } 
                    $description =  $plan->plan_name; 
                }
                // Charge a credit or a debit card 
                $charges = $this->stripe_lib->createCharge($customer->id, $description, $amount); 
                 
                if($charges){ 
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

                        if($_POST['purchased_type'] == 'Package'){

                            $upData = array(
                                'is_auto' => '0'
                            );

                            $this->db->where('fk_user_id', $this->users_id);
                            $this->db->update("rudra_purchased_package",$upData);

                            $insert_array = array(
                                'fk_package_id' => $_POST['purchased_id'],
                                'fk_user_id' => $this->users_id,
                                'transaction_id' => "T".strtoupper(uniqid()),
                                'purchased_key' => $transactionID,
                                'fk_payment_method_id' => 2,
                                'payment_price' => $paidAmount,
                                'purchased_date' => date('Y-m-d'),
                                'expire_date' => date('Y-m-d', strtotime('+30 days'))
                            );

                            $this->db->insert("rudra_purchased_package",$insert_array);
                            $new_id = $this->db->insert_id();

                            $purchasedHistory = array(
                                'fk_user_id' => $this->users_id,
                                'fk_purchased_id' => $new_id,
                                'fk_type' => 'Package'
                            );

                            // start send email process for reciept

                            $from_email = "webo.mohit@gmail.com"; 
                            $to_email = $this->input->post('email'); 
                            $to_email = "mohittodquest@gmail.com"; 
                            
                            // load email library
                            $this->load->library('email'); 
                            
                            $this->email->from($from_email, 'Demo Testing'); 
                            $this->email->to($to_email);
                            $this->email->subject('Email Test'); 
                            $this->email->message('Testing the email class.'); 
                    
                            //Send mail 
                            if($this->email->send()) 
                            $this->session->set_flashdata("email_sent","Email sent successfully."); 
                            else 
                            $this->session->set_flashdata("email_sent","Error in sending Email."); 
                            
                            // end payment details reciept mail process

                            $this->db->insert('rudra_purchased_history',$purchasedHistory);
                            redirect(base_url().'users/packages', 'refresh');

                        }
                        elseif ($_POST['purchased_type'] == 'Plan') {
                            $upData = array(
                                'is_auto' => '0'
                            );

                            $this->db->where('fk_user_id', $this->users_id);
                            $this->db->update("rudra_purchased_plan",$upData);
                            
                            $insert_array = array(
                                'fk_plan_id' => $_POST['purchased_id'],
                                'fk_user_id' => $this->users_id,
                                'transaction_id' => "T".strtoupper(uniqid()),
                                'purchased_key' => $transactionID,
                                'fk_payment_method_id' => 2,
                                'payment_price' => $paidAmount,
                                'purchased_date' => date('Y-m-d'),
                                'expire_date' => date('Y-m-d', strtotime('+30 days'))
                            );

                            $this->db->insert('rudra_purchased_plan',$insert_array); 
                            $new_id = $this->db->insert_id();

                            $purchasedHistory = array(
                                'fk_user_id' => $this->users_id,
                                'fk_purchased_id' => $new_id,
                                'fk_type' => 'Plan'
                            );

                            $this->db->insert('rudra_purchased_history',$purchasedHistory);
                            redirect(base_url().'users/plan', 'refresh');
                        }
                        else{
                            $data['message'] = $customers['msg'];
                            $this->load->view('front/message', $data);
                        }
                        
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


    public function cancel_plan(){

        $user_id = $this->users_id;
        $upData = array(
            'is_auto' => '0'
        );

        $this->db->where('fk_user_id', $user_id);
        $this->db->update("rudra_purchased_plan",$upData);

        redirect(base_url().'users/plan', 'refresh');
    }
}
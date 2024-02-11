<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Packages extends MY_Controller
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
            $this->users_id = $this->session->userdata('rudra_users_id');
            $this->email_id = $details['email_id'];
        }
    }

    public function index()
    {
        $data['package'] = $this->gm->get_list('*', 'rudra_package', array());
        $data['profile_pic'] = $this->profile_pic;
        $last_query = "SELECT * FROM rudra_purchased_package where fk_user_id = $this->users_id AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
        $data['last_package'] = $this->db->query($last_query)->row();
        $data['email_id'] = $this->email_id;
        $this->load->view('users/packages', $data);
    }

    public function purchaseHistory()
    {
        $data['profile_pic'] = $this->profile_pic;

        // $where = array('rudra_purchased_history.fk_user_id'=> $this->users_id ,'rudra_purchased_package.status' => '1', 'rudra_purchased_package.is_deleted' => '0','fk_type'=>'package');
        // $data['purchaseData'] = $this->gm->get_join_list('rudra_purchased_history.*,rudra_purchased_package.*','rudra_purchased_history',$where,'rudra_purchased_package','rudra_purchased_package.id = rudra_purchased_history.fk_purchased_id','List');
        $history_query = "SELECT * FROM rudra_purchased_history WHERE fk_user_id = $this->users_id ORDER BY id DESC";
        $hlist = $this->db->query($history_query)->result();


        // echo "<pre>";    
        //     print_r($this->db->last_query());exit;
        // $hlist = $this->db->query($query)->result();
        if($this->session->userdata('site_lang') == 'danish'){
            $data['months'] = array(
                array('name' => 'Januar', 'id' => 'January'),
                array('name' => 'Februar', 'id' => 'February'),
                array('name' => 'Marts', 'id' => 'March'),
                array('name' => 'April', 'id' => 'April'),
                array('name' => 'Maj', 'id' => 'May'),
                array('name' => 'Juni', 'id' => 'June'),
                array('name' => 'Juli', 'id' => 'July'),
                array('name' => 'August', 'id' => 'August'),
                array('name' => 'September', 'id' => 'September'),
                array('name' => 'Oktober', 'id' => 'October'),
                array('name' => 'November', 'id' => 'November'),
                array('name' => 'December', 'id' => 'December')
            );
        }else{
            $data['months'] = array(
                array('name' => 'January', 'id' => 'January'),
                array('name' => 'February', 'id' => 'February'),
                array('name' => 'March', 'id' => 'March'),
                array('name' => 'April', 'id' => 'April'),
                array('name' => 'May', 'id' => 'May'),
                array('name' => 'June', 'id' => 'June'),
                array('name' => 'July', 'id' => 'July'),
                array('name' => 'August', 'id' => 'August'),
                array('name' => 'September', 'id' => 'September'),
                array('name' => 'October', 'id' => 'October'),
                array('name' => 'November', 'id' => 'November'),
                array('name' => 'December', 'id' => 'December')
            );
        }

        $lists = [];
        $user_id=$this->users_id;
        $fk_type = 'Package';
        $filter_month = $this->input->post('month',true);
        // $filter_month ='December';
        if($this->input->post('fk_type',true)){
            $fk_type = $this->input->post('fk_type',true);
        }

        $data['month']=$this->input->post('month',true);
        $data['fk_type']=$this->input->post('fk_type',true);

        foreach ($hlist as $keys => $values) {
            if($fk_type == 'Package'){
                $query = "SELECT rudra_purchased_package.*, rudra_package.package_name, rudra_package.dnk_name, rudra_package.price, rudra_payment_method.pic as payment_method_icon, rudra_payment_method.name as payment_method FROM rudra_purchased_package LEFT JOIN rudra_package ON rudra_purchased_package.fk_package_id=rudra_package.id LEFT JOIN rudra_payment_method ON rudra_purchased_package.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_package.fk_user_id = $user_id AND rudra_purchased_package.id = $values->fk_purchased_id AND rudra_purchased_package.status = '1' AND rudra_purchased_package.is_deleted = '0' ORDER BY rudra_purchased_package.id DESC";

                $listdata = $this->db->query($query)->result();
                // print_r($details);
                // print_r($listdata); die;
                foreach($listdata as $details){

                    
                    $months = date("F", strtotime($details->purchased_date));
                        if($filter_month != ''){
                            if($filter_month == $months){
                                $hst = array(
                                    'id' => $details->id,
                                    'fk_user_id' => $details->fk_user_id,
                                    'plan_name' => $details->package_name,
                                    'plan_price' => $details->price,
                                    'transaction_id' => $details->transaction_id,
                                    'payment_method_icon' => $details->payment_method_icon,
                                    'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                    'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                    'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                    'is_auto' => $details->is_auto,
                                    'payment_method' => $details->payment_method
                                );
                                $lists[] = $hst;
                            }
                        }else{
                            $hst = array(
                                    'id' => $details->id,
                                    'fk_user_id' => $details->fk_user_id,
                                    'plan_name' => $details->package_name,
                                    'plan_price' => $details->price,
                                    'transaction_id' => $details->transaction_id,
                                    'payment_method_icon' => $details->payment_method_icon,
                                    'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                    'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                    'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                    'is_auto' => $details->is_auto,
                                    'payment_method' => $details->payment_method
                                );
                                $lists[] = $hst;
                        }
                    }
                }else if($fk_type == 'Plan'){
                $query = "SELECT rudra_purchased_plan.*, rudra_plan.plan_name, rudra_plan.dnk_name, rudra_plan.price, rudra_payment_method.pic as payment_method_icon, rudra_payment_method.name as payment_method FROM rudra_purchased_plan LEFT JOIN rudra_plan ON rudra_purchased_plan.fk_plan_id=rudra_plan.id LEFT JOIN rudra_payment_method ON rudra_purchased_plan.fk_payment_method_id=rudra_payment_method.id where rudra_purchased_plan.fk_user_id = $user_id AND rudra_purchased_plan.id = $values->fk_purchased_id AND rudra_purchased_plan.status = '1' AND rudra_purchased_plan.is_deleted = '0' ORDER BY rudra_purchased_plan.id DESC";
                $listdata = $this->db->query($query)->result();

                foreach($listdata as $details){

                    
                    $months = date("F", strtotime($details->purchased_date));
                    if($filter_month != ''){
                            if($filter_month == $months){
                                $hst = array(
                                    'id' => $details->id,
                                    'fk_user_id' => $details->fk_user_id,
                                    'plan_name' => $details->plan_name,
                                    'plan_price' => $details->price,
                                    'transaction_id' => $details->transaction_id,
                                    'payment_method_icon' => $details->payment_method_icon,
                                    'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                                    'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                                    'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                                    'is_auto' => $details->is_auto,
                                    'payment_method' => $details->payment_method
                                );
                                $lists[] = $hst;
                            }
                    }else{
                        $hst = array(
                            'id' => $details->id,
                            'fk_user_id' => $details->fk_user_id,
                            'plan_name' => $details->plan_name,
                            'plan_price' => $details->price,
                            'transaction_id' => $details->transaction_id,
                            'payment_method_icon' => $details->payment_method_icon,
                            'plan_date' => date("d/m/Y h:i:s", strtotime($details->created_at)),
                            'paid_date' => date("d/m/Y", strtotime($details->purchased_date)),
                            'expire_date' => date("d/m/Y", strtotime($details->expire_date)),
                            'is_auto' => $details->is_auto,
                            'payment_method' => $details->payment_method
                        ); 
                        $lists[] = $hst;
                    }
            }
        }
    }
        // echo "<pre>";print_r($lists);
        // exit;
        $data['purchaseData']=$lists;
        $this->load->view('users/purchase_history', $data);
    }


    public function cancel_package(){

        $user_id = $this->users_id;
        $upData = array(
            'is_auto' => '0'
        );

        $this->db->where('fk_user_id', $user_id);
        $this->db->update("rudra_purchased_package",$upData);

        redirect(base_url().'users/packages', 'refresh');
    }

}
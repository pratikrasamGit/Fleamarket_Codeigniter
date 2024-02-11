<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends MY_Controller
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
        }
    }

    public function index()
    {
        $users = $this->gm->get_details('*', 'rudra_user', array('id' => $this->users_id));
        $users->birth_date = explode("-",$users->birth_date);
        $data['users'] = $users;
        $data['profile_pic'] = $this->profile_pic;
        $this->load->view('users/index', $data);
    }

    public function profileUpdate()
    {
        $data = array(
            'first_name'       => $_POST['pu_name'],                       
            'mobile'           => $_POST['pu_phone'],                        
            'birth_date'       => $_POST['pu_dob_year'].'-'.$_POST['pu_dob_month'].'-'.$_POST['pu_dob_day'],                     
            'gender'           => $_POST['pu_dob_gender'],                        
            'location'         => $_POST['pu_dob_location']
        );
        $res = $this->gm->update_data('rudra_user',$data,array('id' => $this->users_id));
        if($res)
        {
            echo json_encode(array('response'=>true,'msg'=>'Updated Successfully'));
        }
        else
        {
            echo json_encode(array('response'=>false,'msg'=>'Something went wrong!'));
        }
    }

    public function favorite()
    {
        $where = array('rudra_user_fav_markets.fk_user_id' => $this->users_id);
        $market = $this->gm->get_join_list('rudra_market.*,rudra_user_fav_markets.status as fstatus','rudra_user_fav_markets',$where,'rudra_market','rudra_user_fav_markets.fk_market_id = rudra_market.id','List');
        $markets = array();
        foreach ($market as $keys => $values) {
            if($values->fstatus==1){
            $market_image = $this->gm->getOrderByList('*','rudra_market_gallery',array('fk_market_id' => $values->id),array('key' => 'id', 'value' => 'DESC'));
            // $values->market_images = $market_image;

            if(empty($market_image)){
                $query21 = "SELECT * FROM rudra_market_gallery where fk_market_id = 0 AND  upload_type = '1' AND status = '1' AND is_deleted = '0' ORDER BY id DESC";
                $images1 = $this->db->query($query21)->result();
                $dimg = array();
                foreach ($images1 as $ikeys => $ivalues) {
                    $ivalues->is_visible = 1;
                    $ivalues->fullurl = base_url().$ivalues->path.$ivalues->file;
                    $values->images = $ivalues;
                    $dimg[] = $ivalues;
                }
                $values->images = $dimg;
            }
            else{
                $im = array();
                foreach ($market_image as $imkeys => $imvalues) {
                    $imvalues->fullurl = base_url().$imvalues->path.$imvalues->file;
                    $im[] = $imvalues;
                }

                $values->images = $im;
            }

            $values->is_fav_market=0;
            if($this->users_id){
                $chk_data_fav = $this->db->get_where("rudra_user_fav_markets",array('fk_user_id' => $this->users_id, 'fk_market_id' => $values->id, 'status' => '1', 'is_deleted' => '0'))->row();
                if(!empty($chk_data_fav)){
                    $values->is_fav_market=1;
                }
            }

            $markets[] = $values;
            }
        }

        $data['market'] = $markets;

        // echo $this->db->last_query();
        // print_r($market);
        $data['profile_pic'] = $this->profile_pic;
        $this->load->view('users/favorite', $data);
    }

    public function notification()
    {
        $data['profile_pic'] = $this->profile_pic;
        $data['notifications'] = $this->gm->get_list('*', 'rudra_notification', array('fk_user_id'=>$this->users_id,'status' => '1', 'is_deleted' => '0'));

        $this->load->view('users/notification', $data);
    }

    public function needHelp()
    {
        $data['profile_pic'] = $this->profile_pic;
        $data['need_help_types'] = $this->gm->get_list('*', 'rudra_need_help_type', array('status' => '1', 'is_deleted' => '0'));


        if($_POST){

            $updateArray = 
            array(
             'fk_user_id' => $this->users_id,
             'fk_help_type_id' => $this->input->post('fk_help_type_id',true),
             'message' => $this->input->post('message',true),
            );

            $this->db->insert('rudra_need_help_message',$updateArray);
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

                redirect(base_url("users/need-help"));


        }

        $where = array('fk_user_id'=> $this->users_id ,'rudra_need_help_message.status' => '1', 'rudra_need_help_message.is_deleted' => '0');
        $data['need_help_message'] = $this->gm->get_join_list('rudra_need_help_message.*,rudra_need_help_type.name','rudra_need_help_message',$where,'rudra_need_help_type','rudra_need_help_type.id = rudra_need_help_message.fk_help_type_id','List');

        $this->load->view('users/need_help', $data);
    }
}
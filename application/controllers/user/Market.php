<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Market extends MY_Controller
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

    public function myMarket()
    {
        $where = array('fk_user_id' => $this->users_id);
        $marketList = $this->gm->getOrderByList('*','rudra_market',$where,array('key' => 'id', 'value' => 'DESC'));
        $marketLists = array();
        foreach ($marketList as $keys => $values) {
            $market_image = $this->gm->getOrderByList('*','rudra_market_gallery',array('fk_market_id' => $values->id, 'is_deleted' => '0', 'status' => '1', 'upload_type' => '1'),array('key' => 'id', 'value' => 'DESC'));
            $values->images = $market_image;
            $marketLists[] = $values;
        }
        $data['market'] = $marketLists;
        $data['profile_pic'] = $this->profile_pic;
        $this->load->view('users/my_market', $data);
    }
}
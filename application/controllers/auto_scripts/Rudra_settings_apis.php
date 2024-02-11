<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Rudra_settings_apis extends CI_Controller
{                   
    
    private $api_status = false;
	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->bdp = $this->db->dbprefix;
        $this->table = 'rudra_settings';
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

    public function rudra_rudra_settings($param1)
    {
        $call_type = $param1;
        $res = array();
        if($call_type == 'page_data')
        {            
            $res = $this->rudra_page_data($_POST);        
        }

        $this->json_output(200,array('status' => 200,'message' => $this->msg,'data'=>$this->return_data,'chk' => $this->chk));

    }

    public function rudra_page_data()
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

                //$rr = $this->db->get($this->table)->result();
                //print_r($rr);exit;
                $aboutus_query = "SELECT * FROM $this->table where st_key = 'aboutus'";
                $aboutus = $this->db->query($aboutus_query)->row();

                $terms_query = "SELECT * FROM $this->table where st_key = 'termsofservices'";
                $terms = $this->db->query($terms_query)->row();

                $rentspace_terms_query = "SELECT * FROM $this->table where st_key = 'rentspace_termsofconditions'";
                $rentspace = $this->db->query($rentspace_terms_query)->row();

                $faq_query = "SELECT * FROM $this->table where st_key = 'faq'";
                $faq = $this->db->query($faq_query)->row();
                $faq_st_meta = str_replace('<p>','',$faq->st_meta);
                $faq_st_meta = str_replace('</p>','',$faq_st_meta);
                $faq->st_meta = $faq_st_meta;
                $faq_st_meta = str_replace('<p>','',$faq->dnk_meta);
                $faq_st_meta = str_replace('</p>','',$faq_st_meta);
                $faq->dnk_meta = $faq_st_meta;

                $howitworks_query = "SELECT * FROM $this->table where st_key = 'howitworks'";
                $howitworks = $this->db->query($howitworks_query)->row();
                //print_r($howitworks);exit;
                //echo $ss;exit;

                $privacypolicy_query = "SELECT * FROM $this->table where st_key = 'privacypolicy'";
                $privacypolicy = $this->db->query($privacypolicy_query)->row();

                $months = array(
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

                $dnk_months = array(
                    array('id' => 'January', 'name' => 'Januar'),
                    array('id' => 'February', 'name' => 'Februar'),
                    array('id' => 'March', 'name' => 'Marts'),
                    array('id' => 'April', 'name' => 'April'),
                    array('id' => 'May', 'name' => 'Maj'),
                    array('id' => 'June', 'name' => 'Juni'),
                    array('id' => 'July', 'name' => 'Juli'),
                    array('id' => 'August', 'name' => 'August'),
                    array('id' => 'September', 'name' => 'September'),
                    array('id' => 'October', 'name' => 'Oktober'),
                    array('id' => 'November', 'name' => 'November'),
                    array('id' => 'December', 'name' => 'December')
                );

                $package = array(
                    array('name' => 'Silver', 'id' => 'Silver'),
                    array('name' => 'Gold', 'id' => 'Gold'),
                    array('name' => 'Kræmmer', 'id' => 'Kræmmer'),
                    array('name' => 'Store-packages', 'id' => 'Store-packages')
                );

                $dnk_package = array(
                    array('id' => 'Silver', 'name' => 'Sølv'),
                    array('id' => 'Gold', 'name' => 'Guld'),
                    array('id' => 'Kræmmer', 'name' => 'Kræmmer'),
                    array('id' => 'Store-packages', 'name' => 'Butik-pakker')
                );

                $this->chk = 1;
                $this->msg = 'Settings Lists';

                $this->return_data = array('aboutus' => ($_POST['lang'] == 'dnk') ? $aboutus->dnk_meta : $aboutus->st_meta, 'termsofservices' => ($_POST['lang'] == 'dnk') ? $terms->dnk_meta : $terms->st_meta, 'rentspace_terms' => ($_POST['lang'] == 'dnk') ? $rentspace->dnk_meta : $rentspace->st_meta, 'faq' => ($_POST['lang'] == 'dnk') ? json_decode($faq->dnk_meta) : json_decode($faq->st_meta), 'howitworks' => ($_POST['lang'] == 'dnk') ? json_decode($howitworks->dnk_meta) : json_decode($howitworks->st_meta), 'privacypolicy' =>  ($_POST['lang'] == 'dnk') ? $privacypolicy->dnk_meta : $privacypolicy->st_meta, 'title' => ($_POST['lang'] == 'dnk') ? 'Hvordan kan vi hjælpe dig?' : 'How can we help you?', 'description' => ($_POST['lang'] == 'dnk') ? 'Du kan altid skrive til os, hvis du opdager, at noget der ikke virker, eller du sidder fast! Vi vil svare så hurtigt som muligt.' : 'You can always write to us if you find that something there is not working, or you are stuck! We will respond as soon as possible.', 'months' => ($_POST['lang'] == 'dnk') ? $dnk_months : $months, 'package' => ($_POST['lang'] == 'dnk') ? $dnk_package : $package);

            }
        }
    } 

    public function str_replace_last( $search , $replace , $str ) {
        if( ( $pos = strrpos( $str , $search ) ) !== false ) {
            $search_length  = strlen( $search );
            $str    = substr_replace( $str , $replace , $pos , $search_length );
        }
        return $str;
    }
    
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Rudra_market_crtl extends CI_Controller
{                   
    public function __construct()
    {
        parent::__construct();                
        $this->bdp = $this->db->dbprefix;
        $this->full_table = 'rudra_market';
        $this->return_data = array('status' => false, 'msg' => 'Error', 'login' => false, 'data' => array());
        //$this->set_data();
        $this->base_id = 0;
        $this->load->model('crudmaster_model','crd');
        $this->load->model('rudra_market_rudra_model','rudram');
        // Uncomment Following Codes for Session Check and change accordingly 
        /*
        if (!$this->session->userdata('rudra_admin_logged_in'))
        {			
            $this->return_data = array('status' => false, 'msg' => 'Error', 'login' => false, 'data' => array());
            $return_url = uri_string();
            redirect(base_url("admin-login?req_uri=$return_url"), 'refresh');
        }
        else
        {
            $this->admin_id = $this->session->userdata('rudra_admin_id');
            $this->return_data = array('status' => false, 'msg' => 'Working', 'login' => true, 'data' => array());
        }
        */
    }
    /***********
	//Rudra_market_crtl ROUTES
        $crud_master = $crm . "Rudra_market_crtl/";
        $route['rudra_market'] = $crud_master . 'index';
        $route['rudra_market/index'] = $crud_master . 'index';
        $route['rudra_market/list'] = $crud_master . 'list';
        $route['rudra_market/post_actions/(:any)'] = $crud_master.'post_actions/$1';
	**************/

    public function index()
    {
        // main index codes goes here
        $data['pageTitle'] = ' Market';                        
        $data['page_template'] = '_rudra_market';
        $data['page_header'] = ' Market';
        $data['load_type'] = 'all';                
        $this->load->view('crm/template', $data);
    }
    public function list()
    {
        // main index codes goes here
        //Creating Cols Array used for Ordering the table: ASC and Descending Order
        //If you change the Columns(of DataTable), please change here too
        $orderArray = array(  'id', 'fk_user_id', 'market_name', 'categories', 'recurring_type', 'start_date', 'end_date', 'start_time', 'end_time', 'address', 'landmark', 'zipcode', 'city', 'contact_person', 'contact_number', 'contact_email', 'total_shares', 'status', 'is_deleted', 'is_feature', 'is_main', 'is_open', 'market_long', 'market_lat', );
		$limit = html_escape($this->input->post('length'));
		$start = html_escape($this->input->post('start'));
        if($limit == ''){
            $limit = 10;
        }
        if($start == ''){
            $start = 0;
        }
		$order = '';
		$dir   = $this->input->post('order')[0]['dir'];
		$order   = $this->input->post('order')[0]['column'];
		$orderColumn = $orderArray[$order];
		$general_search = $this->input->post('search')['value'];
		$filter_data['general_search'] = $general_search;
		$totalData = $this->rudram->count_table_data($filter_data,$this->full_table,'0');
		$totalFiltered = $totalData; //Initailly Total and Filtered count will be same
			$rescheck = '';
		$rows = $this->rudram->get_table_data($limit, $start, $orderColumn, $dir, $filter_data,$rescheck,$this->full_table,'0');
		$rows_count = $this->rudram->count_table_data($filter_data,$this->full_table,'0');
		$totalFiltered = $rows_count;
		if(!empty($rows))
		{
			$res_json = array();
			foreach ($rows as $row)
			{
				$actions_base_url = 'rudra_market/post_actions';
				$actions_query_string = "?id= $row->id.'&target_table='.$row->id";
				$form_data_url = 'rudra_market/post_actions';
				$action_url = 'rudra_market/post_actions';
				$sucess_badge =  "class=\'badge badge-success\'";
				$danger_badge =  "class=\'badge badge-danger\'";
				$info_badge =  "class=\'badge badge-info\'";
				$warning_badge =  "class=\'badge badge-warning\'";
	
				$actions_button ="<a id='edt$row->id' href='javascript:void(0)' class='label label-success text-white f-12' onclick =\"static_form_modal('$form_data_url/get_data?id=$row->id','$action_url/update_data','md','Update Details')\" >Views</a>";$checked = '';
				$checked = '';
                if($row->status){
                    $checked = 'checked';
                }
                $actions_button .= "<div class='switch d-inline m-r-10' onclick=\"status('$row->id','$row->status')\"><input type='checkbox' id='status_$row->id' $checked><label for='status_$row->id' class='cr'></label></div>";
                $actions_button .= "<a class='text-danger' href='javascript:void(0)' onclick=\"deletedata('$row->id')\"><i class='fa fa-trash'></i></a>";
				$row->actions = $actions_button;

                $checked2 = '';
                if($row->is_feature==1){
                    $checked2 = 'checked';
                }
                $row->is_feature = "<div class='switch d-inline m-r-10' onclick=\"feature('$row->id','$row->is_feature')\"><input type='checkbox' id='feature_$row->id' $checked2><label for='feature_$row->id' class='cr'></label></div>";

	
				//JOINS LOGIC
				
				$fk_user_id = $this->db->get_where('rudra_user',array('id'=>$row->fk_user_id))->row();
				$row->fk_user_id = (!empty($fk_user_id) ? $fk_user_id->first_name:'--');

				$query = "SELECT rudra_market_category.*, rudra_category_details.category_name FROM rudra_market_category INNER JOIN rudra_category_details ON rudra_market_category.fk_category_id=rudra_category_details.id where rudra_market_category.fk_market_id = $row->id";
                $catList = $this->db->query($query)->result();

                $catLists = '';
                foreach ($catList as $ckeys => $cvalues) {
                    if ($ckeys === key($catList)) {
                        $catLists = $cvalues->category_name;
                    }
                    else{
                        $catLists = $catLists .', '. $cvalues->category_name;
                    }                        
                }

                $row->categories = $catLists;

				$data[] = $row;
			}
		}
		else
		{
			$data = array();
		}
		$json_data = array
			(
			'draw'           => intval($this->input->post('draw')),
			'recordsTotal'    => intval($totalData),
			'recordsFiltered' => intval($totalFiltered),
			'data'           => $data
            );
		echo json_encode($json_data);
	
    }
    public function post_actions($param1)
    {
        // main index codes goes here
        $action = (isset($_GET['act']) ? $_GET['act'] : $param1);
		$id = (isset($_GET['id']) ? $_GET['id'] : 0);
		$this->return_data['status'] = true;
        $col_json = $this->db->get_where($this->bdp.'crud_master_tables',array('tbl_name'=>$this->full_table))->row(); 
        $data['col_json'] = $col_json;
        $json_cols = json_decode($data['col_json']->col_strc);
        $data['json_cols'] = array();
        $data['json_values'] = array();
        //Get Data Methods
        if($action == "get_data")
        {
            $data['id'] = $id;                           
            foreach($json_cols as $ck => $cv)
            {
                if($cv->form_type == 'ddl')
                {
                    $data[$cv->col_name] = $cv->ddl_options;
                }
                if($cv->form_type == 'json')
                {
                    $data['json_cols'][] = $cv->col_name;
                }

                //Foreign Key Logics
                if($cv->f_key)
                {
                    $ref_table_name = $cv->ref_table;
                    $data[$cv->col_name] = $this->db->get($ref_table_name)->result();
                }
            }

            $data['form_data'] = $this->db->get_where($this->full_table,array('id'=>$id))->row(); 
            if(!empty($data['json_cols']))
            {
                foreach($data['json_cols'] as $k => $v)
                {
                    $data['json_values'][$v] = $data['form_data']->$v;
                }
            }
            //print_r($data);exit;

            $html = $this->load->view("crm/forms/_ajax_rudra_market_form", $data, TRUE);
            $this->return_data['data']['form_data'] = $html;
        }
        // Post Methods
        //Update Codes
        if($action == "update_data")
        {
            if(!empty($_POST))
            {
                $id = $_POST['id'];
                $updateArray = 
				array(
				 'id' => $this->input->post('id',true),
				 'fk_user_id' => $this->input->post('fk_user_id',true),
				 'market_name' => $this->input->post('market_name',true),
				 'categories' => $this->input->post('categories',true),
				 'recurring_type' => $this->input->post('recurring_type',true),
				 'start_date' => $this->input->post('start_date',true),
				 'end_date' => $this->input->post('end_date',true),
				 'start_time' => $this->input->post('start_time',true),
				 'end_time' => $this->input->post('end_time',true),
				 'description' => $this->input->post('description',true),
				 'address' => $this->input->post('address',true),
				 'landmark' => $this->input->post('landmark',true),
				 'zipcode' => $this->input->post('zipcode',true),
				 'city' => $this->input->post('city',true),
				 'contact_person' => $this->input->post('contact_person',true),
				 'contact_number' => $this->input->post('contact_number',true),
				 'contact_email' => $this->input->post('contact_email',true),
				 'total_shares' => $this->input->post('total_shares',true),
				 'status' => $this->input->post('status',true),
				 'is_deleted' => $this->input->post('is_deleted',true),
				 'is_feature' => $this->input->post('is_feature',true),
				 'is_main' => $this->input->post('is_main',true),
				 'is_open' => $this->input->post('is_open',true),
				 'market_long' => $this->input->post('market_long',true),
				 'market_lat' => $this->input->post('market_lat',true),
				);

                $this->db->where('id',$id);
                $this->db->update($this->full_table,$updateArray);
            }
            
        }
        //Insert Method
        if($action == "insert_data")
        {
            $id = 0;
            if(!empty($_POST))
            { 
                //Insert Codes goes here 
                $updateArray = 
				array(
				 'id' => $this->input->post('id',true),
				 'fk_user_id' => $this->input->post('fk_user_id',true),
				 'market_name' => $this->input->post('market_name',true),
				 'categories' => $this->input->post('categories',true),
				 'recurring_type' => $this->input->post('recurring_type',true),
				 'start_date' => $this->input->post('start_date',true),
				 'end_date' => $this->input->post('end_date',true),
				 'start_time' => $this->input->post('start_time',true),
				 'end_time' => $this->input->post('end_time',true),
				 'description' => $this->input->post('description',true),
				 'address' => $this->input->post('address',true),
				 'landmark' => $this->input->post('landmark',true),
				 'zipcode' => $this->input->post('zipcode',true),
				 'city' => $this->input->post('city',true),
				 'contact_person' => $this->input->post('contact_person',true),
				 'contact_number' => $this->input->post('contact_number',true),
				 'contact_email' => $this->input->post('contact_email',true),
				 'total_shares' => $this->input->post('total_shares',true),
				 'status' => $this->input->post('status',true),
				 'is_deleted' => $this->input->post('is_deleted',true),
				 'is_feature' => $this->input->post('is_feature',true),
				 'is_main' => $this->input->post('is_main',true),
				 'is_open' => $this->input->post('is_open',true),
				 'market_long' => $this->input->post('market_long',true),
				 'market_lat' => $this->input->post('market_lat',true),
				);

                $this->db->insert($this->full_table,$updateArray);
                $id = $this->db->insert_id();
            }
            
            
            
        }

        // Export CSV Codes 
        if($action == "export_data")
        {
            $header = array();
            foreach($json_cols as $ck => $cv)
            {
                $header[] = $cv->list_caption;
            }
            $filename = strtolower('rudra_market').'_'.date('d-m-Y').".csv";
            $fp = fopen('php://output', 'w');                         
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);
            fputcsv($fp, $header);
            $result_set = $this->db->get($this->full_table)->result();
            foreach($result_set as $k)
            {  
                $row = array();
                foreach($json_cols as $ck => $cv)
                {
                    $cl = $cv->col_name;                                    
                    $row[] = $k->$cl;
                }                              
                fputcsv($fp,$row);
            }
        }


        //Update Status 
        if($action == "status")
        {
            if(!empty($_POST))
            {
                $id = $_POST['id'];

                $status = '0';
                if($_POST['status'] == 0){
                    $status = '1';

                    $rs_query = "SELECT * FROM rudra_market where id = $id";
                    $rs = $this->db->query($rs_query)->row();

                    $notifyData = array(
                        'fk_user_id' => $rs->fk_user_id,
                        'message' => 'Your market has been approved'
                    );
    
                    $this->db->insert("rudra_notification",$notifyData);
                }
                $updateArray = array(
                    'status' => $status
                );

                $this->db->where('id',$id);
                $this->db->update($this->full_table,$updateArray);
            }
        }

        //Update Feature 
        if($action == "feature")
        {
            if(!empty($_POST))
            {
                $id = $_POST['id'];

                $feature = '0';
                if($_POST['feature'] == 0){
                    $feature = '1';
                }
                $updateArray = array(
                    'is_feature' => $feature
                );

                $this->db->where('id',$id);
                $this->db->update($this->full_table,$updateArray);
            }
        }

        // Delete data
        if($action == 'delete_data')
        {
            if(!empty($_POST))
            {
                $id = $_POST['id'];
                $updateArray = array(
                    'is_deleted' => '1'
                );

                $this->db->where('id',$id);
                $this->db->update($this->full_table,$updateArray);
            }
        }

        echo json_encode($this->return_data);
		exit;
    }
                    
}
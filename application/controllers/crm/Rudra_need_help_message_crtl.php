
<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Rudra_need_help_message_crtl extends CI_Controller
{                   
    public function __construct()
    {
        parent::__construct();                
        $this->bdp = $this->db->dbprefix;
        $this->full_table = 'rudra_need_help_message';
        $this->return_data = array('status' => false, 'msg' => 'Error', 'login' => false, 'data' => array());
        //$this->set_data();
        $this->base_id = 0;
        $this->load->model('crudmaster_model','crd');
        $this->load->model('rudra_need_help_message_rudra_model','rudram');
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
	//Rudra_need_help_message_crtl ROUTES
        $crud_master = $crm . "Rudra_need_help_message_crtl/";
        $route['rudra_need_help_message'] = $crud_master . 'index';
        $route['rudra_need_help_message/index'] = $crud_master . 'index';
        $route['rudra_need_help_message/list'] = $crud_master . 'list';
        $route['rudra_need_help_message/post_actions/(:any)'] = $crud_master.'post_actions/$1';
	**************/

    public function index()
    {
        // main index codes goes here
        $data['pageTitle'] = ' Need Help Message';                        
        $data['page_template'] = '_rudra_need_help_message';
        $data['page_header'] = ' Need Help Message';
        $data['load_type'] = 'all';                
        $this->load->view('crm/template', $data);
    }
    public function list()
    {
        // main index codes goes here
        //Creating Cols Array used for Ordering the table: ASC and Descending Order
        //If you change the Columns(of DataTable), please change here too
        $orderArray = array(  'id', 'fk_user_id', 'parent_id', 'fk_admin_id', 'fk_help_type_id', 'message', 'file', 'path', 'fullpath', 'status', 'is_deleted', );
		$limit = html_escape($this->input->post('length'));
		$start = html_escape($this->input->post('start'));
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
				$actions_base_url = 'rudra_need_help_message/post_actions';
				$actions_query_string = "?id= $row->id.'&target_table='.$row->id";
				$form_data_url = 'rudra_need_help_message/post_actions';
				$action_url = 'rudra_need_help_message/post_actions';
				$sucess_badge =  "class=\'badge badge-success\'";
				$danger_badge =  "class=\'badge badge-danger\'";
				$info_badge =  "class=\'badge badge-info\'";
				$warning_badge =  "class=\'badge badge-warning\'";
	
				// $actions_button ="<a id='edt$row->id' href='javascript:void(0)' class='label label-success text-white f-12' onclick =\"static_form_modal('$form_data_url/get_data?id=$row->id','$action_url/update_data','md','Update Details')\" >Edit</a>";
                $checked = '';
                if($row->status){
                    $checked = 'checked';
                }
                $actions_button = "<div class='switch d-inline m-r-10' onclick=\"status('$row->id','$row->status')\"><input type='checkbox' id='status_$row->id' $checked><label for='status_$row->id' class='cr'></label></div>";
                $actions_button .= "<a class='text-danger' href='javascript:void(0)' onclick=\"deletedata('$row->id')\"><i class='fa fa-trash'></i></a>";
				$row->actions = $actions_button;
	
				//JOINS LOGIC
				
				$fk_user_id = $this->db->get_where('rudra_user',array('id'=>$row->fk_user_id))->row();
				$row->fk_user_id = (!empty($fk_user_id) ? $fk_user_id->first_name:'--');
				$fk_help_type_id = $this->db->get_where('rudra_need_help_type',array('id'=>$row->fk_help_type_id))->row();
				$row->fk_help_type_id = (!empty($fk_help_type_id) ? $fk_help_type_id->name:'--');
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

            $html = $this->load->view("crm/forms/_ajax_rudra_need_help_message_form", $data, TRUE);
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
				 'parent_id' => $this->input->post('parent_id',true),
				 'fk_admin_id' => $this->input->post('fk_admin_id',true),
				 'fk_help_type_id' => $this->input->post('fk_help_type_id',true),
				 'message' => $this->input->post('message',true),
				 'file' => $this->input->post('file',true),
				 'path' => $this->input->post('path',true),
				 'fullpath' => $this->input->post('fullpath',true),
				 'status' => $this->input->post('status',true),
				 'is_deleted' => $this->input->post('is_deleted',true),
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
				 'parent_id' => $this->input->post('parent_id',true),
				 'fk_admin_id' => $this->input->post('fk_admin_id',true),
				 'fk_help_type_id' => $this->input->post('fk_help_type_id',true),
				 'message' => $this->input->post('message',true),
				 'file' => $this->input->post('file',true),
				 'path' => $this->input->post('path',true),
				 'fullpath' => $this->input->post('fullpath',true),
				 'status' => $this->input->post('status',true),
				 'is_deleted' => $this->input->post('is_deleted',true),
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
            $filename = strtolower('rudra_need_help_message').'_'.date('d-m-Y').".csv";
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
                }
                $updateArray = array(
                    'status' => $status
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
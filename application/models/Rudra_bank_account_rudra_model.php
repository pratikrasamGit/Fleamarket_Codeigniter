<?php
                
defined('BASEPATH') or exit('No direct script access allowed');

                
class Rudra_bank_account_rudra_model extends CI_Model
                
{
                   
                    
	public function __construct()
                    
	{
                    
		parent::__construct();
                
                    $this->bdp = $this->db->dbprefix;
                    $this->full_table = 'rudra_bank_account';
                        
                    }
	public function get_table_data($limit,$start,$order,$dir,$filter_data,$tbl_data,$table_name,$dl_status)
	{
		$table = $this->full_table .' TBL';
	$query = " SELECT TBL.id, TBL.fk_user_id, TBL.bank_holder_name, TBL.bank_name, TBL.account_number, TBL.registration_number, TBL.status, TBL.is_deleted" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_user_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.bank_holder_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.bank_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.account_number LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.registration_number LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_deleted LIKE '%".$filter_data['general_search']."%'";
	$where .= " ) ";
	$where .= "AND TBL.is_deleted = '$dl_status'";
	$order_by = ($order == '' ? '' : ' ORDER BY '.$order." ".$dir);
	$limit = " LIMIT ".$start." , " .$limit;
	$query = $query.$where.$order_by.$limit;
	 $res = $this->db->query($query)->result();
	 // echo $this->db->last_query();
	 return $res;
	}


	public function count_table_data($filter_data,$table_name,$dl_status)
		{
		$table = $this->full_table .' TBL';
	$query = " SELECT COUNT(id) as cntrows" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_user_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.bank_holder_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.bank_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.account_number LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.registration_number LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_deleted LIKE '%".$filter_data['general_search']."%'";
	$where .= " ) ";
	$where .= "AND TBL.is_deleted = '$dl_status'";
	$query = $query.$where;
	 $res = $this->db->query($query)->row();
	 return $res->cntrows;
		}

}
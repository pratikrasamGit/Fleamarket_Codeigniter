<?php
                
defined('BASEPATH') or exit('No direct script access allowed');

                
class Rudra_purchased_package_rudra_model extends CI_Model
                
{
                   
                    
	public function __construct()
                    
	{
                    
		parent::__construct();
                
                    $this->bdp = $this->db->dbprefix;
                    $this->full_table = 'rudra_purchased_package';
                        
                    }
	public function get_table_data($limit,$start,$order,$dir,$filter_data,$tbl_data,$table_name,$dl_status)
	{
		$table = $this->full_table .' TBL';
	$query = " SELECT TBL.id, TBL.fk_user_id, TBL.fk_package_id, TBL.fk_payment_method_id, TBL.transaction_method, TBL.transaction_id, TBL.token, TBL.purchased_key, TBL.status, TBL.is_deleted, TBL.purchased_date, TBL.is_auto, TBL.expire_date" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_user_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_package_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_payment_method_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.transaction_method LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.transaction_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.token LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.purchased_key LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_deleted LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.purchased_date LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_auto LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.expire_date LIKE '%".$filter_data['general_search']."%'";
	 $where .= " ) ";
	$where .= "AND TBL.is_deleted = '$dl_status'";
	$order_by = ($order == '' ? '' : ' ORDER BY '.$order." ".$dir);
	 $limit = " LIMIT ".$start." , " .$limit;
	$query = $query.$where.$order_by.$limit;
	 $res = $this->db->query($query)->result();
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
	$where .=  "  OR  TBL.fk_package_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_payment_method_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.transaction_method LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.transaction_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.token LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.purchased_key LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_deleted LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.purchased_date LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_auto LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.expire_date LIKE '%".$filter_data['general_search']."%'";
	 $where .= " ) ";
	$where .= "AND TBL.is_deleted = '$dl_status'";
	$query = $query.$where;
	 $res = $this->db->query($query)->row();
	 return $res->cntrows;
		}

}
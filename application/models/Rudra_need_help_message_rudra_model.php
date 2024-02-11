<?php
                
defined('BASEPATH') or exit('No direct script access allowed');

                
class Rudra_need_help_message_rudra_model extends CI_Model
                
{
                   
                    
	public function __construct()
                    
	{
                    
		parent::__construct();
                
                    $this->bdp = $this->db->dbprefix;
                    $this->full_table = 'rudra_need_help_message';
                        
                    }
	public function get_table_data($limit,$start,$order,$dir,$filter_data,$tbl_data,$table_name,$dl_status)
	{
		$table = $this->full_table .' TBL';
	$query = " SELECT TBL.id, TBL.fk_user_id, TBL.parent_id, TBL.fk_admin_id, TBL.fk_help_type_id, TBL.message, TBL.file, TBL.path, TBL.fullpath, TBL.status, TBL.is_deleted" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_user_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.parent_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_admin_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_help_type_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.message LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.file LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.path LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fullpath LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_deleted LIKE '%".$filter_data['general_search']."%'";
	 $where .= " ) ";
	$where .= "AND TBL.is_deleted = '$dl_status'";
	$order_by = ($order == '' ? '' : ' ORDER BY '.$order." ".$dir);
	 $limit = " LIMIT ".$start." , " .$limit;
	$query = $query.$where.$order_by.$limit;
	 $res = $this->db->query($query)->result();
	 return $res;
	}


	public function count_table_data($filter_data,$table_name, $dl_status)
		{
		$table = $this->full_table .' TBL';
	$query = " SELECT COUNT(id) as cntrows" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_user_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.parent_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_admin_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_help_type_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.message LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.file LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.path LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fullpath LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_deleted LIKE '%".$filter_data['general_search']."%'";
	 $where .= " ) ";
	$where .= "AND TBL.is_deleted = '$dl_status'";
	$query = $query.$where;
	 $res = $this->db->query($query)->row();
	 return $res->cntrows;
		}

}
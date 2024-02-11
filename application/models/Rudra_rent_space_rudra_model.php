<?php
                
defined('BASEPATH') or exit('No direct script access allowed');

                
class Rudra_rent_space_rudra_model extends CI_Model
                
{
                   
                    
	public function __construct()
                    
	{
                    
		parent::__construct();
                
                    $this->bdp = $this->db->dbprefix;
                    $this->full_table = 'rudra_rent_space';
                        
                    }
	public function get_table_data($limit,$start,$order,$dir,$filter_data,$tbl_data,$table_name,$dl_status)
	{
		$table = $this->full_table .' TBL';
	$query = " SELECT TBL.id, TBL.fk_user_id, TBL.fk_market_id, TBL.table_type, TBL.table_no, TBL.table_rent_price, TBL.table_rent_receive, TBL.table_rent_comission, TBL.table_rent_comission_percentage, TBL.file_name, TBL.file_path, TBL.status, TBL.is_deleted" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_user_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_market_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_type LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_no LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_rent_price LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_rent_receive LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_rent_comission LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_rent_comission_percentage LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.file_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.file_path LIKE '%".$filter_data['general_search']."%'";
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


	public function count_table_data($filter_data,$table_name,$dl_status)
		{
		$table = $this->full_table .' TBL';
	$query = " SELECT COUNT(id) as cntrows" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_user_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_market_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_type LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_no LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_rent_price LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_rent_receive LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_rent_comission LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.table_rent_comission_percentage LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.file_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.file_path LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_deleted LIKE '%".$filter_data['general_search']."%'";
	 $where .= " ) ";
	$where .= "AND TBL.is_deleted = '$dl_status'";
	$query = $query.$where;
	 $res = $this->db->query($query)->row();
	 return $res->cntrows;
		}

}
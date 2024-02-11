<?php
                
defined('BASEPATH') or exit('No direct script access allowed');

                
class Rudra_market_rudra_model extends CI_Model
                
{
                   
                    
	public function __construct()
                    
	{
                    
		parent::__construct();
                
                    $this->bdp = $this->db->dbprefix;
                    $this->full_table = 'rudra_market';
                        
                    }
	public function get_table_data($limit,$start,$order,$dir,$filter_data,$tbl_data,$table_name,$dl_status)
	{
		$table = $this->full_table .' TBL';
	$query = " SELECT TBL.id, TBL.fk_user_id, TBL.market_name, TBL.categories, TBL.recurring_type, TBL.start_date, TBL.end_date, TBL.start_time, TBL.end_time, TBL.address, TBL.landmark, TBL.zipcode, TBL.city, TBL.contact_person, TBL.contact_number, TBL.contact_email, TBL.total_shares, TBL.status, TBL.is_deleted, TBL.is_feature, TBL.is_main, TBL.is_open, TBL.market_long, TBL.market_lat" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fk_user_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.market_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.categories LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.recurring_type LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.start_date LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.end_date LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.start_time LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.end_time LIKE '%".$filter_data['general_search']."%'";
	// $where .=  "  OR  TBL.description LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.address LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.landmark LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.zipcode LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.city LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.contact_person LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.contact_number LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.contact_email LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.total_shares LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_deleted LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_feature LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_main LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_open LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.market_long LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.market_lat LIKE '%".$filter_data['general_search']."%'";
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
	$where .=  "  OR  TBL.market_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.categories LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.recurring_type LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.start_date LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.end_date LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.start_time LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.end_time LIKE '%".$filter_data['general_search']."%'";
	// $where .=  "  OR  TBL.description LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.address LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.landmark LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.zipcode LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.city LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.contact_person LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.contact_number LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.contact_email LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.total_shares LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_deleted LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_feature LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_main LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_open LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.market_long LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.market_lat LIKE '%".$filter_data['general_search']."%'";
	 $where .= " ) ";
	$where .= "AND TBL.is_deleted = '$dl_status'";
	$query = $query.$where;
	 $res = $this->db->query($query)->row();
	 return $res->cntrows;
		}

}
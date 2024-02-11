<?php
                
defined('BASEPATH') or exit('No direct script access allowed');

                
class Rudra_package_rudra_model extends CI_Model
                
{
                   
                    
	public function __construct()
                    
	{
                    
		parent::__construct();
                
                    $this->bdp = $this->db->dbprefix;
                    $this->full_table = 'rudra_package';
                        
                    }
	public function get_table_data($limit,$start,$order,$dir,$filter_data,$tbl_data,$table_name)
	{
		$table = $this->full_table .' TBL';
	$query = " SELECT TBL.id, TBL.package_name, TBL.dnk_name, TBL.price, TBL.discount_price ,TBL.picture_count, TBL.package_description, TBL.dnk_description" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.package_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.dnk_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.price LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.discount_price LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.picture_count LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.package_description LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.dnk_description LIKE '%".$filter_data['general_search']."%'";
	 $where .= " ) ";
	$order_by = ($order == '' ? '' : ' ORDER BY '.$order." ".$dir);
	 $limit = " LIMIT ".$start." , " .$limit;
	$query = $query.$where.$order_by.$limit;
	 $res = $this->db->query($query)->result();
	 return $res;
	}


	public function count_table_data($filter_data,$table_name)
		{
		$table = $this->full_table .' TBL';
	$query = " SELECT COUNT(id) as cntrows" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.package_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.dnk_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.price LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.discount_price LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.picture_count LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.package_description LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.dnk_description LIKE '%".$filter_data['general_search']."%'";
	 $where .= " ) ";
	$query = $query.$where;
	 $res = $this->db->query($query)->row();
	 return $res->cntrows;
		}

}
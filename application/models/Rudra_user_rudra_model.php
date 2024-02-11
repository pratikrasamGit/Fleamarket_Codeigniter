<?php
                
defined('BASEPATH') or exit('No direct script access allowed');

                
class Rudra_user_rudra_model extends CI_Model
                
{
                   
                    
	public function __construct()
                    
	{
                    
		parent::__construct();
                
                    $this->bdp = $this->db->dbprefix;
                    $this->full_table = 'rudra_user';
                        
                    }
	public function get_table_data($limit,$start,$order,$dir,$filter_data,$tbl_data,$table_name,$dl_status)
	{
		$table = $this->full_table .' TBL';
	$query = " SELECT TBL.id, TBL.first_name, TBL.last_name, TBL.birth_date, TBL.gender, TBL.location, TBL.email_id, TBL.password, TBL.social_id, TBL.social_type, TBL.profile_pic, TBL.is_social_image, TBL.forgot_code, TBL.forgot_expiry_time, TBL.mobile, TBL.status, TBL.is_delete, TBL.device_token, TBL.is_complete, TBL.fcm_token, TBL.user_long, TBL.user_lat, TBL.zip_code, TBL.city" ;
	$query .= "  FROM $table "; 
	$where = " WHERE 1 = 1 ";
	 $where .= " AND ( ";
	$where .=  "  TBL.id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.first_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.last_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.birth_date LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.gender LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.location LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.email_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.password LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.social_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.social_type LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.profile_pic LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_social_image LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.forgot_code LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.forgot_expiry_time LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.mobile LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_delete LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.device_token LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_complete LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fcm_token LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.user_long LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.user_lat LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.zip_code LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.city LIKE '%".$filter_data['general_search']."%'";
	 $where .= " ) ";
	$where .= "AND TBL.is_delete = '$dl_status'";
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
	$where .=  "  OR  TBL.first_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.last_name LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.birth_date LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.gender LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.location LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.email_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.password LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.social_id LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.social_type LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.profile_pic LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_social_image LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.forgot_code LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.forgot_expiry_time LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.mobile LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.status LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_delete LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.device_token LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.is_complete LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.fcm_token LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.user_long LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.user_lat LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.zip_code LIKE '%".$filter_data['general_search']."%'";
	$where .=  "  OR  TBL.city LIKE '%".$filter_data['general_search']."%'";
	 $where .= " ) ";
	$where .= "AND TBL.is_delete = '$dl_status'";
	$query = $query.$where;
	 $res = $this->db->query($query)->row();
	 return $res->cntrows;
		}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    public function get_list($select,$table,$where)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function getOrderByList($select,$table,$where,$orderBy)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($orderBy['key'],$orderBy['value']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLimitList($select,$table,$where,$limit,$orderBy)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($orderBy['key'],$orderBy['value']);
        if($limit>0)
        {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getLimitDataList($select,$table,$where,$limit,$start,$orderBy)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($orderBy['key'],$orderBy['value']);
        $this->db->limit($limit,$start);
        $query = $this->db->get();
        return $query->result();
    }
	
	public function getLimitSingle($select,$table,$where,$limit,$orderBy)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($orderBy['key'],$orderBy['value']);
        if($limit>0)
        {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        return $query->row();
    }

    public function get_details($select,$table,$where)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_where_in_details($select,$table,$where,$wherein)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->where_in($wherein['key'],$wherein['value']);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_details_orderby($select,$table,$where,$orderBy)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($orderBy['key'],$orderBy['value']);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_or_where_details($select,$table,$where,$or_where)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->or_where($or_where);
        $query = $this->db->get();
        return $query->row();
    }

    public function insert_data($table,$postData)
    {
        $this->db->insert($table, $postData);
        return ($this->db->affected_rows() != 1) ? 0 : $this->db->insert_id();
    }

    public function update_data($table,$data,$where)
    {
        $this->db->trans_start();
        $this->db->where($where);
        $this->db->update($table,$data);
        $this->db->trans_complete();
        if($this->db->trans_status())
        {
            return true;

        }
        else
        {
            return false;
        }
    }

    public function get_join_details($select,$table,$where,$join_table,$join_condition,$join_position)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->join($join_table, $join_condition, $join_position);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_join_list($select,$table,$where,$join_table,$join_condition,$join_position)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->join($join_table, $join_condition, $join_position);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_groupby_join_list($select,$table,$where,$join_table,$join_condition,$join_position,$unique)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->join($join_table, $join_condition, $join_position);
        $this->db->group_by($unique);
        $query = $this->db->get();
        return $query->result();
    }    

    public function get_join_order_by_list($select,$table,$where,$join_table,$join_condition,$join_position,$orderBy)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->join($join_table, $join_condition, $join_position);
        $this->db->order_by($orderBy['key'],$orderBy['value']);
        $query = $this->db->get();
        return $query->result();
    }
	
	public function get_mulit_wherein_join_order_by_list($select,$table,$where,$joinTbl,$orderBy,$wherein)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        foreach ($joinTbl as $jkeys => $jvalues)
        {
            $this->db->join($jvalues['tbl'],$jvalues['join'],$jvalues['position']);
        }
        $this->db->order_by($orderBy['key'],$orderBy['value']);
        $this->db->where_in($wherein['key'], $wherein['value']);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_mulit_join_list($select,$table,$where,$joinTbl,$limit=0)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        foreach ($joinTbl as $jkeys => $jvalues)
        {
            $this->db->join($jvalues['tbl'],$jvalues['join'],$jvalues['position']);
        }
		if($limit>0)
        {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_mulit_join_order_by_list($select,$table,$where,$joinTbl,$orderBy)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        foreach ($joinTbl as $jkeys => $jvalues)
        {
            $this->db->join($jvalues['tbl'],$jvalues['join'],$jvalues['position']);
        }
        $this->db->order_by($orderBy['key'],$orderBy['value']);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_mulit_join_data_list($select,$table,$where,$joinTbl,$limit,$start,$orderBy)
    {

        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        foreach ($joinTbl as $jkeys => $jvalues)
        {
            $this->db->join($jvalues['tbl'],$jvalues['join'],$jvalues['position']);
        }
        $this->db->limit($limit,$start);
        $this->db->order_by($orderBy['key'],$orderBy['value']);
        $query = $this->db->get();
        return $query->result();
    }
	
	public function get_mulit_join_order_by_list_with_limit($select,$table,$where,$joinTbl,$orderBy,$limit=0)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        foreach ($joinTbl as $jkeys => $jvalues)
        {
            $this->db->join($jvalues['tbl'],$jvalues['join'],$jvalues['position']);
        }
        $this->db->order_by($orderBy['key'],$orderBy['value']);
		if($limit>0)
        {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_unique_list($select,$table,$where,$unique)
    {
        $this->db->distinct();
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->group_by($unique);
        $query = $this->db->get();
        return $query->result();
    }
	
	public function get_unique_details($select,$table,$where,$unique)
    {
        $this->db->distinct();
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->group_by($unique);
        $query = $this->db->get();
        return $query->row();
    }

    public function countList($select,$table,$where)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getLastId($orderBy,$tableName,$limit)
    {
        $last = $this->db->order_by($orderBy['keys'],$orderBy['value'])->limit($limit)->get($tableName)->row();
       return  $last;
    }

}

?>

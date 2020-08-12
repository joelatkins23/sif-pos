<?php

defined('BASEPATH') or exit('No direct script access allowed');

function get_row($table, $where, $order_by = "", $like = array(), $select = "")
{
    $ci = &get_instance();
    $ci->db->where($where);
    if ($where != array()) $ci->db->where($where);
    if ($select != "") $ci->db->select($select);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    
    $res = $ci->db->get($table)->result_array();
    if (!empty($res))
        return $res[0];
    return [];
}

function add_logo($msg_body)
{
    $ci = &get_instance();
    $ele = '<div class="message_box" style="width:1024px; margin:0px auto;  padding: 20px; border:1px solid #ccc;">';
    $ele .= '<style type="text/css"> p[style="text-align: center;font-size: 14px;margin-top: 30px;font-family: sans-serif;"]{display:none;}</style>';
    $ele .= '<div style="text-align: center;border-bottom: 3px double  #ccc;"><img src="' . base_url("assets/client_assets/images/logo.png") . '" alt="" style="height: 100px;"> ';
    $ele .= '<div style="font-size: 20px; text-align:center;">The Official Processor of VirSymCoin - The Cryptocurrency For Payments</div></div>';
    $msg_body = str_replace("font-family: sans-serif;", "display:none;", $msg_body);
    $ele .= $msg_body;
    $ele .= '</div>';
    return $ele;
}

function create_row($table, $data = array())
{
    $ci = &get_instance();
    $ci->db->insert($table, $data);
    return array("status" => "ok");
}

function update_row($table, $data, $where = array())
{
    $ci = &get_instance();
    return $ci->db->update($table, $data, $where);
}

function delete_row($table, $where = array())
{
    $ci = &get_instance();
    if($where == array()){
        return $ci->db->empty_table($table);
    } else {
        return $ci->db->delete($table, $where);
    }
}

function get_count_rows_by_limit($table, $where = array(), $order_by = "", $like = array(), $start = "", $limit = "", $select = "")
{
    $ci = &get_instance();
    if ($where != array()) $ci->db->where($where);
    if ($select != "") $ci->db->select($select);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    if ($limit != "") {
        $ci->db->limit($limit, $start);
    }
    return $ci->db->get($table)->num_rows();
}

function get_join_rows_by_limit($table, $where = array(), $order_by = "", $like = array(), $start = "", $limit = "", $select = "", $joins = array())
{
    $ci = &get_instance();
    if ($where != array()) $ci->db->where($where);
    if ($select != "") $ci->db->select($select);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    if ($limit != "") {
        $ci->db->limit($limit, $start);
    }
    if ($joins != array()) {
        foreach ($joins as $key => $join) {
            $ci->db->join($join['table'], $join['where']);
        }
    }
    return $ci->db->get($table)->result_array();
}

function get_count_join_rows_by_limit($table, $where = array(), $order_by = "", $like = array(), $start = "", $limit = "", $select = "", $joins = array())
{
    $ci = &get_instance();
    if ($where != array()) $ci->db->where($where);
    if ($select != "") $ci->db->select($select);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    if ($limit != "") {
        $ci->db->limit($limit, $start);
    }
    if ($joins != array()) {
        foreach ($joins as $key => $join) {
            $ci->db->join($join['table'], $join['where']);
        }
    }
    return $ci->db->get($table)->num_rows();
}

function get_rows($table, $where = array(), $order_by = "", $like = array(), $select = "", $where_in = array())
{
    $ci = &get_instance();
    if ($where != array()) $ci->db->where($where);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    if ($select != "") $ci->db->select($select);
    if ($where_in != array()) {
        foreach ($where_in as $key => $value) {
            $ci->db->where_in($key,$value);
        }
    }

    return $ci->db->get($table)->result_array();
}

function get_rows_join($table, $where = array(), $order_by = "", $like = array(), $select = "", $where_in = array(),$joins=array())
{
    $ci = &get_instance();
    if ($where != array()) $ci->db->where($where);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    if ($select != "") $ci->db->select($select);
    if ($where_in != array()) {
        foreach ($where_in as $key => $value) {
            $value = implode(",", $value);
            $ci->db->where_in($key,$value);
        }
    }
  
    if ($joins != array()) {
        foreach ($joins as $key => $join) {
            $ci->db->join($join['table'], $join['where']);
        }
    }

    return $ci->db->get($table)->result_array();
}


function get_rows_group_by($table, $where = array(), $order_by = "",$group_by="", $like = array(), $select = "")
{
    $ci = &get_instance();
    if ($where != array()) $ci->db->where($where);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    if ($select != "") $ci->db->select($select);
    if ($group_by!="") $ci->db->group_by($group_by);

    return $ci->db->get($table)->result_array();
}

function get_rows_distinct($table, $where = array(), $order_by = "", $like = array(), $distinct) //seun added distinct helper
{
    $ci = &get_instance();
    $ci->db->distinct();
    $ci->db->select($distinct);
    if ($where != array()) $ci->db->where($where);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    return $ci->db->get($table)->result_array();
}

function get_rows_asso($table, $where = array(), $order_by = "", $like = array())
{
    $ci = &get_instance();
    if ($where != array()) $ci->db->where($where);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    return $ci->db->get($table)->result();
}

function get_rows_by_limit($table, $where = array(), $order_by = "", $like = array(), $start = "", $limit = "")
{
    $ci = &get_instance();
    if ($where != array()) $ci->db->where($where);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    if ($limit != "") {
        $ci->db->limit($limit, $start);
    }
    return $ci->db->get($table)->result_array();
}

function get_rows_count($table, $where = array(), $order_by = "", $like = array())
{
    $ci = &get_instance();
    $ci->db->select("id");
    if ($where != array()) $ci->db->where($where);
    if ($like != array()) {
        $ci->db->like($like);
    }
    if ($order_by != "") $ci->db->order_by($order_by);
    return $ci->db->get($table)->num_rows();
}

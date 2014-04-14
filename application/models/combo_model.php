<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Combo_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_dropdown($name, $value="")
    {
        $arr = array();
        switch($name)
        {
            case 'location_country_sn' :
                //$query = $this->db->where('country_id', $value)->get('states');

                $query = $this->db->where('location_country_sn', $value)->get('location_county');
                
                if($query->num_rows() > 0)
                {
                    $arr[] = array('0' => '-- 城市 --');
                    foreach($query->result() as $row)
                    {
                        $arr[] = array($row->sn => $row->name);
                    }
                }
                else
                {
                    $arr[] = array('0' => '-- 城市 --');
                }

            break;
            case 'location_county_sn' :
                $query = $this->db->where('location_county_sn', $value)->get('location_area');
                
                if($query->num_rows() > 0)
                {
                    $arr[] = array('0' => '-- 鄉鎮市 --');
                    foreach($query->result() as $row)
                    {
                        $arr[] = array($row->sn => $row->name);
                    }
                }
                else
                {
                    $arr[] = array('0' => '-- 鄉鎮市 --');
                }
            break;
            default :
				
                $query = $this->db->get('location_country');
                
                if($query->num_rows() > 0)
                {
                    $arr[0] = '-- 地域 --';
                    foreach($query->result() as $row)
                    {
                        //$arr[] = array($row->sn => $row->name);
                        $arr[$row->sn] = $row->name;
                    }
                }
                else
                {
                    $arr[0] = '-- 地域 --';
                }

            break;
        }
        return $arr;
    }

}  


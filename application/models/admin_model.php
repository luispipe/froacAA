<?php


class Admin_model extends CI_Model {

    function get_total_lo(){
        $query = $this->db->count_all('lo');
        return $query;
    }

    function get_total_user(){
        $query = $this->db->count_all('users');
        return $query;
    }

    function get_total_rep(){
        $query = $this->db->count_all('repository');
        return $query;
    }

    function get_total_lo_score(){
        $query = $this->db->count_all('use_score');
        return $query;
    }

    function get_users(){
        $this->db->select('use_username, use_nombre, use_apellido, use_email,
        use_fecha_registro, use_estado, use_rol_id, use_datebirth, use_edu_level, use_level');
        $this->db->from('users');
        $this->db->join('use_level', 'use_level.use_id_level = users.use_edu_level');
        $this->db->where('use_rol_id !=', 1);
        $query = $this->db->get("");
        return $query->result_array();
    }

    function get_lo_score(){
        $query = $this->db->get("use_score");
        return $query->result_array();
    }

    function del_usr($username){
        $this->db->delete('users', array('use_username' => $username));
    }
}

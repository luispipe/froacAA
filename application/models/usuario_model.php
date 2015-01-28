<?php

class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_usr_data($username) {

        $this->db->select('use_username, use_nombre, use_rol_id');
        $this->db->from('users');
        $this->db->where('use_username', $username);
        $query = $this->db->get();

        return $query->result_array();
    }

    function get_all_usr_data($username) {
        $this->db->select('use_username,  use_nombre, use_apellido,'
            . ' users.use_rol_id, use_rol_nombre, use_level, use_email, use_fecha_registro, use_datebirth, use_edu_level ');
        $this->db->from('users');
        $this->db->join('use_rol', 'use_rol.use_rol_id = users.use_rol_id');
        $this->db->join('use_level', 'use_level.use_id_level = users.use_edu_level');
        $this->db->where('use_username', $username);
        $query = $this->db->get();

        return $query->result_array();
    }

    function save_score() {
        $query = $this->db->get_where('use_score', array('lo_id' => $this->input->post("lo_id"),
            'rep_id' => $this->input->post("rep_id"),"use_username" => $this->input->post("username")));
        if ($query->num_rows() == 0) {
            $data = array(
                "lo_id" => $this->input->post("lo_id"),
                "rep_id" => intval($this->input->post("rep_id")),
                "use_sco_score" => intval($this->input->post("score")),
                "use_sco_date" => date("j-m-y"),
                "use_username" => $this->input->post("username")
                );

            $this->db->insert('use_score', $data);
        } else {
            $data = array(
                "use_sco_score" => intval($this->input->post("score")),
                "use_sco_date" => date("j-m-y"),
                );

            $this->db->where('lo_id', $this->input->post("lo_id"));
            $this->db->where('use_username', $this->input->post("username"));
            $this->db->update('use_score', $data);
        }
    }
    
    function get_rol($username) {
    	$this->db->select('use_rol_id');
    	$this->db->from('users');
    	$this->db->where('use_username', $username);
    	$this->db->limit(1);

    	$query = $this->db->get();

    	if ($query->num_rows() == 1) {
    		return $query->result_array();
    	} else {
    		return false;
    	}
    }

    function verify_username($username) {
        //pendiente
        $this->db->select('use_username');
        $this->db->from('users');
        $this->db->where('use_username', $username);
        $this->db->limit(1);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function guardar_usuario() {

        $data = array(
         "use_username"        =>  $this->input->post("username"),
         "use_nombre"          =>  $this->input->post("nombre"),
         "use_apellido"        =>  $this->input->post("apellido"),    
         "use_clave"           =>  md5($this->input->post("passwd2")),
         "use_email"           =>  $this->input->post("mail"),
         "use_fecha_registro"  =>  date("Y-m-d"),       
         "use_estado"          =>  "TRUE",
         "use_rol_id"          =>  $this->input->post("tipoU"),
         "use_edu_level"          =>  $this->input->post("nevel_ed"),
         "use_datebirth"          =>  $this->input->post("fecha_nac")
         );

        $this->db->insert('users', $data);

    }

    public function update_user($username){
        $data = array(
            "use_nombre"          =>  $this->input->post("nombre"),
            "use_apellido"        =>  $this->input->post("apellido"),
            "use_email"           =>  $this->input->post("mail"),
            "use_rol_id"          =>  $this->input->post("tipoU"),
            "use_edu_level"       =>  $this->input->post("nevel_ed"),
            "use_datebirth"       =>  $this->input->post("fecha_nac")
        );

        $this->db->where('use_username', $username);
        $this->db->update('users', $data);
    }

    function verificar_passwd($passwd, $username){
        $this->db->select('use_clave');
        $this->db->from('users');
        $this->db->where('use_username', $username);
        $this->db->where('use_clave', $passwd);
        $this->db->limit(1);

        $query = $this->db->get();

        return $query->num_rows();
    }

    function actualizar_passwd($passwd, $username){

        $data = array(
            "use_clave"          =>  $passwd
        );
        $this->db->where('use_username', $username);
        $this->db->update('users', $data);

    }

    function get_score(){
        $query = $this->db->get_where('use_score', array('lo_id' => $this->input->post("lo_id"),
            'rep_id' => $this->input->post("rep_id"), 'use_username' => $this->input->post("username") ));

        return $query->result_array();
    }





}

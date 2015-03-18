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

    // Metodo que obtiene los registros de un estudiante a partir de un nombre de usuario dado,
    // a partir de la tabla estudiante, rol y nivel educativo


    function get_all_usr_data($username) {
       $query = $this->db->query("select users.use_username, users.use_nombre, users.use_email, users.use_fecha_registro,users.use_apellido, use_rol.use_rol_nombre, use_rol.use_rol_id, 
use_student.use_stu_datebirth, use_level.use_level 
from users  inner join use_student on use_student.use_username=users.use_username
inner join use_level on cast(use_level.use_id_level as text)=use_student.use_stu_level
inner join use_rol on use_rol.use_rol_id=users.use_rol_id
where users.use_username='".$username."'");

        return $query->result_array();
    }


    // Metodo que obtiene los registros del administrador a partir del nombre de usuario a partir de la tabla usuario

    function get_all_admin_data($username){
        $query = $this->db->query("select users.use_nombre, users.use_apellido, users.use_email, users.use_fecha_registro, use_rol.use_rol_nombre
from users inner join use_rol on use_rol.use_rol_id=users.use_rol_id
where users.use_username='".$username."'");

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


    // Metodo que verifica si un nombre de usuario dado existe en la base de datos 

    function verify_username($username) {
        //pendiente
        $this->db->select('use_username');
        $this->db->from('users');
        $this->db->where('use_username', $username);
        $this->db->limit(1);

        $query = $this->db->get();

        return $query->num_rows();
    }

    // Metodo que guarda los registros a partir de la creación de una cuenta por parte del administrador. 
   
    public function guardar_usuario() {

        $data = array(
         "use_username"        =>  $this->input->post("username"),
         "use_nombre"          =>  $this->input->post("nombre"),
         "use_apellido"        =>  $this->input->post("apellido"),    
         "use_clave"           =>  md5($this->input->post("passwd2")),
         "use_email"           =>  $this->input->post("mail"),
         "use_fecha_registro"  =>  date("Y-m-d"),
         "use_rol_id"          =>  $this->input->post("rol"),
         );
        $this->db->insert('users', $data);
    }
    
    // Cuando un usuario (estudiante) se registra, la información se guarda en la tabla
    // de usuario: "users" y en la tabla del estudiante: "use_student"

    public function guardar_estudiante() {
       
        $today = date("Y-m-d");

        $data = array(
            'use_username' => $this->input->post('username'),
            'use_stu_datebirth' => $this->input->post('fecha_nac'),
            'use_ls_id' => $this->input->post('result_test'),
            'use_stu_level' => $this->input->post('nevel_ed'),
        );

        $data2 = array(
            'use_username' => $this->input->post('username'),
            'use_nombre' => $this->input->post('nombre'),
            'use_apellido'=>  $this->input->post('apellido'),
            'use_clave' => md5($this->input->post('passwd')),
            'use_email' => ($this->input->post('mail')),
            'use_fecha_registro' => $today,
            'use_rol_id'=> $this->input->post('tipoU'),
        );

        $this->db->insert('users', $data2);
        $this->db->insert('use_student', $data);
    }

    //Guarda cada una de las preferencias del estudiante en la tabla "use_pre_stu"

    public function insert_pref($pref, $id) {
  
        $data = array(
            'use_pre_id' => $pref,
            'use_username' => $id
        );
        $this->db->insert('use_pre_stu', $data);
    }

    // Se obtienen los registros de las preferencias que hay en la tabla "use_preference"

    public function get_preferencias() {

        $query = $this->db->get('use_preference');

        return $query->result();
    }


    // Se obtienen los registros de las preferencias que hay en la tabla "use_level"

    public function get_nivel_educativo() {

    
        $query = $this->db->get('use_level');

        return $query->result();
    }
    

    //Metodo que selecciona las preferencias de un estudiante dado  

    public function get_preferencia_est($user) {
        $this->db->select('*');
        $this->db->from('use_pre_stu');
        $this->db->where('use_username', $user);
        $this->db->join('use_preference', 'use_pre_stu.use_pre_id = use_preference.use_pre_id');
        $query = $this->db->get();
        return $query->result();
    }


    public function update_user($username){
        $data1 = array(
            "use_nombre"          =>  $this->input->post("nombre"),
            "use_apellido"        =>  $this->input->post("apellido"),
            "use_email"           =>  $this->input->post("mail"),
            "use_rol_id"          =>  $this->input->post("tipoU"),

        );
        $data2 = array(
            "use_stu_level"       =>  $this->input->post("nevel_ed"),
            "use_stu_datebirth"       =>  $this->input->post("fecha_nac")
        );

        $this->db->where('use_username', $username);
        $this->db->update('users', $data1);
        $this->db->update('use_student', $data2);
    }

    //Se verifica si el correo electrónico ingresado existe en la base de datos

    function verify_email($mail){
        
        $this->db->select('use_email');
        $this->db->from('users');
        $this->db->where('use_email', $mail);
        $this->db->limit(1);

        $query = $this->db->get();

        return $query->num_rows();
    }

    
    public function get_rol_data() {

        // Se obtienen los registros de los roles que hay en la tabla "use_rol"
        $query = $this->db->get('use_rol');

        return $query->result();
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

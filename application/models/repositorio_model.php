<?php

Class Repositorio_model extends CI_Model{
    
    
    function get_repos(){
       $query =  $this->db->get("repository");
       return $query->result_array();
    }
     public function get_user_repo() {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->or_where('use_rol_id', 1);
        $this->db->or_where('use_rol_id', 6);
        $query = $this->db->get();
        return $query->result_array();
    }
     public function insertar_repo($user) {
        $today = date("Y-m-d");
        $data = array(
            "rep_host" => $this->input->post('host'),
            "rep_port" => $this->input->post('puerto'),
            "rep_databasename" => $this->input->post('basededatos'),
            "rep_loggin" => $this->input->post('usuario'),
            "rep_password" => $this->input->post('contrasena'),
            "rep_affiliation" => $this->input->post('entidad'),
            "rep_registrationdate" => $today,
            "rep_url" => $this->input->post('url'),
            "rep_typerepository" => $this->input->post('tiporepositorio'),
            "rep_email" => $this->input->post('email'),
            "rep_name" => $this->input->post('nombrerepositorio'),
            "rep_metadata_inf" => $this->input->post('metadata'),
            "rep_frequency" => $this->input->post('periodicidad'),
            "rep_lastupdate" => $today,
            "rep_countoas" => 0,
            "use_username" => $user
        );
        $this->db->insert('repository', $data);
    }

     public function insertar_repo_roap($user) {
        $today = date("Y-m-d");
        $data = array(
            "rep_host" => $this->input->post('host'),
            "rep_port" => $this->input->post('puerto'),
            "rep_databasename" => $this->input->post('basededatos'),
            "rep_loggin" => $this->input->post('usuario'),
            "rep_password" => $this->input->post('contrasena'),
            "rep_affiliation" => $this->input->post('entidad'),
            "rep_registrationdate" => $today,
            "rep_url" => $this->input->post('url'),
            "rep_typerepository" => $this->input->post('tiporepositorio'),
            "rep_email" => $this->input->post('email'),
            "rep_name" => $this->input->post('nombrerepositorio'),
            "rep_metadata_inf" => $this->input->post('metadata'),
            "rep_lastupdate" => $today,
            "rep_countoas" => 0,
            "use_username" => $user
        );
        $this->db->insert('repository', $data);
    }
}

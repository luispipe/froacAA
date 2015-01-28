<?php

Class Repositorio_model extends CI_Model{
    
    
    function get_repos(){
       $query =  $this->db->get("repository");
       return $query->result_array();
    }
}

<?php

Class Lo_model extends CI_Model {

    function get_oas_b($orParams, $andParams) {

        $andQuery = $this->db->query(
            "SELECT lo_id, rep_id, lo_title, lo_language, lo_description,
                    lo_keyword, lo_location,
                    ts_rank_cd(campo_busqueda_index_col, query) AS rank
                    FROM lo, to_tsquery" . $andParams . "query
                        WHERE query @@ campo_busqueda_index_col
                        ORDER BY rank DESC;"
        );

        $orQuery = $this->db->query(
            "SELECT lo_id, rep_id, lo_title, lo_language, lo_description,
                    lo_keyword, lo_location,
                     ts_rank_cd(campo_busqueda_index_col, query) AS rank
                    FROM lo, to_tsquery" . $orParams . "query
                        WHERE query @@ campo_busqueda_index_col
                        ORDER BY rank DESC;"
        );
        $result = array();
        $resultAnd = array();
        $resultOr = array();
        foreach ($andQuery->result_array() as $and) {
            array_push($resultAnd, $and);
        }

        foreach ($orQuery->result_array() as $or) {
            array_push($resultOr, $or);
        }
        //echo $orParams;
        array_push($result, $resultAnd);
        array_push($result, $resultOr);
        return $result;
    }

    function get_metadata($lo_id, $rep_id) {

        $this->db->select('lo_xml_lom');
        $query = $this->db->get_where('lo', array('lo_id' => $lo_id, 'rep_id' => $rep_id));

        return $query->result_array();
    }

    function set_visita_lo() {
        $query = $this->db->get_where('lo_visitas', array('lo_id' => $this->input->post("lo_id"),
            'rep_id' => $this->input->post("rep_id")));

        if ($query->num_rows() != 1) {
            $data = array(
                "lo_id" => $this->input->post("lo_id"),
                "rep_id" => intval($this->input->post("rep_id")),
                "logged" => intval($this->input->post("logged")),
                "clicked" => 1
            );

            $this->db->insert('lo_visitas', $data);
        } else {
            $lo = $this->input->post("lo_id");
            $rep = intval($this->input->post("rep_id"));
            $sql = "UPDATE lo_visitas 
                        SET clicked = (SELECT clicked FROM lo_visitas WHERE lo_id = '$lo' AND rep_id = $rep) + 1
                            WHERE lo_id = '$lo' AND rep_id = $rep;";
            //!!Verificar la referencia de fk_rep en la tabla lo_visitas esta desde lo y deberia ser desde rep.
            $this->db->query($sql);
        }
    }

    function get_rep_lo($rep_id){

        $query = $this->db->get_where('lo', array('rep_id' => $rep_id));
        return $query->result_array();

    }

    function get_lo_usr($username){

        $query = $this->db->query("SELECT lo.lo_id, lo.rep_id, lo_title, lo_language, lo_description,
                  lo_keyword, use_score.use_username FROM lo
                  JOIN use_score on use_score.lo_id = lo.lo_id AND use_score.rep_id = lo.rep_id
                  where use_username = '$username' ORDER BY use_score.use_sco_score  DESC");
        return $query->result_array();

    }

    function get_avg_score(){
        $lo = $this->input->post("lo_id");
        $rep = intval($this->input->post("rep_id"));
        $query = $this->db->query("SELECT AVG(use_sco_score) FROM use_score where
                                   lo_id = '$lo' AND rep_id = '$rep'");
        return $query->result_array();
    }

//    function get_metadata($lo_id, $rep_id) {
//
//        
//        $query = $this->db->query("select lo_xml_lom from lo where lo_id = '$lo_id' AND rep_id = $rep_id");
//
//        return $query->result_array();
//    }
}

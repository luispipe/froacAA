<?php

class Repositorio extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model("repositorio_model");
        $this->load->model("lo_model");
        $this->load->model("usuario_model");//Import al modelo de la clase
    }

    public function index(){
        $this->lista();

    }

    public function lista() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                "main_view" => "base/lista_rep_view",
                "user" => $session_data ['username'],
                "usr_data" => $this->usuario_model->get_usr_data ( $session_data ['username'] ),
                "repos" => $this->repositorio_model->get_repos(),
                "flag"  => "repo",
                "encabezado" => "Resultados de el repositorio",
                "url" => "repositorio/lista/"
            );
            if ($session_data ['username'] == "admin"){
                $this->load->view('layouts/admin_template', $content);
            }else{
                $this->load->view('layouts/est_template', $content);
            }

        } else {
            $content = array(
                "main_view" => "base/lista_rep_view",
                "repos" => $this->repositorio_model->get_repos(),
                "flag"  => "repo",
                "encabezado" => "Resultados de el repositorio",
                "url" => "repositorio/lista/"
            );
            $this->load->view('layouts/base_template', $content);
        }
    }



     public function registrar_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'username' => $session_data['username'],
                "title" => "Registro Repositorios",
                "titulo" => "Administrador",
                "user" => $session_data['username'],
                "main" => "admin/nuevo_repo_view",
                "page" => "Registro",
                "usuario" => $this->repo_model->get_user_repo()
            );
            $this->load->view('include/adm_template1', $data);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function lo_rep($rep_id){
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                "result" => $this->lo_model->get_rep_lo($rep_id),
                "sess" => 1,
                "user" => $session_data['username'],
                "main_view" => "base/result_view_st",
                "url" => "repositorio/lista/",
                "encabezado" => "Resultados de el repositorio",
            );
            $this->load->view("layouts/base_template",$content);
        } else {
            $content = array(
                "result" => $this->lo_model->get_rep_lo($rep_id),
                "sess" => 0,
                "main_view" => "base/result_view_st",
                "url" => "repositorio/lista/",
                "encabezado" => "Resultados de el repositorio",
            );
            $this->load->view("layouts/base_template",$content);
        }

    }

    public function nuevo(){
        $session_data = $this->session->userdata('logged_in');
        if ($this->session->userdata('logged_in')) {
            if ($session_data ['username'] == "admin"){

                $content = array(
                    "main_view" => "admin/nuevo_repo_view",
                    "user" => $session_data ['username'],
                    "usr_data" => $this->usuario_model->get_usr_data ( $session_data ['username'] ),
                    "usuarios" => $this->repositorio_model->get_user_repo()
                );
            }
            $this->load->view('layouts/admin_template', $content);
        }else {
            $this->lista();
        }
    }

/*Metodos del anterio FROAC*/


public function insert_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            if ($this->input->post('tiporepositorio') == 'ROAp') {
                $this->repositorio_model->insertar_repo_roap();
            } else {
                $this->repositorio_model->insertar_repo();
            }

            $this->lista();
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

  
    public function modificar_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                'username' => $session_data['username'],
                "title" => "Modificar Repositorio",
                "titulo" => "Administrador",
                "user" => $session_data['username'],
                "main" => "adm/modificar_repo_view",
                "page" => "Modificación",
                "repomod" => $this->repo_model->get_repo_mod(),
                "usuario" => $this->repo_model->get_user_repo()
            );

            $this->load->view('include/adm_template1', $content);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function actualizar_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $this->repo_model->modificar_repo();
            $this->lista_repo();
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    public function cosechado($actualizar, $idrepository, $lastupdate, $cadenaoai, $metadata, $fechainicio, $fechafin) {
        //echo "Sale por este lado"+$actualizar;

        if ($actualizar == "1") //Todo
            $url = "http://localhost:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=&fechafin=";
        if ($actualizar == "2") //Ultima Actualización
            $url = "http://localhost:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=" . $lastupdate . "&fechafin=";
        if ($actualizar == "3") //Rango de Fechas
            $url = "http://localhost:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=" . $fechainicio . "&fechafin=" . $fechafin . "";
        /* if ($actualizar == "1") //Todo
          $url = "http://froac.manizales.unal.edu.co:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=&fechafin=";
          if ($actualizar == "2") //Ultima Actualización
          $url = "http://froac.manizales.unal.edu.co:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=" . $lastupdate . "&fechafin=";
          if ($actualizar == "3") //Rango de Fechas
          $url = "http://froac.manizales.unal.edu.co:8080/harvesterFROAC/HarvesterOAI?cadenaOAI=" . $cadenaoai . "&idROA=" . $idrepository . "&metadata=" . $metadata . "&fechainicio=" . $fechainicio . "&fechafin=" . $fechafin . "";
         */
$tags = get_meta_tags($url);
return $tags;
}

public function actualizar_oas() {
    //  Prueba para El Cron
//        echo $idrepository;
//        echo $lastupdate;
//        echo $cadenaoai;
//        echo $metadata;
//        $nuevoarhivo = fopen("pruebacron.txt", 'w+');
//        fwrite($nuevoarhivo, "Esto deberia de estar funcionando");
//        fclose($nuevoarhivo);
    global $idrepository;
    $idrepository = $this->input->post("idrepository");
    $lastupdate = $this->input->post("lastupdate");
    $cadenaoai = $this->input->post("cadenaoai");
    $metadata = $this->input->post("metadata");
    $actualizar = $this->input->post("actualizar");
    $fechainicio = $this->input->post("fechainicio");
    $fechafin = $this->input->post("fechafin");


    $resp = $this->cosechado($actualizar, $idrepository, $lastupdate, $cadenaoai, $metadata, $fechainicio, $fechafin);
    if (count($resp) > 0) {
        //Este for se hace en caso de que se tengan varios xml asociados a la actualización
        //for ($v = 0; $v < count($resp); $v++) {
        foreach ($resp as $res) {
            //Ubicación de los archivos xml
            //$url= base_url()."harvester/".$idrepository."_".($i+1).".xml";
            //$url = base_url() . "harvester/FROAC3.xml";
            //$url = base_url() . $resp[$v];
            //$url = "http://froac.manizales.unal.edu.co/harvester/FROAC-11.xml";
            $url = $res;

            //Se carga el contenido del archivo xml en $oas
            $doc = new DOMDocument();
            $doc->load($url);
            //Verifico el estándar de metadatos a analizar
            if ($metadata == "lom") {
                //Se recorre el xml record por record
                $oas = $doc->getElementsByTagName('record');
                //Tenemos cada record
                $rssUpdate = 0;
                $rssInsert = 0;
                $rssLOUp = array();
                $rssLOIn = array();
                foreach ($oas as $oa) {

                    $header = $oa->getElementsByTagName('header');
                    global $idlom;
                    $idlom = $header->item(0)->getElementsByTagName('identifier')->item(0)->nodeValue;
                    $status = $header->item(0)->getAttribute('status');
                    $datestamp = $header->item(0)->getElementsByTagName('datestamp')->item(0)->nodeValue;
                    $xmlo = '';
                    if ($status != 'deleted') {
                        $xmlo0 = $oa->getElementsByTagName('lom');
                        $xmlo1 = $xmlo0->item(0);
                        $xml = $xmlo1->ownerDocument->saveXML($xmlo1);
                        $xmlo = $xml;
                    }
                    //Hago select para determinar la operación a realizar -- Miro si ya existía el OA
                    $consult = $this->repo_model->get_lo($idrepository, $idlom);
                    $vlr = sizeof($consult);
                    $last = "";
                    if ($vlr == 0) {
                        //Quiere decir que no existe un registro de ese OA, entonces lo inserto
                        if ($status != 'deleted') {
                            $data = array(
                                'idrepository' => $idrepository,
                                'idlom' => $idlom,
                                'insertiondate' => date("Y-m-d"),
                                'deleted' => 'false',
                                'lastmodified' => $datestamp,
                                'xmlo' => $xmlo
                            );
                            $this->repo_model->insert_table($data, 'lo');

                            $data2 = array(
                                'idrepository' => $idrepository,
                                'idlom' => $idlom
                            );
                            $this->repo_model->insert_table($data2, 'lom');

                            /* $data2 = array(
                              'idrepository' => $idrepository,
                              'idlom' => $idlom,
                              'noticedate' => $datestamp,
                              'notice_title' => "insert"
                              );
                              $this->repo_model->insert_table($data2, 'rss'); */
                            $rssLOIn[$rssInsert] = $idlom;
                            $rssInsert++;
                        }
                    } else {
                        foreach ($consult as $consu) {
                            $last = $consu['lastmodified'];
                        }
                        //Quiere decir que ya existe un registro de ese OA, entonces debo actualizarlo
                        if ($status != 'deleted') {
                            if ($last != $datestamp) {
                                //Datos que se van a modificar
                                $data = array(
                                    'lastmodified' => $datestamp,
                                    'xmlo' => $xmlo
                                );

                                //Capos para poner en el where
                                $campos = array(
                                    '0' => 'idrepository',
                                    '1' => 'idlom'
                                );

                                //Valores para poner en el where
                                $valores = array(
                                    '0' => $idrepository,
                                    '1' => $idlom
                                );

                                $this->repo_model->update_table($data, 'lo', $campos, $valores);

                                $this->repo_model->delete_table('lom', $campos, $valores);

                                $data2 = array(
                                    'idrepository' => $idrepository,
                                    'idlom' => $idlom
                                );
                                $this->repo_model->insert_table($data2, 'lom');

                                /* $data2 = array(
                                  'idrepository' => $idrepository,
                                  'idlom' => $idlom,
                                  'noticedate' => $datestamp,
                                  'notice_title' => "update"
                                  );
                                  $this->repo_model->insert_table($data2, 'rss'); */
                                $rssLOUp[$rssUpdate] = $idlom;
                                $rssUpdate++;
                            }
                        } else {
                            $data = array(
                                'deleted' => 'true',
                                'lastmodified' => $datestamp,
                                'xmlo' => $xmlo
                            );
                            //Capos para poner en el where
                            $campos = array(
                                '0' => 'idrepository',
                                '1' => 'idlom'
                            );

                            //Capos para poner en el where
                            $valores = array(
                                '0' => $idrepository,
                                '1' => $idlom
                            );

                            $this->repo_model->update_table($data, 'lo', $campos, $valores);

                            $this->repo_model->delete_table('lom', $campos, $valores);
                        }
                    }
                    if ($status != 'deleted') {
                        if ($last != $datestamp) {
                            $meta = $oa->getElementsByTagName('metadata')->item(0);
                            $this->importGeneral($meta, $idrepository, $idlom);
                            $this->importLifeCycle($meta, $idrepository, $idlom);
                            $this->importMetaMetaData($meta, $idrepository, $idlom);
                            $this->importTechnical($meta, $idrepository, $idlom);
                            $this->importEducational($meta, $idrepository, $idlom);
                            $this->importRights($meta, $idrepository, $idlom);
                            $this->importRelation($meta, $idrepository, $idlom);
                            $this->importAnnotation($meta, $idrepository, $idlom);
                            $this->importClassification($meta, $idrepository, $idlom);
                        }
                    }
                }//foreach
            }//if
        }//for
    }//if
    //Hago select para determinar la operación a realizar
    $cantOAs = $this->repo_model->get_cant_oas_repo($idrepository);
    $data = array(
        'lastupdate' => date("Y-m-d"),
        'countoas' => $cantOAs
    );
    //Capos para poner en el where
    $campos = array(
        '0' => 'idrepository'
    );

    //Capos para poner en el where
    $valores = array(
        '0' => $idrepository
    );
    $this->repo_model->update_table($data, 'repository', $campos, $valores);

    $fecha = date("Y-m-d");

    //PROBLEMAS CON RSS
//        if ($rssInsert != 0) {
//            //Noticia de Insertar
//            $data2 = array(
//                'idrepository' => $idrepository,
//                'noticedate' => $fecha,
//                'notice_title' => "Se insertaron " . ($rssInsert - 1) . " objetos en ",
//                'noticetype' => "insert"
//            );
//            $this->repo_model->insert_table($data2, 'rss');
//            $idnotices = $this->repo_model->get_rss_idnotice($idrepository, $fecha, "insert");
//
//            foreach ($rssLOIn as $key => $lo) {
//                //Noticia de Insertar
//                $data3 = array(
//                    'idnotice' => $idnotices,
//                    'idlom' => $lo
//                );
//                $this->repo_model->insert_table($data3, 'rss_lom');
//            }
//        }
//
//        if ($rssUpdate != 0) {
//            //Noticia de Actualizar
//            $data4 = array(
//                'idrepository' => $idrepository,
//                'noticedate' => date("Y-m-d"),
//                'notice_title' => "Se actualizaron " . ($rssUpdate - 1) . " objetos en ",
//                'noticetype' => "update"
//            );
//            $this->repo_model->insert_table($data4, 'rss');
//
//            $idnotice = $this->repo_model->get_rss_idnotice($idrepository, $fecha, "update");
//            foreach ($rssLOUp as $key => $lo) {
//                //Noticia de Insertar
//                $data5 = array(
//                    'idnotice' => $idnotice,
//                    'idlom' => $lo
//                );
//                $this->repo_model->insert_table($data5, 'rss_lom');
//            }
//        }
    $this->lista_repo();
}
}
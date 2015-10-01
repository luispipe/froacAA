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
                "main_view" => "shared_views/lista_rep_view",
                "user" => $session_data ['username'],
                "usr_data" => $this->usuario_model->get_usr_data ( $session_data ['username'] ),
                "repos" => $this->repositorio_model->get_repos(),
                "flag"  => "repo",
                "encabezado" => "Resultados del repositorio",
                "url" => "repositorio/lista/"
            );
            if ($session_data ['username'] == "admin"){
                $this->load->view('base/admin_template', $content);
            }else{

                $this->load->view('base/est_template', $content);
            }

        } else {
            $content = array(
                "main_view" => "shared_views/lista_rep_view",
                "repos" => $this->repositorio_model->get_repos(),
                "flag"  => "repo",
                "encabezado" => "Resultados del repositorio",
                "url" => "repositorio/lista/"
            );
            $this->load->view('base/base_template', $content);
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
                "main_view" => "shared_views/result_view_st",
                "url" => "repositorio/lista/",
                "encabezado" => "Resultados de el repositorio",
            );
            $this->load->view("base/base_template",$content);
        } else {
            $content = array(
                "result" => $this->lo_model->get_rep_lo($rep_id),
                "sess" => 0,
                "main_view" => "shared_views/result_view_st",
                "url" => "repositorio/lista/",
                "encabezado" => "Resultados de el repositorio",
            );
            $this->load->view("base/base_template",$content);
        }

    }

    //Agregar Repositorio --- Lleva a la vista
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
            $this->load->view('base/admin_template', $content);
        }else {
            $this->lista();
        }
    }

/*Metodos del anterio FROAC*/

//Guardar en nuevo Repositorio --- Lleva al modelo
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

    //Modificar un repositorio --- Lleva a la vista
    public function modificar_repo($rep_id) {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $content = array(
                'username' => $session_data['username'],
                "title" => "Modificar Repositorio",
                "titulo" => "Administrador",
                "user" => $session_data['username'],
                "main_view" => "admin/modificar_repo_view",
                "page" => "Modificación",
                "repomod" => $this->repositorio_model->get_repo_mod($rep_id),
                "usuario" => $this->repositorio_model->get_user_repo()
            );
            $this->load->view('base/admin_template', $content);
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    //Modificar repositori --- Lleva al modelo
    public function actualizar_repo() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $this->repositorio_model->modificar_repo();
            $this->lista();
        } else {
            //If no session, redirect to login page
            redirect('init', 'refresh');
        }
    }

    //Esta función es utilizada para el proceso de cosechado. Lo que hace es ir hasta el Servlet que realiza las peticiones OAI
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

    public function actualizar_oas() 
    {
        global $idrepository;
        $idrepository = $this->input->post("idrepository");
        $lastupdate = $this->input->post("lastupdate");
        $cadenaoai = $this->input->post("cadenaoai");
        $metadata = $this->input->post("metadata");
        $actualizar = $this->input->post("actualizar");
        $fechainicio = $this->input->post("fechainicio");
        $fechafin = $this->input->post("fechafin");
        $resp = $this->cosechado($actualizar, $idrepository, $lastupdate, $cadenaoai, $metadata, $fechainicio, $fechafin);
        //Verifica que sí se generaran XML... lo que retorna la función "cosechado"
        if (count($resp) > 0) {

            //Se recorre el vector que tiene las url de los xml
            foreach ($resp as $res) {
                //Ubicación de los archivos xml
                //$url= base_url()."harvester/".$idrepository."_".($i+1).".xml";
                //Ejemplo --- $url = "http://froac.manizales.unal.edu.co/harvester/FROAC-11.xml";
                $url = $res;

                //Se carga el contenido del archivo xml en $doc
                $doc = new DOMDocument();
                $doc->load($url);
                //Verifico el estándar de metadatos a analizar
                if ($metadata == "lom") {
                    //Se recorre el xml record por record
                    $oas = $doc->getElementsByTagName('record');
                    //Tenemos un vector de 'record' en la variable $oas y se recorre
                    foreach ($oas as $oa) {
                        $header = $oa->getElementsByTagName('header');
                        global $idlom;
                        $idlom = $header->item(0)->getElementsByTagName('identifier')->item(0)->nodeValue;
                        $status = $header->item(0)->getAttribute('status');
                        $datestamp = $header->item(0)->getElementsByTagName('datestamp')->item(0)->nodeValue;
                        $xmlo = '';
                        //Si el estado del record es 'deleted' se 
                        if ($status != 'deleted') {
                            $xmlo0 = $oa->getElementsByTagName('lom');
                            $xmlo1 = $xmlo0->item(0);
                            $xml = $xmlo1->ownerDocument->saveXML($xmlo1);
                            $xmlo = $xml;
                        }

                        //Hago select para determinar la operación a realizar -- Miro si ya existía el OA
                        $consult = $this->repositorio_model->get_lo($rep_id, $lo_id); //---- Consultar si existe en la tabla 'lo' un objeto con ese lo_id y rep_id
                        $vlr = sizeof($consult);
                        $last = "";
                        if ($vlr == 0) {
                            //Quiere decir que no existe un registro de ese OA, entonces lo inserto
                            if ($status != 'deleted') {
                                $data = array(
                                    'rep_id' => $rep_id,
                                    'lo_id' => $lo_id,
                                    'lo_insertiondate' => date("Y-m-d"),
                                    'lo_deleted' => 'false',
                                    'lo_lastmodified' => $datestamp,
                                    'xmlo' => $xmlo// a cual variable corresponde en la tabla lo ????
                                );
                                $this->repo_model->insert_table($lo_date, 'lo'); //---- Insertar en la tabla 'lo' lo correspondiente 

                               /* $data2 = array(
                                    'idrepository' => $idrepository,
                                    'idlom' => $idlom
                                );
                                $this->repo_model->insert_table($data2, 'lom'); 

                                 $data2 = array(
                                  'idrepository' => $idrepository,
                                  'idlom' => $idlom,
                                  'noticedate' => $datestamp,
                                  'notice_title' => "insert"
                                  );
                                  $this->repo_model->insert_table($data2, 'rss'); */
                            }
                        } 
                        else 
                        {
                            foreach ($consult as $consu) {
                                $last = $consu['lo_lastmodified'];
                            }
                            //Quiere decir que ya existe un registro de ese OA, entonces debo actualizarlo
                            if ($status != 'lo_deleted') {
                                if ($last != $lo_lastmodified) {
                                    //Datos que se van a modificar
                                    $data = array(
                                        'lo_lastmodified' => $lo_lastmodified,
                                        'xmlo' => $xmlo /// a que equivale???
                                    );

                                    //Capos para poner en el where
                                    $campos = array(
                                        '0' => 'rep_id',
                                        '1' => 'lo_id'
                                    );

                                    //Valores para poner en el where
                                    $valores = array(
                                        '0' => $rep_id,
                                        '1' => $lo_id
                                    );

                                    $this->repo_model->update_table($data, 'lo', $campos, $valores); //---- Insertar en la tabla 'lo' lo correspondiente 

                                    /*$this->repo_model->delete_table('lom', $campos, $valores);

                                    $data2 = array(
                                        'idrepository' => $idrepository,
                                        'idlom' => $idlom
                                    );
                                    $this->repo_model->insert_table($data2, 'lom');

                                    $data2 = array(
                                      'idrepository' => $idrepository,
                                      'idlom' => $idlom,
                                      'noticedate' => $datestamp,
                                      'notice_title' => "update"
                                      );
                                      $this->repo_model->insert_table($data2, 'rss'); */
                                }
                            } else {
                                $data = array(
                                    'lo_deleted' => 'true',
                                    'lo_lastmodified' => $datestamp, // preguntar a que equivale datestamp
                                    'xmlo' => $xmlo
                                );
                                //Capos para poner en el where
                                $campos = array(
                                    '0' => 'rep_id',
                                    '1' => 'lo_id'
                                );

                                //Capos para poner en el where
                                $valores = array(
                                    '0' => $rep_id,
                                    '1' => $lo_id
                                );

                                $this->repo_model->update_table($data, 'lo', $campos, $valores); //---- Insertar en la tabla 'lo' lo correspondiente 

                                //$this->repo_model->delete_table('lom', $campos, $valores);
                            }
                        }
                        if ($status != 'deleted') {
                            if ($last != $datestamp) {
                                /*$meta = $oa->getElementsByTagName('metadata')->item(0);
                                $this->importGeneral($meta, $idrepository, $idlom);
                                $this->importLifeCycle($meta, $idrepository, $idlom);
                                $this->importMetaMetaData($meta, $idrepository, $idlom);
                                $this->importTechnical($meta, $idrepository, $idlom);
                                $this->importEducational($meta, $idrepository, $idlom);
                                $this->importRights($meta, $idrepository, $idlom);
                                $this->importRelation($meta, $idrepository, $idlom);
                                $this->importAnnotation($meta, $idrepository, $idlom);
                                $this->importClassification($meta, $idrepository, $idlom);*/
                            }
                        }
                    }//foreach     
                }//if    
            }//for
        }//if
        $this->lista_repo();
    }
}

function importGeneral($meta, $idrepository, $idlom) {
            /*             * *************************Title************************** */
            $title = $general->getElementsByTagName('title')->item(0)->nodeValue;
            /*             * *************************Language************************** */
            $tagLanguaje = $general->getElementsByTagName('language');
            $j = 1;
            foreach ($tagLanguaje as $language) {
                $lang = $language->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idgenerallanguage' => $j,
                    'language' => $lang
                );
                $this->repositorio_model->insert_table($data, 'lom');
                $j++;
            }
            /*             * *************************Description************************** */
            $tagDescription = $general->getElementsByTagName('description');
            $j = 1;
            foreach ($tagDescription as $description) {
                $descri = $description->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idgeneraldescription' => $j,
                    'description' => $descri
                );
                $this->repositorio_model->insert_table($data, 'lom');
                $j++;
            }
            /*             * *************************Keyword************************** */
            $tagKeyword = $general->getElementsByTagName('keyword');
            $j = 1;
            foreach ($tagKeyword as $keyword) {
                $key = $keyword->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idgeneralkeyword' => $j,
                    'keyword' => $key
                );
                $this->repositorio_model->insert_table($data, 'lom');
                $j++;
            }
            /*             * *************************Structure************************** */
            $structure = $general->getElementsByTagName('structure')->item(0)->nodeValue;
            /*             * *************************Aggregationlevel************************** */
            $aggregationlevel = $general->getElementsByTagName('aggregationlevel')->item(0)->nodeValue;

            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'general_title' => $title,
                'general_structure' => $structure,
                'general_aggregationlevel' => $aggregationlevel
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

            $this->repositorio_model->update_table($data, 'lom', $campos, $valores);
        }
    }

       ///////////////////// L I F E   C Y C L E/////////////
    function importLifeCycle($meta, $idrepository, $idlom) {
        $tagLifecycle = $meta->getElementsByTagName('lifecycle');
        foreach ($tagLifecycle as $lifecycle) {
            /*             * *************************Version************************** */
            $version = $lifecycle->getElementsByTagName('version')->item(0)->nodeValue;
            /*             * *************************Status************************** */
            $status = $lifecycle->getElementsByTagName('status')->item(0)->nodeValue;
            /*             * *************************Contribute************************** */
            $tagContribute = $lifecycle->getElementsByTagName('contribute');
            $j = 1;
            foreach ($tagContribute as $contribute) {
                $role = $contribute->getElementsByTagName('role')->item(0)->nodeValue;
                
//Hacer condicional para verificar si el role es un author
                $date = $contribute->getElementsByTagName('date')->item(0)->nodeValue;
                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idlifecyclecontribute' => $j,
                    'role' => $role,
                    'date' => $date
                );
                $this->repositorio_model->insert_table($data, 'lifecycle_contribute');
                $x = 1;
                $tagEntity = $contribute->getElementsByTagName('entity');
                foreach ($tagEntity as $entity) {
                    $enti = $entity->nodeValue;
                    $data = array(
                        'idrepository' => $idrepository,
                        'idlom' => $idlom,
                        'idlifecyclecontribute' => $j,
                        'idlifecyclecontributeentity' => $x,
                        'entity' => $enti
                    );
                    $this->repositorio_model->insert_table($data, 'lom');
                    $x++;
                }
                $j++;
            }

            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'lifecycle_version' => $version,
                'lifecycle_status' => $status
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

            $this->repositorio_model->update_table($data, 'lom', $campos, $valores);
        }
    }


     ///////////////////// T E C H N I C A L /////////////
    function importTechnical($meta, $idrepository, $idlom) {
        $tagTechnical = $meta->getElementsByTagName('technical');
        foreach ($tagTechnical as $technical) {
            /*             * *************************Format************************** */
            $tagFormat = $technical->getElementsByTagName('format');
            $j = 1;
            foreach ($tagFormat as $format) {
                $form = $format->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idtechnicalformat' => $j,
                    'format' => $form
                );
                $this->repositorio_model->insert_table($data, 'lom');
                $j++;
            }
            /*             * *************************Location************************** */
            $tagLocation = $technical->getElementsByTagName('location');
            $j = 1;
            foreach ($tagLocation as $location) {
                $locat = $location->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'idtechnicallocation' => $j,
                    'location' => $locat
                );
                $this->repositorio_model->insert_table($data, 'lom');
                $j++;
            }
             ///////////////////// E D U C A T I O N A L /////////////
    function importEducational($meta, $idrepository, $idlom) {
        $tagEducational = $meta->getElementsByTagName('educational');
        foreach ($tagEducational as $educational) {
            /*             * *************************Interactivitytype************************** */
            $interactivitytype = $educational->getElementsByTagName('interactivitytype')->item(0)->nodeValue;
            /*             * *************************Learningresourcetype************************** */
            $tagLearningresourcetype = $educational->getElementsByTagName('learningresourcetype');
            $j = 1;
            foreach ($tagLearningresourcetype as $learningresourcetype) {
                $resourcetype = $learningresourcetype->nodeValue;

                $data = array(
                    'idrepository' => $idrepository,
                    'idlom' => $idlom,
                    'ideducationallearningresourcetype' => $j,
                    'learningresourcetype' => $resourcetype
                );
                $this->repositorio_model->insert_table($data, 'lom');
                $j++;
            }
            /*             * *************************Interactivitylevel************************** */
            $interactivitylevel = $educational->getElementsByTagName('interactivitylevel')->item(0)->nodeValue;

            /*             * *************************Difficulty************************** */
            $difficulty = $educational->getElementsByTagName('difficulty')->item(0)->nodeValue;

            //Con esta sección almaceno en la tabla lom metadatos que no son multivaluados
            $data = array(
                'educational_interactivitytype' => $interactivitytype,
                'educational_interactivitylevel' => $interactivitylevel,
                'educational_semanticdensity' => $semanticdensity,
                'educational_difficulty' => $difficulty,
                'educational_typicallearningtime' => $typicallearningtime
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

            $this->repositorio_model->update_table($data, 'lom', $campos, $valores);
        }
    }
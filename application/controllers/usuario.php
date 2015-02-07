<?php

//Clase Usuario, encargada de todas las operaciones y 
//metodos de los usuarios.

class Usuario extends CI_Controller {


    //Metodo constructor de la clase
    public function __construct() {
        parent::__construct();
        $this->load->model("usuario_model");//Import al modelo de la clase
        $this->load->model("lo_model");//Import al modelo lo_model
    }

    //Metodo para obtener datos basicos del usuario
    public function get_usr_data($username) {
        $this->load->view('base/login_view');
    }

    //Metodo que carga la pagina de inicio de sesión
    public function login() {
        $this->load->view('base/login_view');
    }

    //Metodo para crear una nueva cuenta
    public function registro(){
        if ($this->session->userdata('logged_in')) {
            redirect(base_url(), 'refresh');//Definir que pasa si ya esta loggeado
        } else {
            $content = array(
                "preferencias" => $this->usuario_model->get_preferencias(), 
                "main_view" => "base/registro_view"
            );
            $this->load->view('layouts/base_template', $content);
        }
    }

    //Metodo que muestra el perfil del usuario.
    public function perfil() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $rol = $this->usuario_model->get_rol ( $session_data ['username'] );
            if ($rol [0] ['use_rol_id'] == 1) {
                $content = array(
                    "user" => $session_data['username'],
                    "usr_data" => $this->usuario_model->get_usr_data($session_data['username']),
                    "usr_all_data" => $this->usuario_model->get_all_usr_data($session_data['username']),
                    "main_view" => "admin/perfil_view"
                );
                $this->load->view('layouts/admin_template', $content);
            } else {
                $content = array(
                    "user" => $session_data['username'],
                    "usr_data" => $this->usuario_model->get_usr_data($session_data['username']),
                    "usr_all_data" => $this->usuario_model->get_all_usr_data($session_data['username']),
                    "main_view" => "usr/perfil_view"
                );
                $this->load->view('layouts/est_template', $content);
            }

        } else {
            redirect(base_url(), 'refresh');
        }
    }

    //Metodo que establece la calificación de los usuarios para cada 
    //OA parametros cadena = "lo_id, rep_id, lo_score, username"
    function set_score(){

        $this->usuario_model->save_score();

    }

    function get_score(){
        $score = $this->usuario_model->get_score();
        echo $score[0]["use_sco_score"];
    }


    public function verify_username(){

        $username = $_POST["username"];
        $username = strtolower($username);
        $result = $this->usuario_model->verify_username($username);
        print_r($result);
    }

    public function save_user(){

        $this->usuario_model->guardar_usuario();
        $this->login();

    }

    public function editar_usr(){
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $rol = $this->usuario_model->get_rol ( $session_data ['username'] );
            if ($rol [0] ['use_rol_id'] == 1) {
                $content = array(
                    "user" => $session_data['username'],
                    "usr_data" => $this->usuario_model->get_usr_data($session_data['username']),
                    "usr_all_data" => $this->usuario_model->get_all_usr_data($session_data['username']),
                    "main_view" => "admin/perfil_view"
                );
                $this->load->view('layouts/admin_template', $content);
            } else {
                $content = array(
                    "user" => $session_data['username'],
                    "usr_data" => $this->usuario_model->get_usr_data($session_data['username']),
                    "usr_all_data" => $this->usuario_model->get_all_usr_data($session_data['username']),
                    "main_view" => "usr/editar_view"
                );
                $this->load->view('layouts/est_template', $content);
            }

        } else {
            redirect(base_url(), 'refresh');
        }
    }

    function update_user(){
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');

            $this->usuario_model->update_user($session_data["username"]);
            $this->perfil();
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function chpasswd(){
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $this->load->view("usr/chpasswd_view");

        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function verificar_passwd() {
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $res = $this->usuario_model->verificar_passwd(md5($_POST["passwd"]),$session_data["username"]);
            if ($res == 1) {
                echo 1;
            }elseif ($res == 0) {
                echo 0;
            }
        } else {
            redirect(base_url(), 'refresh');
        }


    }

    function upd_passwd(){
        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $this->usuario_model->actualizar_passwd(md5($_POST["passwd_new"]),$session_data["username"]);
            $this->session->unset_userdata('logged_in');
            redirect(base_url(), 'refresh');

        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function mis_objetos(){

        if ($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');

                $content = array(
                    "user" => $session_data['username'],
                    "usr_data" => $this->usuario_model->get_usr_data($session_data['username']),
                    "usr_all_data" => $this->usuario_model->get_all_usr_data($session_data['username']),
                    "main_view" => "base/result_view_st",
                    "encabezado" => "Objetos calificados",
                    "url" => "usuario/perfil/",
                    "result" => $this->lo_model->get_lo_usr($session_data['username']),
                    "sess" => 1
                );
                $this->load->view('layouts/est_template', $content);


        } else {
            redirect(base_url(), 'refresh');
        }

    }

    public function mail(){

        // El mensaje
        $mensaje = "Línea 1\r\nLínea 2\r\nLínea 3";

        // Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
        $mensaje = wordwrap($mensaje, 70, "\r\n");

        // Enviarlo
        mail('leegixus@gmail.com', 'Mi título', $mensaje);

    }


}

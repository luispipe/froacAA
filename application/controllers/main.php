<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );


class Main extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( "usuario_model" );
        $this->load->model ( "admin_model" );
	}
	/**
	 * Controlador inicial, configurado en routes.php
	 */

    function verify_usr($username){
        $rol = $this->usuario_model->get_rol ($username);
        if ($rol [0] ['use_rol_id'] == 1) {
            $route = "admin";
        }elseif ($rol [0] ['use_rol_id'] == 2){
            $route = "est";
        }elseif ($rol [0] ['use_rol_id'] == 3){
            $route = "prof";
        }elseif ($rol [0] ['use_rol_id'] == 4){
            $route = "exp";
        }elseif ($rol [0] ['use_rol_id'] == 5){
            $route = "rep";
        }else {
            $route = "base";
        }

        return $route;
    }


	public function index() {
		if ($this->session->userdata ( 'logged_in' )) {
			$session_data = $this->session->userdata ( 'logged_in' );
            $route = $this->verify_usr( $session_data ['username']);
			$content = array (
					"user" => $session_data ['username'],
					"usr_data" => $this->usuario_model->get_usr_data ( $session_data ['username'] ),
					"main_view" => "shared_views/init_view",
                    "total_user" => $this->admin_model->get_total_user(),
                    "total_rep" => $this->admin_model->get_total_rep(),
                    "total_lo" => $this->admin_model->get_total_lo(),
                    "total_lo_score" => $this->admin_model->get_total_lo_score(),
			)
			;
			$this->load->view ( 'base/'.$route.'_template', $content );
		}else{

            $content = array (
                "main_view" => "shared_views/init_view",
                "total_user" => $this->admin_model->get_total_user(),
                "total_rep" => $this->admin_model->get_total_rep(),
                "total_lo" => $this->admin_model->get_total_lo(),
                "total_lo_score" => $this->admin_model->get_total_lo_score(),
            )
            ;
            $this->load->view ( 'base/base_template', $content );

        }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
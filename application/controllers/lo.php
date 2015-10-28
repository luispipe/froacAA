<?php

Class Lo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("lo_model");
        $this->load->model("usuario_model");

    }

    public function index() {
        echo 'algo';
    }

    public function buscar_lo($params, $sess, $user) {
        $params = urldecode($params);
        $params = preg_replace('/_+/', '_', $params);
        if (substr($params, -1) == "_") {
            $params = substr($params, 0, -1);
        }


        //$params = $this->limpiar($params);
        $arrayParams = explode("_", $params);

        foreach ($arrayParams as $key => $value){

            if (substr($value, -3) == "ion" ){
                $arrayParams[$key] = substr($value,0, -3)."ión";
            }
        }

        $stopwordsConTildes = array("a", "acá", "ahí", "ajena", "ajenas", "ajeno", "ajenos", "al", "algo", "algún", "alguna", "algunas", "alguno", "algunos", "allá", "alli", "allí", "ambos", "ampleamos", "ante", "antes", "aquel", "aquella", "aquellas", "aquello", "aquellos", "aqui", "aquí", "arriba", "asi", "atras", "aun", "aunque", "bajo", "bastante", "bien", "cabe", "cada", "casi", "cierta", "ciertas", "cierto", "ciertos", "como", "cómo", "con", "conmigo", "conseguimos", "conseguir", "consigo", "consigue", "consiguen", "consigues", "contigo", "contra", "cual", "cuales", "cualquier", "cualquiera", "cualquieras", "cuan", "cuán", "cuando", "cuanta", "cuánta", "cuantas", "cuántas", "cuanto", "cuánto", "cuantos", "cuántos", "de", "dejar", "del", "demás", "demas", "demasiada", "demasiadas", "demasiado", "demasiados", "dentro", "desde", "donde", "dos", "el", "él", "ella", "ellas", "ello", "ellos", "empleais", "emplean", "emplear", "empleas", "empleo", "en", "encima", "entonces", "entre", "era", "eramos", "eran", "eras", "eres", "es", "esa", "esas", "ese", "eso", "esos", "esta", "estaba", "estado", "estais", "estamos", "estan", "estar", "estas", "este", "esto", "estos", "estoy", "etc", "fin", "fue", "fueron", "fui", "fuimos", "gueno", "ha", "hace", "haceis", "hacemos", "hacen", "hacer", "haces", "hacia", "hago", "hasta", "incluso", "intenta", "intentais", "intentamos", "intentan", "intentar", "intentas", "intento", "ir", "jamás", "junto", "juntos", "la", "largo", "las", "lo", "los", "mas", "más", "me", "menos", "mi", "mía", "mia", "mias", "mientras", "mio", "mío", "mios", "mis", "misma", "mismas", "mismo", "mismos", "modo", "mucha", "muchas", "muchísima", "muchísimas", "muchísimo", "muchísimos", "mucho", "muchos", "muy", "nada", "ni", "ningun", "ninguna", "ningunas", "ninguno", "ningunos", "no", "nos", "nosotras", "nosotros", "nuestra", "nuestras", "nuestro", "nuestros", "nunca", "os", "otra", "otras", "otro", "otros", "para", "parecer", "pero", "poca", "pocas", "poco", "pocos", "podeis", "podemos", "poder", "podria", "podriais", "podriamos", "podrian", "podrias", "por", "por qué", "porque", "primero", "primero desde", "puede", "pueden", "puedo", "pues", "que", "qué", "querer", "quien", "quién", "quienes", "quienesquiera", "quienquiera", "quiza", "quizas", "sabe", "sabeis", "sabemos", "saben", "saber", "sabes", "se", "segun", "ser", "si", "sí", "siempre", "siendo", "sin", "sín", "sino", "so", "sobre", "sois", "solamente", "solo", "somos", "soy", "sr", "sra", "sres", "sta", "su", "sus", "suya", "suyas", "suyo", "suyos", "tal", "tales", "también", "tambien", "tampoco", "tan", "tanta", "tantas", "tanto", "tantos", "te", "teneis", "tenemos", "tener", "tengo", "ti", "tiempo", "tiene", "tienen", "toda", "todas", "todo", "todos", "tomar", "trabaja", "trabajais", "trabajamos", "trabajan", "trabajar", "trabajas", "trabajo", "tras", "tú", "tu", "tus", "tuya", "tuyo", "tuyos", "ultimo", "un", "una", "unas", "uno", "unos", "usa", "usais", "usamos", "usan", "usar", "usas", "uso", "usted", "ustedes", "va", "vais", "valor", "vamos", "van", "varias", "varios", "vaya", "verdad", "verdadera", "vosotras", "vosotros", "voy", "vuestra", "vuestras", "vuestro", "vuestros", "y", "ya", "yo");
        $stopwordsSinTildes = array("a", "aca", "ahi", "ajena", "ajenas", "ajeno", "ajenos", "al", "algo", "algun", "alguna", "algunas", "alguno", "algunos", "alla", "alli", "alli", "ambos", "ampleamos", "ante", "antes", "aquel", "aquella", "aquellas", "aquello", "aquellos", "aqui", "aqui", "arriba", "asi", "atras", "aun", "aunque", "bajo", "bastante", "bien", "cabe", "cada", "casi", "cierta", "ciertas", "cierto", "ciertos", "como", "como", "con", "conmigo", "conseguimos", "conseguir", "consigo", "consigue", "consiguen", "consigues", "contigo", "contra", "cual", "cuales", "cualquier", "cualquiera", "cualquieras", "cuan", "cuan", "cuando", "cuanta", "cuanta", "cuantas", "cuantas", "cuanto", "cuanto", "cuantos", "cuantos", "de", "dejar", "del", "demas", "demas", "demasiada", "demasiadas", "demasiado", "demasiados", "dentro", "desde", "donde", "dos", "el", "el", "ella", "ellas", "ello", "ellos", "empleais", "emplean", "emplear", "empleas", "empleo", "en", "encima", "entonces", "entre", "era", "eramos", "eran", "eras", "eres", "es", "esa", "esas", "ese", "eso", "esos", "esta", "estaba", "estado", "estais", "estamos", "estan", "estar", "estas", "este", "esto", "estos", "estoy", "etc", "fin", "fue", "fueron", "fui", "fuimos", "gueno", "ha", "hace", "haceis", "hacemos", "hacen", "hacer", "haces", "hacia", "hago", "hasta", "incluso", "intenta", "intentais", "intentamos", "intentan", "intentar", "intentas", "intento", "ir", "jamas", "junto", "juntos", "la", "largo", "las", "lo", "los", "mas", "mas", "me", "menos", "mi", "mia", "mia", "mias", "mientras", "mio", "mio", "mios", "mis", "misma", "mismas", "mismo", "mismos", "modo", "mucha", "muchas", "muchisima", "muchisimas", "muchisimo", "muchisimos", "mucho", "muchos", "muy", "nada", "ni", "ningun", "ninguna", "ningunas", "ninguno", "ningunos", "no", "nos", "nosotras", "nosotros", "nuestra", "nuestras", "nuestro", "nuestros", "nunca", "os", "otra", "otras", "otro", "otros", "para", "parecer", "pero", "poca", "pocas", "poco", "pocos", "podeis", "podemos", "poder", "podria", "podriais", "podriamos", "podrian", "podrias", "por", "por que", "porque", "primero", "primero desde", "puede", "pueden", "puedo", "pues", "que", "que", "querer", "quien", "quien", "quienes", "quienesquiera", "quienquiera", "quiza", "quizas", "sabe", "sabeis", "sabemos", "saben", "saber", "sabes", "se", "segun", "ser", "si", "si", "siempre", "siendo", "sin", "sin", "sino", "so", "sobre", "sois", "solamente", "solo", "somos", "soy", "sr", "sra", "sres", "sta", "su", "sus", "suya", "suyas", "suyo", "suyos", "tal", "tales", "tambien", "tambien", "tampoco", "tan", "tanta", "tantas", "tanto", "tantos", "te", "teneis", "tenemos", "tener", "tengo", "ti", "tiempo", "tiene", "tienen", "toda", "todas", "todo", "todos", "tomar", "trabaja", "trabajais", "trabajamos", "trabajan", "trabajar", "trabajas", "trabajo", "tras", "tu", "tu", "tus", "tuya", "tuyo", "tuyos", "ultimo", "un", "una", "unas", "uno", "unos", "usa", "usais", "usamos", "usan", "usar", "usas", "uso", "usted", "ustedes", "va", "vais", "valor", "vamos", "van", "varias", "varios", "vaya", "verdad", "verdadera", "vosotras", "vosotros", "voy", "vuestra", "vuestras", "vuestro", "vuestros", "y", "ya", "yoz");
        foreach ($arrayParams as $key_p => $word) {
            foreach ($stopwordsSinTildes as $key_s => $stop) {
                if ($word == $stop) {
                    unset($arrayParams[$key_p]);
                }
            }
        }

        $palabras = implode(", ", $arrayParams);
        $params = implode("_", $arrayParams);
        $andParams = "('" . preg_replace('/_/', ' & ', $params) . "')";
        $orParams = "('" . preg_replace('/_/', ' | ', $params) . "')";
       // print_r($andParams);
       // print_r($orParams);
        $oasencontrados = $this->lo_model->get_oas_b($orParams,$andParams);


        if ($this->session->userdata ( 'logged_in' )) {
            $d = 0;
            //print_r($oasencontrados);
            //echo ($oasencontrados[0][0]);
            foreach($oasencontrados[0] as $key){
                $x[$d]['idOA'] = $key["lo_id"];
                $x[$d]['idRepository'] = $key["rep_id"];
                $d++;
            }
            $session_data = $this->session->userdata('logged_in');
            $user = $session_data["username"];
            //print_r($session_data);
            //print_r($x);
            $content = array(
                "result" => $oasencontrados,
                "palabras" => $palabras,
                "sess" => $sess,
                "user" => $user,
                "oasadaptados" => $this->recomendacion($x, $user)
            );
        }else{

            $content = array(
                "result" => $oasencontrados,
                "palabras" => $palabras,
                "sess" => $sess,
                "user" => $user
            );
        }
        //print_r($oasencontrados);

        $this->load->view("base/result_view",$content);
    }


    public function limpiar($cadena) {
        $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
        $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }


    public function load_metadata($id_lo, $id_rep){
        $cosa = $this->lo_model->get_metadata($id_lo, $id_rep);

        $content = array(
            "xml" => $cosa
        );

        $this->load->view("base/metadata_view",$content);

    }

    //Recomendación Paula
    protected function recomendacion($oas, $user){
        $parametros = array(
            'idUsuarioActivo' => $user,
            'OAs' => $oas
        );

        $wsdl_url = 'http://localhost:6020/ServicioWeb?wsdl';
        //$wsdl_url = 'http://froac.manizales.unal.edu.co:6020/ServicioWeb';
        $client = new SOAPClient($wsdl_url);
        $result = $client->adaptarOAs($parametros);
        $cadena = "";
        $otro = "";

        foreach ($result as $paulis) {
            foreach ($paulis as $no) {
                //echo $no->idOA . "-" . $no->idRepository . "$";

                $cadena = $cadena . $no->idOA . "-" . $no->idRepository . "$";
            }
        }
        //$this->llenar_recomendacion($p,$supone);
//        $this->llenar_recomendacion($result);
        return $cadena;
    }

    public function llenar_recomendacion($return1) {

        $return = urldecode($return1);

        $ob = explode("$", $return);
        $ob1 = array_pop($ob);
        $todos = array();
        foreach ($ob as $key) {
            $temp = explode("-", $key);
            $comp = array(
                'idOA' => $temp[0],
                'idRepository' => $temp[1]
            );
            array_push($todos, $comp);
        }
        //print_r($todos);


        //Con los id de los OAs recomendados, busco el titulo y la localización
        for ($i = 0; $i < count($todos); $i++) {
            $rec[$i] = $this->lo_model->titulos_recomendacion($todos[$i]['idOA'],$todos[$i]['idRepository']);
        }

        $data = array(
            "rec" => $rec
        );


        $this->load->view('base/llenar_recomendacion_view', $data);
    }



public function load_indicadores($id_lo, $id_rep, $username){

    echo $id_lo, $id_rep, $username;

}


public function set_visita(){
    $this->lo_model->set_visita_lo();
}


//Hacer que el usuario admin pueda ver los objetos
public function load_lo($url, $lo_name){
    if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');

        $content = [
            "user" => $session_data['username'],
            "usr_data" => $this->usuario_model->get_usr_data($session_data['username']),
            "usr_all_data" => $this->usuario_model->get_all_usr_data($session_data['username']),
            "main_view" => "base/lo_view",
            "sess" => 1,
            "url" => $url,
            "lo_name" => $lo_name
        ];

        if ($session_data ['username'] == "admin"){
            $this->load->view('layouts/admin_template', $content);
        }else{
            $this->load->view('layouts/est_template', $content);
        }


    } else {
        $content = array(
            "main_view" => "base/lo_view",
            "sess" => 0,
            "url" => $url,
            "lo_name" => $lo_name
        );
        $this->load->view('layouts/base_template', $content);
    }
}

public function get_score_avg(){
    $result = $this->lo_model->get_avg_score();
    $avg = round($result[0]['avg']);
    echo $avg;
}


}
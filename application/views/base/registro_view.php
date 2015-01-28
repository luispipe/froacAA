    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepicker/css/datepicker.css">
    <section id="main-content">
      <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">          

          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Crear cuenta en FROAC
              </header>
              <div class="panel-body">
               <div class="row">
                <form method="POST" role="form" action="<?php echo base_url();?>index.php/usuario/save_user" enctype='multipart/form-data'>
                  <div class="col-lg-12">
                    <section class="panel">
                      <header class="panel-heading">
                        Información personal
                      </header>
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Usted es:</label>
                          <select class="form-control input-sm m-bot15" name="tipoU" required>
                            <option value="2">Estudiante</option>
                            <option value="3">Profesor</option>
                          </select> 
                        </div>
                        <div class="form-group">
                          <label for="nombre">Nombre:</label>
                          <input  type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombres" required>
                        </div>
                        <div class="form-group">
                          <label for="apellido">Apellido:</label>
                          <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellidos" required>
                        </div>                        
                        <div class="form-group">
                          <label for="fecha_nac">Fecha de nacimiento:</label>
                          <input data-date-viewmode="years" data-date-format="dd-mm-yyyy" type="text" class="form-control" id="fecha_nac" name="fecha_nac" placeholder="Selecciona año, mes y día">
                        </div>
                        <div class="form-group">
                          <label for="mail">E-mail:</label>
                          <input type="text" class="form-control" id="mail" name="mail" placeholder="Correo electronico" required>
                        </div>
                        <div class="form-group">
                          <label for="username">Nombre de usuario:</label>
                          <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario unico en FROAC" required>
                        </div> 
                        <div id="in_use" class="alert alert-block alert-danger fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="icon-remove"></i>
                          </button>
                          <strong>Lo sentimos!</strong> el nombre de usuario <strong id="in_name"></strong> no esta disponible.
                        </div>
                        <div id="no_use" class="alert alert-success fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="icon-remove"></i>
                          </button>
                          <strong>Éxito!</strong> este nombre de usuario esta disponible.
                        </div>
                        <div class="form-group">
                          <label for="passwd">Password:</label>
                          <input type="password" class="form-control" id="passwd" name="" placeholder="Contraseña" required><br>
                          <input type="password" class="form-control" id="passwd2" name="passwd2" placeholder="Reescribe la contraseña" required>
                        </div>  
                        <div id="no_match" class="alert alert-block alert-danger fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="icon-remove"></i>
                          </button>
                          <strong>Las contraseñas no concuerdan.</strong>
                        </div>                        
                        <div class="form-group">
                          <label for="fecha_nac">Nivel de educación:</label>
                          <select class="form-control input-sm m-bot15" name="nevel_ed" required>
                            <option value="0">Seleccione una opción</option>
                            <option value="1">Básica Primaria</option>
                            <option value="1">Básica Primaria</option>
                            <option value="2">Básica Secundaria</option>
                            <option value="3">Educación Media</option>
                            <option value="4">Educación Superior</option>
                            <option value="5">Carrera Técnica/Tecnológica</option>
                            <option value="6">Pregrado</option>
                            <option value="7">Especialización</option>
                            <option value="8">Maestría</option>
                            <option value="9">Doctorado</option>
                            <option value="10">Posdoctorado</option>
                          </select>
                        </div>
                        <button id="sub" type="submit" class="btn btn-info">Siguiente paso</button>
                      </div>
                    </section>
                  </div>
                </form>
              </div>
            </div>
          </section>
        </div>
        
      </div>
      <!-- page end-->
    </section>
  </section>
  <!--main content end-->

  <!--script for this page-->
  <script type="text/javascript" src="<?php echo base_url();?>asset/datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript">
  $("#in_use, #no_use, #no_match").hide();

  $('#fecha_nac').datepicker();
  $("#username").change(function(){
   $.ajax({
    type: "POST",
    url: "<?php echo base_url()?>index.php/usuario/verify_username",
    data: { username: $("#username").val()}
  })
   .done(function( msg ) {
     if(msg >= 1 ){

      $("#in_name").text($("#username").val());
      $("#in_use").show();
      $("#no_use").hide();
      $("#sub").hide();
      $("#username").val("");
    }else{
      $("#no_use").show();
      $("#in_use").hide();
      $("#sub").show();
    }
  });
 });

  $("#passwd").change(function(){
    if ($("#passwd").val().length < 6){
      alert("Su contraseña debe ser de minimo 6 caracteres!")
      $("#passwd").val("");
    }
  });
  $("#passwd2").change(function(){
    if($("#passwd").val() != $("#passwd2").val()){
      $("#no_match").show();
      $("#passwd2").val("")
    } 
  });




  </script>

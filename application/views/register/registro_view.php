hidden<script type="text/javascript">

    $(document).ready(function() {
        estiloAprendizaje= 'Para conocer su estilo de aprendizaje puede realizar el test ahora mismo o en el momento que usted lo requiera';
        $('#estiloaprendizaje').text(estiloAprendizaje);

        $("#img_ok").hide();
        $("#img_not").hide();
        $("#submitg, #boton, #cancelar, #proc").button();

        $("#fecha_nac").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            changeDay: true,
            yearRange: "1945:2035"

        });
         //Cerrar el calendario (datapicker) al seleccionar el dia
        $('#fecha_nac').on('changeDate', function (cer) {
            if(cer.viewMode === 'days'){
                $('fecha_nac').datepicker('hide');
            }
        });

        $(".submitg").click(function() {
            $("#form").validate({
                rules: {
                    nombre: {
                        required: true,
                        minlength: 3
                    },
                    apellido: {
                        required: true,
                        minlength: 3
                    },
                    fecha_nac: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    sexo: {
                        required: true
                    },
                    lang: {
                        required: true
                    },
                    username: {
                        required: true,
                        minlength: 4
                    },
                    passwd: {
                        required: true,
                        minlength: 6
                    },
                    passwd1: {
                        equalTo: "#passwd"
                    }
                },
                messages: {
                    nombre: {
                        required: "<span style=color:red;>Escribe tu Nombre </span>",
                        minlength: "Tu Nombre con minimo 3 letras."
                    },
                    apellido: {
                        required: "<span style=color:red;>Escribe tu Apellido</span>",
                        minlength: "Tu Nombre con minimo 3 letras"
                    },
                    fecha_nac: {
                        required: "<span style=color:red;>Escribe tu Fecha de Nacimiento </span>"
                    },
                    sexo: {
                        required: "<span style=color:red;>Elige tu Sexo </span>"
                    },
                    lang: {
                        required: "<span style=color:red;>Escribe tu Idioma</span>",
                        minlength: "Mail erróneo",
                        error: "Mail erróneo",
                    },
                    username: {
                        required: "<span style=color:red;>Escribe tu Nombre de usuario</span>",
                        minlength: "Tu nombre de ususario con minimo 4 letras"
                    },
                    passwd: {
                        required: "<span style=color:red;>Escribe tu password</span>",
                        minlength: "Tu password con minimo 6 caracteres "
                    },
                    passwd1: {
                        equalTo: "<span style=color:red;>Las contraseñas no coinciden</span>"
                    }
                }
            });


        });

        $('#proc').click(function() {
          
            var form_data = $('#form_usr').serializeArray();
            $.post("<?php echo base_url() ?>index.php/usuario/test_result", form_data, function(respuesta) {
                // $("#result").text(respuesta);
                //alert("Resultado"+respuesta);
                var cantidades =  JSON.parse(respuesta);
                //$('#verResult').val(','+cantidades[0]+',');
                var larespuesta, cantidad1, cantidad2, cantidad3, cantidad4, cantidad5, cantidad6;
                var i=0;
                for (var x in cantidades) {
                    if (i==0) {
                        larespuesta= cantidades[x];
                    }else if (i==1) {
                        cantidad1= cantidades[x];
                    }else if (i==2){
                        cantidad2= cantidades[x];
                    }else if (i==3){
                        cantidad3= cantidades[x];
                    }else if (i==4){
                        cantidad4= cantidades[x];
                    }else if (i==5){
                        cantidad5= cantidades[x];
                    }else if (i==6){
                        cantidad6= cantidades[x];
                    }
                    i++;
                }
                $('#result_test').val(larespuesta);
                $('#form').show();
                $('#test').hide();
                $('#submitg').show();

                var estiloAprendizaje;
                switch ($('#result_test').val()) {
                    case '1':
                        estiloAprendizaje= 'Su estilo de aprendizaje es: Auditivo-Global (La instrucción que se habla o se escucha facilita el aprendizaje de este tipo de aprendizaje. Las conferencias, las grabaciones, los debates son todos mecanismos que permiten que las personas de este estilo exploren conceptos) ';
                        break;
                    case '2':
                        estiloAprendizaje= 'Su estilo de aprendizaje es: Auditivo-Secuencial (Las personas Auditivas secuenciales tienden a deletrear fonéticamente (sonidos.) Estos estudiantes aprenden escuchando y recuerdan los hechos cuando éstos son presentados en forma de poemas, cantos o melodías) ';
                        break;
                    case '3':
                        estiloAprendizaje= 'Su estilo de aprendizaje es: Kinestesico-Global (Estas personas aprender mejor haciendo actividades que les permiten experimentar o practicar el concepto que están intentando aprender. La clave para el aprendizaje efectivo es que la instrucción les ofrece oportunidades concretas para aplicar la información.)';
                        break;
                    case '4':
                        estiloAprendizaje= 'Su estilo de aprendizaje es: Kinestesico-Secuencial (Estas personas aprenden mejor moviendo, experimentando  y manipulando. Les gusta descubrir como funcionan las cosas y muchas veces son exitosos en artes prácticas como carpintería o diseño)';
                        break;
                    case '5':
                        estiloAprendizaje= 'Su estilo de aprendizaje es: Lector-Global (Las personas con una preferencia a la modalidad leer/escribir aprenden mejor cuando reciben y devuelven la información en palabras)';
                        break;
                    case '6':
                        estiloAprendizaje= 'Su estilo de aprendizaje es: Lector-Secuencial (Las personas con estilo de aprendizaje Lector Secuencial tienen preferencia por información impresa en forma de palabras)';
                        break;
                    case '7':
                        estiloAprendizaje= 'Su estilo de aprendizaje es: Visual-Global (Las personas Visuales Globales aprenden  mirando. Ellos van a imágenes del pasado cuando tratan de recordar. Ellos dibujan la forma de las cosas en su mente)';
                        break;
                    case '8':
                        estiloAprendizaje= 'Su estilo de aprendizaje es: Visual-Secuencial (Las personas visuales secuenciales gustan de reunir y procesar información usando tablas, diagramas, gráficas, mapas y otras imágenes o formas basadas en gráfico para aprender)';
                        break;
                    default:
                        estiloAprendizaje= 'Para conocer su estilo de aprendizaje puede realizar el test ahora mismo o en el momento que usted lo requiera';
                        break;
                }


                $('#estiloaprendizaje').text(estiloAprendizaje);
                $('#result_test').val(larespuesta);
                $('#cantidad1').val(cantidad1);
                $('#cantidad2').val(cantidad2);
                $('#cantidad3').val(cantidad3);
                $('#cantidad4').val(cantidad4);
                $('#cantidad5').val(cantidad5);
                $('#cantidad6').val(cantidad6);




            });
        });



        $('#boton').click(function() {
            $('#test').show();
            $('#form').hide();
            $('#submitg').hide();
            window.location.href = "#main-content";
        });
        $('#cancelar').click(function() {
            $('#test_need').hide();
            $('#form').show();
            $('#submitg').show();
        });
        $('#cancelar1').click(function() {
            $('#test').hide();
            $('#form').show();
            $('#submitg').show();
        });
        $('#username').blur(function() {
             $.get("<?php echo base_url() ?>index.php/usuario/checkusr/"+$("#username").val(), function(respuesta) {
                  $('#rta').val(respuesta);
            if (respuesta == 1){
                $('#img_not').show();
                $('#img_ok').hide();
            } else {
                $('#img_ok').show();
                $('#img_not').hide();
            }
            });
        });
    });

</script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepicker/css/datepicker.css">
    <section id="main-content">
        <section class="wrapper site-min-height">
        <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header   class="panel-heading">
                            Crear cuenta en FROAC
                        </header>

                        <!--FORMULARIO DE REGISTRO DE USUARIO-->

                        <div class="panel-body">
                            <div class="row">
                                <form method="POST" role="form" action="<?php echo base_url();?>index.php/usuario/guardar" enctype='multipart/form-data' id="form">
                                    <div class="col-lg-12">
                                        <!--label>hola:</label><input type="text" id="verResult"/-->
                                        <section class="panel">
                                            <header class="panel-heading">
                                                Información personal
                                            </header>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <input type="hidden" value="2" name="tipoU">
                                                    <!--<label for="exampleInputEmail1">Usted es:</label>
                                                    <select class="form-control input-sm m-bot15" name="tipoU" required>
                                                    <option value="2">Estudiante</option>-->
                                                    <!-- Se elimina la opción de registrarse con el rol de "profesor" ya que
                                                    para este no se deben tener en cuenta las preferencias. A este lo agrega el admin-->
                                                    <!--<option value="3">Profesor</option>
                                                    </select>-->
                                                </div>
                                                <div class="form-group">
                                                <label for="nombre">Nombres:</label>
                                                    <input  type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombres" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="apellido">Apellido:</label>
                                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellidos" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="gender">Genero:</label>
                                                    <select class="form-control input-sm m-bot15" name="gender" id="gender" required>
                                                        <option value="female">Femenino</option>
                                                        <option value="male">Masculino</option>

                                                    </select> </div>

                                                <div class="form-group">
                                                    <label for="fecha_nac">Fecha de nacimiento:</label>
                                                    <!--<input data-date-viewmode="years" data-date-format="dd-mm-yyyy" type="text" class="form-control" id="fecha_nac" name="fecha_nac" placeholder="Selecciona año, mes y día" required>-->
                                                    <input  type="text" class="form-control" id="fecha_nac" name="fecha_nac" placeholder="Selecciona año, mes y día" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mail">E-mail:</label>
                                                    <!-- Se valida la existencia de @ y . en el correo ingresado por medio del atributo pattern -->
                                                    <input type="text" class="form-control" id="mail" name="mail" placeholder="Correo electrónico" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required>
                                                </div>
                                                <div id="in_use1" class="alert alert-block alert-danger fade in">
                                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                                        <i class="icon-remove"></i>
                                                    </button>
                                                    <strong>Lo sentimos!</strong> El correo electrónico ingresado, ya está registrado.
                                                </div>
                                                <div id="no_use1" class="alert alert-success fade in">
                                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                                        <i class="icon-remove"></i>
                                                    </button>
                                                    <strong>Éxito!</strong> este correo electronico esta disponible.
                                                </div>
                                                <div class="form-group">
                                                    <label for="username">Nombre de usuario:</label>
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario único en FROAC" required>
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
                                                    <label for="passwd">Contraseña:</label>
                                                    <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Contraseña" required><br>
                                                    <input type="password" class="form-control" id="passwd2" name="passwd2" placeholder="Reescribe la contraseña" required>
                                                </div>
                                                <div id="no_match" class="alert alert-block alert-danger fade in">
                                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                                        <i class="icon-remove"></i>
                                                    </button>
                                                    <strong>Las contraseñas no concuerdan.</strong>
                                                </div>

                                                  <div class="form-group">
                                                    <label for="etnica">Pertenece a una comunidad indigena:</label>
                                                    <select class="form-control input-sm m-bot15" name="etnica" id="etnica">
                                                        <option value="ninguna">Ninguna</option>
                                                        <option value="embera">Embera Chamí</option>
                                                        <option value="otra">Otra comunidad</option>

                                                </select> </div>

                                                    <div class="form-group">
                                                    <label for="dissabilities">Presenta alguna de las siguientes discapacidades:</label>
                                                    <br>
                                                        <?php
                                                        foreach ($dissabilities as $key) { ?>
                                                            <input type="checkbox" name="dissabilities[]" value= " <?php echo $key->use_dissability_id ?> "/><?php echo $key->use_dissability ?><br />
                                                        <?php } ?>
                                                </div>      


                                                <div class="form-group">
                                                    <label for="level">Nivel Educativo:</label>
                                                    <select class="form-control input-sm m-bot15" name="nevel_ed" required>
                                                        <?php
                                                        foreach ($nivel_educativo as $key) { ?>
                                                            <option name="level[]" value= "<?php echo $key->use_id_level ?>"><?php echo $key->use_level ?></option>
                                                        <?php } ?></select>
                                                </div> 

                                                <div class="form-group">
                                                    <label for="institution_username">Institución a la que pertenece:</label>
                                                    <input type="text" class="form-control" id="institution_username" name="institution_username" placeholder="Nombre de la institución a la que pertenece" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="pref">Preferencias/Necesidades de la Presentación:</label>
                                                    <br>
                                                        <?php
                                                        foreach ($preferencias as $key) { ?>
                                                            <input type="checkbox" name="pref[]" value= " <?php echo $key->use_pre_id ?> "/><?php echo $key->use_pre_preferencia ?><br />
                                                        <?php } ?>
                                                </div>

                                                
                                            </div>
                                           

                                    </div>
                                    <!--FIN FORMULARIO DE REGISTRO DE USUARIO-->

                                    <input id="submitg" type="submit" class="btn btn-info" value="Guardar Información">
                                </form>
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


  $("#in_use1, #no_use1").hide();

  $("#mail").change(function(){
      $.ajax({
          type: "POST",
          url: "<?php echo base_url()?>index.php/usuario/verify_email",
          data: { mail: $("#mail").val()}
      })
          .done(function( msg ) {
              if(msg >= 1 ){

                  $("#in_name").text($("#mail").val());
                  $("#in_use1").show();
                  $("#no_use1").hide();
                  $("#sub").hide();
                  $("#mail").val("");
              }else{
                  $("#no_use1").show();
                  $("#in_use1").hide();
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
    if($("#passwd").val() == $("#passwd2").val()){
        $("#no_match").hide();
    }
    if($("#passwd").val() != $("#passwd2").val()){
      $("#no_match").show();
      $("#passwd2").val("")
    } 
  });

//######################################################################################################################

  //En caso de tener discapacidad se debe mostar un botón que lo lleve al formulario Test para personas con necesidades
  // especiales

  $("#discapasi").click(function () {
          $("#need").show();
      });

  //En caso de dar click en la opción "SI" por equivocación, al dar click en la opción "No", el botón se ocultará.

  $("#discapano").click(function () {
      $("#need").hide();
  })
//######################################################################################################################

//####################################################################################################################

  //Cuando se tiene una discapacidad y se da click en el botón realizar test, este muestra el formulario para
  // realizar el test para personas con necesidades especiales

  $('#need').click(function() {
      $('#test_need').show();
      $('#form').hide();
      $('#submitg').hide();
      window.location.href = "#main-content";
  });

//#####################################################################################################################

//#####################################################################################################################

  //Cuando se tiene una discapacidad, se muestran las preguntas correspondientes al tipo de discapacidad seleccionada.

  $("#1").click(function () {
      if($("#1").attr("estado")==0){
          $("#limitacionV").show();
          $("#1").attr("estado", 1);

      }else{
          $("#1").prop("checked", false);
          $("#limitacionV").hide();
          $("#1").attr("estado", 0);

      }

  });

  $("#6").click(function () {
      if($("#6").attr("estado")==0){
          $("#tamaño").show();
          $("#6").attr("estado", 1);

      }else{
          $("#6").prop("checked", false);
          $("#tamaño").hide();
          $("#6").attr("estado", 0);

      }

  });

  $("#5").click(function () {
      $("#tamaño").hide();
  });

  $("#2").click(function () {
          if($("#2").attr("estado")==0){
              $("#limitacionA").show();
              $("#2").attr("estado", 1);

          }else{
              $("#2").prop("checked", false);
              $("#limitacionA").hide();
              $("#2").attr("estado", 0);

          }
  });

  $("#8").click(function () {
        if($("#8").attr("estado")==0){
            $("#8").attr("estado", 1);
        }else{
            $("#8").prop("checked", false);
            $("#8").attr("estado", 0);
        }
  });


  $("#3").click(function () {
      if($("#3").attr("estado")==0){
          $("#limitacionM").show();
          $("#3").attr("estado", 1);

      }else{
          $("#3").prop("checked", false);
          $("#limitacionM").hide();
          $("#3").attr("estado", 0);

      }

  });

  $("#4").click(function () {
      if($("#4").attr("estado")==0){
          $("#limitacionC").show();
          $("#4").attr("estado", 1);

      }else{
          $("#4").prop("checked", false);
          $("#limitacionC").hide();
          $("#4").attr("estado", 0);

      }

  });


//#####################################################################################################################

//#####################################################################################################################


  $('#respuesta_need').click(function() {
      $("#necesidadespecial").val("");
      //Limitacion Visual ******************
      if($("#1").is(":checked")){
        if($("#5").is(":checked")){
            if($("#necesidadespecial").val()!=""){
                $("#necesidadespecial").val($("#necesidadespecial").val()+",Vision-Nula");
            }else{
                $("#necesidadespecial").val("Vision-Nula");
            }

            $("#necesidadespecial").show();
        }

          if($("#81").is(":checked")){

              if($("#necesidadespecial").val()!=""){
                  $("#necesidadespecial").val($("#necesidadespecial").val()+",Vision-Parcial"+$("#81").attr("value"));
              }else{
                  $("#necesidadespecial").val("Vision-Parcial"+$("#81").attr("value"));
              }
          }

          if($("#82").is(":checked")){

              if($("#necesidadespecial").val()!=""){
                  $("#necesidadespecial").val($("#necesidadespecial").val()+",Vision-Parcial"+$("#82").attr("value"));
              }else{
                  $("#necesidadespecial").val("Vision-Parcial"+$("#82").attr("value"));
              }
          }

          if($("#83").is(":checked")){

              if($("#necesidadespecial").val()!=""){
                  $("#necesidadespecial").val($("#necesidadespecial").val()+",Vision-Parcial"+$("#83").attr("value"));
              }else{
                  $("#necesidadespecial").val("Vision-Parcial"+$("#83").attr("value"));
              }
          }

          if($("#84").is(":checked")){

              if($("#necesidadespecial").val()!=""){
                  $("#necesidadespecial").val($("#necesidadespecial").val()+",Vision-Parcial"+$("#84").attr("value"));
              }else{
                  $("#necesidadespecial").val("Vision-Parcial"+$("#84").attr("value"));
              }
          }
          $("#necesidadespecial").show();
      }

      //Limitacion Visual ******************

      //Limitacion Auditiva *************************
      if($("#2").is(":checked")){
        if($("#91").is(":checked")){

            if($("#101").is(":checked")){

                if($("#111").is(":checked")){

                    if($("#necesidadespecial").val()!=""){
                        $("#necesidadespecial").val($("#necesidadespecial").val()+","+$("#91").attr("value")+"/Señas-Texto");
                    }else{
                        $("#necesidadespecial").val($("#91").attr("value")+"/Señas-Texto");
                    }
                }else {

                        if($("#necesidadespecial").val()!=""){
                            $("#necesidadespecial").val($("#necesidadespecial").val()+","+$("#91").attr("value")+"/Señas");
                        }else {
                            $("#necesidadespecial").val($("#91").attr("value") + "/Señas");
                        }
                    }
                }else{
                if($("#111").is(":checked")){

                    if($("#101").is(":checked")){
                        if($("#111").is(":checked")){
                            if($("#necesidadespecial").val()!=""){
                                $("#necesidadespecial").val($("#necesidadespecial").val()+","+$("#91").attr("value")+"/Señas-Texto");
                            }else{
                                $("#necesidadespecial").val($("#91").attr("value")+"/Señas-Texto");
                            }
                        }else {

                            if($("#necesidadespecial").val()!=""){
                                $("#necesidadespecial").val($("#necesidadespecial").val()+","+$("#91").attr("value")+"/Señas");
                            }else{
                                $("#necesidadespecial").val($("#91").attr("value")+"/Señas");
                            }

                        }

                    }else{
                        if($("#111").is(":checked")){
                            if($("#necesidadespecial").val()!=""){
                                $("#necesidadespecial").val($("#necesidadespecial").val()+","+$("#91").attr("value")+"/Texto");
                            }else{
                                $("#necesidadespecial").val($("#91").attr("value")+"/Texto");
                            }
                        }
                    }


                }
            }


        }

          if($("#92").is(":checked")){

              if($("#101").is(":checked")){

                  if($("#111").is(":checked")){

                      if($("#necesidadespecial").val()!=""){
                          $("#necesidadespecial").val($("#necesidadespecial").val()+","+$("#92").attr("value")+"/Señas-Texto");
                      }else{
                          $("#necesidadespecial").val($("#92").attr("value")+"/Señas-Texto");
                      }
                  }else {

                      if($("#necesidadespecial").val()!=""){
                          $("#necesidadespecial").val($("#necesidadespecial").val()+","+$("#92").attr("value")+"/Señas");
                      }else {
                          $("#necesidadespecial").val($("#92").attr("value") + "/Señas");
                      }
                  }
              }else{
                  if($("#111").is(":checked")){

                      if($("#101").is(":checked")){
                          if($("#111").is(":checked")){
                              if($("#necesidadespecial").val()!=""){
                                  $("#necesidadespecial").val($("#necesidadespecial").val()+","+$("#92").attr("value")+"/Señas-Texto");
                              }else{
                                  $("#necesidadespecial").val($("#92").attr("value")+"/Señas-Texto");
                              }
                          }else {

                              if($("#necesidadespecial").val()!=""){
                                  $("#necesidadespecial").val($("#necesidadespecial").val()+","+$("#92").attr("value")+"/Señas");
                              }else{
                                  $("#necesidadespecial").val($("#92").attr("value")+"/Señas");
                              }

                          }

                      }else{
                          if($("#111").is(":checked")){
                              if($("#necesidadespecial").val()!=""){
                                  $("#necesidadespecial").val($("#necesidadespecial").val()+","+$("#92").attr("value")+"/Texto");
                              }else{
                                  $("#necesidadespecial").val($("#92").attr("value")+"/Texto");
                              }
                          }
                      }


                  }
              }


          }


          $("#necesidadespecial").show();
      }

      if($("#3").is(":checked")){

          if($("#12").is(":checked")){
              if($("#13").is(":checked")){
                  if($("#necesidadespecial").val()!=""){
                      $("#necesidadespecial").val($("#necesidadespecial").val()+",Motriz"+"/Mouse-Teclado");
                  }else{
                      $("#necesidadespecial").val("Motriz"+"/Mouse-Teclado");
                  }
              }else{
                  if($("#necesidadespecial").val()!=""){
                      $("#necesidadespecial").val($("#necesidadespecial").val()+",Motriz"+"/Mouse");
                  }else{
                      $("#necesidadespecial").val("Motriz"+"/Mouse");
                  }
              }
          }else{
              if($("#13").is(":checked")){
                  if($("#necesidadespecial").val()!=""){
                      $("#necesidadespecial").val($("#necesidadespecial").val()+",Motriz"+"/Teclado");
                  }else{
                      $("#necesidadespecial").val("Motriz"+"/Teclado");
                  }
              }
          }
          $("#necesidadespecial").show();
      }
      if($("#4").is(":checked")){
          if($("#necesidadespecial").val()!=""){
              $("#necesidadespecial").val($("#necesidadespecial").val()+",Cognitivo/");
          }else{
              $("#necesidadespecial").val("Cognitivo/");
          }
          if($("#141").is(":checked")){
              $("#necesidadespecial").val($("#necesidadespecial").val()+"-ConcentraSi");
          }else{
              $("#necesidadespecial").val($("#necesidadespecial").val()+"-ConcentraNo");
          }
          if($("#151").is(":checked")){
              $("#necesidadespecial").val($("#necesidadespecial").val()+"-TextoSi");
          }else{
              $("#necesidadespecial").val($("#necesidadespecial").val()+"/TextoNo");
          }
          if($("#161").is(":checked")){
              $("#necesidadespecial").val($("#necesidadespecial").val()+"-InstruccionesSi");
          }else{
              $("#necesidadespecial").val($("#necesidadespecial").val()+"-InstruccionesNo");
          }
          if($("#171").is(":checked")){
              $("#necesidadespecial").val($("#necesidadespecial").val()+"-DistraccionSi");
          }else{
              $("#necesidadespecial").val($("#necesidadespecial").val()+"-DistraccionNo");
          }
          /*var str = $("#necesidadespecial").val();
          $("#necesidadespecial").val(str.substring(0, (str.length)-1));*/
          $("#necesidadespecial").show();
      }
      $("#necesidadespecial").show();
        $('#form').show();
        $('#test_need').hide();
        $('#submitg').show();


  });
//#####################################################################################################################

  </script>

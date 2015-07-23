<?php foreach ($usr_all_data as $usr_data){} ?>
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <aside class="profile-info col-lg-9">
                      <section class="panel">
                          <div class="panel-body bio-graph-info">
                              <h1>Administrador FROAC</h1>
                              <div class="row">
                                  <div class="bio-row">
                                      <p><span>Nombres: </span><b><?php echo $usr_data['use_nombre']?></b></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Apellidos: </span><b><?php echo $usr_data['use_apellido']?></b></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Fecha de nacimiento:</span> <b><?php echo $usr_data['use_datebirth']?></b></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Email: </span><b><?php echo $usr_data['use_email']?></b></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Nivel de educación: </span><b><?php echo $usr_data['use_level']?></b></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Fecha de registro: </span><b><?php echo $usr_data['use_fecha_registro']?></b></p>
                                  </div>                                  
                                  <div class="bio-row">
                                      <p><span>Rol: </span><b><?php echo $usr_data['use_rol_nombre']?></b></p>
                                  </div>
                              </div>
                          </div>
                      </section>
                  </aside>
              </div>

              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
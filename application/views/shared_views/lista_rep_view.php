
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        
        <section class="panel">
            <header class="panel-heading">
                 Repositorios Federados en FROAC</b>
            </header>
            <div class="panel-body">
                <div class="row">
                    <?php
                    foreach ($repos as $key) {
                        ?>
                        <div class="col-lg-4">
                            <!--widget start-->
                            <aside class="profile-nav alt green-border">
                                <section class="panel">
                                    <div class="user-heading alt green-bg">
                                        <h1><?php echo $key['rep_name'] ?></h1>
                                        <p><?php echo $key['rep_affiliation'] ?></p>
                                    </div>

                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a href="<?php echo $key['rep_url'] ?>" target="blank"> <i class="icon-cloud"></i> Ver Sitio del Repositorio</a></li>
                                        <li><a href="javascript:;"> <i class="icon-file-text"></i> Estándar: <b><?php echo $key['rep_metadata_inf'] ?></b> </a></li>
                                        <li><a href="<?php echo base_url()?>repositorio/lo_rep/<?php echo $key['rep_id'] ?>"> <i class="icon-file-text-alt"></i> Cantidad de Objetos <span class="label label-info pull-right r-activity"><?php echo $key['rep_countoas']?></span></a></li>
                                        <li><a href="javascript:;"> <i class="icon-calendar"></i> Última Actualización: <b><?php echo $key['rep_lastupdate']?></b> </a></li>
                                        <?php
                                        $session_data = $this->session->userdata('logged_in');
                                            if ($this->session->userdata('logged_in'))
                                            {
                                                if ($session_data ['username'] == "admin")
                                                {?>
                                                    <li><a href="<?php echo base_url()?>repositorio/modificar_repo/<?php echo $key['rep_id'] ?>"> <i class="icon-file-text-alt"></i>Modificar </span></a></li>
                                                     </td><div  id="actualizaroa<?php echo $i; ?>">
                                                        <input type="radio" id="actualizar<?php echo $i; ?>" name="actualizar" value="1"/>Todo<br/>
                                                        <input type="radio" id="actualizar<?php echo $i; ?>" name="actualizar" value="2" checked="TRUE"/>Desde <?php echo $key['ep_lastupdate'] ?> <br/>
                                                        <input type="radio" id="actualizar<?php echo $i; ?>" name="actualizar" value="3"/>Rango de Fechas:<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        Inicio:<input class="inputext1" id="fechainicio"type="text"  value="" name="fechainicio" /><br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        Fin:&nbsp;&nbsp;&nbsp;&nbsp;<input class="inputext1" id="fechafin" type="text" value="" name="fechafin" />



                                                <td width="10%"> 
                                                 <?php
                                                }
                                            }?>
                                    </ul>

                                </section>
                            </aside>
                            <!--widget end-->
                        </div>

                    <?php } ?>

                </div>
            </div>
        </section>



        <div class="row"  id="result">

        </div>
    </section>
</section>
<!--main content end-->
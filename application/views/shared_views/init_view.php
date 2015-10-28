<?php if($user){$sess = 1; $usr = $user;}else{ $sess = 0; $usr=0;} ?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <br>
        <div class="col-lg-12" style="display: none;" id="hide-s">

            <div class="input-group  m-bot15">
                <span class="input-group-btn">
                    <button class="btn btn-success buscar" type="button">Buscar</button>
                </span>
                <input type="text" class="form-control" id="hide-input" autofocus="">

            </div>



        </div>

        <div class="row">


            <div class="col-lg-12" id="show-s">

                <section class="panel">
                    <div class="panel-body">
                        <div class="">
                            <div class="text-center">
                                <h1 class="froac">Federación de Repositorios de Objetos de Aprendizaje Colombia 
                                    <img src="<?php echo base_url() ?>asset/img/logo2.png" alt="Logo FROAC" width="50">
                                </h1>
                            </div>
                        </div>
                        <br>


                        <div class="row">
                            <div class="col-sm-1"></div>

                            <div class="col-sm-10">
                                <div class="input-group  m-bot15">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success buscar" type="button">Buscar</button>
                                    </span>
                                    <input type="text" class="form-control" id="search" autofocus="">
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <br><br>


        <div class="row state-overview" id="info">
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol terques">
                        <i class="icon-user"></i>
                    </div>
                    <div class="value">
                        <p class="numeros">
                            <?php echo $total_user ?>
                        </p>

                        <p>Usarios</p>
                    </div>
                </section>
            </div>
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="icon-sitemap"></i>
                    </div>
                    <div class="value">
                        <p class="numeros">
                            <?php echo $total_rep ?>
                        </p>

                        <p>Repositorios</p>
                    </div>
                </section>
            </div>
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol yellow">
                        <i class="icon-file-text"></i>
                    </div>
                    <div class="value">
                        <p class="numeros">
                            <?php echo $total_lo ?>
                        </p>

                        <p>Objetos</p>
                    </div>
                </section>
            </div>
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol blue">
                        <i class="icon-check"></i>
                    </div>
                    <div class="value">
                        <p class="numeros">
                            <?php echo $total_lo_score ?>
                        </p>

                        <p>Objetos calificados</p>
                    </div>
                </section>
            </div>
        </div>

        <div class="row"  id="result">

        </div>
    </section>
</section>
<!--main content end-->

<script>

    function verify_params() {
        var params = $("#hide-input").val();
        params = params.toLowerCase().replace(/ /g, '_');
        $("#result").load("<?php echo base_url(); ?>index.php/lo/buscar_lo/" + params + "/" + <?php echo $sess ?> + "/" + "<?php echo $usr ?>");
    }

    $("#result").show();
    $("#search").keyup(function() {
        $("#hide-s").show("slow");
        $("#show-s").hide("slow");
        $("#hide-input").val($("#search").val());
        $("#hide-input").focus();
    });



    $(".buscar").click(function() {
        verify_params();
        $("#info").hide("slow");

    });

    $(document).keypress(function(e) {
        if (e.which == 13 && $("#hide-input").val().length > 0) {
            verify_params();
            $("#info").hide("slow");
        }


    });



</script>
<!-- js placed at the end of the document so the pages load faster -->
<!--<script src="js/jquery.js"></script>-->
<script type="text/javascript" language="javascript"
src="<?php echo base_url() ?>asset/assets/advanced-datatable/media/js/jquery.js"></script>
<script type="text/javascript" language="javascript"
src="<?php echo base_url() ?>asset/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>

<script type="text/javascript">
    /* Formating function for row details */
    function fnFormatDetails(oTable, nTr) {
        var aData = oTable.fnGetData(nTr);
        var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        sOut += '<tr><td>Rendering engine:</td><td>' + aData[1] + ' ' + aData[4] + '</td></tr>';
        sOut += '<tr><td>Link to source:</td><td>Could provide a link here</td></tr>';
        sOut += '<tr><td>Extra info:</td><td>And any further details here (images etc)</td></tr>';
        sOut += '</table>';

        return sOut;
    }

    $(document).ready(function() {
        /*
         * Insert a 'details' column to the table
         */
        var nCloneTh = document.createElement('th');
        var nCloneTd = document.createElement('td');
        nCloneTd.innerHTML = '<img src="<?php echo base_url() ?>asset/assets/advanced-datatable/examples/examples_support/details_open.png">';
        nCloneTd.className = "center";

        $('#hidden-table-info thead tr').each(function() {
            this.insertBefore(nCloneTh, this.childNodes[0]);
        });

        $('#hidden-table-info tbody tr').each(function() {
            this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
        });

        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
        var oTable = $('#hidden-table-info').dataTable({
            "aoColumnDefs": [
                {"bSortable": false, "aTargets": [0]}
            ],
            "aaSorting": [
                [1, 'asc']
            ]
        });

        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $('#hidden-table-info tbody td img').live('click', function() {
            var nTr = $(this).parents('tr')[0];
            if (oTable.fnIsOpen(nTr)) {
                /* This row is already open - close it */
                this.src = "<?php echo base_url() ?>asset/assets/advanced-datatable/examples/examples_support/details_open.png";
                oTable.fnClose(nTr);
            }
            else {
                /* Open this row */
                this.src = "<?php echo base_url() ?>asset/assets/advanced-datatable/examples/examples_support/details_close.png";
                oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
            }
        });
    });
</script>
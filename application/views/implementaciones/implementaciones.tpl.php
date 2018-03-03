<?php
/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
?>
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.js"></script>

<?php echo css("control_escolar/wizard/wizard.css");?>
<?php echo js("control_escolar/implementacion.js");?>
<?php echo js("control_escolar/complemento_jsgrid.js");?>
<?php echo js("control_escolar/datos_generales.js");?>
<?php echo js("control_escolar/profesores.js");?>

    <div class="body">
        <p class="lead">Registro de implementaciones</p>
        <p> En esta sección se registran los datos de las implementaciones de los diferentes cursos presenciales.
            Para mayor referencia consulte el tutorial que puede descargar <a href="<?php echo base_url('assets/files/manual_actividad_docente.pdf'); ?>" download> aquí</a>.
        </p>
        <div class="tab-content">
            <div id="select_lista_cursos" class="tab-pane fade active in">
                <a href="#select_datos_curso" type="button" class="btn bg-teal btn-lg waves-effect pull-right" data-toggle="tab" aria-expanded="false" onclick="carga_datos_implementacion(this);" data-cveimple="">
                    <i class="fas fa-plus fa-2x"></i>
                    <span>Agregar curso</span>
                </a>
                <a href="#" type="button" class="btn bg-teal btn-lg waves-effect pull-right" aria-expanded="false" onclick="exportar_implementaciones(this);" data-namegrid="jsImplementaciones">
                    <i class="fas fa-plus fa-2x"></i>
                    <span>Exportar</span>
                </a><br><br><br><br>
                <div id="jsImplementaciones"></div>
            </div>
            <div id="select_datos_curso" class="tab-pane fade">
                <?php
                if (isset($vista_implementacion))
                {
                    echo $vista_implementacion;
                }
                ?>
            </div>
        </div>
  </div>

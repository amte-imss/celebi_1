<?php
echo form_open('', array("id" => "form_" . $etapa));
//pr($data);
?>
<INPUT type="hidden" id="etapa" name="etapa" value="<?php echo (isset($etapa)) ? $etapa : 0; ?>">
<INPUT type="hidden" class="implementacion" id="implementacion" name="implementacion" value="<?php echo (isset($data['id_implementacion'])) ? $data['id_implementacion'] : 0; ?>">
<h3>Información general del curso</h3>
<fieldset>
    <div class="form-group form-float">
        <div class="row clearfix">
            <div class="col-sm-6">
                <p>
                    <b>Nombre del curso:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <?php
                        echo $this->form_complete->create_element(
                                array('id' => 'curso', 'type' => 'dropdown',
                                    'options' => dropdown_options($catalogos['curso']['opciones'], $catalogos['curso']['key'], $catalogos['curso']['value']),
                                    'first' => array('' => 'Selecciona opción'),
                                    'value' => (isset($data['clave_curso'])) ? $data['clave_curso'] : '',
                                    //                'value' => (isset($value['valor'])) ? $value['valor'] : '',
                                    'attributes' => array(
                                        'name' => 'curso',
                                        'class' => "form-control show-tick",
                                        'placeholder' => "",
                                        'data-fieldkey' => $catalogos['curso']['key'],
                                        'data-fieldvalue' => $catalogos['curso']['value'],
                                        'onchange' => 'cambia_datos_curso(this);'
                                    ),
                                )
                        );
                        ?>
                    </div>
                </div>
                <?php echo form_error_format('curso'); ?>
            </div>

            <div class="col-sm-6">
                <p>
                    <b>Clave del curso:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <?php
                        echo $this->form_complete->create_element(
                                array('id' => 'clave_curso', 'type' => 'text',
                                    'value' => (isset($data['clave_curso'])) ? $data['clave_curso'] : '',
                                    //                'value' => (isset($value['valor'])) ? $value['valor'] : '',
                                    'attributes' => array(
                                        'name' => 'clave_curso',
                                        'class' => "form-control",
                                        'placeholder' => "",
                                        'disabled' => null,
                                    ),
                                )
                        );
                        ?>
                    </div>
                </div>
                <?php echo form_error_format('clave_curso'); ?>
            </div>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="row clearfix">
            <div class="col-sm-6">
                <p>
                    <b>Clave de implementación:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <?php
                        echo $this->form_complete->create_element(
                                array('id' => 'clave_implementacion', 'type' => 'text',
                                    'value' => (isset($data['clave_implementacion'])) ? $data['clave_implementacion'] : '',
                                    //                'value' => (isset($value['valor'])) ? $value['valor'] : '',
                                    'attributes' => array(
                                        'name' => 'clave_implementacion',
                                        'class' => "form-control show-tick",
                                    ),
                                )
                        );
                        ?>

                    </div>
                </div>
                <?php echo form_error_format('clave_implementacion'); ?>
            </div>
            <div class="col-sm-6">
                <p>
                    <b>Tipo de curso:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <?php
                        echo $this->form_complete->create_element(
                                array('id' => 'tipo_curso', 'type' => 'dropdown',
                                    'options' => dropdown_options($catalogos['tipo_curso']['opciones'], $catalogos['tipo_curso']['key'], $catalogos['tipo_curso']['value']),
                                    'first' => array('' => 'Selecciona opción'),
                                    'value' => (isset($data['id_tipo_cursoe'])) ? $data['id_tipo_curso'] : '',
                                    //                'value' => (isset($value['valor'])) ? $value['valor'] : '',
                                    'attributes' => array(
                                        'name' => 'tipo_curso',
                                        'class' => "form-control show-tick dependientes",
                                        'placeholder' => "",
                                        'data-fieldkey' => $catalogos['tipo_curso']['key'],
                                        'data-fieldvalue' => $catalogos['tipo_curso']['value'],
                                        'onchange' => 'cambia_datos_tipo_curso(this);'
                                    ),
                                )
                        );
                        ?>
                    </div>
                </div>
                <?php echo form_error_format('tipo_curso'); ?>
            </div>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="row clearfix">
            <div class="col-sm-6">
                <p>
                    <b>Centro de investigación educación y formación docente(CIEFD):</b>
                </p>
                <?php
                echo $this->form_complete->create_element(
                        array('id' => 'sede', 'type' => 'dropdown',
                            'options' => dropdown_options($catalogos['sede']['opciones'], $catalogos['sede']['key'], $catalogos['sede']['value']),
                            'first' => array('' => 'Selecciona opción'),
                            'value' => (isset($data['clave_unidad_sede'])) ? $data['clave_unidad_sede'] : '',
                            //                'value' => (isset($value['valor'])) ? $value['valor'] : '',
                            'attributes' => array(
                                'name' => 'sede',
                                'class' => "form-control show-tick",
                                'placeholder' => "",
                            ),
                        )
                );
                ?>
                <?php echo form_error_format('sede'); ?>
            </div>
            <div class="col-sm-6">
                <p>
                    <b>Cupo:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <?php
                        echo $this->form_complete->create_element(
                                array('id' => 'reglas_tipo_curso', 'type' => 'dropdown',
//                                    'options' => dropdown_options($catalogos['reglas_tipo_curso']['opciones'], $catalogos['reglas_tipo_curso']['key'], $catalogos['reglas_tipo_curso']['value']),
                                    'first' => array('' => 'Selecciona opción'),
                                    'value' => (isset($data['id_regla_tipo_curso'])) ? $data['id_regla_tipo_curso'] : '',
                                    //                'value' => (isset($value['valor'])) ? $value['valor'] : '',
                                    'attributes' => array(
                                        'name' => 'reglas_tipo_curso',
                                        'class' => "form-control show-tick dependientes",
                                        'data-fieldkey' => $catalogos['reglas_tipo_curso']['key'],
                                        'data-fieldvalue' => $catalogos['reglas_tipo_curso']['value'],
                                        'onchange' => 'cambia_datos_reglas_tc(this);',
                                        'placeholder' => "",
                                    ),
                                )
                        );
                        ?>
                    </div>
                </div>
                <?php echo form_error_format('reglas_tipo_curso'); ?>
            </div>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-group form-float">
            <div class="row clearfix">
                <div class="col-sm-12" id="detalle_regla_curso">

                </div>
            </div>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="row clearfix">
            <div class="col-sm-6">
                <p>
                    <b>Objetivo:</b>
                </p>
                <?php
                echo $this->form_complete->create_element(
                        array('id' => 'objetivo_implementacion', 'type' => 'text',
                            'value' => (isset($data['objetivo'])) ? $data['objetivo'] : '',
                            'attributes' => array(
                                'name' => 'objetivo_implementacion',
                                'class' => "form-control show-tick",
                            ),
                        )
                );
                ?>
            </div>
            <div class="col-sm-6">
                <p>
                    <b>Contenido:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <?php
                        echo $this->form_complete->create_element(
                                array('id' => 'contenido_implementacion', 'type' => 'text',
                                    'value' => (isset($data['contenido_implementacion'])) ? $data['contenido_implementacion'] : '',
                                    'attributes' => array(
                                        'name' => 'contenido_implementacion',
                                        'class' => "form-control show-tick",
                                    ),
                                )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-group form-float">
            <div class="row clearfix">
                <div class="col-sm-12">
                    <p>
                        <b>Categoría convocada:</b>
                    </p>
                    <?php
                    $aux_cc = $catalogos['categoria_convocada']['opciones'];
                    echo generar_arbol($aux_cc, 'id_categoria', 'id_categoria_padre', 'nombre');
                    ?> 
                </div>
            </div>
        </div>
        <?php echo form_error_format('categoria_convocada'); ?>
    </div>
    <!--<a href="#next" role="menuitem" class="btn btn-primary">Siguiente</a>-->
    <!--<a href="#finish" role="menuitem" class="waves-effect">Guardar</a>-->
</fieldset>
<ul class="list-inline pull-right">
    <li>
        <button type="button" onclick="update_insert(this);"  data-forminv="form_<?php echo $etapa; ?>" class="btn btn-primary next-step">Guardar y continuar</button>
    </li>
</ul>
<?php echo form_close(); ?>
<?php
$result = [];
foreach ($catalogos as $key => $value)
{
    if ($value['enviar_objeto'])
    {
        $result[$key] = $value['opciones'];
    }
}
?>

<?php
if (!empty($result))
{
    ?>
    <script>
        memoria_values = <?php echo json_encode($result, JSON_PRETTY_PRINT); ?>
    </script>   
    <?php
}
?>
<?php
$tcd = (isset($data['id_tipo_curso']) && !empty($data['id_tipo_curso'])) ? $data['id_tipo_curso'] : '';
$tc = (isset($post['tipo_curso'])) ? $post['tipo_curso'] : $tcd; 
$rtcd = (isset($post['reglas_tipo_curso'])) ? $post['reglas_tipo_curso'] : '';
$rtc = (isset($post['reglas_tipo_curso'])) ? $post['reglas_tipo_curso'] : $rtcd;
$ccd = (isset($data['categorias']) && !empty($data['categorias'])) ? $data['categorias'] : [];
$cc = (isset($post['clave_convocatoria'])) ? $post['clave_convocatoria'] : $ccd;
    
$guarda_datos = [
    'tipo_curso' => $tc,
    'reglas_tipo_curso' => $rtc,
    'categoria_convocada' => $cc];
//pr($guarda_datos);
?>
<script>
    memoria_datos_generales = <?php echo json_encode($guarda_datos, JSON_PRETTY_PRINT); ?>
</script>

<script>

    $(document).ready(function () {
        $(".conectados").change(function () {
            control_checkbox_convocatoria(this);
        });
        carga_dependientes_dg();//Carga valores dependientes
        carga_dependientes_convocatoria();//Carga valores convocatoria
    });
</script>

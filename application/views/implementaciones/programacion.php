<?php
echo form_open('', array("id" => "form_" . $etapa));
//pr($data);
?>
<INPUT type="hidden" id="etapa" name="etapa" value="<?php echo (isset($etapa)) ? $etapa : 0; ?>" data-forminv="form_<?php echo $etapa; ?>">
<INPUT type="hidden" class="implementacion" id="implementacion" name="implementacion" value="<?php echo (isset($data['id_implementacion'])) ? $data['id_implementacion'] : 0; ?>">
<h3>Programación</h3>
<fieldset>
    <div class="form-group form-float">
        <div class="row clearfix">
            <div class="col-sm-6">
                <p>
                    <b>Fecha de inicio:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <?php
                        echo $this->form_complete->create_element(
                                array('id' => 'fecha_inicial', 'type' => 'text',
                                    'value' => (isset($data['fecha_inicial'])) ? $data['fecha_inicial'] : '',
                                    //                'value' => (isset($value['valor'])) ? $value['valor'] : '',
                                    'attributes' => array(
                                        'name' => 'clave_curso',
                                        'class' => "form-control datepicker",
                                        'placeholder' => "Por favor seleccione una fecha...",
                                    ),
                                )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <p>
                    <b>Fecha de término:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <?php
                        echo $this->form_complete->create_element(
                                array('id' => 'fecha_final', 'type' => 'time',
                                    'value' => (isset($data['fecha_final'])) ? $data['fecha_final'] : '',
                                    //                'value' => (isset($value['valor'])) ? $value['valor'] : '',
                                    'attributes' => array(
                                        'name' => 'fecha_final',
                                        'class' => "form-control datepicker",
                                        'placeholder' => "Por favor seleccione una fecha...",
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
        <div class="row clearfix">
            <div class="col-sm-6">
                <p>
                    <b>Hora de inicio de sesión presencial:</b>
                </p>
                <select class="form-control show-tick">
                    <option value="">Selecciona una opción</option>
                    <option value="8">8:00</option>
                    <option value="9">9:00</option>
                    <option value="10">10:00</option>
                    <!-- <option value="40">40</option>
                    <option value="50">50</option> -->
                </select>
            </div>
            <div class="col-sm-6">
                <p>
                    <b>Hora de término de sesión presencial:</b>
                </p>
                <select class="form-control show-tick">
                    <option value="">Selecciona una opción</option>
                    <option value="13">13:00</option>
                    <option value="14">14:00</option>
                    <option value="15">15:00</option>
                    <!-- <option value="40">40</option>
                    <option value="50">50</option> -->
                </select>
            </div>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="row clearfix">
            <div class="col-sm-4">
                <p>
                    <b>Horas totales:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="number" class="form-control" name="">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <p>
                    <b>Horas de aula:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="number" class="form-control" name="">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <p>
                    <b>Horas fuera de aula:</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="number" class="form-control" name="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="row clearfix">
            <div class="col-sm-6">
                <p>
                    <b>Número de sesiones(Asistencia máxima):</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="number" class="form-control" name="">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <p>
                    <b>Número de sesiones(Asistencia mínima):</b>
                </p>
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="number" class="form-control" name="">
                    </div>
                </div>
            </div>
        </div>
    </div>

</fieldset>
<?php echo form_close(); ?>
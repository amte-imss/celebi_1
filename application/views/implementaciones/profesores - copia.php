<?php
echo form_open('', array("id" => "form_" . $etapa));
//pr($data);
?>
<INPUT type="hidden" id="etapa" name="etapa" value="<?php echo (isset($etapa)) ? $etapa : 0; ?>">
<INPUT type="hidden" class="implementacion" id="etapa" name="implementacion" value="<?php echo (isset($id_implementacion)) ? $id_implementacion : 0; ?>">
<h3>Profesores</h3>
<fieldset>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Unidad</th>
                    <th>Correo</th>
                    <th>Curp</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <!-- <tfoot>
                <tr>
                    <th>Clave de curso</th>
                    <th>Nombre de curso</th>
                    <th>Nombre corto</th>
                    <th>Matrícula</th>
                    <th>Profesor</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </tfoot> -->
            <tbody>
                <tr>
                    <td>CES-060504</td>
                    <td>Código infarto</td>
                    <td>COINF-2018</td>
                    <td>55555555</td>
                    <td>Juan Fernandez Montes</td>
                    <td>JUA251586SANSDK07</td>
                    <td> <a href="#">Ver</a> &nbsp <a href="#">Editar</a> </td>

                </tr>
                <tr>
                    <td>CES-060504</td>
                    <td>Código infarto</td>
                    <td>COINF-2018</td>
                    <td>55555555</td>
                    <td>Juan Fernandez Montes</td>
                    <td>JUA251586SANSDK07</td>
                    <td> <a href="#">Ver</a> &nbsp <a href="#">Editar</a> </td>

                </tr>
                <tr>
                    <td>CES-060504</td>
                    <td>Código infarto</td>
                    <td>COINF-2018</td>
                    <td>55555555</td>
                    <td>Juan Fernandez Montes</td>
                    <td>JUA251586SANSDK07</td>
                    <td> <a href="#">Ver</a> &nbsp <a href="#">Editar</a> </td>

                </tr>
            </tbody>
        </table>
    </div>
</fieldset>
<?php echo form_close(); ?>
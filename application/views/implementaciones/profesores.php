
<?php echo form_open('', array("form_" . $etapa)); ?>
<INPUT type="hidden" id="etapa" name="etapa" value="<?php echo (isset($etapa)) ? $etapa : 0; ?>">
<input type="hidden" name="implementacion" value="<?php echo (isset($id_implementacion) ? $id_implementacion : ''); ?>" id="implementacion">

<h3>Profesores</h3>
<?php
//pr($regla);
?>

<div class="row">
    <div id="jsGridTitulares"></div>
</div>
<div class="row">
    <div id="jsGridAdjuntos"></div>
</div>

<fieldset>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Rol</th>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Delegación</th>
                    <th>Correo</th>
                    <th>Curp</th>
                    <th>Acciones</th>
                </tr>
            </thead>
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
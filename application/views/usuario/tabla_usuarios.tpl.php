<table class="table table-striped">
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Nombre</th>
            <th>Correo electrónico</th>
            <th>Delegación</th>
            <th>Unidad</th>
            <th>Editar</th>
            <th>Censo terminado</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($usuarios as $row)
        {
            ?>
            <tr>
                <td><?php echo $row['matricula']; ?></td>
                <td><?php echo $row['nombre_completo']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['delegacion']; ?></td>
                <td><?php echo $row['unidad']; ?></td>
                <!-- <td><a href="<?php echo site_url() ?>/usuario/ver_usuario_tabla/<?php echo $row['id_usuario']; ?>">Ver</a></td> -->
                <td><a href="<?php echo site_url() ?>/usuario/get_usuarios/<?php echo $row['id_usuario']; ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
                <td>
                    <?php echo form_open('usuario/editar/' . $row['id_usuario'] . '/' . Usuario::CENSO, array('id' => 'area_censo_finalizado_'.$row['id_usuario'])); ?>
                        <input type="hidden" name="usuario" value="<?php echo $row['id_usuario']; ?>">
                        <input type="checkbox" onclick="censo_finalizado(<?php echo $row['id_usuario']; ?>)" name="censo_finalizado_<?php echo $row['id_usuario']; ?>" <?php echo $row['censo_finalizado']? 'checked': ''; ?>>
                    <?php echo form_close(); ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

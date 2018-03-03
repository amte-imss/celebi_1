<table class="table table-striped">
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Nombre</th>
            <th>Correo electrónico</th>
            <th>Delegación</th>
            <th>Unidad</th>
            <th>Usuario activo</th>
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
                <td>
                    <?php echo $row['usuario_activo']? 'Si':'No'; ?>
                </td>
                <td>
                    <?php echo $row['censo_finalizado']? 'Si':'No'; ?>                        
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

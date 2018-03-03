<input type="hidden" name="usuario" value="<?php echo $id_usuario; ?>">
<input type="checkbox" onclick="censo_finalizado(<?php echo $id_usuario; ?>)" name="censo_finalizado_<?php echo $id_usuario; ?>" <?php echo isset($usuario[0]['censo_finalizado']) && $usuario[0]['censo_finalizado']? 'checked': ''; ?>>

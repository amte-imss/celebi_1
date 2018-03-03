<?php echo form_open('', array("form_" . $etapa)); ?>
<INPUT type="hidden" id="etapa" name="etapa" value="<?php echo (isset($etapa)) ? $etapa : 0; ?>">
<?php echo form_close(); ?>
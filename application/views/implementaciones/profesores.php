<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<!--<script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.js"></script>-->
<script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.js"></script>
<?php
echo js("control_escolar/profesores.js");
?>

<?php echo form_open('', array("form_" . $etapa)); ?>
<INPUT type="hidden" id="etapa" name="etapa" value="<?php echo (isset($etapa)) ? $etapa : 0; ?>">

<h3>Profesores</h3>
<?php 
//pr($regla);
?>
<input type="text" name="implementacion" value="<?php echo($id_implementacion);?>" id="implementacion" disabled style="
    display:  none;">

<div class="row">
    <div id="jsGridTitulares"></div>
</div>
<div class="row">
    <div id="jsGridAdjuntos"></div>
</div>
<?php echo form_close(); ?>
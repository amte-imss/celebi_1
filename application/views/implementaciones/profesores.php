<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.js"></script>

<?php
echo form_open('', array("id" => "form_" . $etapa));
//pr($data);
?>
<INPUT type="hidden" id="etapa" name="etapa" value="<?php echo (isset($etapa)) ? $etapa : 0; ?>" data-forminv="form_<?php echo $etapa; ?>">
<INPUT type="hidden" class="implementacion" id="implementacion" name="implementacion" value="<?php echo (isset($data['id_implementacion'])) ? $data['id_implementacion'] : 0; ?>">

<h3>Profesores</h3>
<fieldset>
    <div class="row">
        <div id="jsGridTitulares"></div>
    </div>
    <div class="row">
        <div id="jsGridAdjuntos"></div>
    </div>
</fieldset>
<?php echo form_close(); ?>

<?php echo js("control_escolar/profesores.js"); ?>
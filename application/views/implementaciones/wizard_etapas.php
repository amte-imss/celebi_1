<div class="tab-pane active text-center" role="tabpanel" id="step1" data-etapa="1">
    <div id="contenido1" >
        <?php
        if (isset($step1))
        {
            echo $step1;
        }
        ?>
    </div>
    <ul class="list-inline pull-right">
        <li><button type="button" class="btn btn-primary next-step" data-etapa="1">Guardar y continuar</button></li>
    </ul>
</div>
<div class="tab-pane" role="tabpanel" id="step2" data-etapa="2">
    <div id="contenido2" >
        <?php
        if (isset($step2))
        {
            echo $step2;
        }
        ?>
    </div>
    <ul class="list-inline pull-right">
        <li><button type="button" class="btn btn-default prev-step">Anterior</button></li>
        <li><button type="button" class="btn btn-primary next-step" data-etapa="2">Guardar y continuar</button></li>
    </ul>

</div>
<div class="tab-pane" role="tabpanel" id="step3" >
    <div id="contenido3" >
        <?php
        if (isset($step3))
        {
            echo $step3;
        }
        ?>
    </div>
    <ul class="list-inline pull-right">
        <li><button type="button" class="btn btn-default prev-step">Anterior</button></li>
        <!-- <li><button type="button" class="btn btn-default next-step">Saltar</button></li> -->
        <li><button type="button" class="btn btn-primary btn-info-full next-step" data-etapa="3">Guardar y continuar</button></li>
    </ul>
</div>
<!-- <div class="tab-pane" role="tabpanel" id="step4">
<?php
//if (isset($step4))
{
    //  echo $step4;
}
?>
</div> -->
<!-- <div class="tab-pane" role="tabpanel" id="complete">
    <h3>Completo</h3>
    <p>Haz completado todos los pasos.<br> Gracias.</p>
</div> -->
<div class="clearfix"></div>

<?php
//pr($catalogos);
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
    <script type="text/javascript">
        memoria_values = <?php echo json_encode($result, JSON_PRETTY_PRINT); ?>
    </script>
    <?php
}
?>

<?php echo js("control_escolar/wizard/formulario_curso.js");
?>
    
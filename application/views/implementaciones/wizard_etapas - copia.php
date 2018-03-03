<div class="tab-pane active text-center" role="tabpanel" id="step1">
    <?php
    if (isset($step1))
    {
        echo $step1;
    }
    ?>
</div>
<div class="tab-pane" role="tabpanel" id="step2">
    <?php
    if (isset($step2))
    {
        echo $step2;
    }
    ?>

</div>
<div class="tab-pane" role="tabpanel" id="step3">
    <?php
    if (isset($step3))
    {
        echo $step3;
    }
    ?>
</div>
<div class="tab-pane" role="tabpanel" id="step4">
    <?php
    if (isset($step4))
    {
        echo $step4;
    }
    ?>
</div>
<div class="tab-pane" role="tabpanel" id="complete">
    <h3>Campleto</h3>
    <p>Haz completado todos los pasos.<br> Gracias.</p>
</div>

<!--<div >
-->    <ul class="list-inline pull-right">
    <li class="disabled" aria-disabled="true"><a href="#select_lista_cursos" data-toggle="tab" role="menuitem" onclick="cancelar_edicion(this);">Cancelar</a></li>
    <!--<li><button type="button" class="btn btn-default prev-step">Anterior</button></li>-->
    <!--<li><button type="button" class="btn btn-primary btn-info-full next-step">Guardar y continuar</button></li>-->
</ul><!--
</div>-->
<div class="clearfix"></div>
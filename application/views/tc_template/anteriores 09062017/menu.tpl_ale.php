<?php
$actividad_docente = array(
    1 => array('name_act' => 'Perfil', 'ruta' => 'perfil', 'imagen' => '2.png', 'class' => 'mt'), //mt
//    1 => array('name_act' => 'Información general', 'ruta' => 'info_gral/mostrar/311091488', 'icono' => 'fa fa-user-md', 'class' => 'sub-menu'), //mt
    2 => array('name_act' => 'Información docente', 'ruta' => 'informacion_imss', 'imagen' => '3.png', 'class' => 'sub-menu'), //mt
    3 => array('name_act' => 'Formación docente', 'ruta' => 'formacion_docente', 'imagen' => '10.png', 'class' => 'sub-menu'),
    4 => array('name_act' => 'Actividad docente', 'ruta' => 'actividad_docente', 'imagen' => '4.png', 'class' => 'sub-menu'),
    5 => array('name_act' => 'Becas', 'ruta' => 'becas_comisiones', 'imagen' => '5.png', 'class' => 'sub-menu'),
    6 => array('name_act' => 'Comisiones', 'ruta' => 'comisiones_academicas', 'imagen' => '6.png', 'class' => 'sub-menu'),
    7 => array('name_act' => 'Dirección de tésis', 'ruta' => 'direccion_tesis', 'imagen' => '9.png', 'class' => 'sub-menu'),
    8 => array('name_act' => 'Material educativo', 'ruta' => 'material_educativo', 'imagen' => '7.png', 'class' => 'sub-menu'),
    9 => array('name_act' => 'Investigación', 'ruta' => 'investigacion', 'imagen' => '8.png', 'class' => 'sub-menu'),
);
?>
<div id="sidebar"  class="nav-collapse ">
    <ul class="sidebar-menu" id="nav-accordion">

        <p class="centered"><a href="profile.html"><img src="<?php echo base_url(); ?>assets/img/template_sipimss/ui-zac.jpg" class="img-circle" width="70"></a></p>
        <h5 class="centered">Dianna Angeles</h5>

        <?php
        foreach ($actividad_docente as $value) {
            $class = ($this->uri->rsegment(1) == $value['ruta']) ? 'active' : '';
            ?>
            <li class="<?php echo $value['class']; ?>">
                <!--<a class="<?php // echo $class;  ?>" href="<?php // echo $value['ruta'];  ?>">-->
                <a class="<?php echo $class; ?>" href="<?php echo base_url('index.php/') . $value['ruta']; ?>">
                    <!-- <img class="img-menu" src="<?php //echo base_url('assets/img/template_sipimss/img-menu/') . $value['imagen']; ?>"> -->
                    <span><?php echo $value['name_act']; ?></span>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>
</div>

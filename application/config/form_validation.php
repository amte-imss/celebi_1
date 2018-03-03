<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config = array(
    'etapa_1' => array(
        array(
            'field' => 'tipo_curso',
            'label' => 'Tipo de curso',
            'rules' => 'required'
        ),
        array(
            'field' => 'reglas_tipo_curso',
            'label' => 'Cupo',
            'rules' => 'required'
        ),
        array(
            'field' => 'curso',
            'label' => 'curso',
//            'rules' => 'is_folio_comprobante_unico'
            'rules' => 'required'
        ),
       array(
            'field' => 'categoria_convocada',
            'label' => 'Categoria convocada ',
            'rules' => 'required'
        ),
       array(
            'field' => 'sede',
            'label' => 'Sede',
            'rules' => 'required'
        ),
       array(
            'field' => 'clave_implementacion',
            'label' => 'Clave de implementación',
            'rules' => 'required'
        ),
    ),
    
);

$config["login"] = array(
    array(
        'field' => 'usuario',
        'label' => 'Usuario',
        'rules' => 'required',
        'errors' => array(
            'required' => 'El campo %s es obligatorio, favor de ingresarlo.',
        ),
    ),
    array(
        'field' => 'password',
        'label' => 'Contraseña',
        'rules' => 'required',
        'errors' => array(
            'required' => 'El campo %s es obligatorio, favor de ingresarlo.',
        ),
    ),
    array(
        'field' => 'captcha',
        'label' => 'Imagen de seguridad',
        'rules' => 'required|check_captcha',
        'errors' => array(
            'required' => 'El campo %s es obligatorio, favor de ingresarlo.',
            'check_captcha' => "El texto no coincide con la imagen, favor de verificarlo."
        ),
    ),
);

$config['form_user_update_password'] = array(
    array(
        'field' => 'pass',
        'label' => 'Contraseña',
        'rules' => 'required|min_length[7]'
    ),
    array(
        'field' => 'pass_confirm',
        'label' => 'Confirmar contraseña',
        'rules' => 'required|min_length[7]' //|callback_valid_pass
    ),
);

$config['form_actualizar'] = array(
    array(
        'field' => 'email',
        'label' => 'Correo electrónico',
        'rules' => 'trim|required|valida_correo_electronico' //|callback_valid_pass
    ),
);

$config['form_niveles_acceso_usuario'] = array(
    array(
        'field' => 'niveles',
        'label' => 'niveles',
        'rules' => 'required'
    )
);

$config['form_status_actividad_usuario'] = array(
    array(
        'field' => 'status_actividad',
        'label' => 'Actividad del usuario',
        'rules' => 'required|integer'
    )
);

$config['form_registro'] = array(
    array(
        'field' => 'matricula',
        'label' => 'Matrícula',
        'rules' => 'required|max_length[18]|alpha_dash'
    ),
    array(
        'field' => 'delegacion',
        'label' => 'Delegación',
        'rules' => 'required' //|callback_valid_pass
    ),
    array(
        'field' => 'email',
        'label' => 'Correo electrónico',
        'rules' => 'trim|required|valida_correo_electronico' //|callback_valid_pass
    ),
    array(
        'field' => 'pass',
        'label' => 'Contraseña',
        'rules' => 'required' //|callback_valid_pass
    ),
    array(
        'field' => 'repass',
        'label' => 'Confirmación contraseña',
        'rules' => 'required|matches[pass]'
    ),
    array(
        'field' => 'niveles',
        'label' => 'Niveles de Atencion',
        'rules' => 'required'
    )
);

$config['form_usuario_censo_finalizado'] = array(
    array(
        'field' => 'usuario',
        'label' => 'Usuario',
        'rules' => 'required|integer'
    )
);

$config['form_registro_usuario'] = array(
    array(
        'field' => 'matricula',
        'label' => 'Matrícula',
        'rules' => 'required|max_length[18]|alpha_dash'
    ),
    array(
        'field' => 'delegacion',
        'label' => 'Delegación',
        'rules' => 'required' //|callback_valid_pass
    ),
    array(
        'field' => 'email',
        'label' => 'Correo electrónico',
        'rules' => 'trim|required|valida_correo_electronico' //|callback_valid_pass
    ),
    array(
        'field' => 'pass',
        'label' => 'Contraseña',
        'rules' => 'required' //|callback_valid_pass
    ),
    array(
        'field' => 'repass',
        'label' => 'Confirmación contraseña',
        'rules' => 'required|matches[pass]'
    ),
    array(
        'field' => 'captcha',
        'label' => 'Captcha',
        'rules' => 'required|check_captcha'
    )
);

$config['nueva_convocatoria_censo'] = array(
    array(
        'field' => 'segmento',
        'label' => 'Segmento',
        'rules' => 'required'
    ),
    array(
        'field' => 'nombre',
        'label' => 'Nombre',
        'rules' => 'required'
    ),
    array(
        'field' => 'clave',
        'label' => 'Clave',
        'rules' => 'required'
    ),
    array(
        'field' => 'fecha_inicio_0',
        'label' => 'Fecha inicio de registro',
        'rules' => 'required'
    ),
    array(
        'field' => 'fecha_inicio_1',
        'label' => 'Fecha inicio de validación N1',
        'rules' => 'required'
    ),
    array(
        'field' => 'fecha_inicio_2',
        'label' => 'Fecha inicio de validación N2',
        'rules' => 'required'
    ),
    array(
        'field' => 'fecha_fin_0',
        'label' => 'Fecha fin de registro',
        'rules' => 'required'
    ),
    array(
        'field' => 'fecha_fin_1',
        'label' => 'Fecha fin de validación N1',
        'rules' => 'required'
    ),
    array(
        'field' => 'fecha_fin_2',
        'label' => 'Fecha fin de validación N2',
        'rules' => 'required'
    ),
);

$config['elemento_seccion'] = array(
        array(
            'field' => 'nombre',
            'label' => 'nombre',
            'rules' => 'required|not_space'
        ),
        array(
            'field' => 'id_seccion',
            'label' => 'id_seccion',
            'rules' => 'required'
        ),
        array(
            'field' => 'activo',
            'label' => 'activo',
            'rules' => 'required'
        ),
        array(
            'field' => 'label',
            'label' => 'label',
            'rules' => 'required'
        )
    );

$config['campos_formulario'] = array(
        array(
            'field' => 'id_campo',
            'label' => 'Campo',
            'rules' => 'required'
        ),
        array(
            'field' => 'orden',
            'label' => 'orden',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'display',
            'label' => 'display',
            'rules' => 'required'
        ),
        array(
            'field' => 'activo',
            'label' => 'activo',
            'rules' => 'required'
        ),
        array(
            'field' => 'nueva_linea',
            'label' => 'Nueva línea',
            'rules' => 'required'
        )
    );

$config['formulario'] = array(
        array(
            'field' => 'nombre',
            'label' => 'nombre',
            'rules' => 'required|not_space'
        ),
        array(
            'field' => 'label',
            'label' => 'etiqueta',
            'rules' => 'required'
        ),
        array(
            'field' => 'id_elemento_seccion',
            'label' => 'subsección',
            'rules' => 'required'
        ),
        array(
            'field' => 'activo',
            'label' => 'activo',
            'rules' => 'required'
        )
    );


// VALIDACIONES
/*
             * isset
             * valid_email
             * valid_url
             * min_length
             * max_length
             * exact_length
             * alpha
             * alpha_numeric
             * alpha_numeric_spaces
             * alpha_dash
             * numeric
             * is_numeric
             * integer
             * regex_match
             * matches
             * differs
             * is_unique
             * is_natural
             * is_natural_no_zero
             * decimal
             * less_than
             * less_than_equal_to
             * greater_than
             * greater_than_equal_to
             * in_list
             * validate_date_dd_mm_yyyy
             * validate_date
             * form_validation_match_date  la fecha debe ser mayor que ()
             *
             *
             *
             */


//custom validation

/*

alpha_accent_space_dot_quot
 *
alpha_numeric_accent_slash
 *
alpha_numeric_accent_space_dot_parent
 *
alpha_numeric_accent_space_dot_double_quot

*/

/*
*password_strong
*
*
*
*
*/

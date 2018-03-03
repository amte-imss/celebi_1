var memoria_datos_generales;
function obtiene_elementos_id(catalogo, fieldkey, fieldvalue, elemento_respuesta) {
    var resultado = [];
//    console.log(catalogo);
    Object.keys(catalogo).forEach(function (c, index) {
//    console.log(catalogo[c][fieldkey]);
//    console.log(fieldvalue
//    console.log(fieldkey);
        if (catalogo[c][fieldkey] == fieldvalue) {
            resultado.push(catalogo[c][elemento_respuesta]);
        }
    });
    return resultado;
}

function obtiene_elemento_datos(catalogo, fieldkey, fieldvalue) {
    var resultado = [];
//    console.log(catalogo);
    Object.keys(catalogo).forEach(function (c, index) {
//    console.log(catalogo[c][fieldkey]);
//    console.log(fieldvalue
//    console.log(fieldkey);
        if (catalogo[c][fieldkey] == fieldvalue) {
            resultado = catalogo[c];
            return resultado;
        }
    });
    return resultado;
}

function cambia_datos_curso(element) {
    var objeto_this = $(element);
//    var tipo_curso = obtiene_elementos_id(memoria_values['curso'], objeto_this.data('fieldkey'), objeto_this.val(), 'id_tipo_curso');
    carga_hijos_elemento_catalogo("tipo_curso", memoria_values['tipo_curso'], 'id_tipo_curso', objeto_this.data('fieldvalue'), '');
    if (objeto_this.val() == "") {
        $('#clave_curso').val("");
        $('#tipo_curso').val("");
        $('#reglas_tipo_curso').val("");
        $("#detalle_regla_curso").html("");
        $("#tipo_curso").prop('disabled', true);
        $("#reglas_tipo_curso").prop('disabled', true);
    } else {
        $('#clave_curso').val(objeto_this.val());
        $("#tipo_curso").prop('disabled', false);
        $("#reglas_tipo_curso").prop('disabled', false);
        if ($("#clave_implementacion").val().trim().length < 1) {
            $("#clave_implementacion").val(objeto_this.val());
        }
    }
}

function cambia_datos_tipo_curso(element) {
    var objeto_this = $(element);
    var regla_tipo_curso = obtiene_elementos_id(memoria_values['reglas_tipo_curso'], objeto_this.data('fieldkey'), objeto_this.val(), 'id_regla_tipo_curso');
//    console.log(regla_tipo_curso);
    carga_hijos_elemento_catalogo("reglas_tipo_curso", memoria_values['reglas_tipo_curso'], 'id_regla_tipo_curso', 'cupo_min_max', '', regla_tipo_curso);
    if (objeto_this.val() == "") {
        $('#reglas_tipo_curso').val("");
        $("#detalle_regla_curso").html("");
    }
}


function cambia_datos_reglas_tc(element) {
    var objeto_this = $(element);
    var regla_tipo_curso = obtiene_elemento_datos(memoria_values['reglas_tipo_curso'], objeto_this.data('fieldkey'), objeto_this.val());
    if (objeto_this.val() == "") {
        $("#detalle_regla_curso").html("");
    } else {
        $("#detalle_regla_curso").html(detalle_regla_curso(regla_tipo_curso));

    }
}
function detalle_regla_curso(regla_tipo_curso) {
    var texto = "Cupo minimo: " + regla_tipo_curso.cupo_min_alumnos + "\n" +
            "Cupo máximo: " + regla_tipo_curso.cupo_max_alumnos + "\n" +
            "Número de profesores titulares: " + regla_tipo_curso.num_profesores_titulares + "\n" +
            "Número de profesores adjuntos: " + regla_tipo_curso.num_profesores_adjuntos + "\n" +
            "Cupo minimo de alumnos: " + regla_tipo_curso.cupo_min_alumnos + "\n" +
            "Cupo máximo de alumnos: " + regla_tipo_curso.cupo_max_alumnos + "\n" +
            "Cantidad de horas minimas: " + regla_tipo_curso.horas_min + "\n" +
            "Cantidad de horas máximas: " + regla_tipo_curso.horas_max + "\n"
            ;
//    console.log(regla_tipo_curso);
    return "<p>" +
            "<b>" + texto + "</b>" +
            "</p>";
}

function control_checkbox_convocatoria(element) {
    if ($(element).data('idp') == "") {//es un papá
        $(".conectados").each(function () {
            if ($(this).data('idp') == $(element).data('id')) {
                $(this).prop('checked', $(element).prop("checked"));
            }
        });
    } else {//Es un hijo
        var seleccionado = true;
//        console.log(seleccionado);
        $(".conectados").each(function () {
            if ($(this).data('idp') == $(element).data('idp')) {//identifica hermanos
                seleccionado = ($(this).prop("checked") == seleccionado);
            }
            if ($(this).data('id') == $(element).data('idp')) {
                $(this).prop('checked', ($(element).prop("checked") && seleccionado));
            }
        });

    }
}

function carga_dependientes_dg() {
//    console.log(memoria_datos_generales)
//    datos_dependientes(memoria_datos_generales);
    console.log(memoria_datos_generales);
    $('.dependientes').each(function () {//recorre campos dependientes
        var name = $(this).attr('id');
//        console.log(name);
//        console.log(memoria_datos_generales[name]);
//        console.log("--");
        if (typeof memoria_datos_generales[name] !== 'undefined') {
//            selectItemByValue(name, memoria_datos_generales[name]);
            $("#" + name).val(memoria_datos_generales[name]);
            $("#" + name).trigger("onchange");
        }
    });
}
function carga_dependientes_convocatoria() {
//    console.log(memoria_datos_generales);
    if ((typeof memoria_datos_generales.categoria_convocada !== 'undefined') && (memoria_datos_generales.categoria_convocada.length > 0)) {
        var categoria_convocada = [];
        Object.keys(memoria_datos_generales.categoria_convocada).forEach(function (index) {
            categoria_convocada.push(memoria_datos_generales.categoria_convocada[index]['id_categoria']);
        });
        var padres = [];
        $(".conectados").each(function () {
            var comid = $(this).data('id');
            var comidpad = $(this).data('idp');
            if (categoria_convocada.indexOf(comid.toString()) > -1) {
                $(this).prop('checked', true);
                padres.push(comidpad);
            }
        });
        $(".conectados").each(function () {//Selecciona padres
            var comid = $(this).data('id');
            if (padres.indexOf(comid) > -1) {
                $(this).prop('checked', true);
            }
        });

    }

//function update_insert(element) {
//    var form = $(element).data("forminv");
//    var etapa = $("#etapa").val();
//    var dataSend = $("#" + form).serialize();
//    console.log(etapa);
////    console.log(dataSend);
//    $.ajax({
//        type: "POST",
//        url: site_url + "/implementaciones/registro/",
//        data: dataSend,
////        dataType: "json"
//    })
//            .done(function (result) {
//                console.log(result);
////                try {//Cacha el error
////                    var resp = $.parseJSON(result);
//                    $("#step"+etapa).html(result);
////                    $("#step"+etapa).html(result.msg);
//                    
////                } catch (e) {
////                    $("#step"+etapa).html(result);
////                }
//
//            });
//    
////    $.ajax({
////        type: "POST",
////        url: site_url + "/implementaciones/registro",
////        data: dataSend,
////        dataType: "json"
////    })
////            .done(function (result) {
////                console.log(result);
//////                console.log(result);
//////                try {//Cacha el error
////////                    var resp = $.parseJSON(result);
//////                    $("#alert_estado").show();
//////                    $("#alert_estado").html(result.msg);
//////                    limpia_class_alert('alert_estado', result.tp_msg);
//////                    if (result.tp_msg == 'success') {
//////                        $("#myModal_body").remove();
//////                        grid_implementaciones();//Actualiza grid
//////                    }
//////                } catch (e) {
//////                    $("#alert_estado").html('Ocurrio un error, por favor intentelo más tarde');
//////                    limpia_class_alert('alert_estado', "danger");
//////                    $("#alert_estado").show();
//////                }
////
////            });

}






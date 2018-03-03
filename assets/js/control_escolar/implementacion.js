var estados_implementacion;
var memoria_values;

$(document).ready(function () {

//    mostrar_loader();
//    ocultar_loader();
    grid_implementaciones();

});



function grid_implementaciones() {
    var name_fields = obtener_cabeceras_implementaciones();
    grid = $('#jsImplementaciones').jsGrid({
        height: "500px",
        width: "100%",
//        deleteConfirm: "¿Deseas eliminar este registro?",
        filtering: true,
        inserting: false,
        editing: false,
        sorting: false,
        selecting: false,
        paging: true,
        autoload: true,
        pageSize: 5,
        rowClick: function (args) {
            //console.log(args);
        },
        pageButtonCount: 5,
        pagerFormat: "Páginas: {pageIndex} de {pageCount}    {first} {prev} {pages} {next} {last}   Total: {itemCount}",
        pagePrevText: "Anterior",
        pageNextText: "Siguiente",
        pageFirstText: "Primero",
        pageLastText: "Último",
        pageNavigatorNextText: "...",
        pageNavigatorPrevText: "...",
        noDataContent: "No se encontraron datos",
        invalidMessage: "",
        loadMessage: "Por favor espere",
        onItemUpdating: function (args) {
        },
        onItemEditing: function (args) {
        },
        cancelEdit: function () {
        },
        controller: {
            loadData: function (filter) {
                //console.log(filter);
                var d = $.Deferred();
                //var result = null;

                $.ajax({
                    type: "GET",
                    url: site_url + "/implementaciones/listado",
                    data: filter,
                    dataType: "json"
                })
                        .done(function (result) {
                            console.log(result.estados_implementaciones);
                            estados_implementacion = result.estados_implementaciones;
                            var res = $.grep(result.data, function (registro) {
                                registro.acciones = get_acciones(registro.cve_estado_implementacion, estados_implementacion, registro.id_implementacion);
//                                return (!filter.contestada || (registro.contestada != null && (registro.contestada == filter.contestada)))
//                                        && (!filter.matricula_evaluado || (registro.matricula_evaluado !== null && registro.matricula_evaluado.toLowerCase().indexOf(filter.matricula_evaluado.toString().toLowerCase()) > -1))
//                                        ;
                                return true;
                            });
//                            d.resolve(result['data']);
                            d.resolve(res);
//                            calcula_ancho_grid('jsReporteEncuestas', 'jsgrid-header-cell');
                        });

                return d.promise();
            },
            updateItem: function (item) {
            }
        },
        fields: [
            {name: "activo", type: "checkbox", title: name_fields.activo, /*sorting: true*/},
            {name: "clave_implementacion", type: "text", title: name_fields.clave_implementacion, width: 70},
            {name: "clave_curso", type: "text", title: name_fields.clave_curso},
            {name: "nombre_curso", type: "text", title: name_fields.nombre_curso, width: 200},
            {name: "profesor_titular", type: "text", title: name_fields.profesor_titular, width: 200},
            {name: "estado_implementacion", type: "text", title: name_fields.estado_implementacion, width: 80},
            {name: "acciones", type: "div", title: name_fields.acciones, width: 70},
            {type: "control", editButton: false, deleteButton: false,
                searchModeButtonTooltip: "Cambiar a modo búsqueda", // tooltip of switching filtering/inserting button in inserting mode
                editButtonTooltip: "Editar", // tooltip of edit item button
                searchButtonTooltip: "Buscar", // tooltip of search button
                clearFilterButtonTooltip: "Limpiar filtros de búsqueda", // tooltip of clear filter button
                updateButtonTooltip: "Actualizar", // tooltip of update item button
                cancelEditButtonTooltip: "Cancelar", // tooltip of cancel editing button
            }
        ]
    });
//    $("#jsReporteEncuestas").jsGrid("option", "filtering", false);
}

function cambio_estado(elementos) {
    var estado = $(elementos).data("claveestado");
    var implementacion = $(elementos).data("implementacion");
    $('#myModal_content').html(get_modal_estados(estado, implementacion));
    $("#alert_estado").hide();

}

function actualiza_estado(elementos) {
    var claveestado = $(elementos).data("claveestado");
    var implementacion = $(elementos).data("implementacion");
    console.log(claveestado);
    console.log(implementacion);
    var filter = {
        implementacion: implementacion,
        tipo: claveestado
    };
    if (document.getElementById('observaciones_cancelado')) {
        var obs = document.getElementById('observaciones_cancelado').value;
        filter.observaciones = obs;
    }
//    var prop_estado = estados_implementacion[claveestado];
    $.ajax({
        type: "POST",
        url: site_url + "/implementaciones/cambiar_estado/",
        data: filter,
        dataType: "json"
    })
            .done(function (result) {
                console.log(result);
                try {//Cacha el error
//                    var resp = $.parseJSON(result);
                    $("#alert_estado").show();
                    $("#alert_estado").html(result.msg);
                    limpia_class_alert('alert_estado', result.tp_msg);
                    if (result.tp_msg == 'success') {
                        $("#myModal_body").remove();
                        grid_implementaciones();//Actualiza grid
                    }
                } catch (e) {
                    $("#alert_estado").html('Ocurrio un error, por favor intentelo más tarde');
                    limpia_class_alert('alert_estado', "danger");
                    $("#alert_estado").show();
                }

            });
//                            d.resolve(result['data']);

}

function limpia_class_alert(id, alert) {
    $('#' + id).removeClass('alert-danger').removeClass('alert-success').removeClass('alert-info').removeClass('alert-warning');
    $($('#' + id)).addClass('alert-' + alert);
}

function  get_modal_estados(estado, implementacion) {
    var prop_estado = estados_implementacion[estado];
    var observaciones = '';
    if (prop_estado.requiere_observaciones == 1) {
        observaciones = '<input type="textarea" id="observaciones_cancelado" name="observaciones_cancelado">'
    }

    return '<div class="modal-header">' +
            '<h5 class="modal-title" id="exampleModalLiveLabel">' + prop_estado.nombre + '</h5>' +
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
            '<span aria-hidden="true">×</span>' +
            '</button>' +
            '<div class="alert alert-success" id="alert_estado" role="alert">This is a secondary alert—check it out!</div>' +
            '</div>' +
            '<div class="modal-body" id=myModal_body>' +
            prop_estado.descripcion + '<br>' +
            observaciones +
            '</div>' +
            '<div class="modal-footer">' +
            '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>' +
            '<button type="button" class="btn btn-default" data-claveestado="' + estado + '" data-implementacion="' + implementacion + '" onclick="actualiza_estado(this);">Guardar</button>' +
            '</div>';
}


//function cambia_clave_estado(estados_implementacion) {
//    var transforma_estado = new Object();
//    for (var e in estados_implementacion) {
//        transforma_estado[estados_implementacion[e]["cve_estado_implementacion"]] = estados_implementacion[e];
//    }
//    return transforma_estado;
//}
function get_acciones(estado, estados_implementacion, implementacion) {
    var aux_estados = estados_implementacion[estado];
    var tmp_estados;
    var result = '';
    for (var f in aux_estados.transicion) {//Acciones de estado
        if (aux_estados.transicion[f] != "") {
            tmp_estados = estados_implementacion[aux_estados.transicion[f]];
//        result += '<a href="#" class="btn btn-default" title="' + tmp_estados.nombre + '"><i class="' + tmp_estados.icon + '" ></i></a>';
            result += '<button type="button" onclick="cambio_estado(this);" data-implementacion="' + implementacion + '" data-claveestado="' + tmp_estados.cve_estado_implementacion + '" data-toggle="modal" data-target="#myModal" title="' + tmp_estados.nombre + '"><i class="' + tmp_estados.icon + '" ></i></button>';
        }
    }
    if (aux_estados.is_editar == "1") {
        result += '<a href="#select_datos_curso" class="btn bg-teal btn-lg " data-toggle="tab" aria-expanded="false" onclick="carga_datos_implementacion(this);" data-cveimple="' + implementacion + '">' +
                '<i class="fas fa-plus fa-2x"></i></a>';
    }
    if (aux_estados.is_detalle == "1") {
    }
    if (aux_estados.is_asigna_alumnos == "1") {
    }

    return result;
}

function obtener_cabeceras_implementaciones() {
    var arr_header = {
        activo: 'Activo',
        clave_implementacion: 'Clave de curso',
        clave_curso: 'Nombre corto',
        nombre_curso: 'Nombre del curso',
        profesor_titular: 'Profesor titular',
        estado_implementacion: 'Estado',
        acciones: 'Acciones',
    }

    return arr_header;
}

function cabeceras_no_exportar() {
    var arr_header = {
        acciones: 'Acciones',
    }

    return arr_header;
}

/**
 * Detalle de curso 
 */
function carga_datos_implementacion(element) {
    var cve_imple = $(element).data("cveimple");
    
    var ruta = site_url + "/implementaciones/get_carga_implementacion/" + cve_imple;
    data_ajax(ruta, null, "#content_wizard");
}

/**
 * 
 * @param {type} catalogo_id 
 * @param {type} elemento_catalogo_padre_id
 * @param {type} dropdawn_resultado
 * @param {type} ruta
 * @returns {undefined}
 */
function carga_hijos_elemento_catalogo(dropdawn_resultado, listado, field_key, field_value, key_selecciona, elementos_dependientes) {

    var select = $('#' + dropdawn_resultado + " option");
    $.each(select, function (i, v) {
        if (i > 0) {
            var value = v.value;
            $('#' + dropdawn_resultado + " option[value=" + value + "]").remove();
        }
    });

    var opciones = "<option value=''>Seleccione</option>";
//    console.log(listado);
    for (var index in listado)
    {
        if (typeof elementos_dependientes === 'undefined') {
            if (listado.hasOwnProperty(index)) {
                var key = listado[index][field_key];
                var valor = listado[index][field_value];
                var sel = '';
//                console.log(key);
//                    alert(key_selecciona + " " + valor);
                if (key_selecciona != 'undefined' && key == key_selecciona) {
                    sel = 'selected="selected"';
                }
                opciones += '<option value="' + key + '"' + sel + '>' + valor + '</option>';
            }
        } else {
            if (elementos_dependientes.length > 0) {
                if (listado.hasOwnProperty(index)) {
                    var key = listado[index][field_key];
                    var valor = listado[index][field_value];
                    if (elementos_dependientes.indexOf(key) > -1) {//Valida que exista, si existe lo acepta
                        var sel = '';
//                    alert(key_selecciona + " " + valor);
                        if (key_selecciona != 'undefined' && key == key_selecciona) {
                            sel = 'selected="selected"';
                        }
                        opciones += '<option value="' + key + '"' + sel + '>' + valor + '</option>';
                    }
                }
            }
        }
    }
    $("#" + dropdawn_resultado).html(opciones);
}


function datos_dependientes(memoria_dependientes) {
    console.log(memoria_dependientes);
    $('.dependientes').each(function () {//recorre campos dependientes
        var name = $(this).attr('id');
        console.log(name);
        console.log(memoria_dependientes[name]);
        console.log("--");
        selectItemByValue(name, memoria_dependientes[name]);
    });

}
function datos_dependientes(memoria_dependientes) {

}

function exportar_implementaciones(element) {
    var namegrid = $(element).data('namegrid');
    var headers = remove_headers(obtener_cabeceras_implementaciones(), cabeceras_no_exportar());
//    var headers = obtener_cabeceras_implementaciones();
    export_xlsx_grid(namegrid, headers, 'cursos_cc', 'Cursos');
}
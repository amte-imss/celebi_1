//var activar_delegacion;
var resultado = null;

$(document).ready(function () {

    mostrar_loader();
    $('#modalidad').attr('disabled', true);
    $('#modalidad').append('<option value="">Selecciona una opción</option>');
    $('#area_enfoque').attr('disabled', true);
    $('#area_enfoque').append('<option value="">Selecciona una opción</option>');

    $('#boton_filtro').attr('disabled', true);
    display_config_options(false);

    $('.ditto-column').change(ditto_column_event);
    $('.modo-grid').change(ditto_modo);
    ditto_modo();
    $.ajax({
        url: site_url + '/rama_organica/get_lista_rama',
        type: "POST",
        dataType: "json"
    }).done(function (data) {
        lista_tipo_actividad = data['tipos_actividad'];
        lista_modalidad = data['modalidades'];
        lista_area_enfoque = data['areas_enfoque'];
        lista_delegacion = data['delegaciones'];
        delegaciones();

        $('#tipo_actividad').append('<option value="">Selecciona una opción</option>');
        $.each(lista_tipo_actividad, function (key, value) {
            $('#tipo_actividad').append('<option value="' + value['id_tipo_actividad'] + '">' + value['nombre_tipo_actividad'] + '</option>');
        });

        ocultar_loader();

        $('#tipo_actividad').on('change', function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            var tipo = $(this).val();
            mostrar_loader();
            $('#jsGrid').empty();
            display_config_options(false);

            if (tipo) {
                select_modalidad(tipo);
                $('#modalidad').attr('disabled', false);
            } else {
                $('#modalidad').attr('disabled', true);
                $('#modalidad').empty();
                $('#modalidad').append('<option value="">Selecciona una opción</option>');
            }
            $('#area_enfoque').attr('disabled', true);
            $('#area_enfoque').empty();
            $('#area_enfoque').append('<option value="">Selecciona una opción</option>');

            ocultar_loader();

        });

    }).fail(function (jqXHR, error, errorThrown) {
        console.log("error carga rama");
        console.log(jqXHR);
        console.log(error);
        console.log(errorThrown);
    });

    grid_cursos();

    $('#buscador_cursos').css('display', 'none');
    $('#form_filtro').css('display', 'none');

    $('.buscador_cursos_opciones').click(function () {
        //console.log($(this).val());
        $('#buscador_cursos').css('display', 'none');
        $('#form_filtro').css('display', 'none');
        $('#' + $(this).val()).css('display', 'initial');
        $("#area_cursos").jsGrid("refresh");
    })
});

function grid_cursos() {
    $.getJSON(site_url + '/rama_organica/lista_cursos', function (data) {
        var ditto_lista_cursos = data;
        var grid = $("#area_cursos").jsGrid({
            height: "400px",
            width: "100%",
            deleteButton: false,
            filtering: true,
            inserting: false,
            editing: false,
            sorting: true,
            selecting: false,
            autoload: true,
            pageSize: 5,
            paging: true,
            pageButtonCount: 3,
            pagerFormat: "Páginas: {first} {prev} {pages} {next} {last}    {pageIndex} de {pageCount}",
            pagePrevText: "Anterior",
            pageNextText: "Siguiente",
            pageFirstText: "Primero",
            pageLastText: "Último",
            pageNavigatorNextText: "...",
            pageNavigatorPrevText: "...",
            noDataContent: "No existe ningún registro",
            data: ditto_lista_cursos,
            controller: {
                loadData: function (filter) {
                    return $.grep(ditto_lista_cursos, function (curso) {
                        return (!filter.curso || curso.curso.toString().toLowerCase().indexOf(filter.curso.toString().toLowerCase()) > -1);
                    });
                }
            },
            fields: [
                {name: "curso", title: "Curso", type: "text", filtering: true, width: "35%"},
                {name: "id_tipo_actividad", type: "text", visible: false},
                {name: "nombre_tipo_actividad", title: "Tipo de actividad", type: "text", filtering: false, width: "15%"},
                {name: "id_modalidad", type: "text", visible: false},
                {name: "clave_modalidad", type: "text", visible: false},
                {name: "nombre_modalidad", title: "Modalidad", type: "text", filtering: false, width: "10%"},
                {name: "id_area_enfoque", type: "text", visible: false},
                {name: "nombre_area_enfoque", title: "Curso dirigido a", type: "text", filtering: false, width: "15%"},
                {name: "id_tipo_curso", type: "text", visible: false},
                {name: "clave_tipo_curso", type: "text", visible: false},
                {name: "clave_curso", title: "clave_curso", type: "text", visible: false},
                {name: "nombre_tipo_curso", title: "Tipo de curso", type: "text", filtering: false, width: "15%"},
                {name: "clave_curso", title: "clave_curso", type: "text", visible: false},
                {type: "control", editButton: false, deleteButton: false, width: "10%",
                    clearFilterButton: false, // show clear filter button
                    modeSwitchButton: false,
                    itemTemplate: function (value, item) {
                        //return '<input type="radio" name="curso_radio_select" onchange="get_info_cursos_aux(' + item.id_area_enfoque + ',' + item.id_tipo_curso  + ",'"+ item.clave_curso + "'" + ')">';
                        return '<a name="curso_radio_select" onclick="get_info_cursos_aux(' + item.id_area_enfoque + ',' + item.id_tipo_curso + ",'" + item.clave_curso + "'" + ')">Seleccionar</a>';
                    }
                }
            ]
        });
    });
}

function get_info_cursos_aux(area, tipo_curso, cve_curso) {
    mostrar_loader();
    get_info_cursos(area, tipo_curso, cve_curso);
    ocultar_loader();
}

function select_modalidad(tipo) {
    modalidad(tipo);
    $('#modalidad').empty();

    $('#modalidad').append('<option value="">Selecciona una opción</option>');
    $.each(opciones_modalidad, function (key, value) {
        $('#modalidad').append('<option value="' + value['id_modalidad'] + '">' + value['nombre_modalidad'] + '</option>');
    });

    $('#modalidad').on('change', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        var tipo = $(this).val();
        mostrar_loader();
        $('#jsGrid').empty();
        display_config_options(false);

        if (tipo) {
            select_area_enfoque(tipo);
            $('#area_enfoque').attr('disabled', false);
        } else {
            $('#area_enfoque').attr('disabled', true);
            $('#area_enfoque').empty();
            $('#area_enfoque').append('<option value="">Selecciona una opción</option>');
        }
        ocultar_loader();
    });

}

function select_area_enfoque(tipo) {
    area_enfoque(tipo);
    $('#area_enfoque').empty();

    $('#area_enfoque').append('<option value="">Selecciona una opción</option>');
    $.each(opciones_area_enfoque, function (key, value) {
        $('#area_enfoque').append('<option value="' + value['id_area_enfoque'] + '">' + value['nombre_area_enfoque'] + '</option>');
    });

    $('#area_enfoque').on('change', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        var area = $(this).val();
        if (area) {
            mostrar_loader();
            get_info_cursos(area, null, null);
            ocultar_loader();
        }
    });

}

function get_info_cursos(area, tipo_curso, cve_curso) {
    if (tipo_curso == null && cve_curso == null) {
        console.log('grid_docente');
        $.ajax({
            url: site_url + '/rama_organica/get_info_cursos/' + area,
            type: 'POST',
            dataType: 'json',
        }).done(function (data) {
            lista_tipo_curso = data['tipos_curso'];
            lista_curso = data['cursos'];
            lista_rol = data['roles'];
            tipos_curso(area);
            grid_docente(area);
            display_config_options(true);
        }).fail(function (jqXHR, error, errorThrown) {
            console.log("error carga rama");
            console.log(jqXHR);
            console.log(error);
            console.log(errorThrown);
        });
    } else {
        console.log('grid_docente2');
        $.ajax({
            url: site_url + '/rama_organica/get_info_curso/' + tipo_curso + '/' + cve_curso,
            type: 'POST',
            dataType: 'json',
        }).done(function (data) {
            lista_tipo_curso = data['tipos_curso'];
            lista_curso = data['cursos'];
            lista_rol = data['roles'];
            $('#collapseOne').collapse('hide');
            grid_docente2(area, tipo_curso, cve_curso);
            display_config_options(true);
        }).fail(function (jqXHR, error, errorThrown) {
            console.log("error carga rama");
            console.log(jqXHR);
            console.log(error);
            console.log(errorThrown);
        });
    }
}

function grid_docente(area) {
    var curso_edit_value = null;
    var curso_add_value = null;
    var rol_edit_value = null;
    var rol_add_value = null;
    var matricula_add_value = null;
    var matricula_edit_value = null;


    var nombre_value = "";
    var delegacion_value = null;
    var clave_unidad_value = null;
    var unidad_value = null;
    var clave_categoria_value = null;
    var categoria_value = null;

    opciones_curso = [];
    opciones_rol = [];


    var grid = $('#jsGrid').jsGrid({
        height: "800px",
        width: "100%",
        deleteConfirm: "¿Deseas eliminar este registro?",
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        selecting: false,
        paging: true,
        autoload: true,
        rowClick: function (args) {},
        pageLoading: true,
        pageSize: 5,
        pageButtonCount: 3,
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
            grid._lastPrevItemUpdate = args.previousItem;
        },
        controller: {
            loadData: function (filter) {
                //console.log(filter);
                var d = $.Deferred();
                //var result = null;

                $.ajax({
                    type: "GET",
                    url: site_url + "/docente/registros/lista/" + area,
                    data: filter,
                    dataType: "json"
                })
                        .done(function (result) {
                            //console.log(result);

                            d.resolve({
                                data: result['data'],
                                itemsCount: result['length'],
                            });

                        });

                return d.promise();
            },
            insertItem: function (item) {
                mostrar_loader();
                var di = $.Deferred();
                var datos_nuevos_registro = {
                    //matricula: item['matricula'],
                    matricula: matricula_add_value,
                    rol: rol_add_value,
                    curso: curso_add_value
                }

                $.ajax({
                    type: "POST",
                    url: site_url + "/docente/registros/insertar",
                    data: datos_nuevos_registro
                })
                        .done(function (json) {
                            console.log('success');
                            alert(json['message']);
                            grid.insertSuccess = json['success'];
                            di.resolve(json['data']);
                        })
                        .fail(function (jqXHR, error, errorThrown) {
                            console.log("error");
                            console.log(jqXHR);
                            console.log(error);
                            console.log(errorThrown);
                        });

                curso_add_value = '';
                rol_add_value = null;
                opciones_curso = [];
                opciones_rol = [];
                ocultar_loader();
                return di.promise();
            },
            updateItem: function (item) {
                var de = $.Deferred();
                var datos_nuevos_registro = {
                    id_registro_docente: item['id_registro_docente'],
                    matricula: matricula_edit_value,
                    //matricula: item['matricula'],
                    rol: rol_edit_value,
                    curso: curso_edit_value
                }

                $.ajax({
                    type: "POST",
                    url: site_url + "/docente/registros/editar",
                    data: datos_nuevos_registro
                })
                        .done(function (json) {
                            console.log('success');
                            alert(json['message']);
                            if (json['success']) {
                                de.resolve(json['data']);
                            } else {
                                de.resolve(grid._lastPrevItemUpdate);
                            }
                        })
                        .fail(function (jqXHR, error, errorThrown) {
                            console.log("error");
                            console.log(jqXHR);
                            console.log(error);
                            console.log(errorThrown);
                        });
                curso_edit_value = '';
                rol_edit_value = null;
                opciones_curso = [];
                opciones_rol = [];
                return de.promise();

            },
            deleteItem: function (item) {
                return $.ajax({
                    type: "POST",
                    url: site_url + "/docente/registros/eliminar/",
                    data: item
                });
            }
        },
        fields: [
            {name: "tipo_curso", title: "Tipo de Curso", align: "center",
                sorting: false,
                itemTemplate: function (value, item) {
                    return item['nombre_tipo_curso'];
                },
                insertTemplate: function (value) {
                    var cursoField = this._grid.fields[1];
                    var rolField = this._grid.fields[2];

                    select_tipo_curso_add = $("<select name='tipo_curso' id='tipo_curso'>");
                    select_tipo_curso_add.append("<option value=''>Selecciona un tipo de curso</option>");
                    $.each(opciones_tipo_curso, function (key, value) {
                        $(select_tipo_curso_add).append('<option value="' + value['id_tipo_curso'] + '">' + value['nombre_tipo_curso'] + '</option>');
                    });

                    $(select_tipo_curso_add).on('change', function () {
                        var tipo = $(this).val();
                        if (tipo != "") {
                            cursos(tipo);
                            roles(tipo);
                        } else {
                            opciones_curso = [];
                            opciones_rol = [];
                        }
                        curso_add_value = null;
                        rol_add_value = null;
                        $(".curso-insertcss").empty().append(cursoField.insertTemplate());
                        $(".rol-insertcss").empty().append(rolField.insertTemplate());
                    });
                    return select_tipo_curso_add;
                },
                insertValue: function () {
                    return $('#tipo_curso').val();
                },
                editTemplate: function (value, item) {
                    var cursoField = this._grid.fields[1];
                    var rolField = this._grid.fields[2];

                    select_tipo_curso_edit = $("<select name='tipo_curso' id='tipo_curso'>");
                    $.each(opciones_tipo_curso, function (key, value) {
                        if (item['id_tipo_curso'] == value['id_tipo_curso']) {
                            $(select_tipo_curso_edit).append('<option value="' + value['id_tipo_curso'] + '" selected>' + value['nombre_tipo_curso'] + '</option>');
                            cursos(item['id_tipo_curso']);
                            roles(item['id_tipo_curso']);
                        } else {
                            $(select_tipo_curso_edit).append('<option value="' + value['id_tipo_curso'] + '">' + value['nombre_tipo_curso'] + '</option>');
                        }
                    });

                    $(select_tipo_curso_edit).on('change', function () {
                        var tipo = $(this).val();
                        cursos(tipo);
                        curso_edit_value = opciones_curso[0]['clave_curso'];
                        roles(tipo);
                        rol_edit_value = opciones_rol[0]['id_rol_tipo_curso'];
                        $(".curso-editcss").empty().append(cursoField.editTemplate());
                        $(".rol-editcss").empty().append(rolField.editTemplate());
                    });
                    return select_tipo_curso_edit;
                },
                filterTemplate: function () {
                    var cursoField = this._grid.fields[1];
                    var rolField = this._grid.fields[2];

                    select_tipo_curso_filter = $("<select name='tipo_curso' id='tipo_curso'>");
                    select_tipo_curso_filter.append("<option value=''>Selecciona un tipo de curso</option>");
                    $.each(opciones_tipo_curso, function (key, value) {
                        $(select_tipo_curso_filter).append('<option value="' + value['id_tipo_curso'] + '">' + value['nombre_tipo_curso'] + '</option>');
                    });

                    if ($(select_tipo_curso_filter).val() == "") {
                        opciones_curso = [];
                        opciones_rol = [];
                    }

                    $(select_tipo_curso_filter).on('change', function () {
                        var tipo = $(this).val();
                        if (tipo != "") {
                            cursos(tipo);
                            roles(tipo);
                        } else {
                            opciones_curso = [];
                            opciones_rol = [];
                        }
                        $(".curso-filtercss").empty().append(cursoField.filterTemplate());
                        $(".rol-filtercss").empty().append(rolField.filterTemplate());
                    });

                    return select_tipo_curso_filter;
                },
                filterValue: function () {
                    return $('#tipo_curso').val();
                }
            },
            {name: "curso", title: "Curso", align: "center",
                insertcss: "curso-insertcss",
                editcss: "curso-editcss",
                filtercss: "curso-filtercss",
                sorting: false,
                itemTemplate: function (value, item) {
                    return item['nombre_curso'];
                },
                insertTemplate: function (value) {
                    select_curso_add = $("<select name='curso' id='curso' disabled>");
                    select_curso_add.append("<option value=''>Selecciona un curso</option>");
                    if (opciones_curso.length > 0) {
                        $.each(opciones_curso, function (key, value) {
                            $(select_curso_add).append('<option value="' + value['clave_curso'] + '">' + value['nombre_curso'] + '</option>');
                        });
                        $(select_curso_add).attr('disabled', false);
                    }
                    $(select_curso_add).on('change', function () {
                        curso_add_value = $(this).val();
                    });
                    return select_curso_add;
                },
                editTemplate: function (value, item) {
                    select_curso_edit = $("<select name='curso' id='curso'>");
                    $.each(opciones_curso, function (key, value) {
                        if (typeof item != 'undefined') {
                            if (value['clave_curso'] == item['clave_curso']) {
                                curso_edit_value = item['clave_curso'];
                                $(select_curso_edit).append('<option value="' + value['clave_curso'] + '" selected>' + value['nombre_curso'] + '</option>');
                            } else {
                                $(select_curso_edit).append('<option value="' + value['clave_curso'] + '">' + value['nombre_curso'] + '</option>');
                            }
                        } else {
                            $(select_curso_edit).append('<option value="' + value['clave_curso'] + '">' + value['nombre_curso'] + '</option>');
                        }

                    });
                    $(select_curso_edit).on('change', function () {
                        curso_edit_value = $(this).val();
                    });
                    return select_curso_edit;
                },
                filterTemplate: function (value) {
                    select_curso_filter = $("<select name='curso' id='curso' disabled>");
                    select_curso_filter.append("<option value=''>Selecciona un curso</option>");
                    if (opciones_curso.length > 0) {
                        $.each(opciones_curso, function (key, value) {
                            $(select_curso_filter).append('<option value="' + value['clave_curso'] + '">' + value['nombre_curso'] + '</option>');
                        });
                        $(select_curso_filter).attr('disabled', false);
                    }
                    return select_curso_filter;
                },
                filterValue: function (argument) {
                    return $('#curso').val();
                },
                validate: {
                    message: "El campo curso es obligatorio, por favor seleccione una opción",
                    validator: function (value) {
                        var add = (curso_add_value != null) && (curso_add_value != '');
                        var edit = (curso_edit_value != null) && (curso_edit_value != '');
                        return add || edit;
                    }
                }
            },
            {name: "rol", title: "Rol", align: "center",
                insertcss: "rol-insertcss",
                editcss: "rol-editcss",
                filtercss: "rol-filtercss",
                sorting: false,
                itemTemplate: function (value, item) {
                    return rol_nombre(item['id_rol']);
                },
                insertTemplate: function (value) {
                    select_rol_add = $("<select name='rol' id='rol' disabled>");
                    select_rol_add.append("<option value=''>Selecciona un rol</option>");
                    if (opciones_rol.length > 0) {
                        $.each(opciones_rol, function (key, value) {
                            $(select_rol_add).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
                        });
                        $(select_rol_add).attr('disabled', false);
                    }
                    $(select_rol_add).on('change', function () {
                        rol_add_value = $(this).val();
                    });
                    return select_rol_add;
                },
                editTemplate: function (value, item) {
                    select_rol_edit = $("<select name='rol' id='rol'>");
                    $.each(opciones_rol, function (key, value) {
                        if (typeof item != 'undefined') {
                            if (value['id_rol_tipo_curso'] == item['id_rol']) {
                                rol_edit_value = item['id_rol'];
                                $(select_rol_edit).append('<option value="' + value['id_rol_tipo_curso'] + '" selected>' + value['nombre_rol'] + '</option>');
                            } else {
                                $(select_rol_edit).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
                            }
                        } else {
                            $(select_rol_edit).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
                        }

                    });
                    $(select_rol_edit).on('change', function () {
                        rol_edit_value = $(this).val();
                    });
                    return select_rol_edit;
                },
                filterTemplate: function (value) {
                    select_rol_filter = $("<select name='rol' id='rol' disabled>");
                    select_rol_filter.append("<option value=''>Selecciona un rol</option>");
                    if (opciones_rol.length > 0) {
                        $.each(opciones_rol, function (key, value) {
                            $(select_rol_filter).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
                        });
                        $(select_rol_filter).attr('disabled', false);
                    }
                    return select_rol_filter;
                },
                filterValue: function (argument) {
                    return $('#rol').val();
                },
                validate: {
                    message: "El campo rol es obligatorio, por favor seleccione una opción",
                    validator: function (value) {
                        var add = (rol_add_value != null) && (rol_add_value != '');
                        var edit = (rol_edit_value != null) && (rol_edit_value != '');
                        return add || edit;
                    }
                }
            },
                        {name: "matricula", title: "Matrícula", align: "center",
                itemTemplate: function (value, item) {
                    return item['matricula'];
                },
                insertValue: function () {
                    matricula_add_value = $('#matricula').val();
                    return matricula_add_value;
                },
                insertTemplate: function (value) {
                    var nombreFields = this._grid.fields[4];
                    var delegacionFields = this._grid.fields[5];
                    var claveUnidadFields = this._grid.fields[6];
                    var unidadFields = this._grid.fields[7];
                    var claveCategoriaFields = this._grid.fields[8];
                    var categoriaFields = this._grid.fields[9];

                    input_matricula = $("<input id='matricula' name='matricula' type='text'>");


                    $(input_matricula).keypress(function (event) {
                        if (event.which == 13) {
                            matricula_add_value = $(this).val();

                            var di = $.Deferred();

                            $.ajax({
                                url: site_url + '/docente/docente/' + matricula_add_value,
                                type: 'GET',
                                dataType: 'json',
                            })
                                    .done(function (json) {
                                        console.log("success");
                                        di.resolve(json);
                                        if (json['success']) {
                                            resultado = json['data'];

                                            nombre_value = resultado['nombre_completo'];
                                            delegacion_value = resultado['delegacion'];
                                            clave_unidad_value = resultado['clave_unidad'];
                                            unidad_value = resultado['unidad'];
                                            clave_categoria_value = resultado['clave_categoria'];
                                            categoria_value = resultado['categoria'];

                                        } else {
                                            alert("No existe algún docente registrado con la matrícula " + matricula_add_value);
                                            resultado = null;

                                            nombre_value = "";
                                            delegacion_value = "";
                                            clave_unidad_value = "";
                                            unidad_value = "";
                                            clave_categoria_value = "";
                                            categoria_value = "";
                                        }
                                        $(".nombre-insertcss").empty().append(nombreFields.insertTemplate(nombre_value));
                                        $(".delegacion-insertcss").empty().append(delegacionFields.insertTemplate(delegacion_value));
                                        $(".clave-unidad-insertcss").empty().append(claveUnidadFields.insertTemplate(clave_unidad_value));
                                        $(".unidad-insertcss").empty().append(unidadFields.insertTemplate(unidad_value));
                                        $(".clave-categoria-insertcss").empty().append(claveCategoriaFields.insertTemplate(clave_categoria_value));
                                        $(".categoria-insertcss").empty().append(categoriaFields.insertTemplate(categoria_value));
                                    })
                                    .fail(function () {
                                        console.log("error");
                                        resultado = null;
                                    })
                                    .always(function () {
                                        console.log("complete");
                                        monitor = true;
                                    });
                        }
                    });
                    /*
                     $(input_matricula).focusout(function(event){
                     if(!monitor){
                     matricula_add_value = $(this).val();

                     var di = $.Deferred();

                     $.ajax({
                     url: site_url + '/docente/docente/' + matricula_add_value,
                     type: 'GET',
                     dataType: 'json',
                     })
                     .done(function(json) {
                     console.log("success");
                     di.resolve(json);
                     if(json['success']){
                     resultado = json['data'];

                     nombre_value = resultado['nombre_completo'];
                     delegacion_value = resultado['delegacion'];
                     clave_unidad_value = resultado['clave_unidad'];
                     unidad_value = resultado['unidad'];
                     clave_categoria_value = resultado['clave_categoria'];
                     categoria_value = resultado['categoria'];

                     }else{
                     alert("No existe algún docente registrado con la matrícula " + matricula_add_value);
                     resultado = null;

                     nombre_value = "";
                     delegacion_value = "";
                     clave_unidad_value = "";
                     unidad_value = "";
                     clave_categoria_value = "";
                     categoria_value = "";
                     }
                     $(".nombre-insertcss").empty().append(nombreFields.insertTemplate(nombre_value));
                     $(".delegacion-insertcss").empty().append(delegacionFields.insertTemplate(delegacion_value));
                     $(".clave-unidad-insertcss").empty().append(claveUnidadFields.insertTemplate(clave_unidad_value));
                     $(".unidad-insertcss").empty().append(unidadFields.insertTemplate(unidad_value));
                     $(".clave-categoria-insertcss").empty().append(claveCategoriaFields.insertTemplate(clave_categoria_value));
                     $(".categoria-insertcss").empty().append(categoriaFields.insertTemplate(categoria_value));
                     })
                     .fail(function() {
                     console.log("error");
                     resultado = null;
                     })
                     .always(function() {
                     console.log("complete");
                     monitor = true;
                     });
                     }
                     });
                     */

                    return input_matricula;
                },
                editTemplate: function (value, item) {
                    matricula_edit_value = value;

                    var nombreFields = this._grid.fields[4];
                    var delegacionFields = this._grid.fields[5];
                    var claveUnidadFields = this._grid.fields[6];
                    var unidadFields = this._grid.fields[7];
                    var claveCategoriaFields = this._grid.fields[8];
                    var categoriaFields = this._grid.fields[9];

                    console.log(delegacionFields);
                    input_matricula = $("<input id='matricula' name='matricula' type='text' value='" + matricula_edit_value + "'>");

                    $(input_matricula).keypress(function (event) {
                        if (event.which == 13) {
                            matricula_edit_value = $(this).val();

                            var di = $.Deferred();

                            $.ajax({
                                url: site_url + '/docente/docente/' + matricula_edit_value,
                                type: 'GET',
                                dataType: 'json',
                            })
                                    .done(function (json) {
                                        console.log("success");
                                        di.resolve(json);
                                        if (json['success']) {
                                            resultado = json['data'];

                                            nombre_value = resultado['nombre_completo'];
                                            delegacion_value = resultado['delegacion'];
                                            clave_unidad_value = resultado['clave_unidad'];
                                            unidad_value = resultado['unidad'];
                                            clave_categoria_value = resultado['clave_categoria'];
                                            categoria_value = resultado['categoria'];

                                        } else {
                                            alert("No existe algún docente registrado con la matrícula " + matricula_edit_value);
                                            resultado = null;

                                            nombre_value = "";
                                            delegacion_value = "";
                                            clave_unidad_value = "";
                                            unidad_value = "";
                                            clave_categoria_value = "";
                                            categoria_value = "";
                                        }
                                        $(".nombre-editcss").empty().append(nombreFields.editTemplate(nombre_value));
                                        $(".delegacion-editcss").empty().append(delegacionFields.editTemplate(delegacion_value));
                                        $(".clave-unidad-editcss").empty().append(claveUnidadFields.editTemplate(clave_unidad_value));
                                        $(".unidad-editcss").empty().append(unidadFields.editTemplate(unidad_value));
                                        $(".clave-categoria-editcss").empty().append(claveCategoriaFields.editTemplate(clave_categoria_value));
                                        $(".categoria-editcss").empty().append(categoriaFields.editTemplate(categoria_value));
                                    })
                                    .fail(function () {
                                        console.log("error");
                                        resultado = null;
                                    })
                                    .always(function () {
                                        console.log("complete");
                                    });
                        }
                    });

                    /*
                     $(input_matricula).focusout(function(event){
                     matricula_edit_value = $(this).val();

                     var di = $.Deferred();

                     $.ajax({
                     url: site_url + '/docente/docente/' + matricula_edit_value,
                     type: 'GET',
                     dataType: 'json',
                     })
                     .done(function(json) {
                     console.log("success");
                     di.resolve(json);
                     if(json['success']){
                     resultado = json['data'];

                     nombre_value = resultado['nombre_completo'];
                     delegacion_value = resultado['delegacion'];
                     clave_unidad_value = resultado['clave_unidad'];
                     unidad_value = resultado['unidad'];
                     clave_categoria_value = resultado['clave_categoria'];
                     categoria_value = resultado['categoria'];

                     }else{
                     alert("No existe algún docente registrado con la matrícula " + matricula_edit_value);
                     resultado = null;

                     nombre_value = "";
                     delegacion_value = "";
                     clave_unidad_value = "";
                     unidad_value = "";
                     clave_categoria_value = "";
                     categoria_value = "";
                     }
                     $(".nombre-editcss").empty().append(nombreFields.editTemplate(nombre_value));
                     $(".delegacion-editcss").empty().append(delegacionFields.editTemplate(delegacion_value));
                     $(".clave-unidad-editcss").empty().append(claveUnidadFields.editTemplate(clave_unidad_value));
                     $(".unidad-editcss").empty().append(unidadFields.editTemplate(unidad_value));
                     $(".clave-categoria-editcss").empty().append(claveCategoriaFields.editTemplate(clave_categoria_value));
                     $(".categoria-editcss").empty().append(categoriaFields.editTemplate(categoria_value));
                     })
                     .fail(function() {
                     console.log("error");
                     resultado = null;
                     })
                     .always(function() {
                     console.log("complete");
                     });
                     });
                     */
                    return input_matricula;
                },
                filterTemplate: function () {
                    return  $("<input id='matricula_' name='matricula_' type='text'>");
                },
                filterValue: function () {
                    return $('#matricula_').val();
                },
                /*
                 validate:{
                 validator: "required",
                 message: function (value, item) {
                 return "El campo matrícula es obligatorio, por favor ingreselo.";
                 }

                 }*/
                validate: {
                    message: "El campo matrícula es obligatorio, por favor ingreselo.",
                    validator: function (value) {
                        var add = (matricula_add_value != null) && (matricula_add_value != '');
                        var edit = (matricula_edit_value != null) && (matricula_edit_value != '');
                        return add || edit;
                    }
                }
            },
            {name: "nombre_completo", title: "Nombre", align: "center", type: "text",
                inserting: true, editing: false,
                insertcss: "nombre-insertcss",
                editcss: "nombre-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return value;
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return value;
                }
            },
            {name: "delegacion", title: "Delegación", type: "select", align: "center",
                items: opciones_delegaciones, valueField: "clave_delegacional", textField: "nombre",
                inserting: false, editing: false,
                insertcss: "delegacion-insertcss",
                editcss: "delegacion-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return nombre_delegacion(value);
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return nombre_delegacion(value);
                }
            },
            {name: "clave_unidad", title: "Clave de unidad", align: "center", type: "text", inserting: false, editing: false,
                insertcss: "clave-unidad-insertcss",
                editcss: "clave-unidad-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return value;
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return value;
                }
            },
            {name: "unidad", title: "Unidad", align: "center", type: "text", inserting: false, editing: false,
                insertcss: "unidad-insertcss",
                editcss: "unidad-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return value;
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return value;
                }
            },
            {name: "clave_categoria", title: "Clave de categoría", align: "center", type: "text", inserting: false, editing: false,
                insertcss: "clave-categoria-insertcss",
                editcss: "clave-categoria-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return value;
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return value;
                }
            },
            {name: "categoria", title: "Categoría", align: "center", type: "text", inserting: false, editing: false,
                insertcss: "categoria-insertcss",
                editcss: "categoria-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return value;
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return value;
                }
            },
            {type: "control", editButton: true, deleteButton: true, modeSwitchButton: false,
                searchModeButtonTooltip: "Cambiar a modo búsqueda", // tooltip of switching filtering/inserting button in inserting mode
                insertModeButtonTooltip: "Cambiar a insertar", // tooltip of switching filtering/inserting button in filtering mode
                editButtonTooltip: "Editar", // tooltip of edit item button
                deleteButtonTooltip: "Eliminar", // tooltip of delete item button
                searchButtonTooltip: "Buscar", // tooltip of search button
                clearFilterButtonTooltip: "Limpiar filtros de búsqueda", // tooltip of clear filter button
                insertButtonTooltip: "Agregar", // tooltip of insert button
                updateButtonTooltip: "Actualizar", // tooltip of update item button
                cancelEditButtonTooltip: "Cancelar", // tooltip of cancel editing button
            }
        ]
    }).data("JSGrid");

    var origFinishInsert = jsGrid.loadStrategies.DirectLoadingStrategy.prototype.finishInsert;
    jsGrid.loadStrategies.DirectLoadingStrategy.prototype.finishInsert = function (insertedItem) {
        if (!this._grid.insertSuccess) { // define insertFailed on done of delete ajax request in insertFailed of controller
            return;
        }
        origFinishInsert.apply(this, arguments);
    }
    $("#jsGrid").jsGrid("option", "filtering", true);

    var modo = $("input[type='radio'][name='modo-grid']:checked").attr('data-mode');
    if (modo == 'buscar') {
        $("#jsGrid").jsGrid("option", "inserting", false);
        $("#jsGrid").jsGrid("option", "filtering", true);
    } else {
        $("#jsGrid").jsGrid("option", "filtering", false);
        $("#jsGrid").jsGrid("option", "inserting", true);
    }

}

function ditto_column_event() {
    var data_id = $(this).attr('data-id');
    var status = $(this).is(':checked');
    $("#jsGrid").jsGrid("fieldOption", data_id, "visible", status);
}


function ditto_modo() {
    var modo = $(this).attr('data-mode');
    if (modo == 'buscar') {
        $("#jsGrid").jsGrid("option", "inserting", false);
        $("#jsGrid").jsGrid("option", "filtering", true);
        $('#ditto-config-instrucciones').html('<p>Al crear un nuevo registro, seleccione el  tipo de curso, curso y rol según sea el caso, posteriormente ingrese la matrícula del profesor y oprima la tecla "Enter" de su teclado para rellenar de forma automática el resto de la información.</p>');
    } else {
        $("#jsGrid").jsGrid("option", "filtering", false);
        $("#jsGrid").jsGrid("option", "inserting", true);
        //$('#ditto-config-instrucciones').html('<p>Al editar o crear un nuevo registro, ingrese la matrícula del profesor y oprima la tecla “Enter” de su teclado para rellenar de forma automática el resto de información.</p>');
        $('#ditto-config-instrucciones').html('<p>Al crear un nuevo registro, seleccione el  tipo de curso, curso y rol según sea el caso, posteriormente ingrese la matrícula del profesor y oprima la tecla "Enter" de su teclado para rellenar de forma automática el resto de la información.</p>');
    }
}

function display_config_options(accion) {
    /*
     $('#ditto-config-modo').html('');
     $('#ditto-config-columnas').html('');

     var str = '<h4>Selecciona una acción</h4>';
     str += '<form>';
     str += '<label><input type="radio" name="modo-grid" class="modo-grid" data-mode="buscar" checked>Buscar</label>';
     str += '<label><input type="radio" name="modo-grid" class="modo-grid" data-mode="insertar">Insertar</label>';
     str += '</form>';
     $('#ditto-config-modo').html(str);

     var str2 = '<h4>Mostrar/Ocultar columnas</h4>';
     str2 += '<div class="config-panel">';
     str2 += '<label><input class="ditto-column" data-id="nombre_completo" checked="" type="checkbox"> Nombre </label>';
     str2 += '<label><input class="ditto-column" data-id="delegacion" checked="" type="checkbox">  Delegacion </label>';
     str2 += '<label><input class="ditto-column" data-id="clave_unidad" checked="" type="checkbox">  Clave unidad </label>';
     str2 += '<label><input class="ditto-column" data-id="unidad" checked="" type="checkbox"> Unidad </label>';
     str2 += '<label><input class="ditto-column" data-id="clave_categoria" checked="" type="checkbox"> Clave categoría </label>';
     str2 += '<label><input class="ditto-column" data-id="categoria" checked="" type="checkbox"> Categoría </label>';
     str2 += '</div>';

     $('#ditto-config-columnas').html(str2);
     */
    if (accion) {//Buscar
        $('#ditto-config-columnas').css({"display": "block"});
        $('#ditto-config-modo').css({"display": "block"});
        $('#ditto-config-instrucciones').css({"display": "block"});
    } else {//Insertar
        $('#ditto-config-columnas').css({"display": "none"});
        $('#ditto-config-modo').css({"display": "none"});
        $('#ditto-config-instrucciones').css({"display": "none"});
    }

}

function grid_docente2(area, tipo_curso, cve_curso) {

    var rol_edit_value = null;
    var rol_add_value = null;
    var matricula_add_value = null;
    var matricula_edit_value = null;


    var nombre_value = "";
    var delegacion_value = null;
    var clave_unidad_value = null;
    var unidad_value = null;
    var clave_categoria_value = null;
    var categoria_value = null;

    roles(tipo_curso);

    var grid = $('#jsGrid').jsGrid({
        height: "800px",
        width: "100%",
        deleteConfirm: "¿Deseas eliminar este registro?",
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        selecting: false,
        paging: true,
        autoload: true,
        rowClick: function (args) {},
        pageLoading: true,
        pageSize: 5,
        pageButtonCount: 3,
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
            grid._lastPrevItemUpdate = args.previousItem;
        },
        controller: {
            loadData: function (filter) {
                //console.log(filter);
                var d = $.Deferred();
                //var result = null;

                $.ajax({
                    type: "GET",
                    url: site_url + "/docente/registros_curso/lista/" + cve_curso,
                    data: filter,
                    dataType: "json"
                })
                        .done(function (result) {
                            //console.log(result);

                            d.resolve({
                                data: result['data'],
                                itemsCount: result['length'],
                            });

                            calcula_ancho_grid('jsGrid', 'jsgrid-header-cell');
                        });

                return d.promise();
            },
            insertItem: function (item) {
                mostrar_loader();
                var di = $.Deferred();
                var datos_nuevos_registro = {
                    //matricula: item['matricula'],
                    matricula: matricula_add_value,
                    rol: rol_add_value,
                    curso: cve_curso
                }

                $.ajax({
                    type: "POST",
                    url: site_url + "/docente/registros/insertar",
                    data: datos_nuevos_registro
                })
                        .done(function (json) {
                            console.log('success');
                            alert(json['message']);
                            grid.insertSuccess = json['success'];
                            di.resolve(json['data']);
                            calcula_ancho_grid('jsGrid', 'jsgrid-header-cell');

                        })
                        .fail(function (jqXHR, error, errorThrown) {
                            console.log("error");
                            console.log(jqXHR);
                            console.log(error);
                            console.log(errorThrown);
                        });

                rol_add_value = null;
                ocultar_loader();
                return di.promise();
            },
            updateItem: function (item) {
                var de = $.Deferred();
                var datos_nuevos_registro = {
                    id_registro_docente: item['id_registro_docente'],
                    matricula: matricula_edit_value,
                    //matricula: item['matricula'],
                    rol: rol_edit_value,
                    curso: cve_curso
                }

                $.ajax({
                    type: "POST",
                    url: site_url + "/docente/registros/editar",
                    data: datos_nuevos_registro
                })
                        .done(function (json) {
                            console.log('success');
                            alert(json['message']);
                            if (json['success']) {
                                de.resolve(json['data']);
                            } else {
                                de.resolve(grid._lastPrevItemUpdate);
                            }
                        })
                        .fail(function (jqXHR, error, errorThrown) {
                            console.log("error");
                            console.log(jqXHR);
                            console.log(error);
                            console.log(errorThrown);
                        });
                rol_edit_value = null;
                return de.promise();

            },
            deleteItem: function (item) {
                return $.ajax({
                    type: "POST",
                    url: site_url + "/docente/registros/eliminar/",
                    data: item
                });
            }
        },
        fields: [
            {name: "tipo_curso", title: "Tipo de Curso", align: "center",
                sorting: false, editing: false, filtering: false, inserting: false,
                itemTemplate: function (value, item) {
                    return item['nombre_tipo_curso'];
                },
                insertTemplate: function (value) {
                    return lista_tipo_curso[0]['nombre_tipo_curso'];
                },
                editTemplate: function () {
                    return lista_tipo_curso[0]['nombre_tipo_curso'];
                }
            },
            {name: "curso", title: "Curso", align: "center",
                sorting: false, editing: false, filtering: false, inserting: false,
                itemTemplate: function (value, item) {
                    return item['nombre_curso'];
                },
                insertTemplate: function (value) {
                    return lista_curso[0]['nombre_curso'];
                },
                editTemplate: function () {
                    return lista_curso[0]['nombre_curso'];
                }
            },
            {name: "rol", title: "Rol", align: "center",
                sorting: false,
                itemTemplate: function (value, item) {
                    return rol_nombre(item['id_rol']);
                },
                insertTemplate: function (value) {
                    select_rol_add = $("<select name='rol' id='rol' disabled>");
                    select_rol_add.append("<option value=''>Selecciona un rol</option>");
                    if (opciones_rol.length > 0) {
                        $.each(opciones_rol, function (key, value) {
                            $(select_rol_add).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
                        });
                        $(select_rol_add).attr('disabled', false);
                    }
                    $(select_rol_add).on('change', function () {
                        rol_add_value = $(this).val();
                    });
                    return select_rol_add;
                },
                editTemplate: function (value, item) {
                    select_rol_edit = $("<select name='rol' id='rol'>");
                    $.each(opciones_rol, function (key, value) {
                        if (typeof item != 'undefined') {
                            if (value['id_rol_tipo_curso'] == item['id_rol']) {
                                rol_edit_value = item['id_rol'];
                                $(select_rol_edit).append('<option value="' + value['id_rol_tipo_curso'] + '" selected>' + value['nombre_rol'] + '</option>');
                            } else {
                                $(select_rol_edit).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
                            }
                        } else {
                            $(select_rol_edit).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
                        }

                    });
                    $(select_rol_edit).on('change', function () {
                        rol_edit_value = $(this).val();
                    });
                    return select_rol_edit;
                },
                filterTemplate: function (value) {
                    select_rol_filter = $("<select name='rol' id='rol' disabled>");
                    select_rol_filter.append("<option value=''>Selecciona un rol</option>");
                    if (opciones_rol.length > 0) {
                        $.each(opciones_rol, function (key, value) {
                            $(select_rol_filter).append('<option value="' + value['id_rol_tipo_curso'] + '">' + value['nombre_rol'] + '</option>');
                        });
                        $(select_rol_filter).attr('disabled', false);
                    }
                    return select_rol_filter;
                },
                filterValue: function (argument) {
                    return $('#rol').val();
                },
                validate: {
                    message: "El campo rol es obligatorio, por favor seleccione una opción",
                    validator: function (value) {
                        var add = (rol_add_value != null) && (rol_add_value != '');
                        var edit = (rol_edit_value != null) && (rol_edit_value != '');
                        return add || edit;
                    }
                }
            },
            {name: "matricula", title: "Matrícula", align: "center",
                itemTemplate: function (value, item) {
                    return item['matricula'];
                },
                insertValue: function () {
                    matricula_add_value = $('#matricula').val();
                    return matricula_add_value;
                },
                insertTemplate: function (value) {
                    var nombreFields = this._grid.fields[4];
                    var delegacionFields = this._grid.fields[5];
                    var claveUnidadFields = this._grid.fields[6];
                    var unidadFields = this._grid.fields[7];
                    var claveCategoriaFields = this._grid.fields[8];
                    var categoriaFields = this._grid.fields[9];

                    input_matricula = $("<input id='matricula' name='matricula' type='text'>");


                    $(input_matricula).keypress(function (event) {
                        if (event.which == 13) {
                            matricula_add_value = $(this).val();

                            var di = $.Deferred();

                            $.ajax({
                                url: site_url + '/docente/docente/' + matricula_add_value,
                                type: 'GET',
                                dataType: 'json',
                            })
                                    .done(function (json) {
                                        console.log("success");
                                        di.resolve(json);
                                        if (json['success']) {
                                            resultado = json['data'];

                                            nombre_value = resultado['nombre_completo'];
                                            delegacion_value = resultado['delegacion'];
                                            clave_unidad_value = resultado['clave_unidad'];
                                            unidad_value = resultado['unidad'];
                                            clave_categoria_value = resultado['clave_categoria'];
                                            categoria_value = resultado['categoria'];

                                        } else {
                                            alert("No existe algún docente registrado con la matrícula " + matricula_add_value);
                                            resultado = null;

                                            nombre_value = "";
                                            delegacion_value = "";
                                            clave_unidad_value = "";
                                            unidad_value = "";
                                            clave_categoria_value = "";
                                            categoria_value = "";
                                        }
                                        $(".nombre-insertcss").empty().append(nombreFields.insertTemplate(nombre_value));
                                        $(".delegacion-insertcss").empty().append(delegacionFields.insertTemplate(delegacion_value));
                                        $(".clave-unidad-insertcss").empty().append(claveUnidadFields.insertTemplate(clave_unidad_value));
                                        $(".unidad-insertcss").empty().append(unidadFields.insertTemplate(unidad_value));
                                        $(".clave-categoria-insertcss").empty().append(claveCategoriaFields.insertTemplate(clave_categoria_value));
                                        $(".categoria-insertcss").empty().append(categoriaFields.insertTemplate(categoria_value));
                                    })
                                    .fail(function () {
                                        console.log("error");
                                        resultado = null;
                                    })
                                    .always(function () {
                                        console.log("complete");
                                        monitor = true;
                                    });
                        }
                    });

                    return input_matricula;
                },
                editTemplate: function (value, item) {
                    matricula_edit_value = value;

                    var nombreFields = this._grid.fields[4];
                    var delegacionFields = this._grid.fields[5];
                    var claveUnidadFields = this._grid.fields[6];
                    var unidadFields = this._grid.fields[7];
                    var claveCategoriaFields = this._grid.fields[8];
                    var categoriaFields = this._grid.fields[9];

                    console.log(delegacionFields);
                    input_matricula = $("<input id='matricula' name='matricula' type='text' value='" + matricula_edit_value + "'>");

                    $(input_matricula).keypress(function (event) {
                        if (event.which == 13) {
                            matricula_edit_value = $(this).val();

                            var di = $.Deferred();

                            $.ajax({
                                url: site_url + '/docente/docente/' + matricula_edit_value,
                                type: 'GET',
                                dataType: 'json',
                            })
                                    .done(function (json) {
                                        console.log("success");
                                        di.resolve(json);
                                        if (json['success']) {
                                            resultado = json['data'];

                                            nombre_value = resultado['nombre_completo'];
                                            delegacion_value = resultado['delegacion'];
                                            clave_unidad_value = resultado['clave_unidad'];
                                            unidad_value = resultado['unidad'];
                                            clave_categoria_value = resultado['clave_categoria'];
                                            categoria_value = resultado['categoria'];

                                        } else {
                                            alert("No existe algún docente registrado con la matrícula " + matricula_edit_value);
                                            resultado = null;

                                            nombre_value = "";
                                            delegacion_value = "";
                                            clave_unidad_value = "";
                                            unidad_value = "";
                                            clave_categoria_value = "";
                                            categoria_value = "";
                                        }
                                        $(".nombre-editcss").empty().append(nombreFields.editTemplate(nombre_value));
                                        $(".delegacion-editcss").empty().append(delegacionFields.editTemplate(delegacion_value));
                                        $(".clave-unidad-editcss").empty().append(claveUnidadFields.editTemplate(clave_unidad_value));
                                        $(".unidad-editcss").empty().append(unidadFields.editTemplate(unidad_value));
                                        $(".clave-categoria-editcss").empty().append(claveCategoriaFields.editTemplate(clave_categoria_value));
                                        $(".categoria-editcss").empty().append(categoriaFields.editTemplate(categoria_value));
                                    })
                                    .fail(function () {
                                        console.log("error");
                                        resultado = null;
                                    })
                                    .always(function () {
                                        console.log("complete");
                                    });
                        }
                    });

                    return input_matricula;
                },
                filterTemplate: function () {
                    return  $("<input id='matricula_' name='matricula_' type='text'>");
                },
                filterValue: function () {
                    return $('#matricula_').val();
                },
                validate: {
                    message: "El campo matrícula es obligatorio, por favor ingreselo.",
                    validator: function (value) {
                        var add = (matricula_add_value != null) && (matricula_add_value != '');
                        var edit = (matricula_edit_value != null) && (matricula_edit_value != '');
                        return add || edit;
                    }
                }
            },
            {name: "nombre_completo", title: "Nombre", align: "center", type: "text",
                inserting: true, editing: false,
                insertcss: "nombre-insertcss",
                editcss: "nombre-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return value;
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return value;
                }
            },
            {name: "delegacion", title: "Delegación", type: "select", align: "center",
                items: opciones_delegaciones, valueField: "clave_delegacional", textField: "nombre",
                inserting: false, editing: false,
                insertcss: "delegacion-insertcss",
                editcss: "delegacion-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return nombre_delegacion(value);
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return nombre_delegacion(value);
                }
            },
            {name: "clave_unidad", title: "Clave de unidad", align: "center", type: "text", inserting: false, editing: false,
                insertcss: "clave-unidad-insertcss",
                editcss: "clave-unidad-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return value;
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return value;
                }
            },
            {name: "unidad", title: "Unidad", align: "center", type: "text", inserting: false, editing: false,
                insertcss: "unidad-insertcss",
                editcss: "unidad-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return value;
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return value;
                }
            },
            {name: "clave_categoria", title: "Clave de categoría", align: "center", type: "text", inserting: false, editing: false,
                insertcss: "clave-categoria-insertcss",
                editcss: "clave-categoria-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return value;
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return value;
                }
            },
            {name: "categoria", title: "Categoría", align: "center", type: "text", inserting: false, editing: false,
                insertcss: "categoria-insertcss",
                editcss: "categoria-editcss",
                insertValue: function (value) {
                    return value;
                },
                insertTemplate: function (value) {
                    return value;
                },
                editValue: function (value) {
                    return value;
                },
                editTemplate: function (value) {
                    return value;
                }
            },
            {type: "control", editButton: true, deleteButton: true, modeSwitchButton: false,
                searchModeButtonTooltip: "Cambiar a modo búsqueda", // tooltip of switching filtering/inserting button in inserting mode
                insertModeButtonTooltip: "Cambiar a insertar", // tooltip of switching filtering/inserting button in filtering mode
                editButtonTooltip: "Editar", // tooltip of edit item button
                deleteButtonTooltip: "Eliminar", // tooltip of delete item button
                searchButtonTooltip: "Buscar", // tooltip of search button
                clearFilterButtonTooltip: "Limpiar filtros de búsqueda", // tooltip of clear filter button
                insertButtonTooltip: "Agregar", // tooltip of insert button
                updateButtonTooltip: "Actualizar", // tooltip of update item button
                cancelEditButtonTooltip: "Cancelar", // tooltip of cancel editing button
            }
        ]
    }).data("JSGrid");

    var origFinishInsert = jsGrid.loadStrategies.DirectLoadingStrategy.prototype.finishInsert;
    jsGrid.loadStrategies.DirectLoadingStrategy.prototype.finishInsert = function (insertedItem) {
        if (!this._grid.insertSuccess) { // define insertFailed on done of delete ajax request in insertFailed of controller
            return;
        }
        origFinishInsert.apply(this, arguments);
    }

    $("#jsGrid").jsGrid("option", "filtering", true);

    var modo = $("input[type='radio'][name='modo-grid']:checked").attr('data-mode');
    if (modo == 'buscar') {
        $("#jsGrid").jsGrid("option", "inserting", false);
        $("#jsGrid").jsGrid("option", "filtering", true);
    } else {
        $("#jsGrid").jsGrid("option", "filtering", false);
        $("#jsGrid").jsGrid("option", "inserting", true);
    }


}

/**
 * @fecga 10/11/2017
 * @param {type} padre
 * @param {type} classe
 * @param {type} itemsCount
 * @returns cálcula y modifica tamaño de scroll no exixten registros en el jsgrid
 */
function calcula_ancho_grid(padre, classe) {

    var d = $('#' + padre).data("JSGrid");
    var itemsCount = d.data.length;//Obtiene el tamaño de los datos
//    console.log(d.height);
//    console.log(d);
//    console.log(itemsCount);
    if (itemsCount < 1) {
        var ancho = 0;
        $('#' + padre + ' .' + classe).each(function (index, value) {
            ancho += parseInt(value.style.width.split('px')[0]);
        });
        $('#' + padre + ' .jsgrid-cell').css('width', ancho);
        $('#' + padre + ' .jsgrid-grid-body').css('height', '100');
//        whidth: ancho + 'px'
    }else{//regresa a su estado por default el ancho del body
//        $('#' + padre + ' .jsgrid-grid-body').css('height', d.height.split('px')[0]);//Asigana el valor por default de las propieddes del grid indicado

    }


}

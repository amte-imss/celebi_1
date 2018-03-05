function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
function cancel() {
    $('.wizard .nav-tabs li').each(function (index, val) {
        var e = $(this);
        if (index == 0) {
            e.removeClass('disabled').addClass('active');
            e.children().trigger('click');
        } else {
            e.removeClass('active').addClass('disabled');
        }
    });
    $('#cancel').trigger('click');
}
function step_process(step_process) {//Selecciona y desbloquea el tab de la sección en el proceso que se encuentra el curso
    var total_botones = 3;
//    console.log(step_process);
    for (var i = 0; (i < step_process && i < total_botones); i++) {
        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);
    }
}

function update_insert(etapa, form, $active) {
//    console.log(etapa);
//    console.log(form);
//    console.log($active);
    var dataSend = $("#" + form).serialize();
    switch (etapa) {
        case 1:
            break;
        case 2://Profesores
            var titular = $('#jsGridTitulares').data("JSGrid").data;
            var adjunto = $('#jsGridAdjuntos').data("JSGrid").data;
            console.log(titular);
            console.log(adjunto);
            var data_profesores = [];
            var aux = [];
            for (var i = 0; i < titular.length; ++i) {
                if (!titular[i])
                    continue;
                var valor = titular[i];
                if (typeof valor === 'object') {
                    aux.push(valor.matricula);
                }
            }
            data_profesores['titulares'] = aux;
            aux = [];
            for (var i = 0; i < adjunto.length; ++i) {
                if (!adjunto[i])
                    continue;
                var valor = adjunto[i];
                if (typeof valor === 'object') {
                    aux.push(valor.matricula);
                }
            }
            data_profesores['adjuntos'] = aux;
            console.log('data_profesores--------->');
            console.log(data_profesores);
            console.log('fin--------------------->');
            dataSend += '&titulares=' + data_profesores['titulares'];
            dataSend += '&adjuntos=' + data_profesores['adjuntos'];
            break;
        case 3:
            break;
    }
//    console.log(dataSend);
    $.ajax({
        type: "POST",
        url: site_url + "/implementaciones/registro/",
        data: dataSend,
//        dataType: "json"
    })
            .done(function (result) {
                console.log(result);
                try {//Cacha el error
                    var resp = $.parseJSON(result);
                    $("#contenido" + etapa).html(resp.html);
                    if (resp.tp_msg == "success") {
                        $active.next().removeClass('disabled');
                        nextTab($active);
                        $(".implementacion").val($(".implementacion_ctr").val());

                    }
                } catch (e) {
                    $("#contenido" + etapa).html(result);
                }

            });
}
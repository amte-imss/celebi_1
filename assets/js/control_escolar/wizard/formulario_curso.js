$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();

    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);

        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {
        var prop = $(this).data("etapa");
//        var etapa = prop.val();
        var $active = $('.wizard .nav-tabs li.active');
        update_insert(prop, ("form_" + prop), $active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

function update_insert(etapa, form, $active) {
    console.log(etapa);
    console.log(form);
    console.log($active);
    var dataSend = $("#" + form).serialize();
    switch (etapa) {
        case 1:
            break;
        case 2:
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
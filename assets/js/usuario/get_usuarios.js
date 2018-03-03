$(function(){
       $("ul.dropdown-menu li a.option-input-tablero").click(function(event){
        event.preventDefault();
        $('#btn-filtro-tablero').html($(this).text()+'<span class="caret"></span>');
        $('#filtro_texto').val($(this).attr('data-id'));
    });
});


function censo_finalizado(usuario){
    var destino = site_url + "/usuario/editar/"+usuario+"/censo/";
    data_ajax(destino, '#area_censo_finalizado_'+ usuario, '#area_censo_finalizado_' + usuario, null, true);
}

var titulares = [];
var adjuntos = [];
var delegaciones = [];

$(document).ready(function() {
	get_delegaciones();
	print_grids();

});

function print_grids(){
	var implementacion = $("#implementacion").val();

	$.ajax({
		url: site_url + "/docente/profesores_implementacion/" + implementacion,
		type: 'GET',
		dataType: "json",
		async: false
	})
	.done(function(data) {
		titulares = data['titulares'];
		adjuntos = data['adjuntos'];
		grid_titulares();
		grid_adjuntos();
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}

function get_delegaciones() {
	$.ajax({
		url: site_url + "/catalogo/get_delegaciones",
		type: 'GET',
		dataType: "json",
		async: false
	})
	.done(function(data) {
		console.log("success");
		delegaciones = data;
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}

function grid_titulares() {
	console.log("grid_titulares");
	console.log(titulares);

	var matricula_value = '';
	var nombre_value = "";
  var delegacion_value = null;
  var curp_value = null;
  var correo_value = null;

	console.log("grid");
	$('#jsGridTitulares').jsGrid({
		height: "90px",
		width: "95%",
		filtering: false,
		inserting: false,
		editing: true,
		sorting: false,
		selecting: false,
		paging: false,
		autoload: true,
		rowClick: function (args) {},
		pageLoading: false,
		controller: {
			loadData: function(filter){
				return titulares;
			},
			updateItem: function (item) {
				console.log(item);
				var datos = {
					rol : item['rol'],
					matricula : matricula_value,
					nombre_participante : nombre_value,
					curp: curp_value,
					delegacion: delegacion_value,
					correo_electronico: correo_value
				}
				return datos;
			}
		},
		/*
		controller: {
			loadData: function(filter){
				var d = $.Deferred();

	      $.ajax({
	          type: "GET",
	          url: site_url + "/docente/profesores_implementacion/add/" + implementacion,
	          data: filter,
	          dataType: "json"
	      })
	      .done(function (result) {
	          console.log(result);
	          d.resolve(result.data);

	      });
	      return d.promise();
			}
		},*/
		fields : [
			{name: "rol", title: "Rol", type: "text", align: "center",
				editing: false
			},
			{name: "matricula", title: "Matrícula", align: "center",
				itemTemplate: function (value, item) {
          return item['matricula'];
        },
        editTemplate: function(value,item){
        	matricula_value = value;

        	var nombreField = this._grid.fields[2];
        	var delegacionField = this._grid.fields[3];
        	var curpField = this._grid.fields[4];
        	var correoField = this._grid.fields[5];

        	input_matricula = $("<input id='matricula' name='matricula' type='text' value='" + matricula_value + "'>");

        	$(input_matricula).keypress(function (event) {
        		if (event.which == 13) {
        			matricula_value = $(this).val();

              var di = $.Deferred();

              $.ajax({
                  url: site_url + '/docente/profesor_titular/' + matricula_value,
                  type: 'GET',
                  dataType: 'json',
              })
              .done(function (json) {
              	di.resolve(json);
              	console.log("success");
              	if (json['success']) {
              		resultado = json['data'];

                  nombre_value = resultado['nombre_participante'];
                  delegacion_value = resultado['delegacion'];
                  curp_value = resultado['curp'];
                  correo_value = resultado['correo_electronico'];

                } else {
                    alert("No existe registrado en algún CIEFD el docente con matrícula " + matricula_value);
                    resultado = null;

                    nombre_value = "";
	                  delegacion_value = "";
	                  curp_value = "";
	                  correo_value = "";
                }
                $(".nombre_css").empty().append(nombreField.editTemplate(nombre_value));
                $(".delegacion_css").empty().append(delegacionField.editTemplate(delegacion_value));
                $(".curp_css").empty().append(curpField.editTemplate(curp_value));
                $(".correo_css").empty().append(correoField.editTemplate(correo_value));
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
        editValue: function(){
        	return matricula_value;
        },
				validate: {
            message: "El campo matrícula es obligatorio, por favor ingreselo.",
            validator: function (value) {
              return (matricula_value != null) && (matricula_value != '');
            }
        }
			},
			{name: "delegacion", title: "Delegacion", type: "text", align: "center",
				editing: false, editcss:"delegacion_css",
				editValue: function () {
            return delegacion_value;
        },
        editTemplate: function (value) {
            return value;
        }
			},
			{name: "nombre_participante", title: "Nombre", type: "text", align: "center",
				editing: false, editcss:"nombre_css",
				editValue: function () {
            return nombre_participante;
        },
        editTemplate: function (value) {
            return value;
        }
			},
			{name: "curp", title: "CURP", type: "text", align: "center",
				editing: false, editcss:"curp_css",
				editValue: function () {
            return curp_value;
        },
        editTemplate: function (value) {
            return value;
        }
			},
			{name: "correo_electronico", title: "Correo", type: "text", align: "center",
				editing: false, editcss:"correo_css",
				editValue: function () {
            return correo_value;
        },
        editTemplate: function (value) {
            return value;
        }
			},
			{type: "control", editButton: true, deleteButton: false, clearFilterButton: false, modeSwitchButton: false
			}
		]
	}).data("JSGrid");
}


function grid_adjuntos() {
	console.log("grid_adjuntos");

	var matricula_value = '';
	var nombre_value = "";
  var delegacion_value = null;
  var curp_value = null;
  var correo_value = null;

	console.log("grid");
	$('#jsGridAdjuntos').jsGrid({
		height: "120px",
		width: "95%",
		filtering: false,
		inserting: false,
		editing: true,
		sorting: false,
		selecting: false,
		paging: false,
		autoload: true,
		rowClick: function (args) {},
		pageLoading: false,
		controller: {
			loadData: function(filter){
				return adjuntos;
			},
			updateItem: function (item) {
				console.log(item);
				var datos = {
					rol : item['rol'],
					matricula : matricula_value,
					nombre_participante : nombre_value,
					curp: curp_value,
					delegacion: delegacion_value,
					correo_electronico: correo_value
				}
				return datos;
			}
		},
		/*
		controller: {
			loadData: function(filter){
				var d = $.Deferred();

	      $.ajax({
	          type: "GET",
	          url: site_url + "/docente/profesores_implementacion/add/" + implementacion,
	          data: filter,
	          dataType: "json"
	      })
	      .done(function (result) {
	          console.log(result);
	          d.resolve(result.data);

	      });
	      return d.promise();
			}
		},*/
		fields : [
			{name: "rol", title: "Rol", type: "text", align: "center",
				editing: false
			},
			{name: "matricula", title: "Matrícula", align: "center",
				itemTemplate: function (value, item) {
          return item['matricula'];
        },
        editTemplate: function(value,item){
        	matricula_value = value;

        	var nombreField = this._grid.fields[2];
        	var delegacionField = this._grid.fields[3];
        	var curpField = this._grid.fields[4];
        	var correoField = this._grid.fields[5];

        	input_matricula = $("<input id='matricula' name='matricula' type='text' value='" + matricula_value + "'>");

        	$(input_matricula).keypress(function (event) {
        		if (event.which == 13) {
        			matricula_value = $(this).val();

              var di = $.Deferred();

              $.ajax({
                  url: site_url + '/docente/profesor_titular/' + matricula_value,
                  type: 'GET',
                  dataType: 'json',
              })
              .done(function (json) {
              	di.resolve(json);
              	console.log("success");
              	if (json['success']) {
              		resultado = json['data'];

                  nombre_value = resultado['nombre_participante'];
                  delegacion_value = resultado['delegacion'];
                  curp_value = resultado['curp'];
                  correo_value = resultado['correo_electronico'];

                } else {
                    alert("No existe registrado en algún CIEFD el docente con matrícula " + matricula_value);
                    resultado = null;

                    nombre_value = "";
	                  delegacion_value = "";
	                  curp_value = "";
	                  correo_value = "";
                }
                $(".nombre_css").empty().append(nombreField.editTemplate(nombre_value));
                $(".delegacion_css").empty().append(delegacionField.editTemplate(delegacion_value));
                $(".curp_css").empty().append(curpField.editTemplate(curp_value));
                $(".correo_css").empty().append(correoField.editTemplate(correo_value));
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
        editValue: function(){
        	return matricula_value;
        },
				validate: {
            message: "El campo matrícula es obligatorio, por favor ingreselo.",
            validator: function (value) {
              return (matricula_value != null) && (matricula_value != '');
            }
        }
			},
			/*
			// siap
			{name: "clave_delegacion", title: "Delegacion", type: "select", align: "center",
				items: delegaciones, 
				valueField: "clave_delegacional", textField: "nombre"
			},
			*/
			{name: "delegacion", title: "Delegacion", type: "text", align: "center",
				editing: false, editcss:"delegacion_css",
				editValue: function () {
            return delegacion_value;
        },
        editTemplate: function (value) {
            return value;
        }
			},
			{name: "nombre_participante", title: "Nombre", type: "text", align: "center",
				editing: false, editcss:"nombre_css",
				editValue: function () {
            return nombre_participante;
        },
        editTemplate: function (value) {
            return value;
        }
			},
			{name: "curp", title: "CURP", type: "text", align: "center",
				editing: false, editcss:"curp_css",
				editValue: function () {
            return curp_value;
        },
        editTemplate: function (value) {
            return value;
        }
			},
			{name: "correo_electronico", title: "Correo", type: "text", align: "center",
				editing: false, editcss:"correo_css",
				editValue: function () {
            return correo_value;
        },
        editTemplate: function (value) {
            return value;
        }
			},
			{type: "control", editButton: true, deleteButton: false, clearFilterButton: false, modeSwitchButton: false
			}
		]
	}).data("JSGrid");
}
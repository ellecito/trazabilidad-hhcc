$(document).ready(function() {

	$("#form-importar").validationEngine("attach",{
			promptPosition:"topLeft",
			validationEventTrigger:false,
			prettySelect:0,
			useSuffix:"_chosen",
			onValidationComplete:function(e,o){
				if(o){
					noty({
						text:"Su archivo está siendo enviado. Por favor, espere un momento.",
						layout:"topCenter",
						type:"alert",
						killer:true,
						closeWith:[],
						template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
						fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
					});

					var t=new FormData($("#form-importar")[0]);

					$.ajax({
						url: window.location.pathname + "/importar/",
						type:"post",
						data:t,
						dataType: "html",
						cache: false,
						contentType: false,
						processData: false,
						success:function(result){
							var e = JSON.parse(result);
							if(e.result){
								noty({
									text:"Archivo enviado con éxito.",
									layout:"topCenter",
									type:"success",
									killer:true,
									closeWith:[],
								});

							setTimeout(function(){
								window.location= e.url;
								},500);
							}else{

								noty({
									text: e.msg,
									layout:"topCenter",
									type:"error",
									killer:true,
									closeWith:["click"],
								});
							}


							}
						});
					}
				}
	});

	var options = {
        ajax          : {
            url     : window.location.pathname + "/buscar_paciente/",
            type    : 'POST',
            dataType: 'json',
            // Use "{{{q}}}" as a placeholder and Ajax Bootstrap Select will
            // automatically replace it with the value of the search query.
            data    : {
                q: '{{{q}}}'
            }
        },
        locale        : {
            emptyTitle: 'Buscar',
            statusInitialized: 'Escriba para buscar',
            currentlySelected: 'Seleccionado actualmente',
            errorText: 'No se pudo encontrar resultados',
            searchPlaceholder: 'Buscar...',
            statusSearching: 'Buscando...',
            statusNoResults: 'Sin resultados',
            statusTooShort: 'Por favor ingresar mas caracteres'
        },
        log           : 3,
        preprocessData: function (data) {
            var i, l = data.length, array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text : data[i].hhcc,
                        value: data[i].codigo,
                        data : {
                            subtext: data[i].rut + " | " + data[i].nombres + " " + data[i].apellidos
                        }
                    }));
                }
            }
            // You must always return a valid array when processing data. The
            // data argument passed is a clone and cannot be modified directly.
            return array;
        }
    };

    $('.selectpicker').selectpicker().filter('.with-ajax').ajaxSelectPicker(options);
    $('select').trigger('change');

});

$(document).ready(function(){
	$("#form-agregar").validationEngine('attach', {
        promptPosition:'topLeft',
       	validationEventTrigger:false,
        showOneMessage:true,
        onValidationComplete: function(form, status){
       		if(status) {
	           	noty({
       				layout: 'topCenter',
       				fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>',
         			text: '¿Está seguro que desea realizar la impresión de barras?',
         			buttons: [
           				{addClass: 'btn btn-primary', text: 'Aceptar', onClick: function($noty) {
               				$noty.close();
               				$(window).unbind('beforeunload');

			               	noty({
			                   text: 'Por favor, espere un momento.',
			                   layout: 'topCenter',
			                   type: 'alert',
			                   killer:true,
			                   closeWith: [],
			                   template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
			                   fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
			               	});
			               	
                      $.ajax({
                         type: "POST",
                         data: $("#form-agregar").serialize(),
                         dataType: "json",
                         url: window.location.pathname + "/imprimir/",
                         success: function(json){
                             if(json.result){
                                 noty({
                                     text: "Las barras se han generado con éxito.",
                                     layout: 'topCenter',
                                     type: 'success',
                                     killer: true
                                 });
                                 setTimeout(function() {
                                         window.location.href = json.url;
                                 }, 1000);
                             }
                             else
                             {
                                 var error = noty({
                                     text: json.msg,
                                     layout: 'topCenter',
                                     type: 'error',
                                     timeout: 2000
                                 });
                             }
                         }
                     });

             			}
           				},
			           	{addClass: 'btn btn-danger', text: 'Cancelar', onClick: function($noty) {
			               $noty.close();
			            }
			           	}
        			]
       			});
       		}
     	}
   	});
});

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
         			text: '¿Está seguro que desea cambiar el estado de este registro?',
         			buttons: [
           				{addClass: 'btn btn-primary', text: 'Aceptar', onClick: function($noty) {
               				$noty.close();
               				$(window).unbind('beforeunload');

			               	noty({
			                   text: 'El calculo de nominas se esta realizando. Por favor, espere un momento.',
			                   layout: 'topCenter',
			                   type: 'alert',
			                   killer:true,
			                   closeWith: [],
			                   template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
			                   fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
			               	});
			               	var formData = $("#form-agregar").serialize();
			               	$.redirect("calculo/",{formData}); 

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

	$("#fecha").datepicker();
});

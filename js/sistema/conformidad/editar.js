$(function(){

   $("#form-editar").validationEngine('attach', {
               promptPosition:'topLeft',
       validationEventTrigger:false,
               showOneMessage:true,
           onValidationComplete: function(form, status){
       if(status) {

           noty({
               text: 'Actualizando registro. Por favor, espere un momento.',
               layout: 'topCenter',
               type: 'alert',
               closeWith: [],
               killer:true,
               template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
               fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
           });

           $.ajax({
               url: window.location.pathname,
               type: 'post',
               dataType: 'json',
               data: $("#form-editar").serialize(),
               success: function(json){
                   if(json.result){
                       noty({
                           text: "Registro actualizado con éxito.",
                           layout: 'topCenter',
                           type: 'success',
                           killer: true
                       });

                       setTimeout(function(){
                           window.location.href = window.location.pathname.replace("/editar/" + $("#codigo").val(), "");
                       }, 1000);
                   }
                   else
                   {
                       noty({
                           text: json.msg,
                           layout: 'topCenter',
                           type: 'error',
                           timeout: 3000,
                           killer: true
                       });
                   }
               }
           });
       }
     }
   });

   var options = {
        ajax          : {
            url     : window.location.pathname.replace("/editar/" + $("#codigo").val(), "/buscar_paciente/"),
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

$(document).ready(function(){
	$("#form-agregar").validationEngine('attach', {
        promptPosition:'topLeft',
       	validationEventTrigger:false,
        showOneMessage:true,
        onValidationComplete: function(form, status){
       		if(status) {

              $.ajax({
               url: window.location.pathname + "/validar/",
               type: 'post',
               dataType: 'json',
               data: $("#form-agregar").serialize(),
               success: function(json){
                   if(json.result){
                      noty({
                        layout: 'topCenter',
                        fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>',
                        text: '¿Está seguro que desea realizar el calculo de nomina?',
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

	$("#fecha").datepicker();

  var options = {
        ajax          : {
            url     : window.location.pathname + "/buscar_medico/",
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
                        text : data[i].nombres + " " + data[i].apellidos,
                        value: data[i].codigo,
                        data : {
                            subtext: data[i].rut
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

    var i = 2;

    $("html").on("change", ".medicos", function(){
      var select = $(this);
      $.ajax({
          url: window.location.pathname + "/esp_ser/",
          type: 'post',
          dataType: 'json',
          data: "codigo=" + $(this).val(),
          success: function(json){
            if(json.result){
              var name = select.attr("name").split("_")[1];
              $("#especialidad_" + name).html(json.html);
              $("#especialidad_" + name).trigger('change');
              $('.selectpicker').selectpicker();
            }
          }
        });
    });

    $("#add").click(function(e){
      e.preventDefault();
      var html = '<div class="form-group">';
      html += '<label class="col-sm-2 control-label">Médico</label>';
      html += '<div class="col-sm-4">';
      html += '<select name="medico_' + i + '" class="medicos selectpicker with-ajax validate[required]" data-live-search="true">';
      html += '</select>';
      html += '</div>';
      html += '<label class="col-sm-2 control-label">Especialidad</label>';
      html += '<div class="col-sm-4">';
      html += '<select multiple id="especialidad_' + i + '" name="especialidad_' + i + '[]" class="especialidades with-ajax selectpicker">';
      html += '</select>';
      html += '</div>';
      html += '</div>';
      i += 1;
      $("#form-agregar").append(html);
      $('.selectpicker').selectpicker().filter('.with-ajax').ajaxSelectPicker(options);
      $('select').trigger('change');
    });
});

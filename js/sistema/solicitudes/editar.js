$(function(){

   $("#form-editar").validationEngine("attach",{
      promptPosition:"topLeft",
      validationEventTrigger:false,
      prettySelect:0,
      useSuffix:"_chosen",
      onValidationComplete:function(e,o){
        if(o){
          noty({
            text:"Actualizando registro. Por favor, espere un momento.",
            layout:"topCenter",
            type:"alert",
            killer:true,
            closeWith:[],
            template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
            fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
          });

          var t=new FormData($("#form-editar")[0]);

          $.ajax({
            url: window.location.pathname,
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
                  text:"Registro actualizado con éxito.",
                  layout:"topCenter",
                  type:"success",
                  killer:true,
                  closeWith:[],
                });

              setTimeout(function(){
                window.location= window.location.pathname.replace("/editar/" + $("#codigo").val(), "");
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

   $("#fecha_entrega").datepicker();

   $('#medico').change(function(){
      if($(this).val() == 0){
        $("#hide_medico1").css("display", "block");
        $("#especialidad").val("");
        $("#servicio").val("");
      }else{
        $("#hide_medico1").css("display", "none");
        $.ajax({
          url: window.location.pathname.replace("/editar/" + $("#codigo").val(), "/esp_ser/"),
          type: 'post',
          dataType: 'json',
          data: "codigo=" + $(this).val(),
          success: function(json){
            if(json.result){
              $("#especialidad").val(json.especialidad.nombre);
              $("#servicio").val(json.servicio.nombre);
            }
          }
        });
      }
   });

   function esp_ser(){
    if($('#medico').val() == 0){
        $("#hide_medico1").css("display", "block");
        $("#especialidad").val("");
        $("#servicio").val("");
      }else{
        $("#hide_medico1").css("display", "none");
        $.ajax({
          url: window.location.pathname.replace("/editar/" + $("#codigo").val(), "/esp_ser/"),
          type: 'post',
          dataType: 'json',
          data: "codigo=" + $('#medico').val(),
          success: function(json){
            if(json.result){
              $("#especialidad").val(json.especialidad.nombre);
              $("#servicio").val(json.servicio.nombre);
            }
          }
        });
      }
   }

   esp_ser();

   $('#motivo').change(function(){
        $.ajax({
          url: window.location.pathname.replace("/editar/" + $("#codigo").val(), "/motivo/"),
          type: 'post',
          dataType: 'json',
          data: "codigo=" + $(this).val() + "&fecha_entrega=" + $("#fecha_entrega").val(),
          success: function(json){
            if(json.result){
              if(json.motivo.documento == 1){
                $("#hide_medico2").css("display", "block");
              }else{
                $("#hide_medico2").css("display", "none");
              }

              $("#fecha_devolucion").val(json.motivo.fecha_devolucion);
            }
          }
        });
    });

    $("#fecha_entrega").change(function(){
      if($('#motivo').val() != null){
      $.ajax({
            url: window.location.pathname.replace("/editar/" + $("#codigo").val(), "/motivo/"),
            type: 'post',
            dataType: 'json',
            data: "codigo=" + $('#motivo').val() + "&fecha_entrega=" + $(this).val(),
            success: function(json){
              if(json.result){
                $("#fecha_devolucion").val(json.motivo.fecha_devolucion);
              }
            }
          });
      }
    });
});

$(function(){

   $("#form-agregar").validationEngine('attach', {
               promptPosition:'topLeft',
       validationEventTrigger:false,
               showOneMessage:true,
           onValidationComplete: function(form, status){
       if(status) {

           noty({
               text: 'Creando registro. Por favor, espere un momento.',
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
               data: $("#form-agregar").serialize(),
               success: function(json){
                   if(json.result){
                       noty({
                           text: "Registro creado con éxito.",
                           layout: 'topCenter',
                           type: 'success',
                           killer: true
                       });

                       setTimeout(function(){
                           window.location.href = window.location.pathname.replace("/agregar/", "");
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

   $('#rut').Rut({
    on_success:function(){
      $('#rut').removeClass("validate[required,custom[rut]]"); 
      $('#rut').addClass("validate[required]");
    },
    on_error: function(){
      $('#rut').removeClass("validate[required,custom[rut]]"); 
      $('#rut').removeClass("validate[required]"); 
      $('#rut').addClass("validate[required,custom[rut]]");
    },
    format_on: 'keyup'
  });

   /*$(".especialidad").change(function(){
      var html = $("#div-especialidad").html();
      $("#div-especialidad").append(html);
   });*/

   $("#add").click(function(e){
      e.preventDefault();
      var values = [];
      $(".especialidad").each(function(i , sel){
        var selectValue = $(sel).val();
        if(selectValue != null) values.push(selectValue);
      });
      
      $.ajax({
        url: 'medicos/especialidades/',
        type: 'post',
        dataType: 'json',
        data: "especialidades=" + values,
        success: function(json){
          if(json.result){
            $("#div-especialidad").append(json.html);
            $("#div-especialidad").trigger("chosen:updated");
          }
        }
      });
   });
});

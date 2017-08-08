<div class="page-header">
  <h1>Editar Especialidad</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $especialidad->nombre; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $especialidad->codigo; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="servicio" class="col-sm-2 control-label">Servicio</label>
      <div class="col-sm-4">
        <select id="servicio" name="servicio" class="selectpicker validate[required]">
           <option disabled>Seleccione</option>
           <?php if($servicios){ ?>
           <?php foreach($servicios as $servicio){ ?>
              <option value="<?php echo $servicio->codigo; ?>" <?php if($servicio->codigo == $especialidad->se_codigo) echo "selected"; ?>><?php echo $servicio->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>

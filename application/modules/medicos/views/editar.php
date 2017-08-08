<div class="page-header">
  <h1>Editar Medico</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]" value="<?php echo $medico->rut; ?>" />
        <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $medico->codigo; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <input type="text" id="email" name="email" class="form-control validate[required, custom[email]]" value="<?php echo $medico->email; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="nombres" class="col-sm-2 control-label">Nombres</label>
      <div class="col-sm-10">
        <input type="text" id="nombres" name="nombres" class="form-control validate[required]" value="<?php echo $medico->nombres; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
      <div class="col-sm-10">
        <input type="text" id="apellidos" name="apellidos" class="form-control validate[required]" value="<?php echo $medico->apellidos; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="estado" class="col-sm-2 control-label">Estado</label>
      <div class="col-sm-4">
        <select id="estado" name="estado" class="selectpicker validate[required]">
			     <option disabled>Seleccione</option>
           <option value="1" <?php if($medico->estado) echo "selected"; ?>>Activo</option>
           <option value="0" <?php if(!$medico->estado) echo "selected"; ?>>Inactivo</option>
        </select>
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>

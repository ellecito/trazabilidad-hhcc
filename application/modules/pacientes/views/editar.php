<div class="page-header">
  <h1>Editar Paciente</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]" value="<?php echo $paciente->rut; ?>"/>
        <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $paciente->codigo; ?>"/>
      </div>
    </div>
    <div class="form-group">
      <label for="hhcc" class="col-sm-2 control-label">HHCC</label>
      <div class="col-sm-10">
        <input type="text" id="hhcc" name="hhcc" class="form-control validate[required, custom[number]]"  value="<?php echo $paciente->hhcc; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="nombres" class="col-sm-2 control-label">Nombres</label>
      <div class="col-sm-10">
        <input type="text" id="nombres" name="nombres" class="form-control validate[required]" value="<?php echo $paciente->nombres; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
      <div class="col-sm-10">
        <input type="text" id="apellidos" name="apellidos" class="form-control validate[required]" value="<?php echo $paciente->apellidos; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="comuna" class="col-sm-2 control-label">Estado</label>
      <div class="col-sm-4">
        <select id="estado" name="estado" class="selectpicker validate[required]">
           <option disabled>Seleccione</option>
           <option value="1" <?php if($paciente->estado) echo "selected"; ?>>Activo</option>
           <option value="0" <?php if(!$paciente->estado) echo "selected"; ?>>Fallecido</option>
        </select>
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>

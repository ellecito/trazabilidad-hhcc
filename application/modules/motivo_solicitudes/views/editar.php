<div class="page-header">
  <h1>Editar Motivo Solicitud</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-4">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $motivo->nombre; ?>" />
         <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $motivo->codigo; ?>" />
      </div>
      <label for="dias" class="col-sm-2 control-label">Días</label>
      <div class="col-sm-4">
        <input type="text" id="dias" name="dias" class="form-control validate[required, custom[integer]]" value="<?php echo $motivo->dias; ?>" />
      </div>
    </div>
  </fieldset>
  <fieldset>
    <div class="form-group">
      <label for="documento" class="col-sm-2 control-label">Documento</label>
      <div class="col-sm-4">
        <select name="documento" id="documento" class="selectpicker validate[required]">
          <option value="0" <?php if(!$motivo->documento) echo "selected"; ?>>No Necesita</option>
          <option value="1" <?php if($motivo->documento) echo "selected"; ?>>Necesita</option>
        </select>
      </div>
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-4">
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>

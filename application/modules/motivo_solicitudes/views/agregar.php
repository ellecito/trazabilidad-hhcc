<div class="page-header">
  <h1>Agregar Motivo Solicitud</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-4">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" />
      </div>
      <label for="dias" class="col-sm-2 control-label">Días</label>
      <div class="col-sm-4">
        <input type="text" id="dias" name="dias" class="form-control validate[required, custom[integer]]" />
      </div>
    </div>
  </fieldset>
  <fieldset>
    <div class="form-group">
      <label for="documento" class="col-sm-2 control-label">Documento</label>
      <div class="col-sm-4">
        <select name="documento" id="documento" class="selectpicker validate[required]">
          <option value="0" selected>No Necesita</option>
          <option value="1">Necesita</option>
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
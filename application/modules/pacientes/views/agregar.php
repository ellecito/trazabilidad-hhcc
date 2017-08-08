<div class="page-header">
  <h1>Agregar Paciente</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]" />
      </div>
    </div>
    <div class="form-group">
      <label for="hhcc" class="col-sm-2 control-label">HHCC</label>
      <div class="col-sm-10">
        <input type="text" id="hhcc" name="hhcc" class="form-control validate[required, custom[number]]" />
      </div>
    </div>
    <div class="form-group">
      <label for="nombres" class="col-sm-2 control-label">Nombres</label>
      <div class="col-sm-10">
        <input type="text" id="nombres" name="nombres" class="form-control validate[required]" />
      </div>
    </div>
    <div class="form-group">
      <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
      <div class="col-sm-10">
        <input type="text" id="apellidos" name="apellidos" class="form-control validate[required]" />
      </div>
    </div>
    <div class="form-group">
      <label for="comuna" class="col-sm-2 control-label">Estado</label>
      <div class="col-sm-4">
        <select id="estado" name="estado" class="selectpicker validate[required]">
			     <option disabled selected>Seleccione</option>
           <option value="1">Activo</option>
           <option value="0">Fallecido</option>
        </select>
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>

<div class="page-header">
  <h1>Agregar Medico</h1>
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
      <label for="email" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <input type="text" id="email" name="email" class="form-control validate[required, custom[email]]" />
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
      <label for="estado" class="col-sm-2 control-label">Estado</label>
      <div class="col-sm-4">
        <select id="estado" name="estado" class="selectpicker validate[required]">
			     <option disabled>Seleccione</option>
           <option value="1" selected>Activo</option>
           <option value="0">Inactivo</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="especialidad" class="col-sm-2 control-label">Especialidad</label>
      <div class="col-sm-4" id="div-especialidad">
          <select id="especialidad" name="especialidad[]" class="selectpicker especialidad validate[required]" data-live-search="true" multiple>
             <?php if($especialidades){ ?>
             <?php foreach($especialidades as $especialidad){ ?>
                <option value="<?php echo $especialidad->codigo; ?>"><?php echo $especialidad->nombre; ?></option>
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

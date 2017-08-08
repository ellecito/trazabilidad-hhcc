<div class="page-header">
  <h1>Agregar Funcionario</h1>
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
      <label for="password" class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="password" id="password" name="password" class="form-control validate[required]" />
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
      <label for="tipo" class="col-sm-2 control-label">Tipo Funcionario</label>
      <div class="col-sm-4">
        <select id="tipo" name="tipo" class="selectpicker validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($tipos){ ?>
           <?php foreach($tipos as $tipo){ ?>
              <option value="<?php echo $tipo->codigo; ?>"><?php echo $tipo->nombre; ?></option>
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

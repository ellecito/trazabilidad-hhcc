<div class="page-header">
  <h1>Agregar Funcionario</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">Rut</label>
      <div class="col-sm-10">
        <input type="text" id="rut" name="rut" class="form-control validate[required]" value="<?php echo $funcionario->rut; ?>" />
        <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $funcionario->codigo; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <input type="text" id="email" name="email" class="form-control validate[required, custom[email]]" value="<?php echo $funcionario->email; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="nombres" class="col-sm-2 control-label">Nombres</label>
      <div class="col-sm-10">
        <input type="text" id="nombres" name="nombres" class="form-control validate[required]" value="<?php echo $funcionario->nombres; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
      <div class="col-sm-10">
        <input type="text" id="apellidos" name="apellidos" class="form-control validate[required]" value="<?php echo $funcionario->apellidos; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="estado" class="col-sm-2 control-label">Estado</label>
      <div class="col-sm-4">
        <select id="estado" name="estado" class="selectpicker validate[required]">
           <option disabled>Seleccione</option>
           <option value="1" <?php if($funcionario->estado) echo "selected"; ?>>Activo</option>
           <option value="0" <?php if(!$funcionario->estado) echo "selected"; ?>>Inactivo</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="tipo" class="col-sm-2 control-label">Tipo Funcionario</label>
      <div class="col-sm-4">
        <select id="tipo" name="tipo" class="selectpicker validate[required]">
           <option disabled>Seleccione</option>
           <?php if($tipos){ ?>
           <?php foreach($tipos as $tipo){ ?>
              <option value="<?php echo $tipo->codigo; ?>"  <?php if($funcionario->ti_codigo == $tipo->codigo) echo "selected"; ?>><?php echo $tipo->nombre; ?></option>
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

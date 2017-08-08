<div class="page-header">
  <h1><?php echo $this->session->userdata("usuario")->nombres . " " . $this->session->userdata("usuario")->apellidos;?></h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal" autocomplete="off">
  <fieldset>
    <div class="form-group">
      <label for="rut" class="col-sm-2 control-label">RUT</label>
      <div class="col-sm-10">
        <input disabled type="text" id="rut" name="rut" class="form-control validate[required]" value="<?php echo $this->session->userdata("usuario")->rut;?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="nombres" class="col-sm-2 control-label">Nombres</label>
      <div class="col-sm-10">
        <input type="text" id="nombres" name="nombres" class="form-control validate[required]" value="<?php echo $this->session->userdata("usuario")->nombres;?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
      <div class="col-sm-10">
        <input type="text" id="apellidos" name="apellidos" class="form-control validate[required]" value="<?php echo $this->session->userdata("usuario")->apellidos;?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <input type="text" id="email"  name="email" class="form-control validate[required, custom[email]]" value="<?php echo $this->session->userdata("usuario")->email;?>"  />
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>
<hr>
<div class="page-header">
  <h1>Cambiar Contraseña</h1>
</div>
<form id="form-password" name="form-password" method="post" class="form-horizontal" autocomplete="off">
  <fieldset>
    <div class="form-group">
      <label for="passactual" class="col-sm-2 control-label">Contraseña Actual</label>
      <div class="col-sm-10">
        <input type="password" id="passactual" autocomplete="false" name="passactual" class="form-control validate[required]" />
      </div>
    </div>
	<div class="form-group">
      <label for="passnueva" class="col-sm-2 control-label">Contraseña Nueva</label>
      <div class="col-sm-10">
        <input type="password" id="passnueva" autocomplete="false" name="passnueva" class="form-control validate[required, minSize[5]]" />
      </div>
    </div>
	<div class="form-group">
      <label for="repetirpass" class="col-sm-2 control-label">Repetir Contraseña</label>
      <div class="col-sm-10">
        <input type="password" id="repetirpass" autocomplete="false" name="repetirpass" class="form-control validate[required, equals[passnueva]" />
      </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </fieldset>
</form>

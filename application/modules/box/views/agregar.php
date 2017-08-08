<div class="page-header">
  <h1>Agregar Box</h1>
</div>
<form id="form-agregar" name="form-agregar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" />
      </div>
    </div>
    <div class="form-group">
      <label for="unidad" class="col-sm-2 control-label">Unidad</label>
      <div class="col-sm-4">
        <select id="unidad" name="unidad" class="selectpicker validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($unidades){ ?>
           <?php foreach($unidades as $unidad){ ?>
              <option value="<?php echo $unidad->codigo; ?>"><?php echo $unidad->nombre; ?></option>
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
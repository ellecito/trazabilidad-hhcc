<div class="page-header">
  <h1>Editar Unidad</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $box->nombre; ?>" />
        <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $box->codigo; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="unidad" class="col-sm-2 control-label">Unidad</label>
      <div class="col-sm-4">
        <select id="unidad" name="unidad" class="selectpicker validate[required]">
           <option disabled>Seleccione</option>
           <?php if($unidades){ ?>
           <?php foreach($unidades as $unidad){ ?>
              <option value="<?php echo $unidad->codigo; ?>" <?php if($unidad->codigo == $box->un_codigo) echo "selected";?>><?php echo $unidad->nombre; ?></option>
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
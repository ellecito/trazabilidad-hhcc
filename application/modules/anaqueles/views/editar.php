<div class="page-header">
  <h1>Editar Anaquel</h1>
</div>
<form id="form-editar" name="form-editar" method="post" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
      <div class="col-sm-10">
        <input type="text" id="nombre" name="nombre" class="form-control validate[required]" value="<?php echo $anaquel->nombre; ?>" />
        <input type="hidden" id="codigo" name="codigo" class="form-control validate[required]" value="<?php echo $anaquel->codigo; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="bodega" class="col-sm-2 control-label">Bodega</label>
      <div class="col-sm-4">
        <select id="bodega" name="bodega" class="selectpicker validate[required]">
           <option disabled>Seleccione</option>
           <?php if($bodegas){ ?>
           <?php foreach($bodegas as $bodega){ ?>
              <option value="<?php echo $bodega->codigo; ?>" <?php if($bodega->codigo == $anaquel->bo_codigo) echo "selected";?>><?php echo $bodega->nombre; ?></option>
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
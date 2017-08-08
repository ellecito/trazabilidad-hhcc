<div class="page-header">
  <h1>Agregar División</h1>
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
      <label for="rango_min" class="col-sm-2 control-label">Rango Mínimo</label>
      <div class="col-sm-10">
        <input type="text" id="rango_min" name="rango_min" class="form-control validate[required, custom[number]]" />
      </div>
    </div>
    <div class="form-group">
      <label for="rango_max" class="col-sm-2 control-label">Rango Máximo</label>
      <div class="col-sm-10">
        <input type="text" id="rango_max" name="rango_max" class="form-control validate[required, custom[number]]" />
      </div>
    </div>
    <div class="form-group">
      <label for="anaquel" class="col-sm-2 control-label">Anaquel</label>
      <div class="col-sm-4">
        <select id="anaquel" name="anaquel" class="selectpicker validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($anaqueles){ ?>
           <?php foreach($anaqueles as $anaquel){ ?>
              <option value="<?php echo $anaquel->codigo; ?>"><?php echo $anaquel->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="funcionario" class="col-sm-2 control-label">Funcionario</label>
      <div class="col-sm-4">
        <select id="funcionario" name="funcionario" class="selectpicker validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($funcionarios){ ?>
           <?php foreach($funcionarios as $funcionario){ ?>
              <option value="<?php echo $funcionario->codigo; ?>"><?php echo $funcionario->nombres . " " . $funcionario->apellidos; ?></option>
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
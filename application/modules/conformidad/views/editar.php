<div class="page-header">
  <h1>Editar Conformidad</h1>
  
</div>
<form class="form-horizontal" id="form-editar">
  <div class="form-group">
    <label for="paciente" class="col-sm-2 control-label">Paciente</label>
    <div class="col-sm-4">
      <select id="paciente" name="paciente" class="selectpicker with-ajax validate[required]" data-live-search="true">
           <option value="<?php echo $paciente->codigo; ?>" selected data-subtext="<?php echo $paciente->rut . " | " . $paciente->nombres . " " . $paciente->apellidos;  ?>"><?php echo $paciente->hhcc; ?></option>
        </select>
    </div>
    <label for="cantidad" class="col-sm-2 control-label">Cantidad</label>
    <div class="col-sm-4">
      <input type="text" id="cantidad" name="cantidad" class="form-control validate[required, custom[number]]" value="<?php echo $conformidad->cantidad; ?>" />
      <input type="hidden" id="codigo" name="codigo" value="<?php echo $conformidad->codigo; ?>" />
    </div>
  </div>

  <div class="form-group">
    <label for="motivo" class="col-sm-2 control-label">Motivo</label>
    <div class="col-sm-4">
      <select id="motivo" name="motivo" class="selectpicker validate[required]">
           <option disabled>Seleccione</option>
           <?php if($motivos){ ?>
           <?php foreach($motivos as $motivo){ ?>
           <option value="<?php echo $motivo->codigo; ?>" <?php if($motivo->codigo == $conformidad->tc_codigo) echo "selected"; ?>><?php echo $motivo->nombre; ?></option>
           <?php } ?>
           <?php } ?>
           
        </select>
    </div>
    <label for="detalle" class="col-sm-2 control-label">Detalle</label>
    <div class="col-sm-4">
    <textarea name="detalle" id="detalle" class="form-control"><?php echo $conformidad->obs; ?></textarea>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </div>
</form>
<div class="page-header">
	<h1>Agregar Solicitud</h1>
	
</div>
<form class="form-horizontal" id="form-agregar">
  <div class="form-group">
    <label for="paciente" class="col-sm-2 control-label">Paciente</label>
    <div class="col-sm-4">
      <select id="paciente" name="paciente" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($pacientes){ ?>
           <?php foreach($pacientes as $paciente){ ?>
           <option value="<?php echo $paciente->codigo; ?>"><?php echo $paciente->rut . " | " .$paciente->nombres . " " . $paciente->apellidos; ?></option>
           <?php } ?>
           <?php } ?>
           
        </select>
    </div>
    <label for="fecha_entrega" class="col-sm-2 control-label">Fecha Entrega</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha_entrega" type="text" class="form-control" name="fecha_entrega" value="<?php echo date("d/m/Y"); ?>"/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
    </div>
  </div>

  <div class="form-group">
    <label for="fecha_retorno" class="col-sm-2 control-label">Fecha Devolución</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha_retorno" type="text" class="form-control" name="fecha_retorno" value="<?php echo date("d/m/Y"); ?>"/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
    </div>
    <label for="medico" class="col-sm-2 control-label">Medico</label>
    <div class="col-sm-4">
      <select id="medico" name="medico" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <?php if($medicos){ ?>
           <?php foreach($medicos as $medico){ ?>
           <option value="<?php echo $medico->codigo; ?>"><?php echo $medico->rut . " | " . $medico->nombres . " " . $medico->apellidos; ?></option>
           <?php } ?>
           <?php } ?>
           
        </select>
    </div>
  </div>
  <div class="form-group">
    <label for="motivo" class="col-sm-2 control-label">Motivo</label>
    <div class="col-sm-4">
      <select id="motivo" name="motivo" class="selectpicker validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($motivos){ ?>
           <?php foreach($motivos as $motivo){ ?>
           <option value="<?php echo $motivo->codigo; ?>"><?php echo $motivo->nombre; ?></option>
           <?php } ?>
           <?php } ?>
           
        </select>
    </div>
    <label for="detalle" class="col-sm-2 control-label">Detalle</label>
    <div class="col-sm-4">
    <textarea name="detalle" id="detalle" class="form-control"></textarea>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </div>
</form>
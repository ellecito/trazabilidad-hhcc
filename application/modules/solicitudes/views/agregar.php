<div class="page-header">
	<h1>Agregar Solicitud</h1>
	
</div>
<form class="form-horizontal" id="form-agregar">
  <div class="form-group">
    <label for="paciente" class="col-sm-2 control-label">Paciente</label>
    <div class="col-sm-4">
      <select id="paciente" name="paciente" class="selectpicker validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($pacientes){ ?>
           <?php foreach($pacientes as $paciente){ ?>
           <option value="<?php echo $paciente->rut; ?>"><?php echo $paciente->nombres . " " . $paciente->apellidos; ?></option>
           <?php } ?>
           <?php } ?>
           
        </select>
    </div>
    <label for="fecha" class="col-sm-2 control-label">Fecha</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="datepicker" type="text" class="form-control" name="fecha"/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
    </div>
  </div>

  <div class="form-group">
    <label for="funcionario" class="col-sm-2 control-label">Funcionario</label>
    <div class="col-sm-4">
      <select id="funcionario" name="funcionario" class="selectpicker validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($funcionarios){ ?>
           <?php foreach($funcionarios as $funcionario){ ?>
           <option value="<?php echo $funcionario->rut; ?>"><?php echo $funcionario->nombres . " " . $funcionario->apellidos; ?></option>
           <?php } ?>
           <?php } ?>
           
        </select>
    </div>
    <label for="medico" class="col-sm-2 control-label">Medico</label>
    <div class="col-sm-4">
      <select id="medico" name="medico" class="selectpicker validate[required]">
           <option disabled selected>Seleccione</option>
           <?php if($medicos){ ?>
           <?php foreach($medicos as $medico){ ?>
           <option value="<?php echo $medico->rut; ?>"><?php echo $medico->nombres . " " . $medico->apellidos; ?></option>
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
    <label for="fecha" class="col-sm-2 control-label"></label>
    <div class="col-sm-4">
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </div>
</form>
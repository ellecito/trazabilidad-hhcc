<div class="page-header">
	<h1>Generar Barras</h1>
	
</div>
<form class="form-horizontal" id="form-agregar">
  <div class="form-group">
    <label for="paciente" class="col-sm-2 control-label">Paciente</label>
    <div class="col-sm-4">
      	<select id="paciente" name="paciente" class="selectpicker validate[required]" data-live-search="true">
           <?php if($pacientes){ ?>
           <option value="all" selected>Todos</option>
           <?php foreach($pacientes as $paciente){ ?>
           <option value="<?php echo $paciente->codigo; ?>"><?php echo $paciente->rut . " | " . $paciente->nombres . " " . $paciente->apellidos; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
    </div>
    <label for="estado" class="col-sm-2 control-label">Estado</label>
    <div class="col-sm-4">
    	<select id="estado" name="estado" class="selectpicker validate[required]">
    		<option value="all" selected>Todos</option>
          	<option value="1">Activos</option>
          	<option value="0">Fallecidos</option>
        </select>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </div>
</form>
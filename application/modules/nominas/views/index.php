<div class="page-header">
	<h1>Generar Nominas</h1>
	
</div>
<form class="form-horizontal" id="form-agregar" method=POST action="calculo/">
  <div class="form-group">
    <label for="fecha" class="col-sm-2 control-label">Fecha Solicitud</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha" type="text" class="form-control" name="fecha" value="<?php echo date("d/m/Y", strtotime("+1 day")); ?>"/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
    </div>
    <label for="medicos" class="col-sm-2 control-label">Medicos</label>
    <div class="col-sm-4">
      <select id="medicos" name="medicos[]" class="selectpicker validate[required]" multiple data-live-search="true">
           <?php if($medicos){ ?>
           <?php foreach($medicos as $medico){ ?>
           <option value="<?php echo $medico->codigo; ?>" selected><?php echo $medico->nombres . " " . $medico->apellidos; ?></option>
           <?php } ?>
           <?php } ?>
           
        </select>
    </div>
  </div>
  <div class="form-group">
    <label for="boxs" class="col-sm-2 control-label">Boxs</label>
    <div class="col-sm-4">
      	<select id="boxs" name="boxs[]" class="selectpicker validate[required]" multiple data-live-search="true">
           <?php if($boxs){ ?>
           <?php foreach($boxs as $box){ ?>
           <option value="<?php echo $box->codigo; ?>" selected><?php echo $box->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
    </div>
    <label for="especialidades" class="col-sm-2 control-label">Especialidades</label>
    <div class="col-sm-4">
    	<select id="especialidades" name="especialidades[]" class="selectpicker validate[required]" multiple data-live-search="true">
           <?php if($especialidades){ ?>
           <?php foreach($especialidades as $especialidad){ ?>
           <option value="<?php echo $especialidad->codigo; ?>" selected><?php echo $especialidad->nombre; ?></option>
           <?php } ?>
           <?php } ?> 
        </select>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </div>
</form>
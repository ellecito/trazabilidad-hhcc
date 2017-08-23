<div class="page-header">
	<h1>Calculo de Nominas</h1>
	
</div>
<form class="form-horizontal" id="form-agregar" method=POST action="calculo/">
  <div class="form-group">
    <label for="fecha" class="col-sm-2 control-label">Fecha Solicitud</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha" type="text" class="form-control" name="fecha" value="<?php echo date("d/m/Y", strtotime("+1 day")); ?>"/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
    </div>
    <label for="medicos" class="col-sm-2 control-label">Médicos</label>
    <div class="col-sm-4">
      <select id="medicos" name="medicos[]" class="selectpicker validate[required]" multiple data-live-search="true" data-actions-box="true">
           <?php if($medicos){ ?>
           <?php foreach($medicos as $medico){ ?>
           <option value="<?php echo $medico->codigo; ?>" selected><?php echo $medico->rut . " | " . $medico->nombres . " " . $medico->apellidos; ?></option>
           <?php } ?>
           <?php } ?>
           
        </select>
    </div>
  </div>
  <div class="form-group">
    <label for="boxs" class="col-sm-2 control-label">Unidades</label>
    <div class="col-sm-4">
      	<select id="boxs" name="boxs[]" class="selectpicker validate[required]" multiple data-live-search="true" data-actions-box="true">
           <?php if($boxs){ ?>
           <?php foreach($boxs as $box){ ?>
           <option value="<?php echo $box->codigo; ?>" selected><?php echo $box->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
    </div>
    <label for="especialidades" class="col-sm-2 control-label">Especialidades</label>
    <div class="col-sm-4">
    	<select id="especialidades" name="especialidades[]" class="selectpicker validate[required]" multiple data-live-search="true" data-actions-box="true">
           <?php if($especialidades){ ?>
           <?php foreach($especialidades as $especialidad){ ?>
           <option value="<?php echo $especialidad->codigo; ?>" selected><?php echo $especialidad->nombre; ?></option>
           <?php } ?>
           <?php } ?> 
        </select>
    </div>
  </div>

  <div class="form-group">
    <label for="clases" class="col-sm-2 control-label">Clases</label>
    <div class="col-sm-4">
        <select id="clases" name="clases[]" class="selectpicker validate[required]" multiple data-live-search="true" data-actions-box="true">
           <?php if($clases){ ?>
           <?php foreach($clases as $clase){ ?>
           <option value="<?php echo $clase->codigo; ?>" selected><?php echo $clase->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
    </div>
    <label for="coberturas" class="col-sm-2 control-label">Coberturas</label>
    <div class="col-sm-4">
      <select id="coberturas" name="coberturas[]" class="selectpicker validate[required]" multiple data-live-search="true" data-actions-box="true">
           <?php if($coberturas){ ?>
           <?php foreach($coberturas as $cobertura){ ?>
           <option value="<?php echo $cobertura->codigo; ?>" selected><?php echo $cobertura->nombre; ?></option>
           <?php } ?>
           <?php } ?> 
        </select>
    </div>
  </div>

  <div class="form-group">
    <label for="canales" class="col-sm-2 control-label">Canales</label>
    <div class="col-sm-4">
        <select id="canales" name="canales[]" class="selectpicker validate[required]" multiple data-live-search="true" data-actions-box="true">
           <?php if($canales){ ?>
           <?php foreach($canales as $canal){ ?>
           <option value="<?php echo $canal->codigo; ?>" selected><?php echo $canal->nombre; ?></option>
           <?php } ?>
           <?php } ?>
        </select>
    </div>
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-4">
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </div>
</form>

<form class="form-horizontal" id="form-importar" method="POST" enctype="multipart/form-data">
  <a href="ejemplo">Descargar ejemplo</a>
  <div class="form-group">
    <label for="archivo" class="col-sm-2 control-label">Importar Traza</label>
    <div class="col-sm-8">
      <input id="archivo" type="file" class="nicefileinput nice" name="archivo" accept=".xls,.xlsx"/>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Subir</button>
    </div>
  </div>
</form>
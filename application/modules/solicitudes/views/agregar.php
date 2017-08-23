<div class="page-header" style="text-align: center;">
	<h1>Formulario de Solicitud</h1>	
</div>
<form class="form-horizontal" id="form-agregar">

  <div class="form-group">
    <label for="medico" class="col-sm-2 control-label">Profesional:</label>
    <div class="col-sm-4">
      <select id="medico" name="medico" class="selectpicker validate[required]" data-live-search="true">
           <option disabled selected>Seleccione</option>
           <option value="0">Externo</option>
           <?php if($medicos){ ?>
           <?php foreach($medicos as $medico){ ?>
           <option value="<?php echo $medico->codigo; ?>"><?php echo $medico->rut . " | " . $medico->nombres . " " . $medico->apellidos; ?></option>
           <?php } ?>
           <?php } ?>
           
        </select>
    </div>
    <label for="anexo" class="col-sm-2 control-label">Anexo:</label>
    <div class="col-sm-4">
      <input type="text" id="anexo" name="anexo" class="form-control validate[required, custom[integer]]" />
    </div>
  </div>

  <div class="form-group">
    <label for="especialidad" class="col-sm-2 control-label">Especialidad:</label>
    <div class="col-sm-4">
      <input readonly type="text" id="especialidad" name="especialidad" class="form-control" />
    </div>
    <label for="telefono" class="col-sm-2 control-label">Fono:</label>
    <div class="col-sm-4">
      <input type="text" id="telefono" name="telefono" class="form-control validate[required, custom[phone]]" />
    </div>
  </div>

  <div class="form-group">
    <label for="servicio" class="col-sm-2 control-label">Servicio:</label>
    <div class="col-sm-4">
      <input readonly type="text" id="servicio" name="servicio" class="form-control" />
    </div>
    <label for="celular" class="col-sm-2 control-label">Celular:</label>
    <div class="col-sm-4">
      <input type="text" id="celular" name="celular" class="form-control validate[required, custom[phone]]" />
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
  </div>

  <div class="form-group">
    <label for="paciente" class="col-sm-2 control-label">Paciente</label>
    <div class="col-sm-4">
      <select id="paciente" name="paciente[]" class="selectpicker validate[required]" data-live-search="true" multiple>
           <?php if($pacientes){ ?>
           <?php foreach($pacientes as $paciente){ ?>
           <option value="<?php echo $paciente->codigo; ?>"><?php echo $paciente->hhcc . " | " . $paciente->rut . " | " .$paciente->nombres . " " . $paciente->apellidos; ?></option>
           <?php } ?>
           <?php } ?>
           
        </select>
    </div>
    <label for="fecha_entrega" class="col-sm-2 control-label">Fecha Solicitud</label>
    <div class="col-sm-4">
      <div class="input-group date">
        <input id="fecha_entrega" type="text" class="form-control" name="fecha_entrega" value="<?php echo date("d/m/Y"); ?>"/>
        <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
    </div>
    <div class="text-box">
      <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
    </div>
  </div>

  <div class="form-group" style="display: none;" id="hide_medico2">
    <label for="documento" class="col-sm-2 control-label">Documento</label>
    <div class="col-sm-4">
      <input id="documento" type="file" class="nicefileinput nice" name="documento" accept=".pdf, .doc, .docx"/>
    </div>
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-4">
    </div>
  </div>

  <div class="form-group" style="display: none;" id="hide_medico1">
    <label for="nombre" class="col-sm-2 control-label">Nombre Médico</label>
    <div class="col-sm-4">
      <input type="text" id="nombre" name="nombre" class="form-control validate[required]" />
    </div>
    <label for="email" class="col-sm-2 control-label">Email Médico</label>
    <div class="col-sm-4">
    <input type="text" id="email" name="email" class="form-control validate[required, custom[email]]" />
    </div>
  </div>
</form>
<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Solicitudes</h1>
    <div class="col-md-3" style="margin-top:24px;">
        <form class="form-inline" method="get" action="<?php echo base_url(); ?>solicitudes/">
      <div class="input-group">
        <input type="text"  value="<?php echo $q_f; ?>" name="q" class="form-control">
        <span class="input-group-btn">
        <button type="submit" class="btn btn-default"><i class="icon-search"></i></button>
        </span></div>
    </form>
    </div>
    <div class="col-md-2" style=" margin:24px 0 10px;">
      <div class="text-center new">
        <button onclick="javascript:location.href='<?php echo base_url(); ?>solicitudes/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
      </div>
    </div>
  </div>
</div>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col">Código</th>
        <th scope="col">Fecha Emision</th>
        <th scope="col">Fecha Solicitud</th>
        <th scope="col">Fecha Devolución</th>
        <th scope="col">Medico</th>
        <th scope="col">Motivo</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $solicitud): ?>
				<tr>
					<td><?php echo $solicitud->codigo; ?></td>
					<td><?php echo formatearFecha(substr($solicitud->fecha_emision, 0, 10));?></td>
          <td><?php echo formatearFecha(substr($solicitud->fecha_asignada, 0, 10));?></td>
          <td><?php echo formatearFecha(substr($solicitud->fecha_entrega, 0, 10));?></td>
          <td><?php if($solicitud->medico) echo $solicitud->medico->rut . " | " . $solicitud->medico->nombres . " " . $solicitud->medico->apellidos; if(!$solicitud->medico) echo "Externo: " . $solicitud->nombre_medico; ?></td>
          <td><?php echo $solicitud->motivo->nombre; ?></td>
					<td class="editar">
						<a href="<?php echo base_url(); ?>solicitudes/editar/<?php echo $solicitud->codigo; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
						</a>
            <a href="<?php echo base_url(); ?>solicitudes/descargar/<?php echo $solicitud->codigo; ?>">
              <button title="Descargar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></button>
            </a>
					</td>
				</tr>
			<?php endforeach;?>
		<?php } else{ ?>
			<tr>
				<td colspan="4" style="text-align:center;"><i>No hay registros</i></td>
			</tr>
		<?php } ?>
    </tbody>
  </table>
</div>

<!-- [PAGINACION] -->
<?php echo $pagination; ?>
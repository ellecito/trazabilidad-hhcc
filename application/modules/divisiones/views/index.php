<div class="page-header">
  <div class="row">
    <h1 class="col-md-7">Divisiones</h1>
    <div class="col-md-3" style="margin-top:24px;">
        <form class="form-inline" method="get" action="<?php echo base_url(); ?>divisiones/">
      <div class="input-group">
        <input type="text"  value="<?php echo $q_f; ?>" name="q" class="form-control">
        <span class="input-group-btn">
        <button type="submit" class="btn btn-default"><i class="icon-search"></i></button>
        </span></div>
    </form>
    </div>
    <div class="col-md-2" style=" margin:24px 0 10px;">
      <div class="text-center new">
        <button onclick="javascript:location.href='<?php echo base_url(); ?>divisiones/agregar/'" type="button" class="btn btn-primary col-md-12">Agregar</button>
      </div>
    </div>
  </div>
</div>
<div class="thumbnail table-responsive all-responsive" id="multiselectForm">
  <table border="0" cellspacing="0" cellpadding="0" class="table" style="margin-bottom:0;">
    <thead>
      <tr>
        <th scope="col" style="width:90px;">Código</th>
        <th scope="col" style="width:90px;">Nombre</th>
        <th scope="col" style="width:90px;">Rango Mínimo</th>
        <th scope="col" style="width:90px;">Rango Máximo</th>
        <th scope="col" style="width:90px;">Anaquel</th>
        <th scope="col" style="width:90px;">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="table-hover">
		<?php if($datos){ ?>
			<?php foreach($datos as $division): ?>
				<tr>
					<td><?php echo $division->codigo; ?></td>
					<td><?php echo $division->nombre;?></td>
          <td><?php echo $division->rango_min;?></td>
          <td><?php echo $division->rango_max;?></td>
          <td><?php echo $division->anaquel->nombre;?></td>
					<td class="editar">
            <a class="eliminar" rel="<?php echo $division->codigo; ?>" href="#">
              <button title="Ver" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </a>

						<a href="<?php echo base_url(); ?>divisiones/editar/<?php echo $division->codigo; ?>">
							<button title="Editar" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
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
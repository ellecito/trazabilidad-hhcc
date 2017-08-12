<div class="page-header">
  <h1>Nominas</h1>
</div>
Script se demoro <?php echo round($timediff); ?> segundos.
<a href="pdf/">PDF</a>
<?php foreach($nominas as $nomina){ ?>
	<h1>NOMINA: <?php echo $nomina->codigo; ?></h1>
	<h3>PROFESIONAL: <?php echo $nomina->medico->codigo . " | " . $nomina->medico->nombres . " " . $nomina->medico->apellidos;  ?></h3>
	<p>ESPECIALIDAD: <?php echo $nomina->medico->especialidad->nombre; ?></p>
	<p>FECHA CREACION: <?php echo formatearFecha(substr($nomina->fecha_creacion, 0, 10)) . " " . substr($nomina->fecha_creacion, 10, 6); ?></p>
	<p>FECHA DESPACHO: <?php echo formatearFecha(substr($nomina->fecha_asignacion, 0, 10)) . " 08:00:00"?></p>

	<table>
		<tr>
			<th>HHCC</th>
			<th>PACIENTE</th>
			<th>BOX</th>
		</tr>
		<?php foreach($nomina->pacientes as $paciente){ ?>
		<tr>
			<td><?php echo $paciente->hhcc; ?></td>
			<td><?php echo $paciente->nombres . " " . $paciente->apellidos; ?></td>
			<td><?php echo $paciente->box->nombre; ?></td>
		</tr>
		<?php } ?>
	</table>
	
<?php } ?>
<div class="page-header">
  <h1>Nominas</h1>
</div>
Script se demoro <?php echo round($timediff); ?> segundos.
<?php foreach($nominas as $nomina){ ?>
<center><h3>NOMINA HHCC</h3></center>
<table style="width: 100%;">
	<tr>
		<td><b>NOMINA</b></td>
		<td><?php echo $nomina->codigo; ?></td>
	</tr>
	<tr>
		<td><b>FEC. DESPACHO</b></td>
		<td><?php echo formatearFecha(substr($nomina->fecha_asignacion, 0, 10)) . " " . substr($nomina->fecha_asignacion, 10, 6);?></td>
		<td><b>LUGAR ENTREGA</b></td>
		<td><?php echo $nomina->ubicacion->codigo; ?></td>
		<td><?php echo $nomina->ubicacion->nombre; ?></td>
		<td><b>APROBADAS</b></td>
		<td><?php echo count($nomina->pacientes); ?></td>
	</tr>
	<tr>
		<td><b>FEC. CREACION</b></td>
		<td><?php echo formatearFecha(substr($nomina->fecha_creacion, 0, 10)) . " " . substr($nomina->fecha_creacion, 10, 6); ?></td>
		<td><b>SERVICIO</b></td>
		<td><?php echo $nomina->medico->servicio->codigo; ?></td>
		<td><?php echo $nomina->medico->servicio->nombre; ?></td>
		<td><b>RECHAZADAS</b></td>
		<td>0</td>
	</tr>
	<tr>
		<td><b>TIPO ATENCION</b></td>
		<td>AMB</td>
		<td><b>ESPECIALIDAD</b></td>
		<td><?php echo $nomina->medico->especialidad->codigo; ?></td>
		<td><?php echo $nomina->medico->especialidad->nombre; ?></td>
		<td><b>DEVUELTAS</b></td>
		<td>0</td>
	</tr>
	<tr>
		<td><b></b></td>
		<td></td>
		<td><b>PROFESIONAL</b></td>
		<td><?php echo $nomina->medico->codigo; ?></td>
		<td><?php echo $nomina->medico->nombres . " " . $nomina->medico->apellidos; ?></td>
		<td><b>TOTAL</b></td>
		<td><?php echo count($nomina->pacientes); ?></td>
	</tr>
	<tr style="border-top: 1px solid black; border-bottom: 1px solid black;">
		<td>HHCC</td>
		<td>NOMBRE PACIENTE</td>
		<td></td>
		<td>LUGAR USO</td>
		<td>HOR. DEV.</td>
		<td>ULTIMA UBICACION</td>
		<td></td>
	</tr>
	<?php foreach($nomina->pacientes as $paciente){ ?>
	<tr>
		<td><?php echo $paciente->hhcc; ?></td>
		<td><?php echo $paciente->nombres . " " . $paciente->apellidos; ?></td>
		<td></td>
		<td>LUGAR USO</td>
		<td>HOR. DEV.</td>
		<td>ULTIMA UBICACION</td>
		<td></td>
	</tr>
	<?php } ?>
</table>
<?php } ?>
<div class="page-header">
  <h1>Vouchers</h1>
</div>
<?php foreach($vouchers as $voucher){ ?>
<h3>FUNCIONARIO: <?php echo $voucher->funcionario->nombres . " " .  $voucher->funcionario->apellidos; ?></h3>
<h5>DIVISION: <?php echo $voucher->division->nombre . " | " . $voucher->division->anaquel->nombre . " | " . $voucher->bodega->nombre; ?></h5>
<h5>HHCC</h5>
<?php foreach($voucher->hhcc as $hhcc){ ?>
	<p><?php echo $hhcc; ?></p>
<?php } ?>
<?php } ?>
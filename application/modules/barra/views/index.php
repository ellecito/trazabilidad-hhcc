<div class="page-header">
  <h1>Generar Barra</h1>
</div>
<?php
foreach($pacientes as $paciente){
	echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($paciente->hhcc, $generator::TYPE_CODE_128)) . '"></br>';
	echo $paciente->rut;
	echo "</br>";
}
?>
<button onclick="window.print();">Imprimir</button>
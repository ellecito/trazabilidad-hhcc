<div class="page-header">
  <h1>Generar Barra</h1>
</div>
<?php
$rand = rand();
echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($rand, $generator::TYPE_CODE_128)) . '"></br>';
echo $rand;
?>
</br>
<button onclick="window.print();">Imprimir</button>
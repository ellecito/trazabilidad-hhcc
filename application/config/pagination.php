<?php

#config paginacion

#contenedor paginacion
$config['full_tag_open'] = '<div id="paginacion"><ul class="pagination paginationControl">';
$config['full_tag_close'] = '</ul><script type="text/javascript">$(document).ready(function () {$(".pagination").rPage();});</script></div>';

#primero
$config['first_link'] = '&lt&lt;';  

#siguiente
$config['next_link'] = 'Siguiente';
$config['next_tag_open'] = '<li class="page-away-2" style="display: inline;">';
$config['next_tag_close'] = '</li>';

#anterior
$config['prev_link'] = 'Anterior';
$config['prev_tag_open'] = '<li class="page-away-1" style="display: inline;">';
$config['prev_tag_close'] = '</li>';

#current
$config['cur_tag_open'] = '<li class="active page-away-0" style="display: inline;"><span>';
$config['cur_tag_close'] = '</span></li>';

#link
$config['num_tag_open'] = '<li class="page-away-1" style="display: inline;">';
$config['num_tag_close'] = '</li>';

#ultimo
$config['last_link'] = '';
//$config['last_link'] = '&gt&gt;';
$config['suffix'] = '/';
$config['use_page_numbers'] = TRUE;

$config['uri_segment'] = 2;

/* fin archivo pagination.php */
<?php 
$config = array(
	'contacto' => array(
		array(
			'field'=>'nombres',
			'label'=>'Nombres',
			'rules'=>'required'
		),
		array(
			'field'=>'apellidos',
			'label'=>'Apellidos',
			'rules'=>'required'
		),
		// array(
			// 'field'=>'telefono',
			// 'label'=>'Teléfono',
			// 'rules'=>'required'
		// ),
		array(
			'field'=>'email',
			'label'=>'Email',
			'rules'=>'required|valid_email'
		),
		array(
			'field'=>'mensaje',
			'label'=>'Mensaje',
			'rules'=>'required'
		)
	),
	'login' => array(
		array(
			'field'=>'email',
			'label'=>'Email',
			'rules'=>'required|valid_email'
		),
		array(
			'field'=>'contrasena',
			'label'=>'Contraseña',
			'rules'=>'required'
		)
	),
	'noticia' => array(
		array(
			'field'=>'titulo',
			'label'=>'Título',
			'rules'=>'required'
		),
		array(
			'field'=>'fecha',
			'label'=>'Fecha',
			'rules'=>'required'
		),
		array(
			'field'=>'categoria',
			'label'=>'Categoría',
			'rules'=>'required'
		),
		array(
			'field'=>'estado',
			'label'=>'Estado',
			'rules'=>'required'
		),
		array(
			'field'=>'resumen',
			'label'=>'Resumen',
			'rules'=>'required'
		)
	),
	'agenda' => array(
		array(
			'field'=>'nombre_actividad',
			'label'=>'Nombre Actividad',
			'rules'=>'required'
		),
		array(
			'field'=>'fecha',
			'label'=>'Fecha',
			'rules'=>'required'
		),
		array(
			'field'=>'hora',
			'label'=>'Hora',
			'rules'=>'required'
		),
		array(
			'field'=>'categoria',
			'label'=>'Categoría',
			'rules'=>'required'
		),
		array(
			'field'=>'estado',
			'label'=>'Estado',
			'rules'=>'required'
		),
		array(
			'field'=>'resumen',
			'label'=>'Resumen',
			'rules'=>'required'
		),
		array(
			'field'=>'contenido',
			'label'=>'Contenido',
			'rules'=>'required'
		),
		array(
			'field'=>'direccion',
			'label'=>'Dirección',
			'rules'=>'required'
		)
	)
);
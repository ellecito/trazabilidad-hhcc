CREATE TABLE tipo_funcionario(
	ti_codigo smallint PRIMARY KEY,
	ti_nombre varchar(20)
);

CREATE TABLE funcionario(
	fu_rut varchar(12) PRIMARY KEY,
	fu_nombres varchar(50),
	fu_apellidos varchar(50),
	fu_email varchar(50),
	fu_password varchar(256),
	fu_estado boolean,
	ti_codigo smallint,
	FOREIGN KEY (ti_codigo) REFERENCES tipo_funcionario(ti_codigo)
);

CREATE TABLE bodega(
	bo_codigo smallint PRIMARY KEY,
	bo_nombre varchar(30)
);

CREATE TABLE anaquel(
	an_codigo smallint PRIMARY KEY,
	an_nombre varchar(20),
	bo_codigo smallint,
	FOREIGN KEY (bo_codigo) REFERENCES bodega(bo_codigo)
);

CREATE TABLE division(
	di_codigo int PRIMARY KEY,
	di_nombre varchar(4),
	di_rango_min int,
	di_rango_max int,
	an_codigo smallint,
	FOREIGN KEY (an_codigo) REFERENCES anaquel(an_codigo)
);

CREATE TABLE especialidad(
	es_codigo smallint PRIMARY KEY,
	es_nombre varchar(30)
);

CREATE TABLE medico(
	me_rut varchar(12) PRIMARY KEY,
	me_nombres varchar(50),
	me_apellidos varchar(50),
	me_email varchar(50),
	me_estado boolean,
	es_codigo smallint,
	FOREIGN KEY (es_codigo) REFERENCES especialidad(es_codigo)
);

#FALTA TABLA CAJON, ANALIZAR.

CREATE TABLE paciente(
	pa_rut varchar(12) PRIMARY KEY,
	pa_nombres varchar(50),
	pa_apellidos varchar(50),
	pa_estado boolean,
	pa_hhcc bigint
);

CREATE TABLE motivo_solicitud(
	mo_codigo smallint PRIMARY KEY,
	mo_nombre varchar(20)
);

CREATE TABLE solicitud(
	so_codigo bigint PRIMARY KEY,
	so_fecha_emision datetime,
	so_fecha_asignada datetime,
	fu_rut varchar(12),
	pa_rut varchar(12),
	me_rut varchar(12),
	mo_codigo smallint,
	FOREIGN KEY (fu_rut) REFERENCES funcionario(fu_rut),
	FOREIGN KEY (pa_rut) REFERENCES paciente(pa_rut),
	FOREIGN KEY (me_rut) REFERENCES medico(me_rut),
	FOREIGN KEY (mo_codigo) REFERENCES motivo_solicitud(mo_codigo)
);

CREATE TABLE pasillo(
	pa_codigo smallint PRIMARY KEY,
	pa_nombre varchar(20)
);

CREATE TABLE box(
	bx_codigo smallint PRIMARY KEY,
	bx_nombre varchar(20),
	pa_codigo smallint,
	FOREIGN KEY (pa_codigo) REFERENCES pasillo(pa_codigo)
);

CREATE TABLE agenda(
	ag_codigo bigint PRIMARY KEY,
	ag_fecha_emision datetime,
	ag_fecha_asignada datetime,
	bx_codigo smallint,
	me_rut varchar(12),
	pa_rut varchar(12),
	FOREIGN KEY (bx_codigo) REFERENCES box(bx_codigo),
	FOREIGN KEY (me_rut) REFERENCES medico(me_rut),
	FOREIGN KEY (pa_rut) REFERENCES paciente(pa_rut)
);

CREATE TABLE nomina(
	no_codigo bigint PRIMARY KEY,
	no_fecha_emision datetime,
	no_fecha_asignada datetime
);

CREATE TABLE nomina_agenda(
	no_codigo bigint,
	ag_codigo bigint,
	FOREIGN KEY (no_codigo) REFERENCES nomina(no_codigo),
	FOREIGN KEY (ag_codigo) REFERENCES agenda(ag_codigo)
);

#FALTA TABLA TRAZABILIDAD Y ESTADO TRAZABILIDAD
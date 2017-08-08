/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     08/08/2017 15:00:24                          */
/*==============================================================*/


drop table if exists agenda;

drop table if exists anaquel;

drop table if exists bodega;

drop table if exists box;

drop table if exists cajon;

drop table if exists conformidad;

drop table if exists division;

drop table if exists especialidad;

drop table if exists estado_trazabilidad;

drop table if exists funcionario;

drop table if exists medico;

drop table if exists medico_especialidad;

drop table if exists motivo_solicitud;

drop table if exists nomina;

drop table if exists nomina_agenda;

drop table if exists paciente;

drop table if exists servicio;

drop table if exists solicitud;

drop table if exists tipo_conformidad;

drop table if exists tipo_funcionario;

drop table if exists trazabilidad;

drop table if exists trazabilidad_hhcc;

drop table if exists unidad;

/*==============================================================*/
/* Table: agenda                                                */
/*==============================================================*/
create table agenda
(
   ag_codigo            bigint not null,
   ag_hora_pedido       datetime,
   ag_hora_agendada     datetime,
   pa_codigo            bigint not null,
   me_codigo            bigint not null,
   bx_codigo            smallint not null,
   es_codigo            smallint not null,
   primary key (ag_codigo)
);

/*==============================================================*/
/* Table: anaquel                                               */
/*==============================================================*/
create table anaquel
(
   an_codigo            smallint not null,
   an_nombre            varchar(10),
   bo_codigo            smallint not null,
   primary key (an_codigo)
);

/*==============================================================*/
/* Table: bodega                                                */
/*==============================================================*/
create table bodega
(
   bo_codigo            smallint not null,
   bo_nombre            varchar(30),
   primary key (bo_codigo)
);

/*==============================================================*/
/* Table: box                                                   */
/*==============================================================*/
create table box
(
   bx_codigo            smallint not null,
   bx_nombre            varchar(20),
   un_codigo            smallint not null,
   primary key (bx_codigo)
);

/*==============================================================*/
/* Table: cajon                                                 */
/*==============================================================*/
create table cajon
(
   ca_codigo            smallint not null,
   ca_nombre            varchar(10),
   me_codigo            bigint,
   primary key (ca_codigo)
);

/*==============================================================*/
/* Table: conformidad                                           */
/*==============================================================*/
create table conformidad
(
   co_codigo            bigint not null,
   co_fecha             datetime,
   co_cantidad          smallint,
   co_obs               text,
   tc_codigo            int not null,
   pa_codigo            bigint not null,
   primary key (co_codigo)
);

/*==============================================================*/
/* Table: division                                              */
/*==============================================================*/
create table division
(
   di_codigo            int not null,
   di_nombre            varchar(4),
   di_rango_min         int,
   di_rango_max         int,
   an_codigo            smallint,
   fu_codigo            bigint not null,
   primary key (di_codigo)
);

/*==============================================================*/
/* Table: especialidad                                          */
/*==============================================================*/
create table especialidad
(
   es_codigo            smallint not null,
   es_nombre            varchar(30),
   se_codigo            bigint not null,
   primary key (es_codigo)
);

/*==============================================================*/
/* Table: estado_trazabilidad                                   */
/*==============================================================*/
create table estado_trazabilidad
(
   et_codigo            smallint not null,
   et_nombre            varchar(20),
   primary key (et_codigo)
);

/*==============================================================*/
/* Table: funcionario                                           */
/*==============================================================*/
create table funcionario
(
   fu_codigo            bigint not null,
   fu_rut               varchar(12),
   fu_nombres           varchar(50),
   fu_apellidos         varchar(50),
   fu_email             varchar(50),
   fu_password          varchar(256),
   fu_estado            bool,
   ti_codigo            smallint not null,
   primary key (fu_codigo)
);

/*==============================================================*/
/* Table: medico                                                */
/*==============================================================*/
create table medico
(
   me_codigo            bigint not null,
   me_rut               varchar(12),
   me_nombres           varchar(50),
   me_apellidos         varchar(50),
   me_email             varchar(50),
   me_estado            bool,
   primary key (me_codigo)
);

/*==============================================================*/
/* Table: medico_especialidad                                   */
/*==============================================================*/
create table medico_especialidad
(
   me_codigo            bigint not null,
   es_codigo            smallint not null,
   primary key (me_codigo, es_codigo)
);

/*==============================================================*/
/* Table: motivo_solicitud                                      */
/*==============================================================*/
create table motivo_solicitud
(
   mo_codigo            smallint not null,
   mo_nombre            varchar(20),
   primary key (mo_codigo)
);

/*==============================================================*/
/* Table: nomina                                                */
/*==============================================================*/
create table nomina
(
   no_codigo            bigint not null,
   no_fecha_creada      datetime,
   no_fecha_asignada    datetime,
   me_codigo            bigint not null,
   primary key (no_codigo)
);

/*==============================================================*/
/* Table: nomina_agenda                                         */
/*==============================================================*/
create table nomina_agenda
(
   no_codigo            bigint not null,
   ag_codigo            bigint not null,
   primary key (no_codigo, ag_codigo)
);

/*==============================================================*/
/* Table: paciente                                              */
/*==============================================================*/
create table paciente
(
   pa_codigo            bigint not null,
   pa_rut               varchar(12),
   pa_nombres           varchar(50),
   pa_apellidos         varchar(50),
   pa_estado            bool,
   pa_hhcc              bigint,
   primary key (pa_codigo)
);

/*==============================================================*/
/* Table: servicio                                              */
/*==============================================================*/
create table servicio
(
   se_codigo            bigint not null,
   se_nombre            varchar(20),
   primary key (se_codigo)
);

/*==============================================================*/
/* Table: solicitud                                             */
/*==============================================================*/
create table solicitud
(
   so_codigo            bigint not null,
   so_fecha_emision     datetime,
   so_fecha_asignada    datetime,
   so_fecha_entrega     datetime,
   so_detalle           text,
   mo_codigo            smallint not null,
   fu_codigo            bigint not null,
   me_codigo            bigint not null,
   pa_codigo            bigint not null,
   primary key (so_codigo)
);

/*==============================================================*/
/* Table: tipo_conformidad                                      */
/*==============================================================*/
create table tipo_conformidad
(
   tc_codigo            int not null,
   tc_nombre            varchar(30),
   primary key (tc_codigo)
);

/*==============================================================*/
/* Table: tipo_funcionario                                      */
/*==============================================================*/
create table tipo_funcionario
(
   ti_codigo            smallint not null,
   ti_nombre            varchar(20),
   primary key (ti_codigo)
);

/*==============================================================*/
/* Table: trazabilidad                                          */
/*==============================================================*/
create table trazabilidad
(
   tr_codigo            bigint not null,
   tr_fecha             datetime,
   et_codigo            smallint not null,
   bx_codigo            smallint not null,
   primary key (tr_codigo)
);

/*==============================================================*/
/* Table: trazabilidad_hhcc                                     */
/*==============================================================*/
create table trazabilidad_hhcc
(
   pa_codigo            bigint not null,
   tr_codigo            bigint not null,
   primary key (pa_codigo, tr_codigo)
);

/*==============================================================*/
/* Table: unidad                                                */
/*==============================================================*/
create table unidad
(
   un_codigo            smallint not null,
   un_nombre            varchar(20),
   primary key (un_codigo)
);

alter table agenda add constraint fk_agenda_box foreign key (bx_codigo)
      references box (bx_codigo) on delete restrict on update restrict;

alter table agenda add constraint fk_agenda_especialidad foreign key (es_codigo)
      references especialidad (es_codigo) on delete restrict on update restrict;

alter table agenda add constraint fk_agenda_medico foreign key (me_codigo)
      references medico (me_codigo) on delete restrict on update restrict;

alter table agenda add constraint fk_paciente_agenda foreign key (pa_codigo)
      references paciente (pa_codigo) on delete restrict on update restrict;

alter table anaquel add constraint fk_bodega_anaquel foreign key (bo_codigo)
      references bodega (bo_codigo) on delete restrict on update restrict;

alter table box add constraint fk_pasillo_box foreign key (un_codigo)
      references unidad (un_codigo) on delete restrict on update restrict;

alter table cajon add constraint fk_medico_cajon foreign key (me_codigo)
      references medico (me_codigo) on delete restrict on update restrict;

alter table conformidad add constraint fk_paciente_conformidad foreign key (pa_codigo)
      references paciente (pa_codigo) on delete restrict on update restrict;

alter table conformidad add constraint fk_tipo_conformidad foreign key (tc_codigo)
      references tipo_conformidad (tc_codigo) on delete restrict on update restrict;

alter table division add constraint fk_anaquel_division foreign key (an_codigo)
      references anaquel (an_codigo) on delete restrict on update restrict;

alter table division add constraint fk_funcionario_division foreign key (fu_codigo)
      references funcionario (fu_codigo) on delete restrict on update restrict;

alter table especialidad add constraint fk_servicio_especialidad foreign key (se_codigo)
      references servicio (se_codigo) on delete restrict on update restrict;

alter table funcionario add constraint fk_funcionario_tipo foreign key (ti_codigo)
      references tipo_funcionario (ti_codigo) on delete restrict on update restrict;

alter table medico_especialidad add constraint fk_medico_especialidad foreign key (me_codigo)
      references medico (me_codigo) on delete restrict on update restrict;

alter table medico_especialidad add constraint fk_medico_especialidad2 foreign key (es_codigo)
      references especialidad (es_codigo) on delete restrict on update restrict;

alter table nomina add constraint fk_nomina_medico foreign key (me_codigo)
      references medico (me_codigo) on delete restrict on update restrict;

alter table nomina_agenda add constraint fk_nomina_agenda foreign key (no_codigo)
      references nomina (no_codigo) on delete restrict on update restrict;

alter table nomina_agenda add constraint fk_nomina_agenda2 foreign key (ag_codigo)
      references agenda (ag_codigo) on delete restrict on update restrict;

alter table solicitud add constraint fk_funcionario_solicitud foreign key (fu_codigo)
      references funcionario (fu_codigo) on delete restrict on update restrict;

alter table solicitud add constraint fk_paciente_solicitud foreign key (pa_codigo)
      references paciente (pa_codigo) on delete restrict on update restrict;

alter table solicitud add constraint fk_solicitud_medico foreign key (me_codigo)
      references medico (me_codigo) on delete restrict on update restrict;

alter table solicitud add constraint fk_solicitud_motivo foreign key (mo_codigo)
      references motivo_solicitud (mo_codigo) on delete restrict on update restrict;

alter table trazabilidad add constraint fk_trazabilidad_box foreign key (bx_codigo)
      references box (bx_codigo) on delete restrict on update restrict;

alter table trazabilidad add constraint fk_trazabilidad_estado foreign key (et_codigo)
      references estado_trazabilidad (et_codigo) on delete restrict on update restrict;

alter table trazabilidad_hhcc add constraint fk_trazabilidad_hhcc foreign key (pa_codigo)
      references paciente (pa_codigo) on delete restrict on update restrict;

alter table trazabilidad_hhcc add constraint fk_trazabilidad_hhcc2 foreign key (tr_codigo)
      references trazabilidad (tr_codigo) on delete restrict on update restrict;
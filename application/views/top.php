<?php if(isset($home_indicador)){ ?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="navbar-header"> 
	  <span class="navbar-brand">
		<img src="<?php echo base_url(); ?>imagenes/template/logo.png" width="101" height="90" />
	  </span> 
  </div>
</nav>
<?php }else{ ?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <span class="navbar-brand"><img src="<?php echo base_url(); ?>imagenes/template/logo2.png" width="101" height="40" /></span>
    </div>
    
    <div class="collapse navbar-collapse navbar-ex1-collapse" id="menu">
        <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $this->session->userdata("usuario")->email; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>perfil/"><i class="icon-user"></i> Perfil</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url(); ?>logout/"><i class="icon-power-off"></i> Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    
        <ul class="nav navbar-nav side-nav">
			<li><a href="<?php echo base_url(); ?>barra/">Generar Códigos de Barra</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Mantenedores <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>pacientes/">Pacientes</a></li>
                    <li><a href="<?php echo base_url(); ?>funcionarios/">Funcionarios</a></li>
                    <li><a href="<?php echo base_url(); ?>medicos/">Médicos</a></li>
                    <li><a href="<?php echo base_url(); ?>bodegas/">Bodegas</a></li>
                    <li><a href="<?php echo base_url(); ?>anaqueles/">Anaqueles</a></li>
                    <li><a href="<?php echo base_url(); ?>divisiones/">Divisiones</a></li>
                    <li><a href="<?php echo base_url(); ?>especialidades/">Especialidades</a></li>
                    <li><a href="<?php echo base_url(); ?>solicitudes/">Solicitudes</a></li>
                    <li><a href="<?php echo base_url(); ?>motivo-solicitudes/">Motivo Solicitudes</a></li>
                    <li><a href="<?php echo base_url(); ?>unidades/">Unidades</a></li>
                    <li><a href="<?php echo base_url(); ?>box/">Box</a></li>
                    <li><a href="<?php echo base_url(); ?>servicios/">Servicios</a></li>
                    <li><a href="<?php echo base_url(); ?>motivo-conforme/">Motivo Conforme</a></li>
                    <li><a href="<?php echo base_url(); ?>conformidad/">Conformidad</a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>solicitudes/">Formulario de Solicitud</a></li>
            <li><a href="<?php echo base_url(); ?>nominas/">Calculo de Nominas</a></li>
        </ul>
    </div>
</nav>
<?php } ?>

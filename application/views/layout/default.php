<!DOCTYPE html>
<html lang="es" xml:lang="es">
<!--[if IE 6]>
<html id="ie6" dir="ltr" lang="es-ES">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" dir="ltr" lang="es-ES">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" dir="ltr" lang="es-ES">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]>
<html dir="ltr" lang="es-ES">
<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="">
<meta http-equiv="Content-Language" content="es-ES">
<!-- Metas -->
<?php echo $this->layout->headMeta(); ?>

<!-- title -->
<title><?php echo $this->layout->getTitle(); ?></title>

<!-- CSS -->
<link rel="stylesheet" type="text/css"  href="https://fonts.googleapis.com/css?family=Titillium+Web:400,400italic,600,600italic,700,700italic" />
<?php echo $this->layout->getCss(); ?>

<!-- js -->
<script class="jsbin" src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.5.3/modernizr.min.js"></script>
<?php echo $this->layout->getJs(); ?>

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5-els.js"></script>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<script src="/js/sistema/template/index.js"></script>
<![endif]-->
<link href="/favicon.ico" rel="shortcut icon" />
<?php if($this->layout->current){ ?>
<script type="text/javascript">
$(document).ready(function(){
$("#menu > ul > li:nth-child(<?php echo $this->layout->current ?>)").addClass("active");
<?php if($this->layout->subCurrent){ ?>
$("#menu > ul > li:nth-child(<?php echo $this->layout->current ?>) > .dropdown-menu > li:nth-child(<?php echo $this->layout->subCurrent ?>)").addClass("active");
$("#menu > ul > li:nth-child(<?php echo $this->layout->current ?>)").addClass("open");
<?php } ?>
});
</script>
<?php } ?>
</head>
<body>
<!-- Top --> 
<?php echo $this->load->view('top'); ?> 

<!-- Contenido -->
<?php if(isset($home_indicador)){ ?>
<?=$content_for_layout?>
<!-- Footer --> 
<?php echo $this->load->view('footer'); ?>
<?php } else{ ?>
<div id="wrapper">
  <div id="page-wrapper">
    <?=$this->layout->getNav();?>
    <?=$content_for_layout?>
  </div>
</div>
<?php } ?>
</body>
</html>
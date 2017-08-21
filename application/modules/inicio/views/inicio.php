<style type="text/css">
#myModal{ overflow:hidden;}
@media screen and (min-width: 768px) {
.modal-dialog {
	width: 500px;
}
}
</style>
<div id="page-wrapper">
  <!-- contenido -->
  <div id="login" class="col-sm-4">
    <div class="page-header">
      <h1>SISTEMA DE TRAZABILIDAD HHCC</h1>
    </div>
    <form id="form-login" name="form-login" method="post" class="form-horizontal form-signin" role="form">
      <div class="form-group">
        <label for="inputEmail3">RUT</label>
        <input type="text" class="form-control validate[required]" id="rut" name="rut" autofocus />
      </div>
      <div class="form-group">
        <label for="inputPassword3">Password</label>
        <input type="password" class="form-control validate[required]" id="inputPassword3" name="password" />
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
        <br />
        <br />
        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal">Recuperar contraseña</button>
      </div>
    </form>
  </div>
</div>
<p id="clock" style="text-align: center;">
  <?php echo strftime("%A, %d de %B de %Y, %H:%M:%S", strtotime(date("Y-m-d H:i:s"))); ?>
</p>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title" id="myModalLabel">Recuperar contraseña</h3>
      </div>
      <div class="modal-body">
        <form role="form"  id="form-recuperar" method="post">
          <input type="text" name="email" placeholder="Indica tu email" class="form-control validate[required,custom[email]]" />

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
	  </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

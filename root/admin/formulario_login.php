<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_once('head.php');?>

<body>
    <div id="edit_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Service </h4>
                    Digite Usuario e Senha
                </div>
            <div class="modal-body">
            <form action="verifica_usuario.php" method="post" name="" id="">
                    <input type="hidden" value="edit" name="action" id="action">
                    <!--<input type="hidden" value="0" name="edit_id" id="edit_id">-->
                    <div class="form-group">
                        <label for="" class="control-label">Usuario:<input name="usuario"  class="form-control" type="text" id="usuario" /></label>
                        <label for="" class="control-label">Senha:<input name="senha" type="password" id="senha" /></label>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#edit_model').modal('show');
</script>
</body>
</html>
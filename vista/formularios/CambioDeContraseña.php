<div class="container">

  <div class="formLogin ">
  <?php while(($row=$this->UEH)!=null): ?>

    <form class="mt-5 mb-5 login-input" action="?c=seguros&a=CambioContra" onsubmit="return verificacion()" method="POST" name="Registar">

      <h4> Portal de cobradores </h4>
      <label>Usuario: <?php echo $row->getusuario();$row->getusuario(); ?></label><br>
      <label><h6> Cambiar contraseña </h6></label>
      <label>contraseña
        <input type="password" maxlength="20" placeholder="contraseña" id="contraseña" name="contraseña"></label><br>
      <label>confirmar
        <input type="password" maxlength="20" placeholder="confirmar" id="contraFirm" name="contraFirm"></label><br>
      <input id="id" name="id" type="hidden" value="<?php echo $row->getid(); ?>">
      <input id="usuario" name="usuario" type="hidden" value="<?php echo $row->getusuario(); ?>">
     
      <button class="btn btn-success btn-lg" type="submit"> Registar
      </button> 
      <?php break ?>
      <?php endwhile;?>
      </form>
  </div>
</div>
<script type="text/javascript">
    //la funcion de busqueda ase una busqueda en la tabla y regresa los resultados
    function verificacion() {
        var contraseña=document.getElementById("contraseña").value;
        var conConfirm=document.getElementById("contraFirm").value;

        if(contraseña == conConfirm){
            return true;
        }else{
            alert("Las contraseña no coinciden");
            return false;
        }

    }
</script>
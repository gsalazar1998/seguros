<div id="contenerdorG">
    <div>


        <div class="Modificar">

            <button type="button" class="btn btn-primary" id="Regresar" onclick="Regresar()">Regresar</button>
            <!-- <button type="button" class="btn btn-secondary" id="Editar" onclick="Editar()">Editar</button>-->
            <?php foreach ($this->lSeguroSOLOUNO as $reg_sect) : ?>
                <form name="frmSeguroEditor" action="?c=seguros&a=Actualizar" id="datos" method="POST">

                    <label>Oficina:<input id="OFICINA_Editor" name="OFICINA" type="text" value="<?php echo $reg_sect->getoficina() ?>" disabled="" required></label>
                   
                    <label>Descripcion:<input type="text" id="DESCRIPCION_Editor" name="DESCRIPCION" value="<?php echo $reg_sect->getdescripcion() ?>" disabled="" required></label>
                   
                    <label>limite seguro:<input type="text" id="LIM_SEGURO_Editor" name="LIM_SEGURO" min="1000000" max="99,999,999" maxlength="8"  value="<?php echo $reg_sect->getMax_valdec() ?>"  onkeypress="return (event.charCode>=48 && event.charCode<=57)" required></label>
                  
                    <input id="prodId" name="OFICINA" type="hidden" value="<?php echo $reg_sect->getoficina() ?>">
                    <input id="DESCId" name="DESCRIPCION" type="hidden" value="<?php echo $reg_sect->getdescripcion() ?>">
                    <button type="submit" id="btnguardar_Editor" class="btn btn-success" onclick="valicacionDeCamposVacios()" value="Editar">guardar</button>
                <?php endforeach; ?>
                <!--****************Este es un documento tipo javascript-->
                <script type="text/javascript">
                    //Esta es una funcion que regresa a la vista principal
                    function Regresar() {
                        window.location = "?c=seguros&a=genTabla";
                    }
                </script>
                </form>
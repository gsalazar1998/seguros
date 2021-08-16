<div id="contenerdorG">
    <div>


        <div class="Modificar">



            <form name="frmAgregar" action="?c=seguros&a=agregar" id="datos" method="POST">
        
                <label>Oficina:<input id="OFICINA" name="OFICINA" type="text"  maxlength="6" disabled="true" onkeypress="return (event.charCode>=48&&event.charCode<=57)" required></label>
                
                <label>Descripcion:<input type="text" id="DESCRIPCION" name="DESCRIPCION" required disabled="" onkeypress="return (event.charCode>=65 && event.charCode<=90|| event.charCode>=97 && event.charCode<=122|| event.charCode==32)"></label>

                <label>limite seguro:<input type="number" id="LIM_SEGURO" name="LIM_SEGURO" required disabled="" maxlength="1" onkeypress="return (event.charCode==48||event.charCode==49)"></label>

                <button type="submit" id="btnguardar" class="btn btn-success" value="agregar" disabled="" >guardar</button>


            </form>
            
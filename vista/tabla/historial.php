<div id="contenidoTabla">
    
    <button type="button" class="btn btn-success" id="Regresar" onclick="Regresar()">Regresar</button>
    <button type="button" class="btn btn-primary" id="Actualizar" onclick="Actualizar()">Actualizar Tabla</button>
    <label id="buscador">Buscar:<input id="busqueda" type="text" onkeyup="busqueda()"></label>
    <table id="seguroT" class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">Nº</th>
                <th scope="col">USUARIO</th>
                <th scope="col">FECHA</th>
                <th scope="col">OFICINA</th>    
                <th scope="col">MONTO</th>

            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($this->UEH as $regCob) :
            ?>
                <tr>
                    <td name="id"><?php echo $regCob->getidH() ?></td>
                    <td name="id"><?php echo $regCob->getusuario() ?></td>
                    <td name="id"><?php echo $regCob->getfecha() ?></td>
                    <td name="id"><?php echo $regCob->getoficina() ?></td>
                    <td name="id"><?php echo $regCob->getmonto() ?></td>

                    
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</div>
<!--****************Este es un documento tipo javascript-->
<script type="text/javascript">
    //la funcion de busqueda ase una busqueda en la tabla y regresa los resultados
    function busqueda() {
        var tabla = document.getElementById('seguroT');
        var Pbusqueda = document.getElementById('busqueda').value.toLowerCase();
        for (var i = 1; i < tabla.rows.length; i++) {
            var cellsOfRow = tabla.rows[i].getElementsByTagName('td');
            var found = false;
            for (var j = 0; j < cellsOfRow.length && !found; j++) {
                var compare = cellsOfRow[j].innerHTML.toLowerCase();
                if (Pbusqueda.length == 0 || (compare.indexOf(Pbusqueda)) > -1) {
                    found = true;
                }
            }
            if (found) {
                tabla.rows[i].style.display = '';
            } else {
                tabla.rows[i].style.display = 'none';

            }
        }

    }
    function Actualizar() {
        window.location = "?c=seguros&a=Historial";
    }
    function Regresar() {
        window.location = "?c=seguros&a=genTabla";
    }
</script>
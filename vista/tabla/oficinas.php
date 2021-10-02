</div>
</div>

<div id="contenidoTabla">
    <button type="button" class="btn btn-primary" id="Actualizar" onclick="Actualizar()">Actualizar Tabla <i class="fa fa-retweet"></i></button>
    <label id="buscador">Buscar:<input id="busqueda" type="text" onkeyup="busqueda()"></label>
    <table id="seguroT" class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">OFICINA</th>
                <th scope="col">DECRIPCION</th>
                <th scope="col">LIMITE SEGURO</th>
                <th scope="col">EDITAR</th>
                <th scope="col">Restablecer</th>

            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($this->lSeguros as $regCob) : ?>
                <tr>
                    <td name="id"><?php echo $regCob->getoficina() ?></td>
                    <td name="id"><?php echo $regCob->getdescripcion() ?></td>
                    <td name="id"><?php echo $regCob->getMax_valdec() ?></td>
                    <td><a href="?c=seguros&a=genTabla&Oficina=<?php echo $regCob->getoficina(); ?>"><i class="fa fa-edit"></i></a></td>
                    <td><a href="?c=seguros&a=Restablecer&Oficina=<?php echo $regCob->getoficina();?>&Monto=<?php echo $regCob->getMax_valdec()?>"><i class="fa fa-history"></i></a></td>

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
        window.location = "?c=seguros&a=genTabla";
        
    }
</script>
<div id="menu">
<button type="button" class="btn btn-info" id="Historial" onclick="Historial()">Historial <i class="fa fa-history"></i></button>
<button type="button" class="btn btn-primary" id="salir" onclick="salir()">Salir <i class="fa fa-sign-out"></i></button>

</div>
<!--****************Este es un documento tipo javascript-->
<script type="text/javascript">
    function Historial(){window.location = "?c=seguros&a=historial"};
    function salir(){window.location = "?c=seguros&a=salir"};
</script>
<?php
/* en esta clase de declaran todas las funciones sql para su proxima interaccion desde el controlador*/
require_once('BaseDeDatos.php');
require_once('oficinaSeguros.php');
class consultas{
    private $con;
    
    function __construct()
    {   
        $this->con=BD::conectar();
        

    }
    
       
    public function listar(){
         $listadoRcoc=[];
        $sql="SELECT OFICINA,DESCRIPCION,MAX_VALDEC FROM PL_OFICINAS";
        try{
            $centencia=oci_parse($this->con,$sql);
            oci_execute($centencia);
            while(($row=oci_fetch_array($centencia,OCI_ASSOC))!=false){
                $lista = new oficinaSeguros();
                $lista->setoficina($row['OFICINA']);
                $lista->setdescripcion($row['DESCRIPCION']);
                $lista->setMax_valdec($row['MAX_VALDEC']);
                array_push($listadoRcoc,$lista);
            }
            return $listadoRcoc;
        }catch(Exception $ex){
            $ex->getMessage();
        }
    }

    public function seleccionarUNO($uno){
        $listSelectUNO=[];
        $sql="SELECT OFICINA,DESCRIPCION,MAX_VALDEC FROM PL_OFICINAS WHERE OFICINA = '$uno'";
        try{
            $sqlCentencia=oci_parse($this->con,$sql);
            oci_execute($sqlCentencia);
            while(($row=oci_fetch_array($sqlCentencia,OCI_ASSOC))!=false){
                $SLUNO = new oficinaSeguros();
                $SLUNO->setoficina($row['OFICINA']);
                $SLUNO->setdescripcion($row['DESCRIPCION']);
                $SLUNO->setMax_valdec($row['MAX_VALDEC']);
                array_push($listSelectUNO,$SLUNO);
            }
            return $listSelectUNO;

        }catch(Exception $ex){
            $ex->getMessage();
        }
    }
    public function editar(){
        try{
        $OFICINA=$_POST['OFICINA'];
        $DESCRIPCION=$_POST['DESCRIPCION'];
        $MAX_VALDEC=$_POST['LIM_SEGURO'];
        $sql2 ="UPDATE PL_OFICINAS SET MAX_VALDEC='$MAX_VALDEC' WHERE OFICINA='$OFICINA' AND DESCRIPCION='$DESCRIPCION'";

        $sql2=oci_parse($this->con,$sql2);
        oci_execute($sql2);
            //si se efectuaron cambios en la tabla se envia la alerta verficando que se afecto el registro
            if(oci_num_rows($sql2)>0){
                //si se realizo cambio se imprime y se envia la alerta tipo javascript
                echo '
                <script type="text/javascript">
                 window.alert("El registro fue modificado correctamente"); </script>
                ';
                   return true;
               }else{
                
                 return false;
               }
       }catch(Exception $ex){
           $ex->getMessage();
        }
    }
    
    
}

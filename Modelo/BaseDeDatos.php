<?php
class BD{
    //archivo para establecer la coneccion con la base de datos
    private $con;
   
    function __construct()
    {
        
    }

    public static function conectar(){
        try{
         //return  new PDO("192.168.100.132/tpitic","usuario_plight","u5uar10116ht");
         return   oci_connect("usuario_plight", "u5uar10116ht", "192.168.100.132/tpitic"); 


 /*
if (!$conexion) {    
  $m = oci_error();    
  echo $m['message'], "n";    
  exit; 
} else {    
  echo "Conexión con éxito a Oracle!"; } 

*/

        }catch(Exception $ex){
            die($ex->getMessage());

        }
    }

}
?>


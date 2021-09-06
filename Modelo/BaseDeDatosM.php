<?php
class Mysqldb{
    //archivo para establecer la coneccion con la base de datos MYSQL
    private $MysqlConect;
    function __construct()
    {
        
    }
    public static function conectar(){
        try{
      	return     new PDO("mysql:host=192.168.100.16;dbname=firewall;charset=utf8","jfavila","charrascuas");

        }catch(Exception $ex){
            die($ex->getMessage());

        }
    }

}
?>
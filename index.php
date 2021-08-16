<?php
    /*es el archivo de inicio que dicta que controlador tiene que ir*/
    require_once("Controlador/seguro.php");
    //si existe el controlador que hace referencia 'c' y la funcion que referencia 'a'
    if(isset($_GET['c'])&&isset($_GET['a'])){
        $controlador=$_GET['c'];
        $accion=$_GET['a'];
        
    }else{
        //controlador y funcion principal
        $controlador='seguros';
        $accion='login';
    }
    //declara el controlador y su funcion
    $controlador='C'.$controlador;
    $objControlador= new $controlador;
    $objControlador->{$accion}();
?>
<?php
require_once('./Modelo/oficinaSeguros.php');
require_once('./Modelo/Consultas.php');
class Cseguros extends credencial{
//en controlara la vistas y algunas funciones de consulta
        private $lSeguros;
        private $lSeguroSOLOUNO;
        private $obj;
    function __construct(){
        /*declaracion de objetos para su manejo*/
        /*mCobradores=enfocado en todos losregistos
        mCobradoresSOLOUNO=enfocado en un solo registro*/
        $this->lSeguros=new oficinaSeguros();
        $this->lSeguroSOLOUNO=new oficinaSeguros();
        $this->obj= new consultas();
    }
    public function login(){
        require_once('vista/header.php');
        require_once('vista/login.php');
      //  require_once('/var/www/html/cobradores/vista/tabla/cobradores.php');
        require_once('vista/footer.php');
        
    }
    public function validar(){
        $usuario = $_POST['usuario'];
        $contraseña=$_POST['contraseña'];
       // $this->mCobradores=$this->validar($usuario,$contraseña);
        if($usuario==$this->getusuario()&& $contraseña==$this->getcontra()){
           $this-> genTabla();
        }else{
            header('location:index.php');
            
        }
    }
    public function genTabla(){
        //se encarga de la vista principal y cargar la tabla con los registros
        if(isset($_GET['Oficina'])){
        //aqui recibe la variable get para obtener la informacion de esa clave aparte de
        //mantener la tabla funcionando
        $this->lSeguros=$this->obj->listar();
        $this->lSeguroSOLOUNO=$this->obj->seleccionarUNO($_GET['Oficina']);
         require_once('vista/header.php');
         require_once('/var/www/html/seguros/vista/formularios/formParaEditar.php');
         require_once('/var/www/html/seguros/vista/tabla/oficinas.php');
         require_once('vista/footer.php');
        }else{
        //la vista entrada sin variable get
           $s=  $this->lSeguros=$this->obj->listar();
         //  print_r($s);
       //    var_dump( $this->mCobradores);
             require_once('vista/header.php');
             require_once('/var/www/html/seguros/vista/formularios/formVistaInicial.php');
             require_once('/var/www/html/seguros/vista/tabla/oficinas.php');
             require_once('vista/footer.php');
        }
    }
    public function Actualizar(){
        $this->obj->editar();
        $this->genTabla();
    }
   
    

}
class credencial{
         private $us="sistemas";
        private $cont="supersis";
        public function getusuario(){return $this->us;}
        public function getcontra(){return $this->cont;}
}

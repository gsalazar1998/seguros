<?php
require_once('./Modelo/oficinaSeguros.php');
require_once('./Modelo/usuariosYHistorial.php');

require_once('./Modelo/Consultas.php');

class Cseguros
{
    //en controlara la vistas y algunas funciones de consulta
    private $lSeguros;
    private $lSeguroSOLOUNO;
    private $obj;
    function __construct()
    {
        /*declaracion de objetos para su manejo*/
        /*mCobradores=enfocado en todos losregistos
        mCobradoresSOLOUNO=enfocado en un solo registro
        UEH=enfocado en los usuarios e historial de cambios
        */

        $this->lSeguros = new oficinaSeguros();
        $this->lSeguroSOLOUNO = new oficinaSeguros();
        $this->obj = new consultas();
        $this->UEH = new UsuarioEHistorial();
    }
    public function login()
    {
        require_once('vista/header.php');
        require_once('vista/login.php');
        require_once('vista/footer.php');
    }
    public function validar()
    {
        //valida el usuario y contraseña
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        // $this->mCobradores=$this->validar($usuario,$contraseña);
        $select = $this->UEH = $this->obj->validar($usuario);
        //  var_dump($select);
        //si existe el usuario
        if ($this->UEH != null) {
            //si el usuarioesta activo (la contraseña viene encriptada)
            if ($select->getultima_conexion() != null || $select->getultima_conexion() == null and $select->getstatus() == 'Activado') {
                //Verificar si la contraseña es corecta
                if (password_verify($contraseña, $select->getcontraseña())) {
                    $this->obj->RegistroDeEntrada($select->getid());
                    session_start();
                    $_SESSION['id'] = $select->getid();
                    $_SESSION['usuario'] = $select->getusuario();
                    header("location:?c=seguros&a=genTabla");
                } else {
                    echo '
                <script type="text/javascript">
                window.alert("La contraseña es incorrecta");
                window.location = "?c=seguros&a=login"
                </script>';
                }
            } elseif ($select->getstatus() == 'Inactivo') {
                //aqui verifica la contraseña sin encriptar
                if ($select->getcontraseña() === $contraseña) {
                    //aqui se ase el cambio de contraseña y se cambia el status a activo
                    require_once('vista/header.php');
                    require_once('vista/formularios/CambioDeContraseña.php');
                    require_once('vista/footer.php');
                } else {
                    echo '
                <script type="text/javascript">
                window.alert("La contraseña es incorrecta");
                window.location = "?c=seguros&a=login"
                </script>';
                }
            } else {
                echo '
            <script type="text/javascript">
            window.alert("Este usuario no se encuentra activo favor de contactar a su provedor");
            window.location = "?c=seguros&a=login"
            </script>';
            }
        } else {
            echo '
            <script type="text/javascript">
            window.alert("la contraseña o el usuario son incorrectos");
            window.location = "?c=seguros&a=login"
            </script>';
        }
    }
    public function CambioContra()
    {
        //Realiza el cambio de contaseña 
        $id = $_POST['id'];
        $Con = $_POST['contraFirm'];
        $R = $this->obj->CambioContra($id, $Con);
        if ($R = true) {
            echo '
            <script type="text/javascript">
             window.alert("Se actualizo la contraseña correctamente"); 
             window.location = "?c=seguros&a=login"</script>
             ';
        }
    }
    public function siExisteSession()
    {
        //inicia la sesion
        session_start();
        $usuario = $_SESSION['usuario'];
        if ($usuario == null || $usuario = '') {
            echo '<script type="text/javascript">
            window.alert("Favor de iniciar sesión"); 
            window.location = "?c=seguros&a=login"</script>
            ';
        }
    }
    public function Historial()
    {
        //listado de movimientos en la base de datos
        $this->siExisteSession();
        $this->UEH = $this->obj->historial();
        require_once('vista/header.php');
        require_once('/var/www/html/seguros/vista/tabla/historial.php');
        require_once('vista/footer.php');
    }
    public function genTabla()
    {
        //vista principal de la tabl de oficinas
        $this->siExisteSession();
        //se encarga de la vista principal y cargar la tabla con los registros
        if (isset($_GET['Oficina'])) {
            //aqui recibe la variable get para obtener la informacion de esa clave aparte de
            //mantener la tabla funcionando
            $this->lSeguros = $this->obj->listar();
            $this->lSeguroSOLOUNO = $this->obj->seleccionarUNO($_GET['Oficina']);
            require_once('vista/header.php');
            require_once('/var/www/html/seguros/vista/formularios/formParaEditar.php');
            require_once('/var/www/html/seguros/vista/tabla/oficinas.php');
            require_once('vista/footer.php');
        } else {
            //la vista entrada sin variable get
            $this->lSeguros = $this->obj->listar();
            require_once('vista/header.php');
            require_once('vista/menu.php');
            require_once('/var/www/html/seguros/vista/formularios/formVistaInicial.php');
            require_once('/var/www/html/seguros/vista/tabla/oficinas.php');
            require_once('vista/footer.php');
        }
    }
    public function Actualizar()
    {
        //actualiza oficina
        $this->siExisteSession();
        $id = $_SESSION['id'];
        $this->obj->editar($id);
        $this->genTabla();
    }
    public function Restablecer()
    {
        //restablece el monto de oficina
        $this->siExisteSession();
        $id=$_SESSION['id'];
        $Oficina = $_GET['Oficina'];
        $monto = $_GET['Monto'];
      $res=  $this->obj->restablecer($Oficina,$monto,$id);
      if ($res == true) {
        echo '
        <script type="text/javascript">
        window.alert("El Monto fue restablecido"); 
        window.location = "?c=seguros&a=genTabla"
        </script>
        ';
        
        }else{
            echo '
            <script type="text/javascript">
            window.location = "?c=seguros&a=genTabla"
            </script>
            ';
        }
    }
    public function salir()
    {
        session_start();
        session_destroy();
        header("location:index.php");
    }
}

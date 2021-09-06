<?php
/* en esta clase de declaran todas las funciones sql para su proxima interaccion desde el controlador*/
require_once('BaseDeDatosO.php');
require_once('BaseDeDatosM.php');
require_once('oficinaSeguros.php');
require_once('usuariosYHistorial.php');
class consultas
{
    private $ociConect;
    private $MysqlConect;

    function __construct()
    {
        $this->ociConect = Ocidb::conectar();
        $this->MysqlConect = Mysqldb::conectar();
    }

    public function validar($usuario)
    {
        //valida la existencia del usuario
        $sqlx = "SELECT * FROM s_usuarios WHERE usuario=?";
        try {
            $stemet = $this->MysqlConect->prepare($sqlx);
            $stemet->execute(array($usuario));
            $stemet->setFetchMode(PDO::FETCH_CLASS, 'UsuarioEHistorial');
            $X = $stemet->fetch();
            return ($X);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    public function RegistroDeEntrada($id)
    {
        //registra la hora de entrada y estableze la zona horaria
        date_default_timezone_set('US/Arizona');
        $hora_de_entrada = date('Y-m-d H:i:s ');
        try {
            $sqlUsuario = "UPDATE s_usuarios SET ultima_Conexion = ? WHERE s_usuarios.id_usuario = ?";
            $UsuarioEntrada = $this->MysqlConect->prepare($sqlUsuario);
            $UsuarioEntrada->execute(array($hora_de_entrada, $id));
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public function CambioContra($id, $contraseña)
    {
        //Realiza la encriptacion de la contraseña
        $contraEncript = password_hash($contraseña, PASSWORD_DEFAULT, ['cost' => 10]);
        echo $contraEncript;
        $sql = "UPDATE s_usuarios SET contraseña='$contraEncript',Status='Activado' where  id_usuario=$id";
        try {
            $pdo = $this->MysqlConect->prepare($sql);
            $pdo->execute();
            //si se efectuaron cambios en la tabla se envia la alerta verficando que se afecto el registro
            if ($pdo->rowCount() > 0) {
                //si se realizo cambio se imprime y se envia la alerta tipo javascript
                echo '
                <script type="text/javascript">
                 window.alert("Se actualizo la contraseña correctamente"); </script>
                 ';
                return true;
            } else {

                return false;
            }
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    public function restablecer($OFICINA, $monto, $idUsuario)
    {
        //restablece el monto de la oficina
        $var = "1000000";
        if ($monto > 1000000) {
            $sql2 = "UPDATE PL_OFICINAS SET MAX_VALDEC='1000000' WHERE OFICINA='$OFICINA'";
            $sql2 = oci_parse($this->ociConect, $sql2);
            oci_execute($sql2);
            if (oci_num_rows($sql2) > 0) {
                //Registra el movimiento en la base de datos
                date_default_timezone_set('US/Arizona');
                $hora_de_Registro = date('Y-m-d H:i:s ');
                $sql = "INSERT INTO `s_historial`(`id_usuarioH`, `fecha`, `oficina`, `monto`) VALUES (?,?,?,?)";
                try {
                    $pdo = $this->MysqlConect->prepare($sql);
                    $pdo->execute(array($idUsuario, $hora_de_Registro, $OFICINA, '1000000'));
                } catch (Exception $e) {
                    $e->getMessage();
                }
                return true;
            } else {
                echo '
                <script type="text/javascript">
                 window.alert("error en monto"); 
                 </script>
                ';
            }
        } else {
            
            return false;
        }
    }
    function historial()
    {
        $listadoRcoc = [];
        $sql = "SELECT * FROM s_usuarios as U INNER JOIN s_historial as H ON U.id_usuario=H.id_usuarioH";
        $pdo = $this->MysqlConect->prepare($sql);
        $pdo->execute();
        while ($r = $pdo->fetch(PDO::FETCH_ASSOC)) {
            $listado = new UsuarioEHistorial();
            $listado->setidH($r['id']);
            $listado->setusuario($r['usuario']);
            $listado->setfecha($r['fecha']);
            $listado->setoficina($r['oficina']);
            $listado->setmontos($r['monto']);
            array_push($listadoRcoc, $listado);
        }
        return $listadoRcoc;
    }
    public function listar()
    {
        $listadoRcoc = [];
        $sql = "SELECT OFICINA,DESCRIPCION,MAX_VALDEC FROM PL_OFICINAS";
        try {
            $centencia = oci_parse($this->ociConect, $sql);
            oci_execute($centencia);
            while (($row = oci_fetch_array($centencia, OCI_ASSOC)) != false) {
                $lista = new oficinaSeguros();
                $lista->setoficina($row['OFICINA']);
                $lista->setdescripcion($row['DESCRIPCION']);
                $lista->setMax_valdec($row['MAX_VALDEC']);
                array_push($listadoRcoc, $lista);
            }
            return $listadoRcoc;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public function seleccionarUNO($uno)
    {
        $listSelectUNO = [];
        $sql = "SELECT OFICINA,DESCRIPCION,MAX_VALDEC FROM PL_OFICINAS WHERE OFICINA = '$uno'";
        try {
            $sqlCentencia = oci_parse($this->ociConect, $sql);
            oci_execute($sqlCentencia);
            while (($row = oci_fetch_array($sqlCentencia, OCI_ASSOC)) != false) {
                $SLUNO = new oficinaSeguros();
                $SLUNO->setoficina($row['OFICINA']);
                $SLUNO->setdescripcion($row['DESCRIPCION']);
                $SLUNO->setMax_valdec($row['MAX_VALDEC']);
                array_push($listSelectUNO, $SLUNO);
            }
            return $listSelectUNO;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
    public function editar($idUsuario)
    {
        try {
            $OFICINA = $_POST['OFICINA'];
            $DESCRIPCION = $_POST['DESCRIPCION'];
            $MAX_VALDEC = $_POST['LIM_SEGURO'];

            if ($MAX_VALDEC >= 1000000) {
                $sql2 = "UPDATE PL_OFICINAS SET MAX_VALDEC='$MAX_VALDEC' WHERE OFICINA='$OFICINA' AND DESCRIPCION='$DESCRIPCION'";
                $sql2 = oci_parse($this->ociConect, $sql2);
                oci_execute($sql2);
                //si se efectuaron cambios en la tabla se envia la alerta verficando que se afecto el registro
                if (oci_num_rows($sql2) > 0) {
                    //si se realizo cambio se imprime y se envia la alerta tipo javascript e se inserta registro en el historial
                    date_default_timezone_set('US/Arizona');
                    $hora_de_Registro = date('Y-m-d H:i:s ');
                    $sql = "INSERT INTO `s_historial`(`id_usuarioH`, `fecha`, `oficina`, `monto`) VALUES (?,?,?,?)";
                    try {
                        $pdo = $this->MysqlConect->prepare($sql);
                        $pdo->execute(array($idUsuario, $hora_de_Registro, $OFICINA, $MAX_VALDEC));
                        echo '
                        <script type="text/javascript">
                        window.alert("El registro fue modificado correctamente"); </script>';
                    } catch (Exception $e) {
                        $e->getMessage();
                    }
                    return true;
                } else {

                    return false;
                }
            } else {
                echo '
                <script type="text/javascript">
                 window.alert("El Monoto es incorrecto"); </script>
                ';
            }
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
}

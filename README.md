#PAGINA DE SEGUROS

Este es un sistema MVC(Modelo vista controlador)
con los siguientes archivos
•controlador=se encarga de las funciones principales que vista enviar o movimiento mediante la basde de datos
•Modelo=aqui se registran las tablas de get y set incluyendo las funciones sql confrme a la base de datos
•vista=guarda el codigo html php que se vaya a mandar a llamar y se puede seccionar
        para ser llamado desde elcontrolador
        ejemplo
********desde el controlador*************
        public function genTabla(){
            $this->lSeguroSOLOUNO=$this->obj->seleccionarUNO($_GET['Oficina']));=>se invoco desde el archivo modelo 
            $this->mSeguros=$this->objPDO->listar();=>se invoco desde el archivo modelo
            require_once('vista/header.php');=>cavezera principar del html
            require_once('Vista/formularios/vistaIncial.php');=>cuerpo del html
            require_once('Vista/tabla/seguros.php');=>cuerpo del html
   
            require_once('vista/footer.php');=>pie del html
        }****nota como enlistes tus acciones es como se van a cargar de ariba abajo****

--------------------------------------------------------------------------------------------

para poder ingresar a una funcion es de la siguiente manera 
url
    ?c=(controlador)&a=(funcion)
    ejemplo
    ?c=seguro&a=gent
para poder enviar un dato a través del url es de las iguiente manera
url
    ?c=(controlador)&a=(funcion)&(nombre de la variable GET)=("contenido")
    ejemplo
    href="?c=seguro&a=genTabla&of="
    **nota al realizarlo de esta manera la toma como variable  $_GET

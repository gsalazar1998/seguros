<?php
class oficinaSeguros{
//en este documento se vaciarn todos los campos con get y set de la tabla cobradores
    function __construct(){

    }
    private $OFICINA;
    private $DESCRIPCION;
    private $MAX_VALDEC;
    
    public function getoficina(){ return $this->OFICINA;}
    public function getdescripcion(){ return $this->DESCRIPCION;}
    public function getMax_valdec(){ return $this->MAX_VALDEC;}
   

    public function setoficina($OFICINA){ $this->OFICINA=$OFICINA;}
    public function setdescripcion($DESCRIPCION){ $this->DESCRIPCION=$DESCRIPCION;}
    public function setMax_valdec($MAX_VALDEC){ $this->MAX_VALDEC=$MAX_VALDEC;}
    

}
?>
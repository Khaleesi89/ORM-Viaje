<?php

//el de seba
class Viaje{
    private $idViaje;
    private $vDestino;
    private $vCantidadMax;
    private $arrayObjPasajero;
    private $objEmpresa;
    private $objResponsable;
    private $vImporte;    
    private $tipoAsiento;
    private $idaVuelta;    
    private $mensajeError;

    /**************************************/
    /**************** SET *****************/
    /**************************************/

    /**
     * Establece el valor de idViaje
     */ 
    public function setIdViaje($idViaje){
        $this->idViaje = $idViaje;
    }

    /**
     * Establece el valor de vDestino
     */ 
    public function setVDestino($vDestino){
        $this->vDestino = $vDestino;
    }

    /**
     * Establece el valor de vCantidadMax
     */ 
    public function setVCantidadMax($vCantidadMax){
        $this->vCantidadMax = $vCantidadMax;
    }

    /**
     * Establece el valor de arrayObjPasajero
     */ 
    public function setArrayObjPasajero($arrayObjPasajero){
        $this->arrayObjPasajero = $arrayObjPasajero;
    }

    /**
     * Establece el valor de objEmpresa
     */ 
    public function setObjEmpresa($objEmpresa){
        $this->objEmpresa = $objEmpresa;
    }

    /**
     * Establece el valor de objNumeroEmpleado
     */ 
    public function setObjResponsable($objResponsable){
        $this->objResponsable = $objResponsable;
    }

    /**
     * Establece el valor de vImporte
     */ 
    public function setVImporte($vImporte){
        $this->vImporte = $vImporte;
    }

    /**
     * Establece el valor de tipoAsiento
     */ 
    public function setTipoAsiento($tipoAsiento){
        $this->tipoAsiento = $tipoAsiento;
    }

    /**
     * Establece el valor de idaVuelta
     */ 
    public function setIdaVuelta($idaVuelta){
        $this->idaVuelta = $idaVuelta;
    }
    
    /**
     * Establece el valor de mensajeError
     */ 
    public function setMensajeError($mensajeError){
        $this->mensajeError = $mensajeError;
    }

    /**************************************/
    /**************** GET *****************/
    /**************************************/

    /**
     * Obtiene el valor de idViaje
     */ 
    public function getIdViaje(){
        return $this->idViaje;
    }

    /**
     * Obtiene el valor de vDestino
     */ 
    public function getVDestino(){
        return $this->vDestino;
    }

    /**
     * Obtiene el valor de vCantidadMax
     */ 
    public function getVCantidadMax(){
        return $this->vCantidadMax;
    }

    /**
     * Obtiene el valor de arrayObjPasajero
     */ 
    public function getArrayObjPasajero(){
        return $this->arrayObjPasajero;
    }

    /**
     * Obtiene el valor de objEmpresa
     */ 
    public function getObjEmpresa(){
        return $this->objEmpresa;
    }

    /**
     * Obtiene el valor de objNumeroEmpleado
     */ 
    public function getObjResponsable(){
        return $this->objResponsable;
    }

    /**
     * Obtiene el valor de vImporte
     */ 
    public function getVImporte(){
        return $this->vImporte;
    }

    /**
     * Obtiene el valor de tipoAsiento
     */ 
    public function getTipoAsiento(){
        return $this->tipoAsiento;
    }

    /**
     * Obtiene el valor de idaVuelta
     */ 
    public function getIdaVuelta(){
        return $this->idaVuelta;
    }

    
    /**
     * Obtiene el valor de mensajeError
     */ 
    public function getMensajeError(){
        return $this->mensajeError;
    }


    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/

    /**
     * Este modulo asigna los valores a los atributos cuando se crea una instancia de la clase
    */
    public function __construct(){
        $this->idViaje = "";
        $this->vDestino = "";
        $this->vCantidadMax = "";
        $this->arrayObjPasajero = [];
        $this->objEmpresa = "";
        $this->objResponsable = "";
        $this->vImporte = "";
        $this->tipoAsiento = "";
        $this->idaVuelta = "";
    }

    public function cargar($idViaje, $vDestino, $vCantidadMax, $idEmpresa, $idResponsable, $vImporte, $tipoAsiento, $idaVuelta){		
        $this->setIdViaje($idViaje);
        $this->setVDestino($vDestino);
        $this->setVCantidadMax($vCantidadMax);
        $objEmpresa = new Empresa();
        $objEmpresa->buscar($idEmpresa);
        $this->setObjEmpresa($objEmpresa);
        $objResponsable = new Responsable();
        $objResponsable->buscar ($idResponsable);
        $this->setObjResponsable($objResponsable);
        $this->setVImporte($vImporte);
        $this->setTipoAsiento($tipoAsiento);
        $this->setIdaVuelta($idaVuelta);
    }
    
    /**
     * Este modulo inserta en la BD el viaje
    */
    
    public function insertar(){
        $baseDatos = new BaseDatos();
        $resp = false;
        $objEmpresa = $this->getObjEmpresa();
        $idEmpresa = $objEmpresa->getIdEmpresa();
        $objResponsable = $this->getObjResponsable();
        $idResonsable= $objResponsable->getNroEmpleado();
        $consulta = "INSERT INTO viaje (idviaje,vdestino,vcantmaxpasajeros,idempresa,rnumeroempleado,vimporte,tipoAsiento,idayvuelta) VALUES (".$this->getIdViaje().",'".$this->getVDestino()."',".$this->getVCantidadMax().",". $idEmpresa.",".$idResonsable.",".$this->getVImporte().",'".$this->getTipoAsiento()."','".$this->getIdaVuelta()."')";
        if($baseDatos->iniciar()){
            if($baseDatos->ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensajeError($baseDatos->getERROR());
            }
        }else{
            $this->setMensajeError($baseDatos->getERROR());
        }
        return $resp;
    }

    /**
     * Este modulo modifica un viaje de la BD.
    */
    public function modificar(){
        $baseDatos = new BaseDatos();
        $resp = false;
        $empresa =$this->getObjEmpresa();
        $idEmpres = $empresa->getIdEmpresa();
        $responsable= $this->getObjResponsable();
        $idResp = $responsable->getNroEmpleado();

        /*$consulta = "UPDATE viaje SET vdestino = {$this->getVdestino()}, vcantmaxpasajeros = {$this->getVCantidadMax()}, idempresa = {$idEmpres}, rnumeroempleado = {$idResp}, vimporte = {$this->getVimporte()}, tipoAsiento = '{$this->getTipoAsiento()}', idayvuelta = '{$this->getIdaVuelta()}' WHERE idviaje = {$this->getIdviaje()}";*/
        
        $consulta = "UPDATE viaje SET idViaje = ".$this->getIdViaje().",vdestino = '".$this->getVDestino()."',  vcantmaxpasajeros = ".$this->getVCantidadMax().",idempresa = ".$idEmpres.", rnumeroempleado = ".$idResp.",vimporte = ".$this->getVImporte().",tipoAsiento = ".$this->getTipoAsiento().",idayvuelta = '".$this->getIdaVuelta()."' WHERE idviaje = ".$this->getIdViaje();

/*
        $consulta = "UPDATE viaje 
                    SET idViaje = ".$this->getIdViaje().",
                    vdestino = '".$this->getVDestino()."', 
                    vcantmaxpasajeros = ".$this->getVCantidadMax().", 
                    vimporte = ".$this->getVImporte().",
                    tipoAsiento = '".$this->getTipoAsiento()."',
                    idayvuelta = '".$this->getIdaVuelta()."',
                    idempresa = ".$idEmpres.", 
                    rnumeroempleado = ".$idResp." WHERE idviaje =".$this->getIdViaje();*/
                    
        if($baseDatos->iniciar()){
            if($baseDatos->ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensajeError($baseDatos->getERROR());
            }
        }else{
            $this->setMensajeError($baseDatos->getERROR());
        }
        return $resp;
    }

    /**
     * Este elimina un viaje de la BD.
    */
    public function eliminar(){
        $baseDatos = new BaseDatos();
        $resp = false;
        $consulta = "DELETE FROM viaje WHERE idviaje = ".$this->getIdViaje();
        if($baseDatos->iniciar()){
            if($baseDatos->ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensajeError($baseDatos->getERROR());
            }
        }else{
            $this->setMensajeError($baseDatos->getERROR());
        }
        return $resp;
    }

    public function buscar($idViaje){
        $baseDatos = new BaseDatos();
		$consulta="SELECT * FROM viaje WHERE idviaje = ".$idViaje;
		$resp = false;
		if($baseDatos->iniciar()){
			if($baseDatos->ejecutar($consulta)){
				if($viaje=$baseDatos->registro()){
                    //$objReponsable = new Responsable();
                    //$objEmpresa = new Empresa();
                    //se comento porque ya no es necesario obtener el id de empresa y responsable
                    //$objReponsable->buscar($viaje['rnumeroempleado']);					
                    //$objEmpresa->buscar($viaje['idempresa']);	
                    $this->setIdViaje($viaje['idempresa']);
                    //$this->setIdViaje($idViaje);
					$this->setVDestino($viaje['vdestino']);
					$this->setVCantidadMax($viaje['vcantmaxpasajeros']);
					$this->setObjEmpresa($viaje['idempresa']);
					$this->setObjResponsable($viaje['rnumeroempleado']);
					$this->setVImporte($viaje['vimporte']);
					$this->setTipoAsiento($viaje['tipoAsiento']);
					$this->setIdaVuelta($viaje['idayvuelta']);
					$resp= true;
				}

		 	}else{
                $this->setMensajeError($baseDatos->getERROR());
			}
		 }else{
            $this->setMensajeError($baseDatos->getERROR());
		 }		
		 return $resp;
	}	

    public function listar($condicion = ""){
	    $resp = [];
        $baseDatos = new BaseDatos();
		$consultaViaje = "SELECT * FROM viaje ";
		if($condicion != ""){
		    $consultaViaje .=' where '.$condicion;
		}
		if($baseDatos->iniciar()){
			if($baseDatos->ejecutar($consultaViaje)){				
				while($viaje=$baseDatos->registro()){
                    $objViaje = new Viaje();
                    $objViaje->buscar($viaje['idviaje']);
					array_push($resp, $objViaje);
				}
		 	}else {
                $resp = $this->setMensajeError($baseDatos->getERROR());
			}
		 }else{
            $resp = $this->setMensajeError($baseDatos->getERROR());
		 }	
		 return $resp;
	}	

    /*
     // Este modulo busca en la BD los pasajeros que coniciden con el viaje
    
    public function obtenerPasajeros(){
        $baseDatos = new BaseDatos();
        $resp = false;
        $consulta = "idViaje = ".$this->getIdViaje();
        if($baseDatos->iniciar()){
            $objPasajero = new Pasajero();
            $arrayObjPersona = $objPasajero->listar($consulta);
            if(is_array($arrayObjPersona)){
                $this->setArrayObjPasajero($arrayObjPersona);
                $resp = true;
            }else{
                $this->setMensajeError($baseDatos->getERROR());
            }
        }else{
            $this->setMensajeError($baseDatos->getERROR());
        }
        return $resp;
    }

   

   
     // Este modulo busca en la BD los pasajeros que coniciden con el viaje
    
    public function hayPasajesDisponible(){
        $this->obtenerPasajeros();
        $arrayObjPasajero = $this->getArrayObjPasajero();
        if(count($arrayObjPasajero) < $this->getVCantidadMax()){
            $verificacion = true;
        }else{
            $verificacion = false;
        }
        return $verificacion;
    }

    */


    public function listarPasajeros() {
        $arregloPasajeros = null;
        $base = new BaseDatos();
        $consulta = "SELECT * FROM pasajero WHERE idviaje = ".$this->getIdViaje();
        $consulta .= " ORDER BY papellido";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arregloPasajeros = array();
                while ($row2=$base->Registro()) {
                    $dni = $row2['rdocumento'];
                    $nombre = $row2['pnombre'];
                    $apellido = $row2['papellido'];
                    $telefono = $row2['ptelefono'];
                    $idViaje = $row2['idviaje'];

                    $pasajero = new Pasajero();
                    $pasajero->cargar($dni, $nombre, $apellido, $telefono, $idViaje);
                    array_push($arregloPasajeros, $pasajero);
                }
            } else {
                $this->setMensajeError($base->getERROR());
            }
        } else {
            $this->setMensajeError($base->getERROR());
        }
        return $arregloPasajeros;
    }
    
    
    public function __toString() {
        $pasajeros = $this->listarPasajeros();
        $strRespons = "";
        $strEmpresa = "";
        $responsable = new Responsable();
        $empresa = new Empresa();
       /* $codigoempresa = $this->getObjEmpresa();
        $codigoempleado = $this->getObjResponsable();
        $empresa = $empresa->listar($codigoempresa);
        $responsable = $responsable->listar($codigoempleado);*/
       //responsable 
        if ($responsable->Buscar($this->getObjResponsable())) {
            $strRespons .= $responsable;
        }
        //empresa 
        if($empresa->Buscar($this->getObjEmpresa())){
            $strEmpresa .= $empresa;
        }
        $cant = count($pasajeros);
        $info = "*********DATOS DEL VIAJE**********************
                Código del viaje: {$this->getIdViaje()}
                Destino: {$this->getVDestino()}
                Capacidad de pasajeros: {$this->getVCantidadMax()}
                Cantidad de pasajeros: {$cant}
                Tipo de asiento: {$this->getTipoAsiento()}
                Trayectoria: {$this->getIdaVuelta()}
                Importe del viaje: {$this->getVImporte()}
                ID Empresa: 
                {$empresa}
                n° empleado: 
                {$responsable}
                ******************************                    
                ";
                
        return $info;
    }


}

?>
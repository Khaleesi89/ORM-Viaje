<?php


//VIENDO SI FUNCIONA

class Viaje{

    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa; //OBJETO EMPRESA
    private $rnumeroempleado; // OBJETO RESPONSABLE
    private $vimporte;
    private $tipoAsiento;
    private $idayvuelta;
    private $arrayObjPasajero = [];
    private $mensaje;
   

    public function getIdviaje()
    {
        return $this->idviaje;
    }

    public function setIdviaje($idviaje)
    {
        $this->idviaje = $idviaje;
    }

    public function getVdestino()
    {
        return $this->vdestino;
    }

    public function setVdestino($vdestino)
    {
        $this->vdestino = $vdestino;
    }

    public function getVcantmaxpasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    public function setVcantmaxpasajeros($vcantmaxpasajeros)
    {
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
    }

    public function getObjempresa()
    {
        return $this->idempresa;
    }

    public function setObjempresa($idempresa)
    {
        $this->idempresa = $idempresa;
    }

    public function getRnumeroempleado()
    {
        return $this->rnumeroempleado;
    }

    public function setRnumeroempleado($rnumeroempleado)
    {
        $this->rnumeroempleado = $rnumeroempleado;
    }

    public function getVimporte()
    {
        return $this->vimporte;
    }

    public function setVimporte($vimporte)
    {
        $this->vimporte = $vimporte;
    }

    public function getTipoAsiento()
    {
        return $this->tipoAsiento;
    }

    public function setTipoAsiento($tipoAsiento)
    {
        $this->tipoAsiento = $tipoAsiento;
    }

    public function getIdayvuelta()
    {
        return $this->idayvuelta;
    }

    public function setIdayvuelta($idayvuelta)
    {
        $this->idayvuelta = $idayvuelta;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function setMensaje($nuevo)
    {
        $this->mensaje = $nuevo;
    }
    public function getArrayObjPasajero(){
        return $this->arrayObjPasajero;
    }

    public function setArrayObjPasajero($arrayObjPasajero){
        $this->arrayObjPasajero = $arrayObjPasajero;
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
        //$this->objEmpresa = "";
        //$this->objResponsable = "";
        $this->vImporte = "";
        $this->tipoAsiento = "";
        $this->idaVuelta = "";
    }

   

    public function cargar($idViaje, $vDestino, $vCantidadMax, $objEmpresa, $objResponsable, $vImporte, $tipoAsiento, $idaVuelta){		
        $this->setIdviaje($idViaje);
        $this->setVDestino($vDestino);
        $this->setVcantmaxpasajeros($vCantidadMax);
        $this->setObjEmpresa($objEmpresa);
        $this->setObjResponsable($objResponsable);
        $this->setVImporte($vImporte);
        $this->setTipoAsiento($tipoAsiento);
        $this->setIdayvuelta($idaVuelta);
    }
    
    /**
     * Este modulo inserta en la BD el viaje
    */
    public function insertar(){
        $baseDatos = new BaseDatos();
        $resp = false;
        $consulta = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte, tipoAsiento, idayvuelta) 
                    VALUES ('".$this->getVDestino()."',".$this->getVcantmaxpasajeros().",".$this->getObjEmpresa()->getIdentificacion().",".$this->getObjResponsable()->getNumEmpleado().",".$this->getVImporte().",".$this->getTipoAsiento().",'".$this->getIdayvuelta()."')";
        if($baseDatos->iniciar()){
            if($baseDatos->ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensaje($baseDatos->getERROR());
            }
        }else{
            $this->setMensaje($baseDatos->getERROR());
        }
        return $resp;
    }

    /**
     * Este modulo modifica un viaje de la BD.
    */
    public function modificar(){
        $baseDatos = new BaseDatos();
        $resp = false;
        $consulta = "UPDATE viaje 
                    SET idViaje = ".$this->getIdViaje().",
                    vdestino = '".$this->getVDestino()."', 
                    vcantmaxpasajeros = ".$this->getVcantmaxpasajeros().", 
                    idempresa = ".$this->getObjEmpresa()->getIdentificacion().", 
                    rnumeroempleado = ".$this->getObjResponsable()->getNumEmpleado().", 
                    vimporte = ".$this->getVImporte().",
                    tipoAsiento = ".$this->getTipoAsiento().",
                    idayvuelta = '".$this->getIdayvuelta()."' WHERE idviaje = ".$this->getIdViaje();
        if($baseDatos->iniciar()){
            if($baseDatos->ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensaje($baseDatos->getERROR());
            }
        }else{
            $this->setMensaje($baseDatos->getERROR());
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
                $this->setMensaje($baseDatos->getERROR());
            }
        }else{
            $this->setMensaje($baseDatos->getERROR());
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
                    $objReponsable = new Responsable();
                    $objEmpresa = new Empresa();
                    $objReponsable->buscar($viaje['rnumeroempleado']);					
                    $objEmpresa->buscar($viaje['idempresa']);	
				    $this->setIdViaje($idViaje);
					$this->setVDestino($viaje['vdestino']);
					$this->getVcantmaxpasajeros($viaje['vcantmaxpasajeros']);
					$this->setObjEmpresa($objEmpresa);
					$this->setObjResponsable($objReponsable);
					$this->setVImporte($viaje['vimporte']);
					$this->setTipoAsiento($viaje['tipoAsiento']);
					$this->getIdayvuelta($viaje['idayvuelta']);
					$resp= true;
				}
		 	}else{
                $this->setMensaje($baseDatos->getERROR());
			}
		 }else{
            $this->setMensaje($baseDatos->getERROR());
		 }		
		 return $resp;
	}	

    public function listar($condicion){
	    $resp = [];
        $baseDatos = new BaseDatos();
		$consultaViaje="SELECT * FROM viaje ";
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
                $this->setMensaje($baseDatos->getERROR());
			}
		 }else{
            $this->setMensaje($baseDatos->getERROR());
		 }	
		 return $resp;
	}	

    /**
     * Este modulo busca en la BD los pasajeros que coniciden con el viaje
    */
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
                $this->setMensaje($baseDatos->getERROR());
            }
        }else{
            $this->setMensaje($baseDatos->getERROR());
        }
        return $resp;
    }

    /**
     * Este modulo busca en la BD los pasajeros que coniciden con el viaje
    */
    public function hayPasajesDisponible(){
        $this->obtenerPasajeros();
        $arrayObjPasajero = $this->getArrayObjPasajero();
        if(count($arrayObjPasajero) < $this->getVcantmaxpasajeros()){
            $verificacion = true;
        }else{
            $verificacion = false;
        }
        return $verificacion;
    }
    
    /**
     * Este modulo devuelve una cadena de caracteres mostrando el contenido de los atributos
     * @return string
    */
        public function __toString(){
            return "----------------------------------
                ID: " . $this->getIdviaje() .
                "\nDestino: " . $this->getVdestino() .
                "\nCantidad maxima de pasajeros: " . $this->getVcantMaxPasajeros() .
                "\nEmpresa: \n" . $this->getObjempresa() .
                "\nEmpleado Responsable: \n" . $this->getRnumeroempleado() .
                "\nImporte: $" . $this->getVimporte() .
                "\nTipo de asiento: " . $this->getTipoAsiento() .
                "\nIda y vuelta: " . $this->getIdayvuelta() . "\n";
        }

}

?>








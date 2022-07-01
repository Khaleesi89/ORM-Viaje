<?php

    class Viaje {
        private $codigoViaje; 
        private $destino;
        private $capacidadPasajeros; 
        private $idEmpresa;
        private $objResponsable;
        private $importe;
        private $tipoAsiento;
        private $idayvuelta;
        private $objArrayPasajeros;
        private $mensajeoperacion;

        //Métodos de acceso:
        public function getCodigoViaje() {
            return $this->codigoViaje;
        }
        public function getDestino() {
            return $this->destino;
        }
        public function getCapacidadPasajeros() {
            return $this->capacidadPasajeros;
        }
        public function getIdEmpresa() {
            return $this->idEmpresa;
        }
        public function getObjResponsable() {
            return $this->objResponsable;
        }
        public function getImporte() {
            return $this->importe;
        }
        public function getTipoAsiento() {
            return $this->tipoAsiento;
        }
        public function getIdayvuelta() {
            return $this->idayvuelta;
        }
        public function getObjArrayPasajeros() {
            return $this->objArrayPasajeros;
        }
        public function getmensajeoperacion() {
            return $this->mensajeoperacion;
        }

        public function setCodigoViaje($codigoViaje) {
            $this->codigoViaje = $codigoViaje;
        }
        public function setDestino($destino) {
            $this->destino = $destino;
        }
        public function setCapacidadPasajeros($capacidadPasajeros) {
            $this->capacidadPasajeros = $capacidadPasajeros;
        }
        public function setIdEmpresa($idEmpresa) {
            $this->idEmpresa = $idEmpresa;
        }
        public function setObjResponsable($objResponsable) {
            $this->objResponsable = $objResponsable;
        }
        public function setImporte($importe) {
            $this->importe = $importe;
        }
        public function setTipoAsiento($tipoAsiento) {
            $this->tipoAsiento = $tipoAsiento;
        }
        public function setIdayvuelta($idayvuelta) {
            $this->idayvuelta = $idayvuelta;
        }
        public function setObjArrayPasajeros($objArrayPasajeros) {
            $this->objArrayPasajeros = $objArrayPasajeros;
        }
        public function setmensajeoperacion($mensajeoperacion){
            $this->mensajeoperacion = $mensajeoperacion;
        }
        
        //Métodos varios:
        public function __construct() {
            $this->codigoViaje = 0;
            $this->destino = "";
            $this->capacidadPasajeros = "";
            $this->idEmpresa = null;
            $this->objResponsable = null;
            $this->importe = "";
            $this->tipoAsiento = "";
            $this->idayvuelta = "";
            $this->objArrayPasajeros = [];
        }

        public function cargar($codigoViaje, $destino, $capacidadPasajeros, $idEmpresa, $objResponsable, $importe, $tipoAsiento, $idayvuelta) {
            $this->setCodigoViaje($codigoViaje);
            $this->setDestino($destino);
            $this->setCapacidadPasajeros($capacidadPasajeros);
            $this->setIdEmpresa($idEmpresa);
            $this->setObjResponsable($objResponsable);
            $this->setImporte($importe);
            $this->setTipoAsiento($tipoAsiento);
            $this->setIdayvuelta($idayvuelta);
        }

        public function __toString() {
            $pasajeros = $this->listarPasajeros();
            $strRespons = "";
            $strEmpresa = "";
            $responsable = new Responsable();
            $empresa = new Empresa();
            //responsable 
            if ($responsable->Buscar($this->getObjResponsable())) {
                $strRespons .= $responsable;
            }
            //empresa 
            if($empresa->Buscar($this->getIdEmpresa())){
                $strEmpresa .= $empresa;
            }
            $cant = count($pasajeros);
            $info = "DATOS DEL VIAJE
                    Código del viaje: {$this->getCodigoViaje()}
                    Destino: {$this->getDestino()}
                    Capacidad de pasajeros: {$this->getCapacidadPasajeros()}
                    Cantidad de pasajeros: {$cant}
                    Tipo de asiento: {$this->getTipoAsiento()}
                    Trayectoria: {$this->getIdayvuelta()}
                    Importe del viaje: {$this->getImporte()}
                    {$strEmpresa}
                    {$strRespons}
                    ";
                    //ID Empresa: ".$this->getIdEmpresa()
            return $info;
        }

        public function buscar($id) {
            $baseDatos = new BaseDatos();
            $consulta = "SELECT * FROM viaje WHERE idviaje = ".$id;
            $resp = false;

            if ($baseDatos->iniciar()) {
                if ($baseDatos->ejecutar($consulta)) {
                    if ($row2 = $baseDatos->registro()) {
                        $this->setCodigoViaje($id);
                        $this->setDestino($row2['vdestino']);
                        $this->setCapacidadPasajeros($row2['vcantmaxpasajeros']);
                        $this->setIdEmpresa($row2['idempresa']);
                        $this->setObjResponsable($row2['rnumeroempleado']);
                        $this->setImporte($row2['vimporte']);
                        $this->setTipoAsiento($row2['tipoAsiento']);
                        $this->setIdayvuelta($row2['idayvuelta']);
                        $resp = true;
                    }
                } else {
                    $this->setMensajeOperacion($baseDatos->getError());
                }
            } else {
                $this->setMensajeOperacion($baseDatos->getError());
            }
            return $resp;
        }

        
        public function listar($condicion = ""){
            $arrayViaje = null;
            $base = new BaseDatos();
            $consultaViaje = "SELECT * from viaje ";
            if ($condicion != "") {
                $consultaViaje = $consultaViaje.' WHERE '.$condicion;
            }

            $consultaViaje .= " order by idviaje ";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaViaje)) {				
                    $arrayViaje = array();
                    while ($row2 = $base->Registro()) {
                        $codigoViaje = $row2['idviaje'];
                        $destino = $row2['vdestino'];
                        $capacidadPasajeros = $row2['vcantmaxpasajeros'];
                        $idEmpresa = $row2['idempresa'];
                        $objResponsable = $row2['rnumeroempleado'];
                        $importe = $row2['vimporte'];
                        $tipoAsiento = $row2['tipoAsiento'];
                        $idayvuelta = $row2['idayvuelta'];
                        $nuevoViaje = new Viaje();
                        $nuevoViaje->cargar($codigoViaje, $destino, $capacidadPasajeros, $idEmpresa, $objResponsable, $importe, $tipoAsiento, $idayvuelta);
                        array_push($arrayViaje, $nuevoViaje);
                    }
                 } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                 $this->setmensajeoperacion($base->getError());
            }	
            return $arrayViaje;
        }

        
        public function insertar() {
            $base = new BaseDatos();
            $resp = false;
            $consultaInsertar = "INSERT INTO viaje(idviaje, vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte, tipoAsiento, idayvuelta)
                                VALUES ('".$this->getCodigoViaje()."',
                                        '".$this->getDestino()."',
                                        '".$this->getCapacidadPasajeros()."',
                                        '".$this->getIdEmpresa()."',
                                        '".$this->getObjResponsable()."',
                                        '".$this->getImporte()."',
                                        '".$this->getTipoAsiento()."',
                                        '".$this->getIdayvuelta()."')";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaInsertar)) {
                    echo $this->setCodigoViaje($base->DevolverID()); //(!)
                    $resp = true;
                } else {
                    $this->setmensajeoperacion($base->getError());	
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
            return $resp;
        }

        
        public function modificar() {
            $resp = false; 
            $baseDatos = new BaseDatos();
            $consultaModifica = "UPDATE viaje SET vdestino = '".$this->getDestino()."',
                                                vcantmaxpasajeros = '".$this->getCapacidadPasajeros()."',
                                                idempresa = '".$this->getIdEmpresa()."',
                                                rnumeroempleado = '".$this->getObjResponsable()."',
                                                vimporte = '".$this->getImporte()."',
                                                tipoAsiento = '".$this->getTipoAsiento()."',
                                                idayvuelta = '".$this->getIdayvuelta()."'
                                                WHERE idviaje = ". $this->getCodigoViaje();
            if ($baseDatos->Iniciar()) {
                if ($baseDatos->Ejecutar($consultaModifica)) {
                    $resp = true;
                } else {
                    $this->setmensajeoperacion($baseDatos->getError());
                }
            } else {
                $this->setmensajeoperacion($baseDatos->getError());
            }
            return $resp;
        }
        
        public function eliminar() {
            $baseDatos = new BaseDatos();
            $resp = false;
            if ($baseDatos->Iniciar()) {
                $consultaBorra = "DELETE FROM viaje WHERE idviaje = ".$this->getCodigoViaje();
                if ($baseDatos->Ejecutar($consultaBorra)) {
                    $resp = true;
                } else {
                    $this->setmensajeoperacion($baseDatos->getError());	
                }
            } else {
                $this->setmensajeoperacion($baseDatos->getError());
            }
            return $resp;
        }

        
        public function listarPasajeros() {
            $arregloPasajeros = null;
            $base = new BaseDatos();
            $consulta = "SELECT * FROM pasajero WHERE idviaje = ".$this->getCodigoViaje();
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
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
            return $arregloPasajeros;
        }

        
        public function listarDatosViajes() {
            $arregloPasajeros = $this->listarPasajeros();
            $pasajeros = count($arregloPasajeros);
            $stResponsable = "";
            $stEmpresa = "";
            $responsable = new Responsable();
            $empresa = new Empresa();
            //RESPONS
            if ($responsable->Buscar($this->getObjResponsable())) {
                $stResponsable .= $responsable;
            }
            //EMPRESA:
            if ($empresa->Buscar($this->getIdEmpresa())){
                $stEmpresa .= $empresa;
            }
            //PASAJEROS
            if ($pasajeros == 0) {
                $strPasajero = " el viaje esta vacio.\n";
            } else {
                $strPasajero = $this->mostrarDatosPasajeros($arregloPasajeros);
            }
            $info = "DATOS DEL VIAJE 
                    Código del viaje: {$this->getCodigoViaje()}
                    Destino: {$this->getDestino()}
                    Capacidad de pasajeros: {$this->getCapacidadPasajeros()}
                    Cantidad de pasajeros: {$pasajeros}
                    Tipo de asiento: {$this->getTipoAsiento()}
                    Trayectoria: {$this->getIdayvuelta()}
                    Importe del viaje: {$this->getImporte()}
                    {$stEmpresa}
                    {$stResponsable}
                    LISTA DE PASAJEROS 
                    {$strPasajero}
                    ";
                    //ID Empresa: ".$this->getIdEmpresa()."\n"
                    
            return $info;
        }

        
        public function mostrarDatosPasajeros($arrayPasajeros) {
            $i = 1;
            $cadenaPasajero = "";
            foreach ($arrayPasajeros as $elemento) {
                $cadenaPasajero .= "PASAJERO (".$i.") ".$elemento;
                $i++;
            }
            return $cadenaPasajero;
        }
    }
?>
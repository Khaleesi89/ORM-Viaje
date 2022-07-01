<?php
    class Empresa {
        private $idEmpresa;
        private $enombre;
        private $edireccion;
        private $mensajeoperacion;

       
        public function getIdEmpresa() {
            return $this->idEmpresa;
        }
        public function getEnombre() {
            return $this->enombre;
        }
        public function getEdireccion() {
            return $this->edireccion;
        }
        public function getMensajeOperacion() {
            return $this->mensajeoperacion;
        }
 
        public function setIdEmpresa($idEmpresa) {
            $this->idEmpresa = $idEmpresa;
        }
        public function setEnombre($enombre) {
            $this->enombre = $enombre;
        }
        public function setEdireccion($edireccion) {
            $this->edireccion = $edireccion;
        }
        public function setMensajeOperacion($mensajeoperacion){
            $this->mensajeoperacion = $mensajeoperacion;
        }

        
        public function __construct() {
            $this->idEmpresa = 0;
            $this->enombre = "";
            $this->edireccion = "";
        }

        public function cargar($idEmpresa, $nombreEmpresa, $direccionEmpresa) {
            $this->setIdEmpresa($idEmpresa);
            $this->setEnombre($nombreEmpresa);
            $this->setEdireccion($direccionEmpresa);
        }

        public function __toString() {
            $info = "***********EMPRESA **************
            ID EMPRESA: {$this->getIdEmpresa()}
            NOMBRE EMPRESA: {$this->getEnombre()}
            DIRECCIÓN EMPRESA: {$this->getEdireccion()}
            ***************************
            ";
            return $info;
        }

        public function buscar($idEmpresa) {
            $baseDatos = new BaseDatos();
            $consulta = "SELECT * FROM empresa WHERE idempresa = ".$idEmpresa;
            $resp = false;

            if ($baseDatos->iniciar()) {
                if ($baseDatos->ejecutar($consulta)) {
                    if ($empresa = $baseDatos->registro()) {
                        $this->setIdEmpresa($empresa['idempresa']);
                        $this->setEnombre($empresa['enombre']);
                        $this->setEdireccion($empresa['edireccion']);
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

        
        public function listar($condicion = "") {
            $arrayEmpresas = null;
            $base = new BaseDatos();
            $consultaEmpresa = "SELECT * FROM empresa";
            if ($condicion != "") {
                $consultaEmpresa = $consultaEmpresa.' where '.$condicion;
            }
            $consultaEmpresa .= " order by idempresa ";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaEmpresa)) {				
                    $arrayEmpresas = array();
                    while ($empresa = $base->Registro()) {
                        $idEmpresa = $empresa['idempresa'];
                        $nombre = $empresa['enombre'];
                        $direccion = $empresa['edireccion'];
                        $nuevaEmpresa = new Empresa();
                        $nuevaEmpresa->cargar($idEmpresa, $nombre, $direccion);
                        array_push($arrayEmpresas, $nuevaEmpresa);
                    }
                 } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                 $this->setmensajeoperacion($base->getError());
            }	
            return $arrayEmpresas;
        }

        public function insertar() {
            $base = new BaseDatos();
            $resp = false;
            $consultaInsertar = "INSERT INTO empresa VALUES({$this->getIdEmpresa()}, '{$this->getEnombre()}','{$this->getEdireccion()}')";

            //$consultaInsertar = "INSERT INTO empresa(idempresa, enombre, edireccion)
                                //VALUES (".$this->getIdEmpresa().",'".$this->getEnombre()."','".$this->getEdireccion()."')";
                                        
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaInsertar)) {
                    //$this->setIdEmpresa($base->devuelveIDInsercion($consultaInsertar));
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
            $consultaModifica = "UPDATE empresa SET enombre = '".$this->getEnombre()."',
                                                edireccion = '".$this->getEdireccion()."'
                                                WHERE idempresa = ". $this->getIdEmpresa();
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
                $consultaBorra = "DELETE FROM empresa WHERE idempresa = ".$this->getIdEmpresa();
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

        
        public function listarViajesEmpresa() {
            $arrayViajes = null;
            $base = new BaseDatos();
            $consulta = "SELECT * FROM viaje WHERE idempresa = ".$this->getIdEmpresa();    
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consulta)) {
                    $arrayViajes = array();
                    while ($viaje = $base->Registro()) {
                        $codigoViaje = $viaje['idviaje'];
                        $destino = $viaje['vdestino'];
                        $capacidadPasajeros = $viaje['vcantmaxpasajeros'];
                        $idEmpresa = $viaje['idempresa'];
                        $objResponsable = $viaje['rnumeroempleado'];
                        $importe = $viaje['vimporte'];
                        $tipoAsiento = $viaje['tipoAsiento'];
                        $idayvuelta = $viaje['idayvuelta'];
                        $viajeNew = new Viaje();
                        $viajeNew->cargar($codigoViaje, $destino, $capacidadPasajeros, $idEmpresa, $objResponsable, $importe, $tipoAsiento, $idayvuelta);
                        $arrayViajes[] = $viajeNew;
                    }
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
            return $arrayViajes;
        }

        
        function EliminarViajesEmpresa() {
            $resp = false;
            $listaDeViajes = $this->listarViajesEmpresa();
            foreach ($listaDeViajes as $unViaje) {
                $listaDePasajeros = $unViaje->listarPasajeros();
                foreach ($listaDePasajeros as $unPasajero) {
                    $unPasajero->Eliminar();
                }
                $unViaje->Eliminar();
            }
            return $resp;
        }

        
        public function mostrarViajesEmpresa() {
            $i = 1;
            $info = "";
            $listaDeViajes = $this->listarViajesEmpresa();
            if (count($listaDeViajes) == 0) {
                $info = " La empresa no tiene viajes \n";
            } else {
                foreach ($listaDeViajes as $unViaje) {
                    $info .= "VIAJE ($i)
                    Código del viaje: {$unViaje->getCodigoViaje()}
                    Destino: {$unViaje->getDestino()}
                    Capacidad de pasajeros: {$unViaje->getCapacidadPasajeros()}
                    ";
                    $i++;
                }
            }
            return $info;
        }
    }
?>
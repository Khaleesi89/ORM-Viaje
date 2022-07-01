<?php
    
    class Responsable {
        private $nombre;
        private $apellido;
        private $nroEmpleado;
        private $nroLicencia;
        private $mensajeoperacion;
        
        
        public function getNombre() {
            return $this->nombre;
        }
        public function getApellido() {
            return $this->apellido;
        }
        public function getNroEmpleado() {
            return $this->nroEmpleado;
        }
        public function getNroLicencia() {
            return $this->nroLicencia;
        }
        public function getmensajeoperacion() {
            return $this->mensajeoperacion;
        }

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }
        public function setApellido($apellido) {
            $this->apellido = $apellido;
        }
        public function setNroEmpleado($nroEmpleado) {
            $this->nroEmpleado = $nroEmpleado;
        }
        public function setNroLicencia($nroLicencia) {
            $this->nroLicencia = $nroLicencia;
        }
        public function setmensajeoperacion($mensajeoperacion){
            $this->mensajeoperacion = $mensajeoperacion;
        }

        
        public function __construct() {
            $this->nroEmpleado = 0;
            $this->nroLicencia = "";
            $this->nombre = "";
            $this->apellido = "";
        }

        public function cargar($nroEmpleado, $nroLicencia, $nombre, $apellido) {
            $this->setNroEmpleado($nroEmpleado);
            $this->setNroLicencia($nroLicencia);
            $this->setNombre($nombre);
            $this->setApellido($apellido);
        }

        public function __toString() {
            $info = "********RESPONSABLE*************
                    Nombre: {$this->getNombre()}
                    Apellido: {$this->getApellido()}
                    N° de empleado: {$this->getNroEmpleado()}
                    N° de licencia: {$this->getNroLicencia()}
                    *********************
                    ";
            return $info;
        }

        
        public function buscar($nroEmpleado) {
            $baseDatos = new BaseDatos();
            $consulta = "SELECT * FROM responsable WHERE rnumeroempleado = ".$nroEmpleado;
            $resp = false;

            if ($baseDatos->iniciar()) {
                if ($baseDatos->ejecutar($consulta)) {
                    if ($row2 = $baseDatos->registro()) {
                        $this->setNroEmpleado($nroEmpleado);
                        $this->setNroLicencia($row2['rnumerolicencia']);
                        $this->setNombre($row2['rnombre']);
                        $this->setApellido($row2['rapellido']);
                        $resp= true;
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
            $arregloResponsable = null;
            $base = new BaseDatos();
            $consulta = "SELECT * from responsable ";
            if ($condicion != "") {
                $consulta = $consulta.' WHERE '.$condicion;
            }

            $consulta .= " order by rapellido ";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consulta)) {				
                    $arregloResponsable = array();
                    while ($row2 = $base->Registro()) {
                        $nuevoResponsable = new Responsable();
                        $nuevoResponsable->buscar($row2['rnumeroempleado']);
                        array_push($arregloResponsable, $nuevoResponsable);
                    }
                 } else {
                     $this->setmensajeoperacion($base->getError());
                     
                }
            } else {
                 $this->setmensajeoperacion($base->getError());
            }	
            return $arregloResponsable;
        }

        
        public function insertar() {
            $base = new BaseDatos();
            $resp = false;
            $insert = "INSERT INTO responsable(rnumeroempleado, rnumerolicencia, rnombre, rapellido) 
                                VALUES ('".$this->getNroEmpleado()."',
                                        '".$this->getNroLicencia()."', 
                                        '".$this->getNombre()."',
                                        '".$this->getApellido()."')";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($insert)) {
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
            $modif = "UPDATE responsable SET rnumerolicencia = '".$this->getNroLicencia()."',
                                                rnombre = '".$this->getNombre()."',
                                                rapellido = '".$this->getApellido()."'
                                                WHERE rnumeroempleado = ". $this->getNroEmpleado();
            if ($baseDatos->Iniciar()) {
                if ($baseDatos->Ejecutar($modif)) {
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
                $eliminar = "DELETE FROM responsable WHERE rnumeroempleado = ".$this->getNroEmpleado();
                if ($baseDatos->Ejecutar($eliminar)) {
                    $resp = true;
                } else {
                    $this->setmensajeoperacion($baseDatos->getError());	
                }
            } else {
                $this->setmensajeoperacion($baseDatos->getError());
            }
            return $resp;
        }

        //VIAJES Q TIENE A CARGO UN ENCARGADO EN ESPECIFICO
         
        public function listarViajesResponsable() {
            $arrayViajes = null;
            $base = new BaseDatos();
            $consulta = "SELECT * FROM viaje WHERE rnumeroempleado = ".$this->getNroEmpleado();    
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consulta)) {
                    $arrayViajes = array();
                    while ($resp=$base->Registro()) {
                        $codigoViaje = $resp['idviaje'];
                        $destino = $resp['vdestino'];
                        $capacidadPasajeros = $resp['vcantmaxpasajeros'];
                        $idEmpresa = $resp['idempresa'];
                        $objResponsable = $resp['rnumeroempleado'];
                        $importe = $resp['vimporte'];
                        $tipoAsiento = $resp['tipoAsiento'];
                        $idayvuelta = $resp['idayvuelta'];
                        $viaje = new Viaje();
                        $viaje->cargar($codigoViaje, $destino, $capacidadPasajeros, $idEmpresa, $objResponsable, $importe, $tipoAsiento, $idayvuelta);
                        $arrayViajes[] = $viaje;
                    }
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
            return $arrayViajes;
        }

        //FUNCION QUE BORRA TODOS LO SVIAJES ASOCIADOS A UN RESPONSABLE

        function eliminarViajesResponsable()
        {
            $resp = false;
            $listaDeViajes = $this->listarViajesResponsable();
            foreach ($listaDeViajes as $unViaje) {
                $listaDePasajeros = $unViaje->listarPasajeros();
                foreach ($listaDePasajeros as $unPasajero) {
                    $unPasajero->Eliminar();
                }
                $unViaje->Eliminar();
            }
            return $resp;
        }

        //STRIN CON LOS VIAJES A CARGO

        public function mostrarViajesResponsable() {
            $i = 1;
            $cadenaViaje = "";
            $listaDeViajes = $this->listarViajesResponsable();
            if (count($listaDeViajes) == 0) {
                $cadenaViaje = ">>> El empleado no tiene viajes a su cargo.\n";
            } else {
                foreach ($listaDeViajes as $unViaje) {
                    $cadenaViaje .= "DATOS DEL VIAJE ($i)
                    Código del viaje: {$unViaje->getCodigoViaje()}
                    Destino: {$unViaje->getDestino()}
                    Capacidad de pasajeros: {$unViaje->getCapacidadPasajeros()}
                    ";
                    $i++;
                }
            }
            return $cadenaViaje;
        }
    }
?>
<?php
    //nombre, apellido, numero de documento y teléfono + idViaje
    class Pasajero {
        private $dni;
        private $nombre;
        private $apellido;
        private $telefono;
        private $idviaje; //
        private $mensajeoperacion;

        //Métodos de acceso:
        public function getNombre() {
            return $this->nombre;
        }
        public function getApellido() {
            return $this->apellido;
        }
        public function getDni() {
            return $this->dni;
        }
        public function getTelefono() {
            return $this->telefono;
        }
        public function getIdviaje() {
            return $this->idviaje;
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
        public function setDni($dni) {
            $this->dni = $dni;
        }
        public function setTelefono($telefono) {
            $this->telefono = $telefono;
        }
        public function setIdviaje($idViajes) {
            $this->idviaje = $idViajes;
        }
        public function setmensajeoperacion($mensajeoperacion){
            $this->mensajeoperacion = $mensajeoperacion;
        }

        //Métodos varios:
        public function __construct() {
            $this->nombre = "";
            $this->apellido = "";
            $this->dni = "";
            $this->telefono = "";
            $this->idviaje = null;
        }

        public function cargar($dni, $nombre, $apellido, $telefono, $idViaje) {		
            $this->setDni($dni);
            $this->setNombre($nombre);
            $this->setApellido($apellido);
            $this->setTelefono($telefono);
            $this->setIdviaje($idViaje);
        }

        public function __toString() {
            
            $cadena = "********* PASAJERO *************
                    Nombre: {$this->getNombre()}
                    Apellido: {$this->getApellido()}
                    DNI: {$this->getDni()}
                    Teléfono: {$this->getTelefono()}
                    ID Viaje: {$this->getIdviaje()} 
                    ***********************
                    ";
            return $cadena;
        }

        public function buscar($nroDocumento) {
            $baseDatos = new BaseDatos();
            $consulta = "SELECT * FROM pasajero WHERE rdocumento = ".$nroDocumento;
            $resp = false;

            if ($baseDatos->iniciar()) {
                if ($baseDatos->ejecutar($consulta)) {
                    if ($row2 = $baseDatos->registro()) {
                        //Se busca el objViaje por el código de viaje:
                        $objViaje = new Viaje();
                        $objViaje->Buscar($this->getIdviaje());

                        $this->setDni($nroDocumento);
                        $this->setNombre($row2['pnombre']);
                        $this->setApellido($row2['papellido']);
                        $this->setTelefono($row2['ptelefono']);
                        $this->setIdViaje($row2['idviaje']); 
                        //$this->getIdviaje($objViaje->getCodigoViaje());
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
            $arrayPasajeros = null;
            $base = new BaseDatos();
            $consultaPasajero = "SELECT * from pasajero ";
            //Si la condición recibida por parámetro no está vacia, se arma un nuevo string para la consulta en la BD:
            if ($condicion != "") {
                $consultaPasajero = $consultaPasajero.' where '.$condicion;
            }

            $consultaPasajero .= " order by papellido ";
            //echo $consultaResponsable;
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaPasajero)) {				
                    $arrayPasajeros = array();
                    while ($row2 = $base->Registro()) {
                        $dni = $row2['rdocumento'];
                        $objPasajero = new Pasajero();
                        $objPasajero->buscar($dni);
                        array_push($arrayPasajeros, $objPasajero);
                    }
                 } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                 $this->setmensajeoperacion($base->getError());
            }	
            return $arrayPasajeros;
        }

        public function insertar() {
            $base = new BaseDatos();
            $resp = false;
            $consultaInsertar = "INSERT INTO pasajero(rdocumento, pnombre, papellido, ptelefono, idviaje) 
                                VALUES ('".$this->getDni()."',
                                        '".$this->getNombre()."',
                                        '".$this->getApellido()."',
                                        '".$this->getTelefono()."',
                                        '".$this->getIdviaje()."')"; 
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaInsertar)) {
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
            $consultaModifica = "UPDATE pasajero SET pnombre = '".$this->getNombre()."',
                                                papellido = '".$this->getApellido()."',
                                                ptelefono = '".$this->getTelefono()."',
                                                idviaje = '".$this->getIdviaje()."'
                                                WHERE rdocumento = ". $this->getDni();
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
        
        /**
         * Método 5: eliminar - 
         * Elimina una tupla en la tabla "pasajero".
         * @return boolean $resp
         */
        public function eliminar() {
            $baseDatos = new BaseDatos();
            $resp = false;
            if ($baseDatos->Iniciar()) {
                $consultaBorra = "DELETE FROM pasajero WHERE rdocumento = ".$this->getDni();
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
    }
?>
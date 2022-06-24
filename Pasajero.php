<?php
class Pasajero{
    private $nombre;
    private $apellido;
    private $documento;
    private $telefono;
    private $objViaje;

    /**************************************/
	/**************** SET *****************/
	/**************************************/

    /**
     * Establece el valor de telefono
     */ 
    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    /**
     * Establece el valor de documento
     */ 
    public function setDocumento($documento){
        $this->documento = $documento;
    }

    /**
     * Establece el valor de apellido
     */ 
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    /**
     * Establece el valor de nombre
     */ 
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    /**
     * Establece el valor de objViaje
     */ 
    public function setObjViaje($objViaje){
        $this->objViaje = $objViaje;
    }


	/**************************************/
	/**************** GET *****************/
	/**************************************/

    /**
     * Obtiene el valor de documento
     */ 
    public function getDocumento(){
        return $this->documento;
    }

    /**
     * Obtiene el valor de telefono
     */ 
    public function getTelefono(){
        return $this->telefono;
    }

    /**
     * Obtiene el valor de apellido
     */ 
    public function getApellido(){
        return $this->apellido;
    }

    /**
     * Obtiene el valor de nombre
     */ 
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * Obtiene el valor de objViaje
     */ 
    public function getObjViaje(){
        return $this->objViaje;
    }


	/**************************************/
	/************** FUNCIONES *************/
	/**************************************/

    public function __construct($nombre,$apellido,$documento,$telefono)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->documento = $documento;
        $this->telefono = $telefono;
    }

    /**
     * Este modulo agrega un pasajero de la BD.
    */
    public function insertarPasajero(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "INSERT INTO pasajero (pdocumento, pnombre, papellido, ptelefono, idviaje) 
                    VALUES (".$this->getDocumento().",'".$this->getNombre()."','".$this->getApellido()."','".$this->getTelefono()."','".$this->getObjViaje()->getIdaVuelta()."')";
        if($baseDatos->iniciar()){
            if($baseDatos->ejecutar($consulta)){
                $resp = true;
            }else{
                $resp = $baseDatos->getError();
            }
        }else{
            $resp = $baseDatos->getError();
        }
        return $resp;
    }

    /**
     * Este modulo modifica un pasajero de la BD.
    */
    public function modificarPasajero(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "UPDATE FROM pasajero 
                    SET pdocumento = ".$this->getDocumento().", 
                    pnombre = '".$this->getNombre()."', 
                    papellido ='".$this->getApellido()."', 
                    ptelefono = ".$this->getTelefono().", 
                    idviaje = '".$this->getObjViaje()->getIdaVuelta()."' WHERE pdocumento = ".$this->getDocumento();
        if($baseDatos->iniciar()){
            if($baseDatos->ejecutar($consulta)){
                $resp = true;
            }else{
                $resp = $baseDatos->getError();
            }
        }else{
            $resp = $baseDatos->getError();
        }
        return $resp;
    }

    /**
     * Este elimina un pasajero de la BD.
    */
    public function eliminarPasajero(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "DELETE FROM pasajero WHERE pdocumento = ".$this->getDocumento();
        if($baseDatos->iniciar()){
            if($baseDatos->ejecutar($consulta)){
                $resp = true;
            }else{
                $resp = $baseDatos->getError();
            }
        }else{
            $resp = $baseDatos->getError();
        }
        return $resp;
    }

    public function buscarPasajero($documento){
        $baseDatos = new BaseDatos();
		$consulta="SELECT * FROM pasajero WHERE pdocumento = ".$documento;
		$resp = null;
		if($baseDatos->iniciar()){
			if($baseDatos->ejecutar($consulta)){
				if($pasajero=$baseDatos->registro()){					
				    $this->setDocumento($documento);
					$this->setNombre($pasajero['pnombre']);
					$this->setApellido($pasajero['papellido']);
					$this->setTelefono($pasajero['ptelefono']);
					$this->setObjViaje($pasajero['idviaje']);
					$resp= true;
				}
		 	}else{
                $resp = $baseDatos->getError();
			}
		 }else{
            $resp = $baseDatos->getError();
		 }		
		 return $resp;
	}

    public function listarPasajeros($condicion){
	    $resp = null;
        $baseDatos = new BaseDatos();
		$consultaPasajero="SELECT * FROM pasajero ";
		if($condicion != ""){
		    $consultaPasajero +=' where '.$condicion;
		}
		if($baseDatos->iniciar()){
			if($baseDatos->ejecutar($consultaPasajero)){
				if($pasajero=$baseDatos->registro()){	
                    $resp = [];				
				    $documento = $pasajero['pdocumento'];
					$nombre = $pasajero['pnombre'];
					$apellido = $pasajero['papellido'];
					$telofono = $pasajero['ptelefono'];
					$idViaje = $pasajero['idviaje'];
					$objPasajero = new Pasajero($nombre, $apellido, $documento, $idViaje);
                    array_push($resp, $objPasajero);
				}
		 	}else{
                $resp = $baseDatos->getError();
			}
		 }else{
            $resp = $baseDatos->getError();
		 }		
		 return $resp;
	}

    public function __toString()
    {
        return ("El nombre del pasajero es: ".$this->getNombre()."\n".
                "El apellido del pasajero es: ".$this->getApellido()."\n".
                "El documento del pasajero es: ".$this->getDocumento()."\n".
                "El codigo del viaje es: ".$this->getObjViaje()->getIdaVuelta()."\n".
                "El telefono del pasajero es: ".$this->getTelefono()."\n");
    }
    
}
?>
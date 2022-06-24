<?php
class ResponsableV{
    private $nombre;
    private $apellido;
    private $numEmpleado;
    private $numLicencia;

    /**************************************/
	/**************** SET *****************/
	/**************************************/

    /**
     * Establece el valor de numLicencia
     */ 
    public function setNumLicencia($numLicencia){
        $this->numLicencia = $numLicencia;
    }

    /**
     * Establece el valor de numEmpleado
     */ 
    public function setNumEmpleado($numEmpleado){
        $this->numEmpleado = $numEmpleado;
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


	/**************************************/
	/**************** GET *****************/
	/**************************************/

    /**
     * Obtiene el valor de nombre
     */ 
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * Obtiene el valor de apellido
     */ 
    public function getApellido(){
        return $this->apellido;
    }

    /**
     * Obtiene el valor de numEmpleado
     */ 
    public function getNumEmpleado(){
        return $this->numEmpleado;
    }

    /**
     * Obtiene el valor de numLicencia
     */ 
    public function getNumLicencia(){
        return $this->numLicencia;
    }


	/**************************************/
	/************** FUNCIONES *************/
	/**************************************/

	public function __construct($nombre, $apellido, $numLicencia, $numEmpleado)
	{
        $this->nombre = $nombre;
        $this->apellido = $apellido;
		$this->numLicencia = $numLicencia;
		$this->numEmpleado = $numEmpleado;
	}

    /**
     * Este modulo agrega un pasajero de la BD.
    */
    public function insertarPasajero(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "INSERT INTO responsable (rnumerolicencia, rnombre, rapellido) 
                    VALUES (".$this->getNumLicencia().",'".$this->getNombre()."','".$this->getApellido()."')";
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
        $consulta = "UPDATE FROM responsable 
                    SET rnumerolicencia = ".$this->getNumLicencia().", 
                    rnombre = '".$this->getNombre()."', 
                    rapellido ='".$this->getApellido()."' WHERE rnumeroempleado = ".$this->getNumEmpleado();
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
    public function eliminarPasajero(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "DELETE FROM responsable WHERE rnumeroempleado = ".$this->getNumEmpleado();
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

    public function buscarResponsable($nroEmpleado){
        $baseDatos = new BaseDatos();
		$consulta="SELECT * FROM responsable WHERE rnumeroempleado = ".$nroEmpleado;
		$resp = null;
		if($baseDatos->iniciar()){
			if($baseDatos->ejecutar($consulta)){
				if($responsable=$baseDatos->registro()){					
				    $this->setNombre($responsable['rnombre']);
					$this->setApellido($responsable['rapellido']);
					$this->setNumLicencia($responsable['rnumerolicencia']);
					$this->setNumEmpleado($nroEmpleado);
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
		$consultaResponsable="SELECT * FROM responsable ";
		if($condicion != ""){
		    $consultaResponsable +=' where '.$condicion;
		}
		if($baseDatos->iniciar()){
			if($baseDatos->ejecutar($consultaResponsable)){
				if($responsable=$baseDatos->registro()){		
                    $resp = [];		
				    $nombre = $responsable['rnombre'];
					$apellido = $responsable['rapellido'];
					$nroLicencia = $responsable['rnumerolicencia'];
					$nroEmpleado = $responsable['rnumeroempleado'];
                    $objResponsable = new ResponsableV($nombre, $apellido, $nroLicencia, $nroEmpleado);
                    array_push($resp, $objResponsable);
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
		return ("El nombre del responsable del viaje es: ".$this->getNombre()."\n".
				"El apellido del responsable del viaje es: ".$this->getApellido()."\n".
				"El numero de empleado es: ".$this->getNumEmpleado()."\n".
				"El numero de licencia es: ".$this->getNumLicencia()."\n");
	}

}
?>
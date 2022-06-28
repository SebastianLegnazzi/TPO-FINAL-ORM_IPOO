<?php
class Empresa {
    private $identificacion;
    private $nombre;
    private $direccion;

    
    /**************************************/
    /**************** SET *****************/
    /**************************************/
    
    /**
     * Establece el valor de identificacion
     */ 
    public function setIdentificacion($identificacion){
        $this->identificacion = $identificacion;
    }

    /**
     * Establece el valor de nombre
     */ 
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    /**
     * Establece el valor de arrayViajes
     */ 
    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }

    
    /**************************************/
    /**************** GET *****************/
    /**************************************/
    
    /**
     * Obtiene el valor de identificacion
     */ 
    public function getIdentificacion(){
        return $this->identificacion;
    }

    /**
     * Obtiene el valor de nombre
     */ 
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * Obtiene el valor de arrayViajes
     */ 
    public function getDireccion(){
        return $this->direccion;
    }
    
    
    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/
    
    public function __construct(){
        $this->identificacion = "";
        $this->nombre = "";
        $this->direccion = "";
    }

    public function cargar($identificacion, $nombre, $direccion){		
        $this->setIdentificacion($identificacion);
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
    }

    /**
     * Este modulo agrega un pasajero de la BD.
    */
    public function insertar(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "INSERT INTO empresa (enombre, edireccion) 
                    VALUES ('".$this->getNombre()."','".$this->getDireccion()."')";
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
    public function modificar(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "UPDATE empresa 
                    SET idempresa = ".$this->getIdentificacion().", 
                    enombre = '".$this->getNombre()."', 
                    edireccion ='".$this->getDireccion()."' WHERE idempresa = ".$this->getIdentificacion();
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
    public function eliminar(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "DELETE FROM empresa WHERE idempresa = ".$this->getIdentificacion();
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

    public function buscar($idEmpresa){
        $baseDatos = new BaseDatos();
		$consulta="SELECT * FROM empresa WHERE idempresa = ".$idEmpresa;
		$resp = null;
		if($baseDatos->iniciar()){
			if($baseDatos->ejecutar($consulta)){
				while($empresa=$baseDatos->registro()){					
				    $this->setIdentificacion($idEmpresa);
					$this->setNombre($empresa['enombre']);
					$this->setDireccion($empresa['edireccion']);
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

    public function listar($condicion){
	    $resp = null;
        $baseDatos = new BaseDatos();
		$consultaEmpresa="SELECT * FROM empresa ";
		if($condicion != ""){
		    $consultaEmpresa .=' where '.$condicion;
		}
		if($baseDatos->iniciar()){
			if($baseDatos->ejecutar($consultaEmpresa)){
                $resp = [];	
				while($empresa=$baseDatos->registro()){	
				    $idEmpresa = $empresa['idempresa'];
					$nombre = $empresa['enombre'];
					$direccion = $empresa['edireccion'];
                    $objEmpresa = new Empresa();
                    $objEmpresa->cargar($idEmpresa, $nombre, $direccion);
					array_push($resp, $objEmpresa);
				}
		 	}else{
                $resp = $baseDatos->getError();
			}
		 }else{
            $resp = $baseDatos->getError();
		 }		
		 return $resp;
	}

    public function __toString(){
        return "Identificacion de la empresa: ".$this->getIdentificacion()."\n".
                "Nombre de la empresa: ".$this->getNombre()."\n".
                "La direccion de la empresa es: ".$this->getDireccion()."\n";
    }



}

?>
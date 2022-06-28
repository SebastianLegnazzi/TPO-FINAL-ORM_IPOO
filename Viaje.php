<?php
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

    public function cargar($idViaje, $vDestino, $vCantidadMax, $objEmpresa, $objResponsable, $vImporte, $tipoAsiento, $idaVuelta){		
        $this->setIdViaje($idViaje);
        $this->setVDestino($vDestino);
        $this->setVCantidadMax($vCantidadMax);
        $this->setObjEmpresa($objEmpresa);
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
        $resp = null;
        $consulta = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte, tipoAsiento, idayvuelta) 
                    VALUES ('".$this->getVDestino()."',".$this->getVCantidadMax().",".$this->getObjEmpresa()->getIdentificacion().",".$this->getObjResponsable()->getNumEmpleado().",".$this->getVImporte().",".$this->getTipoAsiento().",'".$this->getIdaVuelta()."')";
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
     * Este modulo modifica un viaje de la BD.
    */
    public function modificar(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "UPDATE viaje 
                    SET idViaje = ".$this->getIdViaje().",
                    vdestino = '".$this->getVDestino()."', 
                    vcantmaxpasajeros = ".$this->getVCantidadMax().", 
                    idempresa = ".$this->getObjEmpresa()->getIdentificacion().", 
                    rnumeroempleado = ".$this->getObjResponsable()->getNumEmpleado().", 
                    vimporte = ".$this->getVImporte().",
                    tipoAsiento = ".$this->getTipoAsiento().",
                    idayvuelta = '".$this->getIdaVuelta()."' WHERE idviaje = ".$this->getIdViaje();
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
     * Este elimina un viaje de la BD.
    */
    public function eliminar(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "DELETE FROM viaje WHERE idviaje = ".$this->getIdViaje();
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

    public function buscar($idViaje){
        $baseDatos = new BaseDatos();
		$consulta="SELECT * FROM viaje WHERE idviaje = ".$idViaje;
		$resp = null;
		if($baseDatos->iniciar()){
			if($baseDatos->ejecutar($consulta)){
				if($viaje=$baseDatos->registro()){
                    $objReponsable = new ResponsableV();
                    $objEmpresa = new Empresa();
                    $objReponsable->buscar($viaje['rnumeroempleado']);					
                    $objEmpresa->buscar($viaje['idempresa']);	
				    $this->setIdViaje($idViaje);
					$this->setVDestino($viaje['vdestino']);
					$this->setVCantidadMax($viaje['vcantmaxpasajeros']);
					$this->setObjEmpresa($objEmpresa);
					$this->setObjResponsable($objReponsable);
					$this->setVImporte($viaje['vimporte']);
					$this->setTipoAsiento($viaje['tipoAsiento']);
					$this->setIdaVuelta($viaje['idayvuelta']);
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

    public static function listar($condicion){
	    $resp = null;
        $baseDatos = new BaseDatos();
		$consultaViaje="SELECT * FROM viaje ";
		if($condicion != ""){
		    $consultaViaje .=' where '.$condicion;
		}
		if($baseDatos->iniciar()){
			if($baseDatos->ejecutar($consultaViaje)){				
				$resp = [];
				while($viaje=$baseDatos->registro()){
					$idViaje = $viaje['idviaje'];
					$destino = $viaje['vdestino'];
					$cantMaxPasajeros = $viaje['vcantmaxpasajeros'];
					$importe = $viaje['vimporte'];
					$tipoAsiento = $viaje['tipoAsiento'];
					$idaYVuelta = $viaje['idayvuelta'];
                    $objViaje = new Viaje();
                    $objReponsable = new ResponsableV();
                    $objEmpresa = new Empresa();
                    $objReponsable->buscar($viaje['rnumeroempleado']);
                    $objEmpresa->buscar($viaje['idempresa']);
                    $objViaje->cargar($idViaje, $destino, $cantMaxPasajeros, $objEmpresa, $objReponsable, $importe, $tipoAsiento, $idaYVuelta);
					array_push($resp, $objViaje);
				}
		 	}else {
                $resp = $baseDatos->getError();
			}
		 }else{
            $resp = $baseDatos->getError();
		 }	
		 return $resp;
	}	

    /**
     * Este modulo busca en la BD los pasajeros que coniciden con el viaje
    */
    public function obtenerPasajeros(){
        $baseDatos = new BaseDatos();
        $resp = null;
        $consulta = "idViaje = ".$this->getIdViaje();
        if($baseDatos->iniciar()){
            $objPasajero = new Pasajero();
            $arrayObjPersona = $objPasajero->listar($consulta);
            if(is_array($arrayObjPersona)){
                $this->setArrayObjPasajero($arrayObjPersona);
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
     * Este modulo busca en la BD los pasajeros que coniciden con el viaje
    */
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
    
    /**
     * Este modulo devuelve una cadena de caracteres mostrando el contenido de los atributos
     * @return string
    */
    public function __toString(){
        return ("El codigo del viaje es: ".$this->getIdViaje()."\n".
                "El destino del viaje es: ".$this->getVDestino()."\n"."\n".
                "Los datos de la empresa son: "."\n".$this->getObjEmpresa()."\n".
                "Los datos del responsable del viaje son: "."\n".$this->getObjResponsable()."\n".
                "El importe del viaje es: ".$this->getVImporte()."\n".
                "El tipo de asiento del viaje es: ".$this->getTipoAsiento()."\n".
                "El viaje es de ida y vuelta: ".$this->getIdaVuelta()."\n");
    }
}

?>
<?php
class BaseDatos {
    private $HOSTNAME;
    private $BASEDATOS;
    private $USUARIO;
    private $CLAVE;
    private $CONEXION;
    private $QUERY;
    private $RESULT;
    private $ERROR;


    
    /**************************************/
    /**************** SET *****************/
    /**************************************/
    
    /**
     * Establece el valor de HOSTNAME
     */ 
    public function setHOSTNAME($HOSTNAME){
        $this->HOSTNAME = $HOSTNAME;
    }

    /**
     * Establece el valor de BASEDATOS
     */ 
    public function setBASEDATOS($BASEDATOS){
        $this->BASEDATOS = $BASEDATOS;
    }

    /**
     * Establece el valor de USUARIO
     */ 
    public function setUSUARIO($USUARIO){
        $this->USUARIO = $USUARIO;
    }

    /**
     * Establece el valor de CLAVE
     */ 
    public function setCLAVE($CLAVE){
        $this->CLAVE = $CLAVE;
    }

    /**
     * Establece el valor de QUERY
     */ 
    public function setQUERY($QUERY){
        $this->QUERY = $QUERY;
    }

    /**
     * Establece el valor de CONEXION
     */ 
    public function setCONEXION($CONEXION){
        $this->CONEXION = $CONEXION;
    }

    /**
     * Establece el valor de RESULT
     */ 
    public function setRESULT($RESULT){
        $this->RESULT = $RESULT;
    }

    /**
     * Establece el valor de ERROR
     */ 
    public function setERROR($ERROR){
        $this->ERROR = $ERROR;
    }

    
    /**************************************/
    /**************** GET *****************/
    /**************************************/
    
    /**
     * Obtiene el valor de HOSTNAME
     */ 
    public function getHOSTNAME(){
        return $this->HOSTNAME;
    }

    /**
     * Obtiene el valor de BASEDATOS
     */ 
    public function getBASEDATOS(){
        return $this->BASEDATOS;
    }

    /**
     * Obtiene el valor de USUARIO
     */ 
    public function getUSUARIO(){
        return $this->USUARIO;
    }

    /**
     * Obtiene el valor de CLAVE
     */ 
    public function getCLAVE(){
        return $this->CLAVE;
    }

    /**
     * Obtiene el valor de CONEXION
     */ 
    public function getCONEXION(){
        return $this->CONEXION;
    }

    /**
     * Obtiene el valor de QUERY
     */ 
    public function getQUERY(){
        return $this->QUERY;
    }

    /**
     * Obtiene el valor de RESULT
     */ 
    public function getRESULT(){
        return $this->RESULT;
    }

    /**
     * Obtiene el valor de ERROR
     */ 
    public function getERROR(){
        return "\n".$this->ERROR;
    }

    
    /**************************************/
    /************** FUNCIONES *************/
    /**************************************/
    
    public function __construct(){
        $this->HOSTNAME = "127.0.0.1:3308";
        $this->BASEDATOS = "bdviajes";
        $this->USUARIO = "root";
        $this->CLAVE = "";
        $this->CONEXION = "";
        $this->QUERY = " ";
        $this->RESULT = 0;
        $this->ERROR = " ";
    }
    
    public function iniciar(){
        $verificacion = false;
        $conexion = mysqli_connect($this->getHOSTNAME(), $this->getUSUARIO(), $this->getCLAVE(), $this->getBASEDATOS());
        if($conexion){
            if(mysqli_select_db($conexion, $this->getBASEDATOS())){
                $this->setCONEXION($conexion);
                unset($this->QUERY);
                unset($this->ERROR);
                $verificacion = true;
            }else{
                $this->setERROR(mysqli_errno($conexion).":".mysqli_error($conexion));
            }
        }else{
            $this->setERROR(mysqli_errno($conexion).":".mysqli_error($conexion));
        }
        return $verificacion;
    }

    public function ejecutar($consulta){
        $verificacion = false;
        unset($this->ERROR);
        $this->setQUERY($consulta);
        $this->setRESULT(mysqli_query($this->getCONEXION(), $consulta));
        if($this->getRESULT()){
            $verificacion = true;
        }else{
            $this->setERROR(mysqli_errno($this->getCONEXION()).":".mysqli_error($this->getCONEXION()));
        }
        return $verificacion;
    }

    public function registro(){
        $verificacion = null;
        if($this->getRESULT()){
            unset($this->ERROR);
            if($temp = mysqli_fetch_assoc($this->getRESULT())){
                $verificacion = $temp;
            }else{
                mysqli_free_result($this->getRESULT());
            }
        }else{
            $this->setERROR(mysqli_errno($this->getCONEXION()).":".mysqli_error($this->getCONEXION()));
        }
        return $verificacion;
    }

    public function devuelveIDInsercion($consulta){
        $verificacion = null;
        unset($this->ERROR);
        if($this->setRESULT(mysqli_query($this->getCONEXION(), $consulta))){
            $id = mysqli_insert_id();
            $verificacion = $id;
        }else{
            $this->setERROR(mysqli_errno($this->getCONEXION()).":".mysqli_error($this->getCONEXION()));
        }
        return $verificacion;
    }
}
?>
<?php
/**************************************/
/********** INCLUIMOS CLASES **********/
/**************************************/

include "Viaje.php";
include "Pasajero.php";
include "ResponsableV.php";
include "Empresa.php";
include "BaseDatos.php";

/**************************************/
/************** MODULOS ***************/
/**************************************/

/**
 * Muestra el menu para que el usuario elija y retorna la opcion
 * @return int 
 */
function menu(){
    echo "\n"."MENU DE OPCIONES"."\n";
    echo "1) Saber la cantidad de pasajeros."."\n";
    echo "2) Ver los datos del viaje."."\n";
    echo "3) Ver los datos de los pasajeros."."\n";
    echo "4) Modificar los datos de un pasajero."."\n";
    echo "5) Agregar pasajeros al viaje."."\n";
    echo "6) Eliminar un pasajero del viaje."."\n";
    echo "7) Modificar responsable viaje"."\n";
    echo "8) Ver datos de un pasajero"."\n";
    echo "9) Cambiar datos del viaje."."\n";
    echo "0) Volver"."\n";
    echo "Opcion: ";
    $menu = trim(fgets(STDIN));
    echo "\n";
    return $menu;
}

/**
 * Muestra el menu de inicio para que el usuario elija y retorna la opcion
 * @return int 
 */
function menuInicio(){
    echo "\n"."MENU DE OPCIONES"."\n";
    echo "ingrese que desea hacer: "."\n".
    "0. Salir"."\n".
    "1. Cargar un nuevo Viaje"."\n".
    "2. Cargar una nueva Empresa"."\n".
    "3. Cargar un nuevo Responsable"."\n".
    "4. Ver todos los viajes."."\n".
    "5. Modificar un viaje"."\n".
    "6. Elimina un viaje"."\n";
    echo "Opcion: ";
    $menu = trim(fgets(STDIN));
    echo "\n";
    return $menu;
}

/**
 * Este modulo crea en la BD viajes
 * @param int $cant
 * @return array
 */
function creaViajes($cant){
    for($i = 0; $i < $cant;$i++){
        $objEmpresa = pedirEmpresa();
        $objResponsable = pedirResponsable();
        echo "Ingrese la empresa del viaje: "."\n";
        echo "Ingrese el destino del viaje ".($i+1)." : ";
        $destViaje = trim(fgets(STDIN));
        echo "Ingrese la cantidad de personas maximas que pueden realizar el viaje ".($i+1)." : ";
        $cantMax = trim(fgets(STDIN));
        $cantMax = verificadorInt($cantMax);
        echo "Ingrese si el viaje ".($i+1)." es de \n 1- ida \n 2- ida y vuelta : "."\n";
        $idaVuelta = trim(fgets(STDIN));
        $idaVuelta = verificarIdaVuelta($idaVuelta);
        echo "Ingrese el importe del viaje ".($i+1)." : ";
        $importe = trim(fgets(STDIN));
        $importe = verificadorInt($importe);
        echo "Ingrese el tipo de asiento del viaje ".($i)." \n 0- para asiento de primera clase \n 1- para asiento estandar: "."\n";
        $tipoAsiento = trim(fgets(STDIN));
        $tipoAsiento = verificarTipoAsiento($tipoAsiento);
        $objViaje = new Viaje();
        $objViaje->cargar(null, $destViaje, $cantMax, $objEmpresa, $objResponsable, $importe, $tipoAsiento, $idaVuelta);
        $resp = $objViaje->insertar();
        if($resp){
            separador();
            echo "El viaje se ha creado correctamente!"."\n";
            separador();
        }else{
            separador();
            echo "No se pudo insertar el viaje a la Base de Datos por el siguiente error: "."\n".$resp;
            separador();
        }
    }
}

function pedirEmpresa(){
    $objEmpresa = new Empresa();
    $arrayObjEmpresa = $objEmpresa->listar("");
    $stringEmpresa = "==============="."\n";
    foreach($arrayObjEmpresa as $objEmpresa){
        $stringEmpresa .= $objEmpresa."==============="."\n";
    }
    echo "Ingrese el codigo de alguna de las siguientes empresas, en caso de no estar, ingrese 0 para cargar una: "."\n".$stringEmpresa;
    $empresaElegida = trim(fgets(STDIN));
    if($empresaElegida == 0){
        crearEmpresa();
        echo "Ingrese el codigo de alguna de las siguientes empresas"."\n".$stringEmpresa;
        $empresaElegida = trim(fgets(STDIN));
    }
    $resp = $objEmpresa->buscar($empresaElegida);
    while(!$resp){
        echo "El codigo de la empresa no existe, porfavor ingrese alguna de las siguientes opciones: "."\n".$stringEmpresa;
        $empresaElegida = trim(fgets(STDIN));
        $resp = $objEmpresa->buscar($empresaElegida);
    }
    return $objEmpresa;
}

function pedirResponsable(){
    $objResponsable = new ResponsableV();
    $arrayObjResponsable = $objResponsable->listar("");
    $stringResponsable = "==============="."\n";
    foreach($arrayObjResponsable as $objResponsable){
        $stringResponsable .= $objResponsable."==============="."\n";
    }
    echo "Ingrese el numero de empleado de alguna de los siguientes resposnables, en caso de no estar, ingrese 0 para cargar uno: "."\n".$stringResponsable;
    $responsableElegido = trim(fgets(STDIN));
    if($responsableElegido == 0){
        crearResponsable();
        echo "Ingrese el numero de empleado de alguna de los siguientes resposnables"."\n".$stringResponsable;
        $responsableElegido = trim(fgets(STDIN));
    }
    $resp = $objResponsable->buscar($responsableElegido);
    while(!$resp){
        echo "El numero de empleado no existe, porfavor ingrese uno de los siguientes responsables: "."\n".$stringResponsable;
        $responsableElegido = trim(fgets(STDIN));
        $resp = $objResponsable->buscar($responsableElegido);
    }
    return $objResponsable;
}

/**
 * Busca el index del viaje con el que va a realizar las operaciones
 * @param array $viajes
 * @return object
 */
function viajeModificar()
{
    separador();
    $objViaje = new viaje();
    echo "los viajes son: "."\n";
    echo stringObjViajes();
    echo "Ingrese el codigo del viaje con el que desea interactuar: ";
    $codigo = trim(fgets(STDIN));
    $codigo = verificadorInt($codigo);
    $resp = $objViaje->buscar($codigo);
    while(!$resp){
        echo "El codigo ingresado no existe o esta mal ingresado, Ingreselo nuevamente: "."\n";
        echo stringObjViajes();
        $codigo = trim(fgets(STDIN));
        $codigo = verificadorInt($codigo);
        $resp = $objViaje->buscar($codigo);
    }
    separador();
    return $objViaje;
}

/**
 * Verifica que tipo de asiento es y devuelve una cadena de caracteres correspondiente
 * @param object $objViaje
 * @return string
 */
function tipoAsientoViaje($objViaje){
    if($objViaje->getTipoAsiento() == 1){
        $stringClase = "de primera clase";
    }else{
        $stringClase = "tipo estandar";
    }
    return $stringClase;
}

/**
 * Verifica que tipo de vuelo es y devuelve una cadena de caracteres correspondiente
 * @param object $objViaje
 * @return string
 */
function tipoVuelo($objViaje){
    if($objViaje->getIdaVuelta() == "si"){
        $stringTipo = "ida y vuelta";
    }else{
        $stringTipo = "ida";
    }
    return $stringTipo;
}

/**
 * Devuelve una cadena de caracteres para ver los datos del viaje por pantalla
 * @param array $arrayViajes
 * @return string
 */
function stringObjViajes(){
    $stringViajes = null;
    $objViaje = new Viaje();
    $arrayObjViaje = $objViaje->listar("");
    if($arrayObjViaje > 0){
        foreach($arrayObjViaje as $viaje){
            $stringTipoAsiento = tipoAsientoViaje($viaje);
            $tipoVuelo = tipoVuelo($viaje);
            $stringViajes.= "Codigo: ".$viaje->getIdViaje()." - viaje ".$stringTipoAsiento." de tipo ".$tipoVuelo." con destino a ".$viaje->getVDestino()."\n";
        }
    }
    return $stringViajes;
}

/**
 * Crea un pasajero en la BD
 */
function crearEmpresa(){
    echo "ingrese el nombre de la empresa: ";
    $nombreEmpresa = trim(fgets(STDIN));
    echo "ingrese la direccion de la empresa: ";
    $direccionEmpresa = trim(fgets(STDIN));
    echo "\n";
    $objEmpresa = new Empresa();
    $objEmpresa->cargar(null, $nombreEmpresa, $direccionEmpresa);
    $resp = $objEmpresa->insertar();
    if($resp){
        separador();
        echo "La empresa se inserto a la Base de Datos correctamente!"."\n";
        $objEmpresa->buscar(count($objEmpresa->listar("")));
        separador();
    }else{
        separador();
        echo "No se pudo insertar la empresa a la Base de Datos por el siguiente error: "."\n".$resp;
        $objEmpresa = null;
        separador();
    }
}

/**
 * Crea el responsable y devuelve el objeto
 * @return object
 */
function crearResponsable(){
    separador();
    echo "ingrese el nombre del responsable: ";
    $nombreResp =  trim(fgets(STDIN));
    echo "ingrese el apellido del responsable: ";
    $apellidoResp =  trim(fgets(STDIN));
    echo "ingrese el numero de licencia del responsable: ";
    $numLincenciaResp =  trim(fgets(STDIN));
    separador();
    echo "\n";
    $objResponsable = new ResponsableV();
    $objResponsable->cargar($nombreResp,$apellidoResp,$numLincenciaResp,null);
    $resp = $objResponsable->insertar();
    if($resp){
        separador();
        echo "El responsable se inserto a la Base de Datos correctamente!"."\n";
        $objResponsable->buscar(count($objResponsable->listar("")));
        separador();
    }else{
        separador();
        echo "No se pudo insertar el responsable a la Base de Datos por el siguiente error: "."\n".$resp."\n";
        $objResponsable = null;
        separador();
    }
}

/**
 * Crea un pasajero en la BD
 */
function crearPasajero($objViaje){
    echo "ingrese el nombre del pasajero: ";
    $nombrePasajero =  trim(fgets(STDIN));
    echo "ingrese el apellido del pasajero: ";
    $apellidoPasajero =  trim(fgets(STDIN));
    echo "ingrese el DNI del pasajero: ";
    $dniPasajero =  trim(fgets(STDIN));
    echo "ingrese el telefono del pasajero: ";
    $telefonoPasajero =  trim(fgets(STDIN));
    echo "\n";
    $objPasajero = new Pasajero();
    $objPasajero->cargar($nombrePasajero,$apellidoPasajero,$dniPasajero,$telefonoPasajero,$objViaje);
    $resp = $objPasajero->insertar();
    if($resp){
        separador();
        echo "El pasajero se inserto a la Base de Datos correctamente!"."\n";
        separador();
    }else{
        separador();
        echo "No se pudo insertar el pasajero a la Base de Datos por el siguiente error: "."\n".$resp;
        separador();
    }
}

/**
 * Muestra por pantalla todos los viajes disponibles;
 * @param array $viajes
 */
function mostrarViajes(){
    $objViaje = new Viaje();
    $arrayObjViaje = $objViaje->listar("");
    echo "Los viajes creados son: "."\n";
    foreach($arrayObjViaje as $viaje){
        separador();
        echo $viaje."\n";
        separador();
    }
}

/**
 * Devuelve por pantalla un string que separa los puntos
 */
function separador(){
    echo "========================================================"."\n";
}

/**
 * Verifica que el valor ingreasado sea un entero, en caso contario lo vuelve a pedir hasta que sea un entero
 * @param int $dato
 * @return int
 */
function verificadorInt($dato){
    while(is_numeric($dato) == false){
        echo "El valor ".$dato." no es correcto, Por favor ingrese numeros: ";
        $dato = trim(fgets(STDIN));
    }
    return $dato;
}
/**
 * Verifica que el valor ingreasado sea un entero, en caso contario lo vuelve a pedir hasta que sea un entero
 * @param int $dato
 * @return int
 */
function verificarTipoAsiento($dato){
    $dato = verificadorInt($dato);
    while(($dato < 0) || ($dato > 1)){
        echo "Los valores permitidos son 0 y 1, porfavor ingrese uno de estos valores \n 0- para asiento de primera clase \n 1- para asiento estandar: "."\n";
        $dato = trim(fgets(STDIN));
    }
    return $dato;
}

/**
 * Verifica que el valor ingreasado sea un entero, en caso contario lo vuelve a pedir hasta que sea un entero
 * @param int $dato
 * @return string
 */
function verificarIdaVuelta($dato){
    $dato = verificadorInt($dato);
    while(($dato < 1) || ($dato > 2)){
        echo "Los valores permitidos son 1 y 2, porfavor ingrese uno de estos valores \n 1- ida \n 2- ida y vuelta: "."\n";
        $dato = trim(fgets(STDIN));
    }
    $dato = ($dato == 1) ? "no" : "si";
    return $dato;
}

/**
 * Este modulo cambia datos del array Pasajeros
 * @param object $viaje
 */
function cambiarDatoPasajero($objPasajero){
    do{
        echo "Ingrese que dato desea cambiar: "."\n".
             "1. Modificar Nombre "."\n".
             "2. Modificar Apellido "."\n".
             "3. Modificar Telefono "."\n".
             "4. Ver datos "."\n".
             "5. Salir "."\n";
        $seleccion = trim(fgets(STDIN));
        switch ($seleccion){
            case 1: 
                separador();
                echo "Ingrese el nuevo nombre: "; 
                $nuevoNombre = trim(fgets(STDIN));
                $objPasajero->setNombre($nuevoNombre);
                $resp = $objPasajero->modificar();
                if($resp == true){
                    echo "El nombre se ha cambiado correctamente!"."\n";
                }else{
                    echo "El nombre no se pudo modificar por el siguiente error: ".$resp;
                }
                separador();
                break;

            case 2: 
                separador();
                echo "Ingrese el nuevo apellido: "; 
                $nuevoApellido = trim(fgets(STDIN));
                $objPasajero->setApellido($nuevoApellido);
                $resp = $objPasajero->modificar();
                if($resp == true){
                    echo "El apellido se ha cambiado correctamente!"."\n";
                }else{
                    echo "El apellido no se pudo modificar por el siguiente error: ".$resp;
                }
                separador();
                break;

            case 3: 
                separador();
                echo "Ingrese el nuevo Telefono: "; 
                $nuevoTelefono = trim(fgets(STDIN));
                $objPasajero->setTelefono($nuevoTelefono);
                $resp = $objPasajero->modificar();
                if($resp == true){
                    echo "El telefono se ha cambiado correctamente!"."\n";
                }else{
                    echo "El telefono no se pudo modificar por el siguiente error: ".$resp;
                }
                separador();
                break;

            case 4: 
                separador();
                echo $objPasajero;
                separador();
            break;

            case 5: 
                break;
            break;

            default:
            echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 5"."\n"."\n";
            break;
                
        }
        }while($seleccion != 5);
}

/**
 * Este modulo cambia los datos del responsable del vuelo
 * @param object $viaje
 */
function cambiarDatoResponsable($objResponsable){
    do{
        echo "Ingrese que dato desea cambiar: "."\n".
             "1. Modificar Nombre "."\n".
             "2. Modificar Apellido "."\n".
             "3. Modificar Numero de Licencia "."\n".
             "4. Ver datos "."\n".
             "5. Salir "."\n";
        $seleccion = trim(fgets(STDIN));
        switch ($seleccion){
            case 1: 
                separador();
                echo "Ingrese el nuevo nombre: "; 
                $nuevoNombre = trim(fgets(STDIN));
                $objResponsable->setNombre($nuevoNombre);
                $resp = $objResponsable->modificar();
                if($resp == true){
                    echo "El telefono se ha cambiado correctamente!"."\n";
                }else{
                    echo "El telefono no se pudo modificar por el siguiente error: ".$resp;
                }
                separador();
                break;

            case 2: 
                separador();
                echo "Ingrese el nuevo apellido: "; 
                $nuevoApellido = trim(fgets(STDIN));
                $objResponsable->setApellido($nuevoApellido);
                $resp = $objResponsable->modificar();
                if($resp == true){
                    echo "El telefono se ha cambiado correctamente!"."\n";
                }else{
                    echo "El telefono no se pudo modificar por el siguiente error: ".$resp;
                }
                separador();
                break;

            case 3: 
                separador();
                echo "Ingrese el nuevo numero de licencia: "; 
                $nuevoNumLicencia = trim(fgets(STDIN));
                $objResponsable->setNumLicencia($nuevoNumLicencia);
                $resp = $objResponsable->modificar();
                if($resp == true){
                    echo "El telefono se ha cambiado correctamente!"."\n";
                }else{
                    echo "El telefono no se pudo modificar por el siguiente error: ".$resp;
                }
                separador();
                break;

            case 4: 
                separador();
                echo $objResponsable;
                separador();
            break;

            case 5: 
                break;
            break;

            default:
            echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 5"."\n"."\n";
            break;
                
        }
        }while($seleccion != 5);
}

/**
 * Este modulo cambia los datos del viaje
 * @param object $viaje
 */
function cambiarDatosViaje($objViaje){
    do{
        echo "Ingrese que dato desea cambiar: "."\n".
             "1. Modificar destino "."\n".
             "2. Modificar cantidad maxima de pasajeros "."\n".
             "3. Modificar importe del viaje "."\n".
             "4. Modificar el tipo de asiento del viaje "."\n".
             "5. Modificar si es de ida o vuelta "."\n".
             "6. Ver datos "."\n".
             "7. Salir "."\n";
        $seleccion = trim(fgets(STDIN));
        switch ($seleccion){
            case 1: 
                separador();
                echo "ingrese el nuevo destino: ";
                $nuevoDestino = trim(fgets(STDIN));
                $objViaje->setVDestino($nuevoDestino);
                $resp = $objViaje->modificar();
                if($resp){
                    echo "El destino se ha cambiado correctamente!"."\n";
                }else{
                    echo "El destino no se ha podido cambiar por el siguiente error: ".$resp."\n";
                }
                separador();
                break;

            case 2: 
                separador();
                echo "ingrese la nueva capacidad del viaje: ";
                $nuevaCapacidad = trim(fgets(STDIN));
                $nuevaCapacidad = verificadorInt($nuevaCapacidad);
                $objViaje->setVCantidadMax($nuevaCapacidad);
                $resp = $objViaje->modificar();
                if($resp){
                    echo "La capacidad se ha cambiado correctamente!"."\n";
                }else{
                    echo "La capacidad maxima no se ha podido cambiar por el siguiente error: ".$resp."\n";
                }
                separador();
                break;

            case 3: 
                separador();
                echo "ingrese el nuevo importe del viaje: ";
                $nuevoImporte = trim(fgets(STDIN));
                $nuevoImporte = verificadorInt($nuevoImporte);
                $objViaje->setVImporte($nuevoImporte);
                $resp = $objViaje->modificar();
                if($resp){
                    echo "La capacidad se ha cambiado correctamente!"."\n";
                }else{
                    echo "La capacidad maxima no se ha podido cambiar por el siguiente error: ".$resp."\n";
                }
                separador();
                break;

            case 4: 
                separador();
                echo "Ingrese el nuevo tipo de asiento del viaje \n 0- para asiento de primera clase \n 1- para asiento estandar: ";
                $nuevoTipAsiento = trim(fgets(STDIN));
                $nuevoTipAsiento = verificarTipoAsiento($nuevoTipAsiento);
                $objViaje->setTipoAsiento($nuevoTipAsiento);
                $resp = $objViaje->modificar();
                if($resp){
                    echo "La capacidad se ha cambiado correctamente!"."\n";
                }else{
                    echo "La capacidad maxima no se ha podido cambiar por el siguiente error: ".$resp."\n";
                }
                separador();
            break;

            case 5: 
                separador();
                echo "Ingrese el nuevo tipo de viaje \n 1- ida \n 2- ida y vuelta : ";
                $nuevoTipViaje = trim(fgets(STDIN));
                $nuevoTipViaje = verificarIdaVuelta($nuevoTipViaje);
                $objViaje->setIdaVuelta($nuevoTipViaje);
                $resp = $objViaje->modificar();
                if($resp){
                    echo "La capacidad se ha cambiado correctamente!"."\n";
                }else{
                    echo "La capacidad maxima no se ha podido cambiar por el siguiente error: ".$resp."\n";
                }
                separador();
            break;

            case 6: 
                separador();
                echo $objViaje;
                separador();
            break;

            case 7: 
                break;
            break;

            default:
            echo "El número que ingresó no es válido, por favor ingrese un número del 1 al 5"."\n"."\n";
            break;
                
        }
        }while($seleccion != 7);
}

function opcionesViaje(){
    $objViaje = viajeModificar();
    $opcion = menu();
    do {
    switch ($opcion) {

        // Vuelve al menu inicial
        case 0: 
            break;
        break;
        
        // Saber la cantidad de pasajeros
        case 1: 
            separador();
            $objViaje->obtenerPasajeros();
            echo "la cantidad de pasajeros del viaje ".$objViaje->getVDestino()." es: ".count($objViaje->getArrayObjPasajero())."\n";
            separador();
        break;
    
        // Ver los datos del viaje
        case 2: 
            separador();
            echo "Los datos del viaje son: "."\n".$objViaje."\n";
            separador();
        break;

        // Ver los datos de los pasajeros
        case 3: 
            separador();
            $objViaje->obtenerPasajeros();
            $arrayObjPasajeros = $objViaje->getArrayObjPasajero();
            if(count($arrayObjPasajeros) > 0){
                echo "Las personas del viaje ".$objViaje->getVDestino()." son: "."\n";
                foreach($arrayObjPasajeros as $objPasajero){
                    separador();
                    echo $objPasajero;
                    separador();
                }
            }else{
                separador();
                echo "No hay pasajeros en este viaje todavia!"."\n";
                separador();
            }
        break;

        // Modificar los datos de un pasajero
        case 4: 
            separador();
            echo "Ingrese el DNI de que pasajero desea cambiar el dato: ";
            $dni = trim(fgets(STDIN));
            $objPasajero = new Pasajero();
            $resp = $objPasajero->buscar($dni);
            if($resp){
                cambiarDatoPasajero($objPasajero);
                echo "Los datos se han cambiado correctamente!"."\n";
            }else{
                echo "El DNI del pasajero ingresado no existe!"."\n";
            }
            separador();
        break;
            
        // Agregar un pasajeros al viaje
        case 5: 
            separador();
            $superaCapacidad = $objViaje->hayPasajesDisponible();
            if($superaCapacidad){
                echo "Ingrese cuantos pasajeros nuevos ingresaran al viaje: ";
                $cantPasajerosNuevos = trim(fgets(STDIN));
                $cantPasajerosNuevos = verificadorInt($cantPasajerosNuevos);
                $cantidadAumentada = count($objViaje->getArrayObjPasajero()) + $cantPasajerosNuevos;
                if($cantidadAumentada <= $objViaje->getVCantidadMax()){
                    for($i = 0;$i < $cantPasajerosNuevos;$i++){
                        crearPasajero($objViaje);
                    }                
                    echo "Los pasajeros se agregaron correctamente al viaje!"."\n";
                }else{
                    echo "La cantidad de pasajeros es superior a la capacidad maxima!"."\n";
                }
            }else{
                echo "El vuelo ya esta lleno!"."\n";
            }
            separador();
        break;
            
        // Eliminar un pasajero del viaje
        case 6: 
            separador();
            echo "ingrese el DNI del pasajero que desea eliminar: ";
            $dni = trim(fgets(STDIN));
            $objPasajero = new Pasajero();
            $resp = $objPasajero->buscar($dni);
            if($resp){
                $resp = $objPasajero->eliminar($dni);
                if($resp){
                    echo "El pasajero se elimino correctamente!"."\n";
                }else{
                    echo "No se pudo elimiar el pasajero por el siguiente error: ".$resp;
                }
            }else{
                echo "El DNI del pasajero ingresado no existe!"."\n";
            }
            separador();
        break;
            
        // Modificar responsable viaje
        case 7: 
            separador();
            cambiarDatoResponsable($objViaje->getObjResponsable());
            separador();
        break;
    
        // Ver datos de un pasajero
        case 8: 
            separador();
            echo "ingrese el DNI del pasajero que desea buscar: ";
            $dni = trim(fgets(STDIN));
            $objPasajero = new Pasajero();
            $resp = $objPasajero->buscar($dni);
            if($resp){
                echo "Los datos datos del pasajero ".$dni." son:"."\n";
                echo $objPasajero;
            }else{
                echo "El pasajero ingresado no existe!"."\n";
            }
            separador();
        break;
    
        // Cambiar datos del viaje
        case 9: 
            cambiarDatosViaje($objViaje);
        break;
    
        default: 
            echo "El número que ingresó no es válido, por favor ingrese un número del 0 al 9"."\n"."\n";
            break;
        }
        $opcion = menu();
    } while ($opcion != 0);
}

/**************************************/
/********* PROGRAMA PRINCIPAL *********/
/**************************************/

//Este programa ejecuta segun la opcion elegida del usuario la secuencia de pasos a seguir
do{
    $objViaje = new Viaje();
    $dimensionViaje = count($objViaje->listar(""));
    if($dimensionViaje > 0){
        $seleccion = menuInicio();
        switch($seleccion){
            
            // Salir del programa
            case 0:
                exit();
            break;

            // Cargar un viaje
            case 1:
                separador();
                echo "Ingrese la cantidad de viajes que desea agregar: ";
                $cant = trim(fgets(STDIN));
                $cant = verificadorInt($cant);
                creaViajes($cant);
            break;
    
            // Cargar una empresa
            case 2:
                crearEmpresa();
            break;

            // Cargar una responsable
            case 3:
                crearResponsable();
            break;

            // Mostrar todos los viajes
            case 4:
                separador();
                mostrarViajes();
                separador();
            break;
    
            // Modificar un viaje
            case 5:
                opcionesViaje();
            break;
            
            // Elimina un viaje
            case 6:
                separador();
                echo "Los viajes son: "."\n".stringObjViajes();
                echo "Ingrese el codigo del viaje que desea eliminar: ";
                $objViaje = new Viaje();
                $codigo = trim(fgets(STDIN));
                $codigo = verificadorInt($codigo);
                $resp = $objViaje->buscar($codigo);
                while(!$resp){
                    echo "El codigo ingresado no existe, porfavor ingrese uno de los viajes mostrados"."\n".stringObjViajes();
                    $codigo = trim(fgets(STDIN));
                    $resp = $objViaje->buscar($codigo);
                }
                $objViaje->obtenerPasajeros();
                if(count($objViaje->getArrayObjPasajero()) == 0){
                    $resp = $objViaje->eliminar();
                    if($resp){
                        echo "El viaje fue eliminado correctamente!"."\n";
                    }else{
                        echo "el codigo ingresado no coicide con ningun viaje!"."\n";
                    }
                }else{
                    echo "No se puede eliminar el viaje, ya que contiene pasajeros!"."\n";
                }
                separador();
            break;
    
            default : 
            echo "El número que ingresó no es válido, por favor ingrese un número del 0 al 6"."\n"."\n";
            break;
        }
    }else{
        do{
        separador();
        echo "No hay viajes ingresados todavia! ingrese alguna de las siguentes opciones"."\n".
             "0- Salir"."\n".
             "1- Cargar una empresa"."\n".
             "2- Cargar un responsable"."\n".
             "3- Cargar un viaje"."\n";
        $opcion = trim(fgets(STDIN));
            switch($opcion){
                
                // Salir del programa
                case 0:
                    exit();
                break;

                // Cargar una empresa
                case 1:
                    crearEmpresa();
                break;
        
                // Cargar un responsable
                case 2:
                    crearResponsable();
                break;
        
                // Cargar un viaje
                case 3:
                    separador();
                    echo "Ingrese la cantidad de viajes que desea agregar: ";
                    $cant = trim(fgets(STDIN));
                    $cant = verificadorInt($cant);
                    creaViajes($cant);
                break;
        
                default : 
                echo "El número que ingresó no es válido, por favor ingrese un número del 0 al 3"."\n"."\n";
                break;
            }
        $dimensionViaje = count($objViaje->listar(""));
        }while(($opcion != 0) && ($dimensionViaje == 0));
    }
}while($seleccion != 0);

?>
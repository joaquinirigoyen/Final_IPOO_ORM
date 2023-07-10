<?php
include_once 'viaje.php';
include_once 'pasajero.php';
include_once 'responsableV.php';
include_once 'empresa.php';
include_once 'baseDeDatos.php';

/**
 * Menu de opciones de usuario
 * 
 * @return int
 */
function MenuPrincipal(){
    echo "====================\n";
    echo "MENU PRINCIPAL\n";
    echo "elija una opción:\n";
    echo "1-Empresa\n";
    echo "2-Viaje\n";
    echo "3-Pasajero\n";
    echo "4-Responsable\n";
    echo "====================\n";

    $opcion = trim(fgets(STDIN));
    return $opcion;
}

function mostrar($array){
    $cadena = "";
    if (count($array) == 0){
        $cadena = "El arreglo no tiene elementos"."\n";
    }else{
        for ($i=0; $i < count($array) ; $i++) { 
            $cadena = $cadena . $array [$i] ."\n";
        }
    }

    return $cadena;
}
/**
 * permitir crear pasajero, viaje, empresa y responsable
 * para modificar a cada objeto : modificar todo de una pasada. en caso de '' no setear nada en caso de !''
 * elejir que modificar en el menu. submenu: 4...crear,modificar,eliminar y volver al menu principal. opcion 0 finalizar programa
 * poder elegir sobre que empresa trabajar
 * 
 * primero creo la empresa,responsable, luego viaje y por ultimo los pasajeros para esos viajes
 * 
 * mostrar: por cada obj un mostrar....pedir id getid, crear nuevo objeto y buscar. si el objeto != "" (existe) mostrar con echo y sino poner no existe
 */

do {
    $opcion = MenuPrincipal();

    /********************EMPRESA*******************************/
    if ($opcion == 1){
        echo "====================\n";
        echo "EMPRESA\n";
        echo "Que desea realizar?:\n";
        echo "1-crear una empresa\n";
        echo "2-modificar una empresa\n";
        echo "3-eliminar una empresa\n";
        echo "4-Mostrar\n";
        echo "5-volver al menu principal\n";
        echo "====================\n";
        $opcionE = trim(fgets(STDIN));
        
        if($opcionE == 1){
            $objEmpresa = new Empresa;
            echo "ingresar el nombre de la empresa: \n";
            $nomE = trim(fgets(STDIN));
            echo "ingresar la direccion de la empresa: \n";
            $direc = trim(fgets(STDIN));

            $objEmpresa->cargar("",$nomE,$direc,[]);
            $respuesta = $objEmpresa->insertar();

            // Inserto el OBj pasajero en la base de datos
            if ($respuesta==true) {
                echo "\nOP INSERCION;  La empresa fue ingresada en la BD \n";
                
                echo mostrar($objEmpresa->listar());
            }else{ 
                echo $objPasajero->getmensajeoperacion();

            }
        }
        if ($opcionE == 2){
            $objEmpresa = new Empresa;
            echo mostrar($objEmpresa->listar());
            echo "ingresar el id de la empresa que desea modificar: \n";
            $id = trim(fgets(STDIN));
            $respuesta = $objEmpresa->Buscar($id);
            if ($respuesta){
                echo "ingresar el nuevo nombre de la empresa: \n";
                $nom = trim(fgets(STDIN));
                echo "ingresar la nueva direccion de la empresa: \n";
                $direc = trim(fgets(STDIN));
            
                $objEmpresa->setNombre($nom);
                $objEmpresa->setDireccion($direc);

                $respuesta = $objEmpresa->modificar();
                if ($respuesta==true) {
                    echo " \nOP MODIFICACION: Los datos fueron actualizados correctamente \n";
                    echo mostrar($objEmpresa->listar());
                }else {
                    echo $objEmpresa->getmensajeoperacion();
                }
            }else{
                echo "No existe empresa con ese id \n";
                echo mostrar($objEmpresa->listar());
            }
        }

        if ($opcionE == 3){
            $objEmpresa = new Empresa();
            echo "ingrese el id de la empresa que desea eliminar: \n";
            echo  mostrar($objEmpresa->listar());
            $id = trim(fgets(STDIN));

            $empresa = $objEmpresa->Buscar($id);
            if ($empresa){
                echo "****ATENCION**** \n";
                echo "si elimina la empresa en caso de tener viajes asociados se eliminaran tambien. Desea continuar? \n";
                $respuesta = trim(fgets(STDIN));
                if ($respuesta == 'si'){
                    $objEmpresa->eliminarEmpresa();
                    echo "empresa eliminada con exito \n";
                    echo mostrar($objEmpresa->listar());
                }
            }else{
                echo "no existe empresa con ese id";
            }
        }

        if ($opcionE == 4){
            $objEmpresa = new Empresa;
            echo mostrar($objEmpresa->listar());
        }

        if ($opcionE == 5){
           
           $opcion= MenuPrincipal();
           
        }

    }
    /*******************VIAJE*********************************/
    if ($opcion == 2){
        echo "====================\n";
        echo "Viajes\n";
        echo "Que desea realizar?:\n";
        echo "1-crear un viaje\n";
        echo "2-modificar un viaje\n";
        echo "3-eliminar un viaje\n";
        echo "4-Mostrar\n";
        echo "5-volver al menu principal\n";
        echo "====================\n";
        $opcionV = trim(fgets(STDIN));

        if ($opcionV == 1){
            $objViaje = new Viaje();
            $objEmpresa = new Empresa();
            $objResponsable = new ResponsableV();

            echo "ingresar el destino del viaje: \n";
            $destino = trim(fgets(STDIN));
            echo "ingresar la cantidad maxima de pasajeros del viaje: \n";
            $maxP = trim(fgets(STDIN));
            echo "ingresar el responsable del viaje: \n";
            echo mostrar($objResponsable->listar());
            $idResponsable = trim(fgets(STDIN));
            if (!$objResponsable->Buscar($idResponsable)){
                echo "el numero de responsable ingresado no existe";
            }else{
                echo "ingresar el importe del viaje: \n";
                $importe = trim(fgets(STDIN));
                echo "ingresar el id de la empresa que le va asignar al viaje: \n";
                echo mostrar($objEmpresa->listar());
                $idEmpresa = trim(fgets(STDIN));
                if (!$objEmpresa->Buscar($idEmpresa)){
                    echo "el id ingresado no existe";
                }else {
                    $objViaje->cargar("",$maxP,$destino,[],$objResponsable,$importe,$objEmpresa);
                    $respuesta = $objViaje->insertar();
                    if ($respuesta==true) {
                        echo "\nOP INSERCION;  El Viaje fue ingresado en la BD \n";
                        echo mostrar($objViaje->listar());
                    }else { 
                        echo $objPasajero->getmensajeoperacion();
        
                    }

                }

            }
        }
        if ($opcionV == 2){
            $objViaje = new Viaje();
            echo "ingresar el id del viaje que desea modificar: \n";
            echo mostrar($objViaje->listar());
            $idViaje = trim(fgets(STDIN));
            $respuesta = $objViaje->Buscar($idViaje);
            if ($respuesta){
                echo "ingresar el nuevo destino del viaje: \n";
                $destino = trim(fgets(STDIN));
                $objViaje->setDestino($destino);

                echo "ingresar la nueva cantidad maxima de pasajeros: \n";
                $maxP = trim(fgets(STDIN));
                $objViaje->setMaxPasajeros($maxP);

                echo "ingresar el nuevo responsable del viaje: \n";
                $objResponsable = new ResponsableV();
                echo mostrar($objResponsable->listar());
                $idResponsable = trim(fgets(STDIN));
                $objResponsable->Buscar($idResponsable);
                $objViaje->setResponsable($objResponsable);

                echo "ingresar la nueva empresa que le va asignar al viaje: \n";
                $objEmpresa = new Empresa();
                echo mostrar($objEmpresa->listar());
                $idEmpresa = trim(fgets(STDIN));
                $objEmpresa->Buscar($idEmpresa);
                $objViaje->setObjEmpresa($objEmpresa);

                echo "ingrese el nuevo costo del viaje";
                $costo = trim(fgets(STDIN));
                $objViaje->setPrecio($costo);

                $respuesta = $objViaje->modificar();

                if ($respuesta) {
                    echo " \nOP MODIFICACION: Los datos fueron actualizados correctamente \n";
                    echo mostrar($objViaje->listar());
                }else {
                    echo $objViaje->getmensajeoperacion();
                }
            }else{
                echo "No existe ese viaje";
            }

        }
        if($opcionV == 3){
            $objViaje = new Viaje();
            echo "ingrese el id del viaje que desea eliminar: \n";
            echo  mostrar($objViaje->listar());
            $id = trim(fgets(STDIN));

            $viaje = $objViaje->Buscar($id);
            if ($viaje){
                echo "****ATENCION**** \n";
                echo "si elimina el viaje en caso de tener pasajeros guardados se eliminaran tambien. Desea continuar? \n";
                $respuesta = trim(fgets(STDIN));
                if ($respuesta == 'si'){
                    $objViaje->eliminarViaje();
                    echo "viaje eliminado con exito  \n";
                }
            }else{
                echo "no existe viaje con ese id  \n";
            }


        }
        if ($opcionV == 4){
            $objViaje = new Viaje();
            echo mostrar($objViaje->listar());
        }  
        if ($opcionV == 5){
            $opcion= MenuPrincipal();
        }
    }
    /*******************PASAJERO******************************/
    if ($opcion == 3){
        echo "====================\n";
        echo "PASAJERO\n";
        echo "Que desea realizar?:\n";
        echo "1-Ingresar un pasajero\n";
        echo "2-modificar un pasajero\n";
        echo "3-eliminar un pasajero\n";
        echo "4-Mostrar pasajeros\n";
        echo "5-volver al menu principal\n";
        echo "====================\n";
        $opcionP = trim(fgets(STDIN));
        if ($opcionP == 1){
            
            echo "ingresar el nombre del pasajero: \n";
            $nom = trim(fgets(STDIN));
            echo "ingresar el apellido del pasajero: \n";
            $ape = trim(fgets(STDIN));
            echo "ingresar el documento del pasajero: \n";
            $doc = trim(fgets(STDIN));
            echo "ingresar el telefono del pasajero: \n";
            $tel = trim(fgets(STDIN));
            echo "ingresar a que viaje quiere asignar el pasajero: \n";
            $objViaje = new Viaje();
            echo mostrar($objViaje->listar()) ."\n";
            $idV = trim(fgets(STDIN));

            $objPasajero = new Pasajero();
            $pasajero = $objPasajero->Buscar($doc);
            if ($pasajero){
                echo "ya hay un pasajero con ese DNI \n";
            }else{
                $objPasajero->cargar($nom,$ape,$doc,$tel,$idV);
                $respuesta = $objPasajero->insertar();
            }
                // Inserto el OBj pasajero en la base de datos
                if ($respuesta==true) {
                    echo "\nOP INSERCION;  El pasajero fue ingresado en la BD \n";
                }else { 
                    echo $objPasajero->getmensajeoperacion();

                }
        }
            
        if ($opcionP == 2){
            $objPasajero = new Pasajero();
            echo "ingresar el dni del pasajero que desea modificar: \n";
            $num_doc = trim(fgets(STDIN));
            $respuesta = $objPasajero->Buscar($num_doc);
            if ($respuesta){
                echo "ingresar el nuevo nombre del pasajero: \n";
                $nom = trim(fgets(STDIN));
                echo "ingresar el nuevo apellido del pasajero: \n";
                $ape = trim(fgets(STDIN));
                echo "ingresar el nuevo telefono del pasajero: \n";
                $tel = trim(fgets(STDIN));
                echo "ingresar el nuevo viaje que le va a asignar al pasajero: \n";
                $objViaje = new Viaje();
                echo mostrar($objViaje->listar());
                $idV = trim(fgets(STDIN));

                $objPasajero->setNombre($nom);
                $objPasajero->setApellido($ape);
                $objPasajero->setTelefono($tel);
                $objPasajero->setIdViaje($idV);

                $respuesta = $objPasajero->modificar();
                if ($respuesta==true) {
                    echo " \nOP MODIFICACION: Los datos fueron actualizados correctamente";
                    echo mostrar($objPasajero->listar());
                    echo mostrar($objViaje->listar());
                }else {
                    echo $obj_Persona->getmensajeoperacion();
                }
            }else{
                echo "No existe pasajero con ese dni";
            }
        }
        if ($opcionP == 3){
            $objPasajero = new Pasajero();
            echo mostrar($objPasajero->listar());
            echo "ingresar el dni del pasajero que desea eliminar: \n";
            $num_doc = trim(fgets(STDIN));
            $respuesta = $objPasajero->Buscar($num_doc);
            if($respuesta){
                $eliminar = $objPasajero->eliminar();
                if($eliminar){
                    echo "pasajero eliminado con exito \n\n";
                    echo mostrar($objPasajero->listar());
                }else{
                    echo $objPasajero->getmensajeoperacion();
                }
            }else{
                echo "no existe pasajero con ese dni \n";
            }
        }

        if ($opcionP == 4){
            $objPasajero = new Pasajero;
            echo mostrar($objPasajero->listar());
        }

        if ($opcionP == 5){
           
            $opcion= MenuPrincipal();
            
        }
    }
    /*******************RESPONSABLE***************************/ 
    if ($opcion == 4){
        echo "====================\n";
        echo "Responsable\n";
        echo "Que desea realizar?:\n";
        echo "1-Agregar un responsable\n";
        echo "2-Modificar un responsable\n";
        echo "3-eliminar un responsable\n";
        echo "4-Mostrar responsables \n";
        echo "5-volver al menu principal\n";
        echo "====================\n";
        $opcionR = trim(fgets(STDIN));

        if ($opcionR == 1){
            $objResponsable = new ResponsableV;
            echo "ingresar el numero de licencia del responsable: \n";
            $numL = trim(fgets(STDIN));
            echo "ingresar el nombre del responsable: \n";
            $nom = trim(fgets(STDIN));
            echo "ingresar el apellido del responsable: \n";
            $ape = trim(fgets(STDIN));

            $objResponsable->cargar("",$numL,$nom,$ape);
            $respuesta = $objResponsable->insertar();

            // Inserto el OBj pasajero en la base de datos
            if ($respuesta==true) {
                echo "\nOP INSERCION;  El responsable fue ingresado en la BD \n";
                echo mostrar($objResponsable->listar());
            }else{ 
                echo $objPasajero->getmensajeoperacion();

            }
        }
        if ($opcionR == 2){
            $objResponsable = new ResponsableV;
            echo mostrar($objResponsable->listar());
            echo "ingresar el numero de empleado del responsable que desea modificar: \n";
            $numL = trim(fgets(STDIN));
            $respuesta = $objResponsable->Buscar($numL);
            if ($respuesta){
                echo "ingresar el nuevo numero de licencia del responsable: \n";
                $numL = trim(fgets(STDIN));
                echo "ingresar el nuevo nombre del responsable: \n";
                $nom = trim(fgets(STDIN));
                echo "ingresar el nuevo apellido del responsable: \n";
                $ape = trim(fgets(STDIN));
            
                $objResponsable->setNumeroLiencia($numL);
                $objResponsable->setNombre($nom);
                $objResponsable->setApellido($ape);

                $respuesta = $objResponsable->modificar();
                if ($respuesta==true) {
                    echo " \nOP MODIFICACION: Los datos fueron actualizados correctamente \n";
                    echo mostrar($objResponsable->listar());
                }else {
                    echo $objResponsable->getmensajeoperacion();
                }
            }else{
                echo "No existe responsable con ese numero de licencia \n";
                echo mostrar($objResponsable->listar());
            }
        }
        if ($opcionR == 3){
            $objResponsable = new ResponsableV;
            echo mostrar($objResponsable->listar());
            echo "ingresar el numero de empleado del responsable que desea eliminar: \n";
            $numE = trim(fgets(STDIN));
            $respuesta = $objResponsable->Buscar($numE);
            if($respuesta){
                $eliminar = $objResponsable->eliminar();
                if($eliminar){
                    echo "empleado eliminado con exito \n\n";
                    echo mostrar($objResponsable->listar());
                }else{
                    echo $objResponsable->getmensajeoperacion();
                }
            }else{
                echo "no existe responsable con ese numero de empleado \n";
            }
        }

        if ($opcionR == 4){
            $objResponsable = new ResponsableV;
            echo mostrar($objResponsable->listar());
        }
        
        if ($opcionR == 5){
            $opcion= MenuPrincipal();
        }
    }

echo "Desea finalizar el programa? \n";
$respuesta = trim(fgets(STDIN));
}while ($respuesta != 'si');

echo "FIN PROGRAMA\n";
?>
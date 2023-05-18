<?php
include_once 'ViajeFeliz.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';

// Creo el objeto viaje 
$objViaje = new ViajeFeliz(0, 0, "",[],[],0,0);//inicializo el viaje en 0 

/**
 * Menu de opciones de usuario
 * 
 * @return int
 */
function MenuPrincipal()
{
    echo "====================\n";
    echo "MENU PRINCIPAL\n";
    echo "elija una opción:\n";
    echo "1-Cargar información del viaje\n";
    echo "2-Vender pasajes\n";
    echo "3-Modificar viaje\n";
    echo "====================\n";

    $opcion = trim(fgets(STDIN));
    return $opcion;
}

do {
    $opcion = MenuPrincipal();

    switch ($opcion) {
        case 1:
            echo "Ingrese el código del viaje:\n";
            $codigo = trim(fgets(STDIN));
            $objViaje->setCodigo($codigo);

            echo "Ingrese la cantidad máxima de pasajeros:\n";
            $maxPasajeros = trim(fgets(STDIN));
            $objViaje->setMaxPasajeros($maxPasajeros);

            echo "Ingrese el destino:\n";
            $destino = trim(fgets(STDIN));
            $objViaje->setDestino($destino);

            echo "ingrese el precio:\n";
            $precio = trim(fgets(STDIN));
            $objViaje->setPrecio($precio) ;

            echo "Información guardada con éxito.\n";
            break;
        
        case 2:
            if (($objViaje->getMaxPasajeros() == 0) && ($objViaje->getPrecio() == 0)){
                echo "primero se debe ingresar una cantidad maxima de pasajeros y el precio"."\n";
            break;
            }
            echo "ingresa el nombre del pasajero"."\n";
            $nombre = trim(fgets(STDIN));
            echo "ingresa el apellido del pasajero"."\n";
            $apellido = trim(fgets(STDIN));
            echo "ingresa el dni del pasajero"."\n";
            $num_doc = trim(fgets(STDIN));
            if ($objViaje->buscaPasajero($num_doc) >= 0){
                echo "ya hay una persona con ese dni";
                break;
            }
            echo "ingresa el numero de telefono del pasajero"."\n";
            $telefono = trim(fgets(STDIN));
            echo "ingrese el numero de asiento"."\n";
            $numA = trim(fgets(STDIN));
            echo "ingrese el numero de ticket"."\n";
            $numT = trim(fgets(STDIN));
            
            echo "que clase de pasajero es: comun/vip/especial (c/v/e)";
            $respuesta = trim(fgets(STDIN));
            if ($respuesta == 'c'){
                $objPasajero = new Pasajero($nombre,$apellido,$num_doc,$telefono,$numA,$numT);
                echo "Debe pagar: $",$objViaje->venderPasaje($objPasajero)."\n";
            }
            if ($respuesta == 'v'){
                echo "ingrese el numero frecuente:\n";
                $numFrecuente = trim(fgets(STDIN));
                echo "ingrese la cantidad de millas:\n";
                $millas = trim(fgets(STDIN));
                $objPasajero = new PasajeroVip($numFrecuente,$millas,$nombre,$apellido,$num_doc,$telefono,$numA,$numT);
                echo "Debe pagar: $",$objViaje->venderPasaje($objPasajero2)."\n";
            }
            if ($respuesta == 'e'){
                echo "Necesita silla de ruedas?:\n";
                $servicioEspecial = trim(fgets(STDIN));
                echo "Necesita comida en especial?:\n";
                $comidaEspecial = trim(fgets(STDIN));
                echo "Necesita asistencia?:\n";
                $asistenciaEspecial = trim(fgets(STDIN));
                $objPasajero = new PasajeroEspecial($servicioEspecial,$comidaEspecial,$asistenciaEspecial,$nombre,$apellido,$num_doc,$telefono,$numA,$numT);
                echo "Debe pagar: $",$objViaje->venderPasaje($objPasajero3)."\n";
            }
       
        break;

        case 3:
            echo "¿Qué desea modificar?\n";
            echo "1-Codigo del viaje\n";
            echo "2-Cantidad maxima de pasajeros\n";
            echo "3-Nuevo destino\n";
            echo "4-Datos de los pasajeros\n";
            $opcionModificacion = trim(fgets(STDIN));

            switch ($opcionModificacion) {
                case 1:
                 echo "Ingrese el nuevo código del viaje:\n";
                 $codigo = trim(fgets(STDIN));
                 $objViaje->setCodigo($codigo);
                break;
                case 2:
                    echo "Ingrese la nueva cantidad máxima de pasajeros:\n";
                    $maxPasajeros = trim(fgets(STDIN));
                    $objViaje->setMaxPasajeros($maxPasajeros);
                break;
                case 3:
                    echo "Ingrese el nuevo destino:\n";
                    $destino = trim(fgets(STDIN));
                    $objViaje->setDestino($destino);
                break;
                case 4:
                    echo "Ingrese el número de pasajero que desea modificar:\n";
                    $numeroPasajero = trim(fgets(STDIN));

                    if ($numeroPasajero < 1 || $numeroPasajero > $objViaje->setMaxPasajeros($maxPasajeros)) {
                        echo "Número de pasajero inválido.\n";
                        
                    }else{

                    echo "Ingrese el nuevo nombre del pasajero:\n";
                    $nombre= trim(fgets(STDIN));

                    echo "Ingrese el nuevo apellido del pasajero:\n";
                    $apellido = trim(fgets(STDIN));

                    echo "Ingrese el nuevo número de documento del pasajero:\n";
                    $num_doc = trim(fgets(STDIN));

                    $objViaje->setColPasajeros($colPasajeros);     
                }
                break;

                default:
                    echo "Opción inválida.\n";
                break;
            }

            echo "Información modificada con éxito.\n";
        break;
        default:
            echo "Opción inválida.\n";
        break;
    }

    echo "¿Desea volver al menú principal? (si/no)\n";
    $respuesta = trim(fgets(STDIN));

} while ($respuesta === 'si');

echo "FIN PROGRAMA\n";
?>
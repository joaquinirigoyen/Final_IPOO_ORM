<?php
include_once 'ViajeFeliz.php';

// Creo el objeto viaje 
$objViaje = new ViajeFeliz(0, 0, "");//inicializo el viaje en 0 

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
    echo "2-Modificar viaje\n";
    echo "3-Ver datos del viaje\n";
    echo "4-Ver pasajeros\n";
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
            echo "Desea cargar los pasajeros ahora? Despues no podra hacerlo\n";
            $respuesta = trim(fgets(STDIN));
            if ($respuesta == 'si'){
                $objViaje->cargarPasajeros();
            }
            echo "Información guardada con éxito.\n";
            break;

        case 2:
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

                    $objViaje->setPasajeros($nombre, $apellido, $num_doc);     
                }
                break;

                default:
                    echo "Opción inválida.\n";
                break;
            }

            echo "Información modificada con éxito.\n";
        break;

        case 3:
            echo $objViaje->__toString();
        break;
        
        case 4:
            echo "Lista de pasajeros:\n";
            $pasajeros = $objViaje->getPasajeros();
            foreach ($pasajeros as $pasajero) {
                echo "Nombre: " . $pasajero['nombre'] . "\n";
                echo "Apellido: " . $pasajero['apellido'] . "\n";
                echo "Número de documento: " . $pasajero['num_doc'] . "\n";
                echo "====================\n";
            }
    
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
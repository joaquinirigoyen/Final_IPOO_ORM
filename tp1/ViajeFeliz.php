<?php
class ViajeFeliz {
private $codigo;
private $maxPasajeros;
private $destino;
private $pasajeros;

public function __construct($codigo,$maxPasajeros,$destino){
    $this->codigo = $codigo;
    $this->maxPasajeros = $maxPasajeros;
    $this->destino = $destino;
    //$this->pasajeros [] = $pasajeros;

}
//retorna el codigo
public function getCodigo (){
    return $this->codigo;
}
//setea el codigo
public function setCodigo ($codigo){
    return $this->codigo = $codigo;
}
//retorna la cantidad maxima de pasajeros
public function getMaxPasajeros (){
    return $this->maxPasajeros;
}
//setea la cantidad maxima de pasajeros
public function setMaxPasajeros ($maxPasajeros){
    return $this->maxPasajeros = $maxPasajeros;
}
//retorna el destino 
public function getDestino(){
    return $this->destino;
}
//setea el destino 
public function setDestino ($destino){
    return $this->destino = $destino;
}
//retorna los pasajeros
public function getPasajeros (){
    return $this->pasajeros;
}
// setea los pasajeros
public function setPasajeros($nombre, $apellido, $num_doc)
{
    $pasajeros = array(
        "nombre" => $nombre,
        "apellido" => $apellido,
        "num_doc" => $num_doc
    );

    $this->pasajeros[] = $pasajeros; // agregar el pasajero al array de pasajeros
}


public function __toString()
{
    return "Codigo: \n".$this->getCodigo()."\n"."Cantidad maxima de pasajeros: \n"
    .$this->getMaxPasajeros()."\n"."Destino: \n".$this->getDestino()."\n";
}
//metodo agregar pasajero 

 function pasajeros($nombre, $apellido, $num_doc) {
    $pasajeros = [];
    $pasajeros ["nombre"] = $nombre;
   $pasajeros ["apellido"] = $apellido;
    $pasajeros ["num_doc"] = $num_doc;
  
    return $pasajeros;
}

public function cargarPasajeros (){
    $cadena= "";
    //$pasajeros = [];
    echo "Ingresar datos de los pasajeros:\n";
    for ($i = 1; $i <= $this->maxPasajeros; $i++) {
        echo "Pasajero " . $i . ":\n";
        echo "Nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Apellido: ";
        $apellido = trim(fgets(STDIN));
        echo "Número de documento: ";
        $num_doc = trim(fgets(STDIN));
        
        $pasajeros = array(
            "nombre" => $nombre,
            "apellido" => $apellido,
            "num_doc" => $num_doc
        );

        $this->pasajeros[] = $pasajeros;

        $cadena.= "Nombre: " . $pasajeros["nombre"] . " - Apellido: " . $pasajeros["apellido"] . " - Número de documento: " . $pasajeros["num_doc"] . "\n";
    }  

    echo $cadena;
}

}
?>
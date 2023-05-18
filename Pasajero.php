<?php
class Pasajero{

private $nombre;
private $apellido;
private $num_doc;
private $telefono;
private $numA;
private $numT;

public function __construct($nombre,$apellido,$num_doc,$telefono,$numA,$numT)
{
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->num_doc = $num_doc;
    $this->telefono = $telefono;
    $this->numA = $numA;
    $this->numT = $numT;
}
//metodos de acceso nombre
public function getNombre () {
    return $this->nombre;
}
public function setNombre($nombre){
    return $this->nombre = $nombre;
}
//metodos de acceso apellido
public function getApellido (){
    return $this->apellido;
}
public function setApellido($apellido){
    return $this->apellido = $apellido;
}
//metodos de acceso num_doc
public function getNum_doc (){
    return $this->num_doc;
}
public function setNum_doc($num_doc){
    return $this->num_doc = $num_doc;
}
//metodos de acceso telefono
public function getTelefono (){
    return $this->telefono;
}
public function setTelefono($telefono){
    return $this->telefono = $telefono;
}
public function getNumA()
{
return $this->numA;
}

public function setNumA($numA)
{
$this->numA = $numA;
}

public function getNumT()
{
return $this->numT;
}

public function setNumT($numT)
{
$this->numT = $numT;
}

public function __toString()
{
    return "nombre: ".$this->getNombre()."\n"."Apellido: "
    .$this->getApellido()."\n"."Documento: ".$this->getNum_doc()."\n"."Telefono: ".$this->getTelefono()."\n"."numero asiento".$this->getNumA()."\n"."Numero ticket:". $this->getNumT()."\n";
}

public function darPorcentajeIncremento() {

    $incremento = 10;

    return $incremento;
}

}
?>
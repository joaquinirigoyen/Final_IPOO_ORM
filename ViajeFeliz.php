<?php
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
class ViajeFeliz {
private $codigo;
private $maxPasajeros;
private $destino;
private $colPasajeros;
private $responsable;
private $precio;
private $recaudacionTotal;

public function __construct($codigo,$maxPasajeros,$destino, $colPasajeros,$responsable,$precio,$recaudacionTotal){
    $this->codigo = $codigo;
    $this->maxPasajeros = $maxPasajeros;
    $this->destino = $destino;
    $this->colPasajeros = $colPasajeros;
    $this->responsable = $responsable;
    $this->precio = $precio;
    $this->recaudacionTotal = $recaudacionTotal;

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
public function getColPasajeros (){
    return $this->colPasajeros;
}
// setea los pasajeros
public function setColPasajeros($colPasajeros)
{
    return $this->colPasajeros = $colPasajeros;
}

public function getResponsable()
{
return $this->responsable;
}
public function setResponsable($responsable)
{
$this->responsable = $responsable;
}
public function getPrecio()
{
return $this->precio;
}

public function setPrecio($precio)
{
$this->precio = $precio;

}

public function getRecaudacionTotal()
{
return $this->recaudacionTotal;
}
public function setRecaudacionTotal($recaudacionTotal)
{
$this->recaudacionTotal = $recaudacionTotal;
}

public function __toString()
{
    return "Codigo: ".$this->getCodigo()."\n"."Cantidad maxima de pasajeros: "
    .$this->getMaxPasajeros()."\n"."Destino: ".$this->getDestino()."\n"."Pasajeros: ".$this->mostrarPasajeros()."\n";
}

public function mostrarPasajeros (){
    $cadena = "";
    if (count($this->getColPasajeros()) == 0){
        $cadena = "El viaje no tiene pasajeros"."\n";
    }else{
        $pasajeros = $this->getColPasajeros();
        for ($i=0; $i < count($this->getColPasajeros()) ; $i++) { 
            $cadena = $cadena . $pasajeros [$i] ."\n";
        }
    }

    return $cadena;
}
public function  hayPasajesDisponible(){
    $pasajeDisponible = false;
    if (count($this->getColPasajeros()) < $this->getMaxPasajeros()){
        $pasajeDisponible = true;
    }
    return $pasajeDisponible;
}

public function buscaPasajero ($num_doc){

    $encontrado = false;
    $posPasajero = 0;
    $colPasajeros = $this->getColPasajeros();
    while ($posPasajero < count($colPasajeros) && $encontrado == false ){
        $dni2 = $colPasajeros [$posPasajero]->getNum_doc();
        if ($num_doc == $dni2){
            $encontrado = true;
        }
        $posPasajero ++;
    }
    if ($encontrado == false){
        $posPasajero = -1;
    }else {
        $posPasajero --;
    }
    return $posPasajero;
}

public function venderPasaje($objPasajero){
    if (($this->hayPasajesDisponible() == true) && ($this->buscaPasajero($objPasajero->getNum_doc()) == -1)){
        $colPasaje = $this->getColPasajeros();
        array_push($colPasaje,$objPasajero);

        $precioPasaje = $this->getPrecio();
        $incremento = $objPasajero->darPorcentajeIncremento();

        $precioFinal = ($precioPasaje * ($incremento + 100))/100;
        $recaudacion = $this->getRecaudacionTotal(); 

        $recaudacion = $recaudacion + $precioFinal;

        $this->setRecaudacionTotal($recaudacion);
        
    }
    return $precioFinal ;
}
}
?>
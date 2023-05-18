<?php
include_once 'pasajero.php';
class PasajeroVip extends Pasajero {
    private $numFrecuente;
    private $millas;

    public function __construct($numFrecuente,$millas,$nombre,$apellido,$num_doc,$telefono,$numA,$numT){
        parent::__construct($nombre,$apellido,$num_doc,$telefono,$numA,$numT);
        $this->numFrecuente = $numFrecuente;
        $this->millas = $millas;
    }

    public function getNumFrecuente()
    {
        return $this->numFrecuente;
    }
    public function setNumFrecuente($numRecuente)
    {
        $this->numFrecuente = $numRecuente;
    }
    public function getMillas()
    {
        return $this->millas;
    }
    public function setMillas($millas)
    {
        $this->millas = $millas;
    }

    public function __toString(){
        $cadena =parent::__toString();
    
        $cadena .= "Millas".$this->getMillas()."\n"."Numero frecuente:". $this->getNumFrecuente()."\n";
        return $cadena;
    }
    

    public function darPorcentajeIncremento(){
        if ($this->getMillas() > 300){
            $incremento = 30;    
        }else{
            $incremento = 35;
        }
        return $incremento;
    }




} 
?>
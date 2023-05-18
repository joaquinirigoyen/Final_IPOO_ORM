<?php
include_once 'Pasajero.php';

class PasajeroEspecial extends Pasajero {
    private $servicioEspecial;
    private $comidaEspecial;
    private $asistenciaEspecial;

    public function __construct($servicioEspecial,$comidaEspecial,$asistenciaEspecial,$nombre,$apellido,$num_doc,$telefono,$numA,$numT){
        parent::__construct($nombre,$apellido,$num_doc,$telefono,$numA,$numT);
        $this->servicioEspecial = $servicioEspecial;
        $this->comidaEspecial = $comidaEspecial;
        $this->asistenciaEspecial = $asistenciaEspecial;
    }

    public function getServicioEspecial()
    {
        return $this->servicioEspecial;
    }

    public function setServicioEspecial($servicioEspecial)
    {
        $this->servicioEspecial = $servicioEspecial;
    }
    public function getComidaEspecial()
    {
        return $this->comidaEspecial;
    }
    public function setComidaEspecial($comidaEspecial)
    {
        $this->comidaEspecial = $comidaEspecial;
    }
    public function getAsistenciaEspecial()
    {
        return $this->asistenciaEspecial;
    }
    public function setAsistenciaEspecial($asistenciaEspecial)
    {
        $this->asistenciaEspecial = $asistenciaEspecial;
    }

    public function __toString(){
        $cadena =parent::__toString();
    
        $cadena .= "Servicio".$this->getServicioEspecial()."\n"."Asistencia:". $this->getAsistenciaEspecial()."\n"."comida". $this->getComidaEspecial();

        return $cadena;
    }
    
    public function cuentaServicios (){
        $cantServicios = 0;
        if ($this->getServicioEspecial() == true){
            $cantServicios ++;
        } 
        if ($this->getComidaEspecial() == true){
            $cantServicios ++;
        }
        if ($this->getAsistenciaEspecial() == true){
            $cantServicios ++;
        }

        return $cantServicios;
    }

    public function darPorcentajeIncremento(){
        if ( $this->cuentaServicios() > 1 ){
            $incremento = 30;
        }else{
            $incremento = 15;
        }
       return $incremento;
    }

} 


?>
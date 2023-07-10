<?php
class Viaje {

private $idViaje;
private $maxPasajeros;
private $destino;
private $colPasajeros;
private $responsable;
private $precio;
private $objEmpresa;
private $recaudacionTotal;
private $mensajeoperacion;

public function __construct(){
    $this->idViaje = "";
	$this->destino = "";
	$this->maxPasajeros = "";
	$this->colPasajeros = [];
	$this->responsable = null;
	$this->objEmpresa = null;
	$this->precio = "";
	$this->recaudacionTotal = "";
}

public function cargar($id,$maxP,$destino,$colP,$resp,$precio,$empre){
    $this->setIdViaje($id);
    $this->setMaxPasajeros($maxP);
    $this->setDestino($destino);
    $this->setColPasajeros($colP);
    $this->setResponsable($resp);
    $this->setPrecio($precio);
    $this->setObjEmpresa($empre);
}
public function getIdViaje() {
	return $this->idViaje;
}

public function setIdViaje($idViaje) {
	$this->idViaje = $idViaje;
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
/**
 * devuelve arreglo pasajero
 * @return array
 */
public function getColPasajeros (){
    return $this->colPasajeros;
}
// setea los pasajeros
public function setColPasajeros($colPasajeros){
    return $this->colPasajeros = $colPasajeros;
}
/**
 * @return Responsable
 */
public function getResponsable(){
return $this->responsable;
} 
/**
 * setea el responsable
 */
public function setResponsable($responsable)
{
$this->responsable = $responsable;
}
public function getPrecio(){
return $this->precio;
}

public function setPrecio($precio){
$this->precio = $precio;

}
/**
 * @return Empresa
 */
public function getObjEmpresa() {
	return $this->objEmpresa;
}

public function setObjEmpresa($objEmpresa) {
	$this->objEmpresa = $objEmpresa;
}
public function getRecaudacionTotal(){
	return $this->recaudacionTotal;
}
public function setRecaudacionTotal($recaudacionTotal){
	$this->recaudacionTotal = $recaudacionTotal;
}
public function getmensajeoperacion(){
	return $this->mensajeoperacion ;
}
public function setmensajeoperacion($mensajeoperacion){
	$this->mensajeoperacion=$mensajeoperacion;
}

public function __toString()
{
    return "Codigo: ".$this->getIdViaje()."\n"."Cantidad maxima de pasajeros: "
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


	/***********************************************BASE DE DATOS***********************************************
	 * Recupera los datos de un viaje por un id
	 * @param int $id
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idViaje){
		$base=new BaseDatos();
		$consultaPersona="Select * from viaje where idviaje=".$idViaje;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($fila=$base->Registro()){

                    $objEmpresa = new Empresa();
                    $objEmpresa->buscar($fila['idempresa']);
					if($objEmpresa == false){
                        $objEmpresa = null;
                    }

                    $objResponsable = new ResponsableV();
                    $objResponsable->Buscar($fila['rnumeroempleado']);
					if($objResponsable == false){
                        $objResponsable = null;
                    }

					$maxp = ($fila['vcantmaxpasajeros']);
					$destino = ($fila['vdestino']);
                    $precio = ($fila['vimporte']);
					$total = ($fila['vrecaudacion']);
                    
					$pasajero = new Pasajero();
                    $colPasajeros = $pasajero->listar("pasajero.idviaje = ".$idViaje);

                
                    $this->cargar($idViaje,$maxp,$destino, $colPasajeros, $objResponsable,$precio, $objEmpresa,$total);
                    $resp = true;				
                }else{
		 			$this->setmensajeoperacion($base->getError());
                }
		    }else{
		 		$this->setmensajeoperacion($base->getError());
            }		
		}
      return $resp;
	}
	  /**
     * Busca todos los viajes que cumplan una condición y devuelve un arreglo
     * que los contiene.
     * 
     * @param string $condicion
     * 
     */
	public function listar($condicion=""){
	    $arregloViaje = null;
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje ";
		if ($condicion!=""){
		    $consultaViaje=$consultaViaje.' where '.$condicion;
		}
		$consultaViaje.=" order by idviaje ";
		//echo $consultaViaje;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){				
				$arregloViaje= array();
				while($fila=$base->Registro()){
                    $objEmpresa = new Empresa();
                    $objEmpresa->buscar($fila['idempresa']);
					if($objEmpresa == false){
                        $objEmpresa = null;
                    }

                    $objResponsable = new ResponsableV();
                    $objResponsable->Buscar($fila['rnumeroempleado']);
					if($objResponsable == false){
                        $objResponsable = null;
                    }

					$maxp = ($fila['vcantmaxpasajeros']);
					$destino = ($fila['vdestino']);
                    $precio = ($fila['vimporte']);
					$total = ($fila['vrecaudacion']);
                    $idViaje = ($fila['idviaje']);
                    
					$pasajero = new Pasajero();
                    $colPasajeros = $pasajero->listar("pasajero.idviaje = ".$idViaje);
                 
					$objViaje = new Viaje();

                    $objViaje->cargar($idViaje,$maxp,$destino, $colPasajeros, $objResponsable,$precio, $objEmpresa,$total);
					array_push($arregloViaje, $objViaje);
				}
			}else {
				$this->setmensajeoperacion($base->getError());	
			}
		 }else {
			$this->setmensajeoperacion($base->getError());	
		 }	

		return $arregloViaje;
	}	
/**
 * @param Empresa
 * @param Responsable
 */
    public function insertar(){
		$base = new BaseDatos();
        $resp = null;
        $idEmpresa = $this->getObjEmpresa()->getIdEmpresa();
        $idResponsable = $this->getResponsable()->getNumeroEmpleado();
        $consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado,vimporte)
			VALUES ('" . $this->getDestino() . "'," . $this->getMaxPasajeros() .", ".
        $idEmpresa.", ".$idResponsable.",". $this->getPrecio() . ")";
        if ($base->Iniciar()) {
            $id = $base->devuelveIDInsercion($consultaInsertar);
            if ($id != null) {
                $resp = true;
                $this->setIdViaje($id);
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
	}
	
	public function modificar(){
	    $resp = false;
        $base = new BaseDatos();
        $idEmpresa = $this->getObjEmpresa()->getIdEmpresa();
        $idResponsable = $this->getResponsable()->getNumeroEmpleado();
        $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getDestino() . "',vcantmaxpasajeros=" . $this->getMaxPasajeros() . ",idempresa=" .$idEmpresa. ",rnumeroempleado=" . $idResponsable. ",vimporte=" . $this->getPrecio() . " WHERE idviaje =" . $this->getIdViaje();
        echo $consultaModifica;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM viaje WHERE idviaje=".$this->getIdViaje();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
					$this->setmensajeoperacion($base->getError());
				}
		}else{
			$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
	  /**
     * Elimina el viaje
     */
    public function eliminarViaje(){
        $colPasajeros = $this->getColPasajeros();

        for($i = 0; $i < count($colPasajeros); $i++){
            $colPasajeros[$i]->eliminar();
        }
        $this->eliminar();
    }
 
}
?>
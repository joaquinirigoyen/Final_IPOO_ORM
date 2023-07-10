<?php
include_once 'baseDeDatos.php';
class Pasajero{

private $nombre;
private $apellido;
private $num_doc;
private $telefono;
private $idViaje;
private $mensajeoperacion;

public function __construct()
{
    $this->nombre = "";
    $this->apellido = "";
    $this->num_doc = "";
    $this->telefono = "";
	$this->idViaje = "";
}

public function cargar($nom,$ape,$doc,$tel,$id){
    $this->setNombre($nom);
    $this->setApellido($ape);
    $this->setNum_doc($doc);
    $this->setTelefono($tel);
	$this->setIdViaje($id);

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
public function getIdViaje() {
	return $this->idViaje;
}
public function setIdViaje($idViaje) {
	$this->idViaje = $idViaje;
}

public function getmensajeoperacion(){
    return $this->mensajeoperacion ;
}
public function setmensajeoperacion($mensajeoperacion){
    $this->mensajeoperacion=$mensajeoperacion;
}

public function __toString()
{
    return "nombre: ".$this->getNombre()."\n"."Apellido: "
    .$this->getApellido()."\n"."Documento: ".$this->getNum_doc()."\n"."Telefono: ".$this->getTelefono()."\n"."id Viaje:". $this->getIdViaje()."\n";
}

/**
	 * Recupera los datos de un pasajero por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($num_doc){
		$base=new BaseDatos();
		$consultaPersona="Select * from pasajero where pdocumento=".$num_doc;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($fila=$base->Registro()){					
				    $nombre = $fila['pnombre'];
					$apellido = $fila['papellido'];
					$telefono = $fila['ptelefono'];
					$idViaje = $fila['idviaje'];

					$this->cargar($nombre, $apellido, $telefono, $telefono,$idViaje);
					$resp= true;
				}				
			
		 	}else {
		 		$this->setmensajeoperacion($base->getError());
		 	}
		 }else{
		 	$this->setmensajeoperacion($base->getError());
		 }		
		 return $resp;
	}	
	/*
	Análisis de error:
	Se quita la etiqueta static de la función para que no de error
	*/
	//public static function listar($condicion=""){
	public function listar($condicion=""){
	    $arregloPasajero = null;
		$base=new BaseDatos();
		$consultaPersonas="Select * from pasajero ";
		if ($condicion!=""){
		    $consultaPersonas=$consultaPersonas.' where '.$condicion;
		}
		$consultaPersonas.=" order by papellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersonas)){				
				$arregloPasajero= array();
				while($fila=$base->Registro()){
					
					$Nombre=$fila['pnombre'];
					$Apellido=$fila['papellido'];
                    $NroDoc=$fila['pdocumento'];
					$Tel=$fila['ptelefono'];
                    $idViaje = $fila['idviaje'];

					$perso=new Pasajero();
					$perso->cargar($Nombre,$Apellido,$NroDoc,$Tel,$idViaje);
					array_push($arregloPasajero,$perso);
	
				}
			
		 	}else {
                $this->setmensajeoperacion($base->getError());
			}
		 }else {
		 	$this->setmensajeoperacion($base->getError());
		 }	

		    return $arregloPasajero;
	}	
	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO pasajero(pnombre, papellido, pdocumento,  ptelefono, idViaje) 
			VALUES ('".$this->getNombre()."','".$this->getApellido()."','".$this->getNum_doc()."','".$this->getTelefono()."','".$this->getIdViaje()."')";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaInsertar)){
			    $resp=  true;
			}else {
				$this->setmensajeoperacion($base->getError());	
			}
		}else{
			$this->setmensajeoperacion($base->getError());
		}
		
        return $resp;
	}
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE pasajero SET pdocumento = ".$this->getNum_doc().", pnombre = '".$this->getNombre().
        "', papellido = '".$this->getApellido()."', ptelefono = '".$this->getTelefono().
        "', idviaje = ".$this->getIdViaje()."' WHERE pdocumento=". $this->getNum_doc()."';";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp= true;
			}else{
				$this->setmensajeoperacion($base->getError());
			}
		}else{
			$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM pasajero WHERE pdocumento=".$this->getNum_doc();
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
     * Elimina todos los Pasajeros de la base de datos según su ID de viaje
     * recibido por parámetro
     * Retorna true si tiene éxito en la operación, false en caso contrario
     * 
     * @param int $condicion
     * @return boolean
     */
    public function eliminarPasajerosPorIdViaje($condicion){
		$base = new BaseDatos();
		$exito = false;
		if($base->Iniciar()){
            $consulta = "DELETE FROM pasajero WHERE idViaje = ".$condicion.";";
            if($base->Ejecutar($consulta)){
                $exito = true;
			} else {
                $this->setMensajeOperacion($base->getError());
            }
		} else {
            $this->setMensajeOperacion($base->getError());	
		}
		return $exito; 
	}
}
?>


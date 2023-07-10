<?php
include_once 'baseDeDatos.php';
class Empresa{
private $idEmpresa;
private $nombre;
private $direccion;
private $colViajes;
private $mensajeoperacion;

public function __construct()
{
    $this->idEmpresa = 0;
	$this->nombre = "";
    $this->direccion = "";
	$this->colViajes = [];
}

public function cargar($id,$nom,$direc,$colViajes){
	$this->setIdEmpresa($id);
    $this->setNombre($nom);
    $this->setDireccion($direc);
	$this->setColViajes($colViajes);
}
//metodos de acceso nombre
public function getNombre () {
    return $this->nombre;
}
public function setNombre($nombre){
    return $this->nombre = $nombre;
}
//metodos de acceso apellido
public function getDireccion (){
    return $this->direccion;
}
public function setDireccion($direccion){
    return $this->direccion = $direccion;
}
public function getmensajeoperacion(){
    return $this->mensajeoperacion ;
}
public function setmensajeoperacion($mensajeoperacion){
    $this->mensajeoperacion=$mensajeoperacion;
}
public function getIdEmpresa() {
	return $this->idEmpresa;
}
public function setIdEmpresa($idEmpresa) {
	$this->idEmpresa = $idEmpresa;
}
public function getColViajes() {
	return $this->colViajes;
}

/**
* @param $colViajes
*/
public function setColViajes($colViajes) {
	$this->colViajes = $colViajes;
}

public function __toString()
{
    return "nombre: ".$this->getNombre()."\n"."direccion: ".$this->getDireccion()."\n"."id: ". $this->getIdEmpresa()."\n"."viajes:". $this->mostrarColViajes()."\n";
}
/**
 * Devuelve un string con la información de todos los viajes de la empresa
 * 
 * @return string
 */
public function mostrarColViajes(){
	// string $cadena
	$cadena = "";

	if(count($this->getColViajes())  == 0){
		$cadena = "Esta empresa no tiene viajes cargados\n";
	} else {
		$viajes = $this->getColViajes();
		for($i = 0; $i < count($this->getColViajes()); $i++){
			$cadena = $cadena.$viajes[$i]."\n";
		}
	}
	return $cadena;
}

	/**
     * Debido a un bug de recursion infinito al utilizar el Buscar de esta clase 
     * se actualiza la colección de viajes aparte
     */
    public function actualizarColViajes(){
        $viaje = new Viaje();
        $colViajes = $viaje->listar("viaje.idempresa = ".$this->getIdEmpresa());
        $this->setColViajes($colViajes);
    }
	/**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idEmpresa){
		$base=new BaseDatos();
		$consultaPersona="Select * from empresa where idempresa=".$idEmpresa;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($fila=$base->Registro()){

					$nombre = ($fila['enombre']);
					$direccion = ($fila['edireccion']);

					$this->cargar($idEmpresa, $nombre, $direccion, []);
					$resp= true;
				}				
			
		 	}else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
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
	    $arregloEmpresa = null;
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa ";
		if ($condicion!=""){
		    $consultaEmpresa=$consultaEmpresa.' where '.$condicion;
		}
		$consultaEmpresa.=" order by idempresa ";
		//echo $consultaEmpresa;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){			
				$arregloEmpresa= array();
				while($fila=$base->Registro()){

					$Id = $fila['idempresa']; 
					$Nombre=$fila['enombre'];
					$Direccion=$fila['edireccion'];
                    
					$viaje = new Viaje();
                    $colViajes = $viaje->listar("viaje.idempresa = ".$Id);

					$empre=new empresa();
					$empre->cargar($Id,$Nombre,$Direccion,$colViajes);

					array_push($arregloEmpresa,$empre);
	
				}
			
		 	}else {
                $this->setmensajeoperacion($base->getError());
			}
		 }else {
		 	$this->setmensajeoperacion($base->getError());
		 }	

		return $arregloEmpresa;
	}	
	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa(enombre, edireccion) 
			VALUES ('".$this->getNombre()."','".$this->getDireccion()."')";
		if($base->Iniciar()){
			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdEmpresa($id);
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
		$consultaModifica="UPDATE empresa SET  enombre='".$this->getNombre()."',edireccion='".$this->getDireccion()."' WHERE idempresa=". $this->getIdEmpresa();
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
				$consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
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
     * Elimina la empresa
     */
    public function eliminarEmpresa(){

        $this->actualizarColViajes();
        $colViajes = $this->getColViajes();
        for ($i = 0; $i < count($colViajes); $i++){
            $colViajes[$i]->eliminarViaje();
        }
        $this->eliminar();
    }
}
?>
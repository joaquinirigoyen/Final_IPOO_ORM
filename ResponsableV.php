<?php
class ResponsableV{

    private $numeroEmpleado;
    private $numeroLicencia;
    private $nombre;
    private $apellido;
    private $mensajeoperacion;

    public function __construct(){
        $this->numeroEmpleado = "";
        $this->numeroLicencia = "";
        $this->nombre = "";
        $this->apellido = "";
    }
    public function cargar($num,$numL,$nom,$ape){
        $this->setNumeroEmpleado($num);
        $this->setNumeroLiencia($numL);
        $this->setNombre($nom);
        $this->setApellido($ape);
    }

    public function getNumeroEmpleado(){
        return $this->numeroEmpleado;
    }
    public function getNumeroLicencia(){
        return $this->numeroLicencia;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function setNumeroEmpleado($numeroEmpleado){
        $this->numeroEmpleado = $numeroEmpleado;
    }
    public function setNumeroLiencia($numeroLicencia){
        $this->numeroLicencia = $numeroLicencia;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setApellido($apellido){
        $this->apellido = $apellido;
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
        .$this->getApellido()."\n"."Numero empleado: ".$this->getNumeroEmpleado()."\n"."Numero de licencia: ".$this->getNumeroLicencia()."\n";
    }

    
    public function Buscar($numeroEmpleado){
		$base=new BaseDatos();
		$consultaResponsable="Select * from responsable where rnumeroempleado=".$numeroEmpleado;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){
				if($fila=$base->Registro()){
                    $numL = ($fila['rnumerolicencia']);
					$nombre = ($fila['rnombre']);
                    $apellido = ($fila['rapellido']);

					$this->cargar($numeroEmpleado,$numL, $nombre, $apellido);
					$resp= true;
				}				
			
		 	}else {
		 		$this->setmensajeoperacion($base->getError());
		 	}
		 }else {
		 	$this->setmensajeoperacion($base->getError());
		 }		
		return $resp;
	}	

	public function listar($condicion=""){
	    $arregloResponsable = null;
		$base=new BaseDatos();
		$consultaResponsable="Select * from responsable ";
		if ($condicion!=""){
		    $consultaResponsable=$consultaResponsable.' where '.$condicion;
		}
		$consultaResponsable.=" order by rnumeroempleado ";
		//echo $consultaResponsable;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){			
				$arregloResponsable= array();
				while($fila=$base->Registro()){

                    $numeroEmpleado = $fila['rnumeroempleado'];
                    $numL = $fila['rnumerolicencia'];
					$nombre = $fila['rnombre'];
                    $apellido = $fila['rapellido'];

					$responsable=new ResponsableV();

					$responsable->cargar($numeroEmpleado,$numL,$nombre,$apellido);

					array_push($arregloResponsable,$responsable);
	
				}
			
		 	}else {
                $this->setmensajeoperacion($base->getError());
			}
		 }else {
		 	$this->setmensajeoperacion($base->getError());
		 }	

		return $arregloResponsable;
	}	

	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO responsable(rnumerolicencia,rnombre, rapellido) 
			VALUES ('".$this->getNumeroLicencia()."','".$this->getNombre()."','".$this->getApellido()."')";
		if($base->Iniciar()){
			// if($base->Ejecutar($consultaInsertar)){
			//     $resp=  true;
			// }else {
			// 	$this->setmensajeoperacion($base->getError());	
			// }
			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setNumeroEmpleado($id);
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
		$consultaModifica="UPDATE responsable SET  rnumerolicencia='".$this->getNumeroLicencia()."',rnombre='".$this->getNombre()."',rapellido='".$this->getApellido()."' WHERE rnumeroempleado=". $this->getNumeroEmpleado();
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
				$consultaBorra="DELETE FROM responsable WHERE rnumeroempleado=".$this->getNumeroEmpleado();
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

}

?>
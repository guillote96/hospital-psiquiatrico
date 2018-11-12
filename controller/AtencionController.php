<?php  

class AtencionController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }


    public function registrarAtencion(){
    	//RECORDAR QUE TIENE un 1 POR DEFECTO PERO HAY QUE PASARLE EL ID DEL PACIENTE QUE CORRESPONDA (UNICAMENTE ESTA PARA PRUEBAS)
    	$string=PDOPaciente::getInstance()->traer_paciente(1)[0]->getNombre()." ".PDOPaciente::getInstance()->traer_paciente(1)[0]->getApellido();
    	$datos = array('paciente' => PDOPaciente::getInstance()->traer_paciente(1)[0],
    		           'nombreapellido' => $string, 
    		           'resources' => array("usuario"=>PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername()),
                       'motivos' => PDOMotivoConsulta::getInstance()->listAll(),
                       'tratamientos' => PDOTratamientoFarmacologico::getInstance()->listAll(),
                       'acompanamientos' => PDOacompanamiento::getInstance()->listAll(),
                       'permisos' => $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]));

     $view = new RegistrarAtencion();
     $view->show($datos);

    }

     public function registrar_atencion($id){
     	//registra la atencion (FALTA API PARA DERIVACION). el string nomapellido no se registra, es usado para identificar al paciente, sin embargo, en el arreglo que le paso a la vista esta el objeto correspondiente al paciente que estoy manipulando con toda su informacion.Falta direccionar a otra vista cuando ya inserta el valor.

     	if(!isset($_POST['nombreapellido']) || empty($_POST['nombreapellido']) || 
           !isset($_POST['fecha']) || empty($_POST['fecha']) ||
           !isset($_POST['motivo']) || empty($_POST['motivo']) || 
           !isset($_POST['internacion']) || empty($_POST['internacion']) ||
           !isset($_POST['diagnostico']) || empty($_POST['diagnostico'])){


     		return false;
     	}


     	$derivacion=null;
     	$articulacion=null;
     	$observaciones=null;
     	$tratamientos=null;
     	$acompanamiento=null;

     	if(isset($_POST['derivacion']) && !empty($_POST['derivacion'])){
     		$derivacion=$_POST['derivacion'];
     	}

     	if(isset($_POST['articulacion']) && !empty($_POST['articulacion'])){
     		$articulacion=$_POST['articulacion'];
     	}

     	if(isset($_POST['observaciones']) && !empty($_POST['observaciones'])){
     		$observaciones=$_POST['observaciones'];
     	}

     	if(isset($_POST['tratamiento']) && !empty($_POST['tratamiento'])){
     		$tratamientos=$_POST['tratamiento'];
     	}
     	if(isset($_POST['acompanamiento']) && !empty($_POST['acompanamiento'])){
     		$acompanamiento=$_POST['acompanamiento'];
     	}
          
        $array= array(':pacienteid' => $id, 
        	           ':fecha' => $_POST['fecha'], 
        	           ':motivoid'=> $_POST['motivo'] ,
        	           ':derivacionid' => $derivacion ,
        	           ':articulacion' => $articulacion, 
                       ':internacion' => $_POST['internacion'],
                       ':diagnostico' => $_POST['diagnostico'],
                       ':observaciones' =>  $observaciones,
        	           ':tratamiento' => $tratamientos, 
        	           ':acompanamiento' =>$acompanamiento);

       PDOConsulta::getInstance()->insertarConsulta($array);

    }




}





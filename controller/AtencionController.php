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

        public function validador_campos(){
        if(!isset($_POST['nombreapellido']) || empty($_POST['nombreapellido']) || 
           !isset($_POST['fecha']) || empty($_POST['fecha']) ||
           !isset($_POST['motivo']) || empty($_POST['motivo']) || 
           !isset($_POST['internacion']) || empty($_POST['internacion']) ||
           !isset($_POST['diagnostico']) || empty($_POST['diagnostico']) ||
           !isset($_GET['pacienteId']) || empty($_GET['pacienteId'])){


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
          
        $array= array( ':pacienteid' => $_GET['pacienteId'], 
                       ':fecha' => $_POST['fecha'], 
                       ':motivoid'=> $_POST['motivo'] ,
                       ':derivacionid' => $derivacion ,
                       ':articulacion' => $articulacion, 
                       ':internacion' => $_POST['internacion'],
                       ':diagnostico' => $_POST['diagnostico'],
                       ':observaciones' =>  $observaciones,
                       ':tratamiento' => $tratamientos, 
                       ':acompanamiento' =>$acompanamiento);

        return $array;

    }


    public function registrarAtencion(){
    	//RECORDAR QUE TIENE un 1 POR DEFECTO PERO HAY QUE PASARLE EL ID DEL PACIENTE QUE CORRESPONDA (UNICAMENTE ESTA PARA PRUEBAS)
      if(!isset($_GET['id']) || empty($_GET['id'])){
        return false;
      }
    	$string=PDOPaciente::getInstance()->traer_paciente($_GET['id'])[0]->getNombre()." ".PDOPaciente::getInstance()->traer_paciente($_GET['id'])[0]->getApellido();
    	$datos = array('paciente' => PDOPaciente::getInstance()->traer_paciente($_GET['id'])[0],
    		           'nombreapellido' => $string, 
    		           'resources' => array("usuario"=>PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]),
                       'motivos' => PDOMotivoConsulta::getInstance()->listAll(),
                       'tratamientos' => PDOTratamientoFarmacologico::getInstance()->listAll(),
                       'acompanamientos' => PDOacompanamiento::getInstance()->listAll(),
                       'permisos' => $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]));

     $view = new RegistrarAtencion();
     $view->show($datos);

    }

     public function registrar_atencion(){
     	//registra la atencion (FALTA API PARA DERIVACION). el string nomapellido no se registra, es usado para identificar al paciente, sin embargo, en el arreglo que le paso a la vista esta el objeto correspondiente al paciente que estoy manipulando con toda su informacion.Falta direccionar a otra vista cuando ya inserta el valor.
        $array= self::validador_campos();
        PDOConsulta::getInstance()->insertarConsulta($array);

        PacienteController::getInstance()->listarTodosLosPacientes();

        //falta redireccionar alguna view

    }


    public function editarAtencion($idAtencion){
        //valor por defecto para pruebas nada mas (idAtencion)
            $atencion=PDOConsulta::getInstance()->traer_consulta($idAtencion)[0];
            $string= PDOPaciente::getInstance()->traer_paciente($atencion->getPacienteId())[0]->getNombre(). " ".PDOPaciente::getInstance()->traer_paciente($atencion->getPacienteId())[0]->getApellido();
            $datos = array('nombreapellido' => $string,
                           'atencion' => $atencion,
                           'resources' => array("usuario"=>PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]),
                           'motivos' => PDOMotivoConsulta::getInstance()->listAll(),
                           'tratamientos' => PDOTratamientoFarmacologico::getInstance()->listAll(),
                           'acompanamientos' => PDOacompanamiento::getInstance()->listAll(),
                           'permisos' => $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]));
            $view= new editarAtencion();
            $view->show($datos);

    }

    public function editar_atencion(){
        $array= self::validador_campos();
         if(!isset($_GET['id']) || empty($_GET['id'])){
            return false;
        }
        $array[':id']=$_GET['id'];
        PDOConsulta::getInstance()->actualizarConsulta($array);

         //falta redireccionar alguna view
    }

     public function eliminar_atencion(){
         if(!isset($_GET['id']) || empty($_GET['id'])){
            return false;
           }
         $array = array(':id' => $_GET['id']);
         PDOConsulta::getInstance()->eliminarConsulta($array);

          //falta redireccionar alguna view
     }

         public function listarAtenciones($idPaciente){
            //Traer atenciones de determinado paciente
             $atenciones= PDOConsulta::getInstance()->traer_consultas_de_paciente(array(':pacienteid' => $idPaciente));



            $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOConsulta::getInstance()->cantidad());
             //$atenciones= PDOConsulta::getInstance()->listarCantidad(1,$cantidad['cantidadElementos'],$idPaciente);
             $datos = array('atenciones' => $atenciones,
                            'resources' => array("usuario" => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]),
                            'permisos' => PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]),
                            'cantidad' => $cantidad['cantidadPaginas'],'pagina' => 1);
             
             $view = new ListarAtenciones();
            $view->show($datos);

    }


     public function listar_atenciones(){
        $idPaciente=1;
        if (empty($_GET['pagina'])){
            return false;
        }
        $pagina = $_GET['pagina'];
        $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOConsulta::getInstance()->cantidad());
        $resources = array('atenciones' => PDOConsulta::getInstance()->listarCantidad($pagina,$cantidad['cantidadElementos'],$idPaciente),
            'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),
            'cantidad' => $cantidad['cantidadPaginas'], 
            'pagina' => $pagina, 
            'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0],
            'permisos' => PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]));
        $view = new ListarAtenciones();
        $view->show($resources);
    }

    public function reportes(){
        $view = new Reportes();
        $resources = array('usuario' =>PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
        $view->show($resources);
    }

    public function graficoPorCriterio(){
        $i = $_GET['i'];
        if($i == 1){
            //Consultas agrupadas por motivo
            $criterio = "Motivo";
        }
        else if ($i == 2){
            $masculino = PDOConsulta::getInstance()->cantidadDeConsultasPorGenero(1);
            $femenino = PDOConsulta::getInstance()->cantidadDeConsultasPorGenero(2);
            $otro = PDOConsulta::getInstance()->cantidadDeConsultasPorGenero(3);
            $datos = array(array('nombre' => "Masculino",'porcentaje' => $masculino),array('nombre' => "Femenino", 'porcentaje' => $femenino), array('nombre' => "Otro", 'porcentaje' => $otro));
            $criterio = "Género";
        }
        else if ($i == 3){
            $informacion = PDOConsulta::getInstance()->consultasAgrupadasPorLocalidad();
            $datos=array();
            foreach ($informacion as &$dato){
              array_push($datos,array('nombre' => $dato->getName(), 'porcentaje' => $dato->getId()));
            }
            $total = count($datos);
            $criterio = "Localidad";
        }
        $view = new GraficoPorCriterio();
        $resources = array('usuario' =>PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0],'criterio' => $criterio, 'datos' => $datos);
        $view->show($resources);
    }

    public function listadoPDF(){
      require('./recursos/fpdf181/fpdf.php');

      $pdf = new FPDF();
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',16);
      $pdf->Cell(40,10,'Hello World!');
      $pdf->Output();
    }


    public function listadoPorCriterio(){
      $i = $_GET['i'];
      if($i == 1){
        $criterio = "Motivo";
      }
      else if ($i == 2){
        $datos = PDOConsulta::getInstance()->consultasPorGenero();
        $criterio = "Género";
      }
      else if($i == 3){
        $datos = PDOConsulta::getInstance()->consultasPorLocalidad();
        $criterio = "Localidades";
      }
      $view = new ListadoPorCriterio();
      $resources = array('usuario' =>PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0],'criterio' => $criterio, 'datos' => $datos);
      $view->show($resources);
    }




}





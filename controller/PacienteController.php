<?php

class PacienteController{

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    

    public function listarTodosLosPacientes(){
         if (sizeof($_SESSION) == 0){
            $view = new IniciarSesion();
            $view->show();
        }
        else{
            if($_SESSION["id"] == NULL){
                $view = new IniciarSesion();
                $view->show();
            }
            else{
            $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
             $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOPaciente::getInstance()->cantidad());
            $resources =array('resources'=> PDOPaciente::getInstance()->listarCantidad(1,$cantidad['cantidadElementos']),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'pagina' => 1, 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
              $view = new ListarPaciente();
              $view->show($resources, $permisos);
            }
        }
    }

    public function listarPacientes(){
        if (empty($_GET['pagina'])){
            return false;
        }
        $pagina = $_GET['pagina'];
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
        $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOPaciente::getInstance()->cantidad());
        $resources =array('resources'=> PDOPaciente::getInstance()->listarCantidad($pagina,$cantidad['cantidadElementos']),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'pagina' => $pagina, 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
        $view = new ListarPaciente();
        //$cantElementos=$cantidad[0][0];
        $view->show($resources, $permisos);
    }

    public function agregarPaciente(){
        if (sizeof($_SESSION) == 0){
            $view = new IniciarSesion();
            $view->show();
        }
        else{
            if($_SESSION["id"] == NULL){
                $view = new IniciarSesion();
                $view->show();
            }
            else{
              $partidos = PDOPartido:: getInstance()->listAll();
              $localidades = PDOLocalidad:: getInstance()->listAll();
              $obraSociales = PDOObraSocial:: getInstance()->listAll();
              $regionSanitaria = PDORegionSanitaria:: getInstance()->listAll();
              $generos = PDOGenero:: getInstance()->listAll();
              $tiposDoc = PDOTipoDoc:: getInstance()->listAll();
              $view = new AgregarPaciente();
              $usuario = PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername();
              $titulo = PDOConfiguracion::getInstance()->traer_titulo()[0][0];
              $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
              $view->show($partidos, $localidades,$obraSociales,$regionSanitaria,$generos,$tiposDoc,$usuario,$titulo, $permisos);
            }
        }
    }

    public function agregar_paciente(){

      if(empty($_POST['apellido']) && empty($_POST['nombre']) && empty($_POST['fecha_nac']) &&empty($_POST['lugar_nac']) && empty($_POST['partido']) && empty($_POST['localidad']) &&empty($_POST['domicilio']) && empty($_POST['partido']) && empty($_POST['genero']) &&empty($_POST['tiene_doc']) && empty($_POST['tipo_doc']) && empty($_POST['numero_documento']) && empty($_POST['telefono']) && empty($_POST['region_sanitaria']) && empty($_POST['numero_historia_clinica']) && empty($_POST['numero_carpeta']) && empty($_POST['obra_social'])){
           
             $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOPaciente::getInstance()->cantidad());
             $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
             $resources = array('resources'=> PDOPaciente::getInstance()->listarCantidad(1,$cantidad['cantidadElementos']),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' =>$permisos);
       
              $view = new ListarPaciente();
              $view->show($resources, $permisos);

      }
        $resources = PDOPaciente:: getInstance()->agregar_paciente($_POST['apellido'],$_POST['nombre'], $_POST['fecha_nac'],$_POST['lugar_nac'],$_POST['partido'],$_POST['localidad'],$_POST['genero'],$_POST['tiene_doc'],$_POST['tipo_doc'],$_POST['numero_documento'],$_POST['telefono'],$_POST['region_sanitaria'],$_POST['domicilio'],$_POST['numero_historia_clinica'],$_POST['numero_carpeta'],$_POST['obra_social']);

        $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOPaciente::getInstance()->cantidad());
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
       $resources =array('resources'=> PDOPaciente::getInstance()->listarCantidad(1,$cantidad['cantidadElementos']),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' =>$permisos);
       
        $view = new ListarPaciente();
        $view->show($resources, $permisos);
    }

    public function actualizar_paciente(){
      if(empty($_POST['apellido']) && empty($_POST['nombre']) && empty($_POST['fecha_nac']) &&empty($_POST['lugar_nac']) && empty($_POST['partido']) && empty($_POST['localidad']) &&empty($_POST['domicilio']) && empty($_POST['partido']) && empty($_POST['genero']) &&empty($_POST['tiene_doc']) && empty($_POST['tipo_doc']) && empty($_POST['numero_documento']) && empty($_POST['telefono']) && empty($_POST['region_sanitaria']) && empty($_POST['numero_historia_clinica']) && empty($_POST['numero_carpeta']) && empty($_POST['obra_social'])){
           
             $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOPaciente::getInstance()->cantidad());
             $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
             $resources = array('resources'=> PDOPaciente::getInstance()->listarCantidad(1,$cantidad['cantidadElementos']),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' =>$permisos);
       
              $view = new ListarPaciente();
              $view->show($resources, $permisos);

      }



        $datos=array("apellido" => $_POST['apellido'],
                    "nombre"  => $_POST['nombre'],
                    "fecha_nac" => $_POST['fecha_nac'],
                    "lugar_nac" => $_POST['lugar_nac'],
                    "partido" => $_POST['partido'],
                    "localidad" => $_POST['localidad'],
                    "domicilio" => $_POST['domicilio'],
                    "genero" =>  $_POST['genero'],
                    "tiene_doc" => $_POST['tiene_doc'],
                    "tipo_doc" => $_POST['tipo_doc'],
                    "numero_documento" => $_POST['numero_documento'],
                    "telefono" => $_POST['telefono'],
                    "region_sanitaria" => $_POST['region_sanitaria'],
                    "numero_historia_clinica" => $_POST['numero_historia_clinica'],
                    "numero_carpeta" => $_POST['numero_carpeta'],
                    "obra_social" => $_POST['obra_social']);
        
        PDOPaciente::getInstance()->actualizar_paciente($datos);
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
         $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOPaciente::getInstance()->cantidad());
        $resources =array('resources'=> PDOPaciente::getInstance()->listarCantidad(1,$cantidad['cantidadElementos']),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
        $view = new ListarPaciente();
        $view->show($resources, $permisos);

    }

     public function editarPaciente($id){
        $resources = array('resources' => (PDOPaciente::getInstance()->traer_paciente($id))[0],
                           'datos' =>  PDOPaciente::getInstance()->traer_datosVarios($id),
                           'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),
                           'partidos' => PDOPartido::getInstance()->listAll(),
                           'localidades' => PDOLocalidad::getInstance()->listAll(),
                           'region_sanitaria' => PDORegionSanitaria::getInstance()->listAll(),
                           'tipodoc' => PDOTipoDoc::getInstance()->listAll(),
                           'genero' => PDOGenero::getInstance()->listAll(),
                           'obrasocial' => PDOObraSocial::getInstance()->listAll(),
                           'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
        $view = new EditarPaciente();
        $view->show($resources, $permisos);
    }

    public function eliminarPaciente($id){
        $resources = PDOPaciente::getInstance()->eliminar_paciente($id);
        PacienteController:: getInstance()->listarTodosLosPacientes();
    }

    public function buscarPaciente (){
         if (sizeof($_SESSION) == 0){
            $view = new IniciarSesion();
            $view->show();
        }
        else{
            if($_SESSION["id"] == NULL){
                $view = new IniciarSesion();
                $view->show();
            }
            else{
              $view = new BuscarPaciente();
              $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
              $tiposDoc = PDOTipoDoc:: getInstance()->listAll();
              $datos=array('usuario' => (PDOUsuario::getInstance()->traer_usuario($_SESSION['id']))[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'tiposDoc' => $tiposDoc, 'mensajeError' => null);
              $view->show($datos);
            }
        }
    }

     public function buscar_paciente(){

        $apellido = $_POST['apellido'];
        $nombre = $_POST['nombre'];
        $tipo_doc = $_POST['tipo_doc'];
        $numero_documento = $_POST['numero_documento']; 
        $numero_historia_clinica = $_POST['numero_historia_clinica'];
        $resources = PDOPaciente::getInstance()->buscar_paciente($apellido, $nombre, $tipo_doc, $numero_documento, $numero_historia_clinica);
        //SI HAY RESULTADOS DE BUSQUEDA
        if($resources!=null){
           $datos=array('resources'=>$resources, 'usuario' => (PDOUsuario::getInstance()->traer_usuario($_SESSION['id']))[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'titulo1' => "Resultados de la búsqueda");
           $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
           $view = new ListarPaciente();
           $view->show($datos,$permisos);
        }
        else{
              $view = new BuscarPaciente();
              $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
              $tiposDoc = PDOTipoDoc:: getInstance()->listAll();
              $datos=array('usuario' => (PDOUsuario::getInstance()->traer_usuario($_SESSION['id']))[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'tiposDoc' => $tiposDoc, 'mensajeError' =>"No se encontraron resultados");
              $view->show($datos);
        }

     /*if(!empty($_POST['apellido']) || !empty($_POST['nombre']) || (!empty($_POST['numero_documento']) && !empty($_POST['tipo_doc']))){
                
           $datos=array('resources' => PDOPaciente::getInstance()->buscarPacientePorDatosPersonales($_POST['apellido'],$_POST['nombre'],$_POST['numero_documento'],$_POST['tipo_doc']),
             'usuario' => (PDOUsuario::getInstance()->traer_usuario($_SESSION['id']))[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
           $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
           $view = new ListarPaciente();
           $view->show($datos,$permisos);
           return true;
        }else 

           if( !empty($_POST['numero_historia_clinica'])){
               $datos=array('resources' => PDOPaciente::getInstance()->buscarPacienteHistoriaClinica($_POST['numero_historia_clinica']),
                          'usuario' => (PDOUsuario::getInstance()->traer_usuario($_SESSION['id']))[0]->getUsername());
                $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
                $view = new ListarPaciente();
                $view->show($datos,$permisos);
                return true;
        }else
             {

              $view = new BuscarPaciente();
              $datos=array('usuario' => (PDOUsuario::getInstance()->traer_usuario($_SESSION['id']))[0]->getUsername(), 
                           'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0],
                           'mensaje' => "Falta completar campos de Datos de paciente o Numero de Historia clinica");
              $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
              $view->show($datos,$permisos);
             return false;
             }
*/

     }
	






}
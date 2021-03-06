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
            $resources =array('resources'=> PDOPaciente::getInstance()->listarCantidad(1,$cantidad['cantidadElementos'],null),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'pagina' => 1, 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
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
        $resources =array('resources'=> PDOPaciente::getInstance()->listarCantidad($pagina,$cantidad['cantidadElementos'],null),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'pagina' => $pagina, 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
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
              $mensaje = null;
              $view->show($partidos, $localidades,$obraSociales,$regionSanitaria,$generos,$tiposDoc,$usuario,$titulo, $permisos, $mensaje);
            }
        }
    }

    public function agregar_paciente(){

      if(empty($_POST['apellido']) || empty($_POST['nombre']) || empty($_POST['fecha_nac']) || empty($_POST['lugar_nac']) || empty($_POST['partido']) || empty($_POST['localidad']) || empty($_POST['domicilio']) || empty($_POST['partido']) || empty($_POST['genero']) || empty($_POST['tiene_doc']) || empty($_POST['tipo_doc']) || empty($_POST['numero_documento']) || empty($_POST['telefono']) || empty($_POST['region_sanitaria']) || empty($_POST['numero_historia_clinica']) || empty($_POST['numero_carpeta']) || empty($_POST['obra_social'])){
           
             $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOPaciente::getInstance()->cantidad());
             $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
             $resources = array('resources'=> PDOPaciente::getInstance()->listarCantidad(1,$cantidad['cantidadElementos'],null),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' =>$permisos);
              $view = new AgregarPaciente();
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
              $mensaje = "No pueden quedar campos vacios";
              $view->show($partidos, $localidades,$obraSociales,$regionSanitaria,$generos,$tiposDoc,$usuario,$titulo, $permisos, $mensaje);
              return false;

      }
        $resources = PDOPaciente:: getInstance()->agregar_paciente($_POST['apellido'],$_POST['nombre'], $_POST['fecha_nac'],$_POST['lugar_nac'],$_POST['partido'],$_POST['localidad'],$_POST['genero'],$_POST['tiene_doc'],$_POST['tipo_doc'],$_POST['numero_documento'],$_POST['telefono'],$_POST['region_sanitaria'],$_POST['domicilio'],$_POST['numero_historia_clinica'],$_POST['numero_carpeta'],$_POST['obra_social']);

        $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOPaciente::getInstance()->cantidad());
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
       $resources =array('resources'=> PDOPaciente::getInstance()->listarCantidad(1,$cantidad['cantidadElementos'],null),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' =>$permisos);
       
        $view = new ListarPaciente();
        $view->show($resources, $permisos);
    }

    public function actualizar_paciente(){
      if(empty($_POST['apellido']) || empty($_POST['nombre']) || empty($_POST['fecha_nac']) || empty($_POST['lugar_nac']) || empty($_POST['partido']) || empty($_POST['localidad']) || empty($_POST['domicilio']) || empty($_POST['partido']) || empty($_POST['genero']) || empty($_POST['tiene_doc']) || empty($_POST['tipo_doc']) || empty($_POST['numero_documento']) || empty($_POST['telefono']) || empty($_POST['region_sanitaria']) || empty($_POST['numero_historia_clinica']) || empty($_POST['numero_carpeta']) || empty($_POST['obra_social'])){
           
             $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(PDOPaciente::getInstance()->cantidad());
             $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
             $resources = array('resources'=> PDOPaciente::getInstance()->listarCantidad(1,$cantidad['cantidadElementos'],null),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' =>$permisos);
       
              $view = new ListarPaciente();
              $view->show($resources, $permisos);
              return false;

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
        $resources =array('resources'=> PDOPaciente::getInstance()->listarCantidad(1,$cantidad['cantidadElementos'],null),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
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
        if (isset($_POST['apellido'])) {
          $apellido = $_POST['apellido'];
        }
        if (isset($_POST['nombre'])) {
          $nombre = $_POST['nombre'];
        }
        if (isset($_POST['tipo_doc'])) {
          $tipo_doc = $_POST['tipo_doc'];
        }
        if (isset($_POST['numero_documento'])) {
          $numero_documento = $_POST['numero_documento'];
        }
        if (isset($_POST['numero_historia_clinica'])) {
          $numero_historia_clinica = $_POST['numero_historia_clinica'];
        }
        if (isset($_GET['apellido'])) {
          $apellido = $_GET['apellido'];
        }
        if (isset($_GET['nombre'])) {
          $nombre = $_GET['nombre'];
        }
        if (isset($_GET['tipo_doc'])) {
          $tipo_doc = $_GET['tipo_doc'];
        }
        if (isset($_GET['numero_documento'])) {
          $numero_documento = $_GET['numero_documento'];
        }
        if (isset($_GET['numero_historia_clinica'])) {
          $numero_historia_clinica = $_GET['numero_historia_clinica'];
        }
        $pacientes = PDOPaciente::getInstance()->buscar_paciente($apellido, $nombre, $tipo_doc, $numero_documento, $numero_historia_clinica);
        $array = PDOPaciente::getInstance()->traer_consulta($apellido, $nombre, $tipo_doc, $numero_documento, $numero_historia_clinica);
        //SI HAY RESULTADOS DE BUSQUEDA
        if($pacientes!=null){
           if(!empty ($_GET['pagina'])){
            $pagina = $_GET['pagina'];
           }
           else{
            $pagina = 1;
           }
          $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
          $cantidad = PDOConfiguracion::getInstance()->cantDePaginas(array(array(count($pacientes))));
          $resources =array('resources'=> PDOPaciente::getInstance()->listarCantidad($pagina,$cantidad['cantidadElementos'],$array),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'pagina' => $pagina, 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'datos'=>$array, 'mensaje' => "Resultados de la búsqueda");
            $view = new ListarPaciente();

           $view->show($resources, $permisos);
        }
        else{
              $view = new BuscarPaciente();
              $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
              $tiposDoc = PDOTipoDoc:: getInstance()->listAll();
              $datos=array('usuario' => (PDOUsuario::getInstance()->traer_usuario($_SESSION['id']))[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'tiposDoc' => $tiposDoc, 'mensajeError' =>"No se encontraron resultados");
              $view->show($datos);
        }
     }
     
}
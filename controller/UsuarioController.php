<?php

class UsuarioController {
    
    private static $instance;
    public static $usuario;  //clase Usuario

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    public function setUsuario($usuario){

       self::$usuario =$usuario;
    }

     public function getUsuario(){

       return self::$usuario;
    }
    
    public function listResources(){
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
                $cantidad =PDOConfiguracion::getInstance()->cantDePaginas(PDOUsuario::getInstance()->cantidad());
                $resources = array('resources'=> PDOUsuario::getInstance()->listarCantidad(1,$cantidad['cantidadElementos']),
                'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),
                'cantidad' => $cantidad['cantidadPaginas'], 'pagina' => 1, 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
                $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
                $view = new SimpleResourceList();
                $view->show($resources, $permisos);
            }
        }

    }

    public function listarUsuarios(){
        if (empty($_GET['pagina'])){
            return false;
        }
        $pagina = $_GET['pagina'];
        $cantidad =PDOConfiguracion::getInstance()->cantDePaginas(PDOUsuario::getInstance()->cantidad());
        $resources = array('resources'=> PDOUsuario::getInstance()->listarCantidad($pagina,$cantidad['cantidadElementos']),'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),'cantidad' => $cantidad['cantidadPaginas'], 'pagina' => $pagina, 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
        $view = new SimpleResourceList();
        $view->show($resources, $permisos);
    }
    
    public function home($id){
        $view = new Home();
        if(empty($id)){
            $titulo = PDOConfiguracion::getInstance()->traer_titulo()[0][0];
            $descripcion = PDOConfiguracion::getInstance()->traer_descripcion()[0][0];
            $email = PDOConfiguracion::getInstance()->traer_email()[0][0];
            $view->inicioSinSesion($titulo,$descripcion,$email);
        }
        else
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);  
           $view->inicio(array('usuario' => PDOUsuario::getInstance()->traer_usuario($id)[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'descripcion' => PDOConfiguracion::getInstance()->traer_descripcion()[0][0], 'permisos' => $permisos));
    }
    public function registrarse(){
        if (sizeof($_SESSION) == 0){
            $view = new IniciarSesion();
            $view->show();
        }
        else{
            if($_SESSION["id"] == NULL){
                $view = new IniciarSesion();
                $view->show();
             }
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);     
        $view = new Registrarse();
        $view->show(array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos));
       }
    }

    public function agregarUsuario(){
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
        $view = new Registrarse();
        if(!empty($_POST['usuario']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['activo']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) ){
            if(PDOUsuario::getInstance()->existe_usuario($_POST['usuario'])){
                $view->show(array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'error' => 2));
                return false;
            }
            $usuario = $_POST['usuario'];
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $view->show(array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'error' => 3));
                return false;
            }
            //if(isset($_POST['password']))
            $password = $_POST['password'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $activo = $_POST['activo'];
            $resources = PDOUsuario::getInstance()->agregar_usuario($usuario, $email, $password, $nombre, $apellido, $activo);
            $this->listResources();
        }
        else{
            $view->show(array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'error' => 1));
                return false;
        }
    }

    public function actualizarUsuario($id){
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $activo = $_POST['activo']; 
        $resources = PDOUsuario::getInstance()->actualizar_usuario($usuario, $email, $nombre, $apellido, $activo, $id);
        $this->getInstance()->listResources();   
    }
    public function eliminarUsuario(){
        $id = $_GET["id"];
        if( $id != $_SESSION['id']){
            $resources = PDOUsuario::getInstance()->eliminar_usuario($id);
        }
        $this->getInstance()->listResources(); 
    }
    public function editarUsuario($id){
        $resources = PDOUsuario::getInstance()->traer_usuario($id);
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]); 
        $view = new EditarUsuario();
        $view->show(array('resources' => $resources[0],'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos));
    }

     public function iniciarSesion(){
        $view = new IniciarSesion();
        $titulo = PDOConfiguracion::getInstance()->traer_titulo()[0][0];
        $view->show($titulo);   
    }

    public function verificarDatos(){
        if(empty($_POST['usuario']) && empty($_POST['contraseña'])){
            return false;
        }
        $usuario = $_POST['usuario'];
        $password = $_POST['contraseña'];

        if( PDOUsuario::getInstance()->existe_usuario($usuario)){
            $usuarioObj = PDOUsuario::getInstance()->traer_usuario_por_username($usuario);
            $id = $usuarioObj->getId();
            if(PDOUsuario::getInstance()->verificar_password($usuario,$password)){
                    self::getInstance()->alta_sesion($usuario,$id);
                    self::getInstance()->setUsuario(PDOUsuario::getInstance()->traer_usuario_por_username($usuario));
                     $_SESSION['usuario'] =self::getInstance()->getUsuario()->getUsername();
                     $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]); 
                     $resources= array('usuario' => self::getInstance()->getUsuario()->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos);
                    //redireccionar a Home
                    $view = new Home();
                    $view->inicio($resources);
                    return true;
            }else{
                echo "Contraseña incorrecta";
                return false;
            }
               
        }
        echo "Usuario o Contraseña Incorrecta";
        return false;
    }
    public function alta_sesion($usuario,$id){
        if(!isset($_SESSION)){
            session_start();
         }else{
             session_destroy();
             session_start(); 
         }
        $_SESSION['id'] = $id;
        $_SESSION['usuario']= $usuario;

    }

    public function agregar_rol($id){
        //$user = PDOUsuario::getInstance()->traer_usuario($id);
        $view = new AgregarRol();
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]); 
        $resources= array('resources' => PDORol::getInstance()->traer_roles_noUsuario($id),
                           'misRoles' => PDORol::getInstance()->traer_roles_usuario($id),
                           'user' => PDOUsuario::getInstance()->traer_usuario($id),
                           'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
        $view->show($resources, $permisos); 
    }

    public function cerrarSesion(){
        session_destroy();
        $view = new Home();
        $titulo = PDOConfiguracion::getInstance()->traer_titulo()[0][0];
        $descripcion = PDOConfiguracion::getInstance()->traer_descripcion()[0][0];
        $email = PDOConfiguracion::getInstance()->traer_email()[0][0];
        $view->inicioSinSesion($titulo,$descripcion,$email);
    }

   public function buscarPorUsername(){
         if(empty($_POST['buscar'])){
            return false;
          }
         $datos= PDOUsuario:: getInstance()->buscarPorUsername($_POST['buscar']);
         $view= new BuscarUsuario();
         $view->show($datos);
    }
    public function tipoDeBusqueda(){
        if(empty($_POST['buscar'])){
            return false;
          }
        $datos; $view;
        if(strtolower ($_POST['buscar']) == "activo"){
            $datos= PDOUsuario:: getInstance()->buscarPorActivo(1);
        }else if(strtolower ($_POST['buscar']) == "bloqueado"){
            $datos= PDOUsuario:: getInstance()->buscarPorActivo(2);
        } else{
            $datos= PDOUsuario:: getInstance()->buscarPorUsername($_POST['buscar']);
        }
         $view= new BuscarUsuario();
         $view->show(array('resources' => $datos, 'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername()));

    }

    public function asignar_rol($id){
        $idRol= $_POST['idRol']; 
        $consulta = PDOUsuario::getInstance()->asignar_rol($id, $idRol);
        $this->getInstance()->agregar_rol($id); 
    }

    public function desasignar_rol($idU, $idR){
        $consulta = PDOUsuario::getInstance()->desasignar_rol($idU, $idR);

        $this->getInstance()->agregar_rol($idU);  
    }

    public function cambiar_estado($id, $estado){
        $consulta = PDOUsuario::getInstance()->cambiar_estado($id, $estado);
        $this->getInstance()->listResources();
    }

    public function traer_mis_permisos($u){
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
                $datos= PDOUsuario:: getInstance()->buscarPorUsername($u);
                $id= $datos[0]->getId();
                $consulta = PDOPermiso::getInstance()->traer_permisos_usuario($id);
                $view = new MisPermisos();
                $view->show(array('resources' => $consulta, 'usuario' =>PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]));
            }
        }
    }
    public function checkPermiso($permiso, $id){
        $consulta = PDOPermiso::getInstance()->traer_permisos_usuario($id);
        $tengoPermiso = false;
        foreach ($consulta as &$element) {
            if($permiso == $element->getNombre()){
                $tengoPermiso = true;
            }
        }
        return $tengoPermiso;
    }



}

    


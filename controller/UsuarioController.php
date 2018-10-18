<?php

class UsuarioController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    
    public function listResources(){
        $cantidadDeElementosPorPagina = PDOConfiguracion::getInstance()->cantidadDeElementos();
        $cantidadDeRegistros = PDOUsuario::getInstance()->cantidad();
        $cantElementos=$cantidadDeElementosPorPagina[0][0];
        $cantRegistros =$cantidadDeRegistros[0][0];
        $cantidadDePaginas = round(($cantRegistros / $cantElementos),0,PHP_ROUND_HALF_UP);
        $resources = PDOUsuario::getInstance()->listarCantidad(1,$cantElementos);
        $view = new SimpleResourceList();
        $view->show($resources,$cantidadDePaginas);
    }

    public function listarUsuarios(){
        if (empty($_GET['pagina'])){
            return false;
        }
        $pagina = $_GET['pagina'];
        $cantidadDeElementosPorPagina = PDOConfiguracion::getInstance()->cantidadDeElementos();
        $cantidadDeRegistros = PDOUsuario::getInstance()->cantidad();
        $cantElementos=$cantidadDeElementosPorPagina[0][0];
        $cantRegistros =$cantidadDeRegistros[0][0];
        $cantidadDePaginas = round(($cantRegistros / $cantElementos),0,PHP_ROUND_HALF_UP);


        $cantidad = PDOConfiguracion::getInstance()->cantidadDeElementos();
        $resources = PDOUsuario::getInstance()->listarCantidad($pagina,$cantElementos);
        $view = new SimpleResourceList();
        $cantElementos=$cantidad[0][0];
        $view->show($resources,$cantidadDePaginas);
    }
    
    public function home(){
        $view = new Home();
        $view->show();
    }
    public function registrarse(){
        $view = new Registrarse();
        $view->show();
    }

    public function agregarUsuario(){
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        if(isset($_POST['password']))
            $password = $_POST['password'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $activo = $_POST['activo'];     
        $resources = PDOUsuario::getInstance()->agregar_usuario($usuario, $email, $password, $nombre, $apellido, $activo);
        $view = new Home();
        $view->show();
    }
    public function actualizarUsuario($id){
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $activo = $_POST['activo']; 
        $resources = PDOUsuario::getInstance()->actualizar_usuario($usuario, $email, $nombre, $apellido, $activo,$id);
        $resources = PDOUsuario::getInstance()->listAll();
        $view = new SimpleResourceList();
        $view->show($resources);       
    }
    public function eliminarUsuario(){
        $id = $_GET["id"];
        $resources = PDOUsuario::getInstance()->eliminar_usuario($id);
        $resources = PDOUsuario::getInstance()->listAll();
        $view = new SimpleResourceList();
        $view->show($resources); 
    }
    public function editarUsuario($id){
        $resources = PDOUsuario::getInstance()->traer_usuario($id);
        $view = new EditarUsuario();
        $view->show($resources[0]);
    }

     public function iniciarSesion(){
        $view = new IniciarSesion();
        $view->show();   
    }

    public function verificarDatos(){
        if(empty($_POST['usuario']) && empty($_POST['contraseña'])){
            return false;
        }
        $usuario = $_POST['usuario'];
        $password = $_POST['contraseña'];

        if( PDOUsuario::getInstance()->existe_usuario($usuario)){
             
            if(PDOUsuario::getInstance()->verificar_password($usuario,$password)){
                    self::getInstance()->alta_sesion($usuario);
                    //redireccionar a Home
                    $view = new Home();
                    $view->inicio($_SESSION);
                    return true;
            }else{
                echo "Contraseña incorrecta";
                return false;
            }
               
        }
        echo "Usuario o Contraseña Incorrecta";
        return false;
    }
    public function alta_sesion($usuario){
        session_start();
        $_SESSION['sesion']= true;
        $_SESSION['usuario']= $usuario;

    }

    public function agregar_rol($id){
        $usuario = PDOUsuario::getInstance()->traer_usuario($id);
        $resources = PDORol::getInstance()->traer_roles();
        $misRoles = PDORol::getInstance()->traer_roles_usuario($id);
        $view = new AgregarRol();
        $view->show($usuario, $resources, $misRoles); 
    }

    public function cerrarSesion(){
        session_destroy();
        $view = new Home();
        $_SESSION['sesion']=false;
        $view->inicio($_SESSION);
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
         $view->show($datos);

    }

    // ARREGLAR LA PARTE DE VERIFICAR SI YA TIENE ROL
    public function asignar_rol($id){
        $idRol= $_POST['idRol']; 
     
      //  if( PDOUsuario::getInstance()->verificar_rol($id, $idRol)){
            $consulta = PDOUsuario::getInstance()->asignar_rol($id, $idRol);

            $usuario = PDOUsuario::getInstance()->traer_usuario($id);
            $resources = PDORol::getInstance()->traer_roles();
            $misRoles = PDORol::getInstance()->traer_roles_usuario($id);
            $view = new AgregarRol();
            $view->show($usuario, $resources, $misRoles); 
     /*   }
        else{
        
        }   */
    }

    public function desasignar_rol($idU, $idR){
        $consulta = PDOUsuario::getInstance()->desasignar_rol($idU, $idR);

        $usuario = PDOUsuario::getInstance()->traer_usuario($idU);
        $resources = PDORol::getInstance()->traer_roles();
        $misRoles = PDORol::getInstance()->traer_roles_usuario($idU);
        $view = new AgregarRol();
        $view->show($usuario, $resources, $misRoles); 
    }

    public function cambiar_estado($id, $estado){
        $consulta = PDOUsuario::getInstance()->cambiar_estado($id, $estado);

        //CONSULTAR PARA LLAMAR A LA FUNCTION LISTRESOURCES
        $resources = PDOUsuario::getInstance()->listAll();
        $view = new SimpleResourceList();
        $view->show($resources);
    }

    public function traer_mis_permisos($u){
        $datos= PDOUsuario:: getInstance()->buscarPorUsername($u);
        $id= $datos[0]->getId();
        $misRoles = PDORol::getInstance()->traer_roles_usuario($id);
        $consulta = PDOPermiso::getInstance()->traer_permisos_usuario($id,$misRoles);
        $view = new MisPermisos();
        $view->show($consulta);

    }


}

    


<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once('controller/LocalidadController.php');
require_once('model/PDORepository.php');
require_once('model/PDOLocalidad.php');
require_once('model/PDOPaciente.php');
require_once('model/Paciente.php');
require_once('model/Localidad.php');
require_once('view/TwigView.php');
require_once('view/Registrarse.php');
require_once('view/EditarUsuario.php');
require_once('view/SimpleResourceList.php');
require_once('view/Home.php');
require_once('view/HomeVerdadero.php');
require_once('view/IniciarSesion.php');
require_once('view/BuscarUsuario.php');
require_once('view/ListarPaciente.php');
require_once('view/AgregarPaciente.php');
require_once('view/EditarPaciente.php');
require_once('controller/UsuarioController.php');
require_once('controller/PacienteController.php');
require_once('model/PDOUsuario.php');
require_once('model/Usuario.php');




if(isset($_GET["action"])){
	if ($_GET["action"] == 'listResources'){
	    UsuarioController::getInstance()->listResources();
	}else if ($_GET["action"] == 'agregarUsuario'){
		UsuarioController::getInstance()->agregarUsuario();		
	}
	else if ($_GET["action"] == 'eliminarUsuario'){
		$id = $_GET["id"];
		UsuarioController::getInstance()->eliminarUsuario($id);
	}
	else if ($_GET["action"] == 'registrarse'){
		UsuarioController::getInstance()->registrarse();
	}
	else if ($_GET["action"] == 'editarUsuario'){
		$id= $_GET["id"];
		UsuarioController::getInstance()->editarUsuario($id);
	}
	else if ($_GET["action"] == 'actualizarUsuario'){
		$id= $_GET["id"];
		UsuarioController::getInstance()->actualizarUsuario($id);
	}
	else if ($_GET["action"] == 'iniciarSesion'){
		UsuarioController::getInstance()->iniciarSesion();
	}
	else if ($_GET["action"] == 'verificarDatos'){
		UsuarioController::getInstance()->verificarDatos();
	}
	else if ($_GET["action"] == 'cerrarSesion'){
		UsuarioController::getInstance()->cerrarSesion();
	}
	else if ($_GET["action"] == 'buscarUsuario'){
		UsuarioController:: getInstance()->tipoDeBusqueda();
		//UsuarioController::getInstance()->buscarPorUsername();
	}
	else if ($_GET["action"] == 'listarPacientes'){
		PacienteController:: getInstance()->listarTodosLosPacientes();
	}
    else if ($_GET["action"] == 'agregarPaciente'){
		PacienteController:: getInstance()->agregarPaciente();
	}
	else if ($_GET["action"] == 'agregar_paciente'){
		PacienteController:: getInstance()->agregar_paciente();
	}
	else if ($_GET["action"] == 'editarPaciente'){
		$id= $_GET["id"];
		PacienteController:: getInstance()->editarPaciente($id);
	}
	else if ($_GET["action"] == 'actualizarPaciente'){
		PacienteController:: getInstance()->actualizar_paciente();
	}
	else if ($_GET["action"] == 'eliminarPaciente'){
		PacienteController:: getInstance()->eliminarPaciente($_GET["id"]);
	}															
}	
else{
	    UsuarioController::getInstance()->home();
	}
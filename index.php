<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
 session_start();


require_once('controller/LocalidadController.php');
require_once('model/PDORepository.php');
require_once('model/PDOLocalidad.php');
require_once('model/PDOPaciente.php');
require_once('model/PDOPartido.php');
require_once('model/Paciente.php');
require_once('model/Partido.php');
require_once('model/Localidad.php');
require_once('model/RegionSanitaria.php');
require_once('model/ObraSocial.php');
require_once('model/Genero.php');
require_once('model/TipoDoc.php');
require_once('view/TwigView.php');
require_once('view/ListarRoles.php');
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
require_once('view/BuscarPaciente.php');
require_once('controller/UsuarioController.php');
require_once('controller/PacienteController.php');
require_once('controller/RolController.php');
require_once('controller/PermisoController.php');
require_once('model/PDOUsuario.php');
require_once('model/PDORol.php');
require_once('model/PDORegionSanitaria.php');
require_once('model/PDOObraSocial.php');
require_once('model/PDOGenero.php');
require_once('model/PDOTipoDoc.php');
require_once('model/Usuario.php');
require_once('controller/ConfiguracionController.php');
require_once('model/Configuracion.php');
require_once('model/Rol.php');
require_once('model/PDOConfiguracion.php');
require_once('model/Permiso.php');
require_once('model/PDOPermiso.php');
require_once('view/ModuloDeConfiguracion.php');
require_once('view/AgregarRol.php');
require_once('view/ListarPermisos.php');
require_once('view/MisPermisos.php');





if(isset($_GET["action"])){
	if ($_GET["action"] == 'listResources'){
		//if(UsuarioController::checkPermissions('paciente_show', $_SESSION('id'))
	    UsuarioController::getInstance()->listResources();
	}
	else if ($_GET["action"] == 'agregarUsuario'){
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
	else if ($_GET["action"] == 'moduloDeConfiguracion'){
		ConfiguracionController:: getInstance()->listarVariables();
	}
	else if ($_GET["action"] == 'buscarPaciente'){
		PacienteController:: getInstance()->buscarPaciente();
	}
	else if ($_GET["action"] == 'buscar_paciente'){
		PacienteController:: getInstance()->buscar_paciente();
	}
	else if ($_GET["action"] == 'modificarConfiguracion'){
		ConfiguracionController::getInstance()->modificarConfiguracion();
	}
	else if ($_GET["action"] == 'agregarRol'){
		$id= $_GET["id"];
		UsuarioController::getInstance()->agregar_rol($id);
	}
	else if ($_GET["action"] == 'asignarRol'){
		$id= $_GET["id"];
		UsuarioController::getInstance()->asignar_rol($id);
	}
	else if ($_GET["action"] == 'desasignarRol'){
		$idU= $_GET["idU"];
		$idR= $_GET["idR"];
		UsuarioController::getInstance()->desasignar_rol($idU, $idR);
	}
	else if ($_GET["action"] == 'cambiarEstado'){
		$id= $_GET["id"];
		$estado= $_GET["estado"];
		UsuarioController::getInstance()->cambiar_estado($id, $estado);
	}
	else if ($_GET["action"] == 'listarRoles'){
		RolController::getInstance()->listar_roles();
	}
	else if ($_GET["action"] == 'listarPermisos'){
		PermisoController::getInstance()->listar_permisos();
	}
	else if ($_GET["action"] == 'traerMisPermisos'){
		$us= $_GET["us"];
		UsuarioController::getInstance()->traer_mis_permisos($us);
	}																					
}	
else{
	    UsuarioController::getInstance()->home();
	}
<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
 session_start();


require_once('controller/LocalidadController.php');
require_once('controller/AtencionController.php');
require_once('model/PDORepository.php');
require_once('model/PDOLocalidad.php');
require_once('model/PDOPaciente.php');
require_once('model/PDOPartido.php');
require_once('model/PDOConsulta.php');
require_once('model/PDOMotivoConsulta.php');
require_once('model/PDOTratamientoFarmacologico.php');
require_once('model/PDOAcompanamiento.php');
require_once('model/Acompanamiento.php');
require_once('model/TratamientoFarmacologico.php');
require_once('model/MotivoConsulta.php');
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
require_once('view/IniciarSesion.php');
require_once('view/BuscarUsuario.php');
require_once('view/ListarPaciente.php');
require_once('view/ListarUsuarios.php');
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
require_once('model/Consulta.php');
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
require_once('view/Acceso.php');
require_once('view/RegistrarAtencion.php');
require_once('view/EditarAtencion.php');
require_once('view/ListarAtenciones.php');
require_once('view/Reportes.php');
require_once('view/GraficoPorCriterio.php');
require_once('view/AltaRol.php');
require_once('view/AltaPermiso.php');
require_once('view/EditarRol.php');
require_once('view/EditarPermiso.php');
require_once('view/ListadoPorCriterio.php');
require_once('model/ConsultaDetallada.php');



if(isset($_GET["action"])){
	if ($_GET["action"] == 'listResources'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else{
		 	if (UsuarioController::getInstance()->checkPermiso('usuario_show', $_SESSION['id'])){
	   			UsuarioController::getInstance()->listResources();
	   		} 
	   		else{
	   			//UsuarioController::getInstance()->home($_SESSION['id']);
	   			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
	   		}
	   	}	
	}
	else if ($_GET["action"] == 'agregarUsuario'){
		UsuarioController::getInstance()->agregarUsuario();		
	}
	else if ($_GET["action"] == 'eliminarUsuario'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('usuario_delete', $_SESSION['id'])){
			$id = $_GET["id"];
			UsuarioController::getInstance()->eliminarUsuario($id);
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}

	else if ($_GET["action"] == 'registrarse'){
		if (!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else{
			if(UsuarioController::getInstance()->checkPermiso('usuario_new', $_SESSION['id'])){
	    		UsuarioController::getInstance()->registrarse();
			}
			else{
				UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
			}	
		}
	}
	else if ($_GET["action"] == 'editarUsuario'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('usuario_update', $_SESSION['id'])){
			$id= $_GET["id"];
			UsuarioController::getInstance()->editarUsuario($id);
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}	
	}
	else if ($_GET["action"] == 'actualizarUsuario'){
		if(!empty($_GET["id"])){
		   $id= $_GET["id"];
		   UsuarioController::getInstance()->actualizarUsuario($id);
	    }
	}
	else if ($_GET["action"] == 'iniciarSesion'){
		$_SESSION['usuario']=UsuarioController::getInstance()->iniciarSesion();
	}
	else if ($_GET["action"] == 'verificarDatos'){
		UsuarioController::getInstance()->verificarDatos();
	}
	else if ($_GET["action"] == 'cerrarSesion'){
		UsuarioController::getInstance()->cerrarSesion();
	}
	else if ($_GET["action"] == 'listarPacientes'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('paciente_index', $_SESSION['id'])){
			PacienteController:: getInstance()->listarTodosLosPacientes();
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}
    else if ($_GET["action"] == 'agregarPaciente'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('paciente_new', $_SESSION['id'])){
			PacienteController:: getInstance()->agregarPaciente();
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
		
	}
	else if ($_GET["action"] == 'agregar_paciente'){
		PacienteController:: getInstance()->agregar_paciente();
	}
	else if ($_GET["action"] == 'editarPaciente'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('paciente_update', $_SESSION['id'])){
			$id= $_GET["id"];
			PacienteController:: getInstance()->editarPaciente($id);
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}
	else if ($_GET["action"] == 'actualizarPaciente'){
		PacienteController:: getInstance()->actualizar_paciente();
	}
	else if ($_GET["action"] == 'eliminarPaciente'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('paciente_destroy', $_SESSION['id'])){
			PacienteController:: getInstance()->eliminarPaciente($_GET["id"]);
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
		
	}
	else if ($_GET["action"] == 'moduloDeConfiguracion'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('configuracion_show', $_SESSION['id'])){
			ConfiguracionController:: getInstance()->listarVariables(0);
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}
	else if ($_GET["action"] == 'buscarPaciente'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('paciente_show', $_SESSION['id'])){
			PacienteController:: getInstance()->buscarPaciente();
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}
	else if ($_GET["action"] == 'buscar_paciente'){
		PacienteController:: getInstance()->buscar_paciente();
	}
	else if ($_GET["action"] == 'buscarUsuario'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('usuario_show', $_SESSION['id'])){
			UsuarioController:: getInstance()->buscarUsuario();
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}
	else if ($_GET["action"] == 'buscar_usuario'){
		UsuarioController:: getInstance()->buscar_usuario();
	}
	else if ($_GET["action"] == 'modificarConfiguracion'){
		ConfiguracionController::getInstance()->modificarConfiguracion();
	}
	else if ($_GET["action"] == 'agregarRol'){

		if(!empty($_GET["id"]))
		   UsuarioController::getInstance()->agregar_rol($_GET["id"]);
	}
	else if ($_GET["action"] == 'asignarRol'){
		if(!empty($_GET["id"]))
		   UsuarioController::getInstance()->asignar_rol($_GET["id"]);
	}
	else if ($_GET["action"] == 'desasignarRol'){
		if(!empty($_GET["idU"]) && !empty($_GET["idR"]))
		  UsuarioController::getInstance()->desasignar_rol($_GET["idU"], $_GET["idR"]);
	}
	else if ($_GET["action"] == 'cambiarEstado'){
		if(!empty($_GET["id"]) && !empty($_GET["estado"]))
		UsuarioController::getInstance()->cambiar_estado($_GET["id"], $_GET["estado"]);
	}
	else if ($_GET["action"] == 'listarRoles'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('paciente_show', $_SESSION['id'])){
			RolController::getInstance()->listar_roles();
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}
	else if ($_GET["action"] == 'listarPermisos'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('paciente_show', $_SESSION['id'])){
			PermisoController::getInstance()->listar_permisos();
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
		
	}
	else if ($_GET["action"] == 'traerMisPermisos'){
		$us= $_GET["us"];
		UsuarioController::getInstance()->traer_mis_permisos($us);
	}
	else if ($_GET["action"] == 'listarUsuarios'){
		UsuarioController::getInstance()->listarUsuarios();
	}
	else if ($_GET["action"] == 'listar_pacientes'){
		PacienteController::getInstance()->listarPacientes();
	}
	else if ($_GET["action"] == 'registrarAtencion'){
	    if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
         else if(UsuarioController::getInstance()->checkPermiso('paciente_show', $_SESSION['id'])){
		    AtencionController::getInstance()->registrarAtencion();
	   }
	   else{ UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);}
	}
	else if ($_GET["action"] == 'registrar_atencion'){
		AtencionController::getInstance()->registrar_atencion();
	}
	else if ($_GET["action"] == 'editarAtencion'){
		AtencionController::getInstance()->editarAtencion($_GET['id']);
	}
	else if ($_GET["action"] == 'editar_atencion'){
		AtencionController::getInstance()->editar_atencion();
	}
	else if ($_GET["action"] == 'eliminar_atencion'){
		AtencionController::getInstance()->eliminar_atencion();
	}
	else if ($_GET["action"] == 'listarAtenciones'){
		AtencionController::getInstance()->listarAtenciones($_GET['id']);
	}
	else if ($_GET["action"] == 'listar_atenciones'){
		AtencionController::getInstance()->listar_atenciones($_GET["id"]);
	}
	else if ($_GET["action"] == 'reportes'){
		AtencionController::getInstance()->reportes();
	}
	else if ($_GET["action"] == 'graficoPorCriterio'){
		AtencionController::getInstance()->graficoporCriterio();
	}
	else if ($_GET["action"] == 'altaRol'){
				if (!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else{
			if(UsuarioController::getInstance()->checkPermiso('usuario_new', $_SESSION['id'])){
	    		RolController::getInstance()->agregar_rol();
			}
			else{
				UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
			}	
		}
	}
	else if ($_GET["action"] == 'alta_rol'){
		RolController:: getInstance()->alta_rol();
	}
	else if ($_GET["action"] == 'eliminarRol'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('configuracion_show', $_SESSION['id'])){
			$id = $_GET["id"];
			RolController::getInstance()->eliminarRol($id);
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}
	else if ($_GET["action"] == 'editarRol'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('configuracion_show', $_SESSION['id'])){
			$id = $_GET["id"];
			RolController:: getInstance()->editar_rol($id);
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}
	else if ($_GET["action"] == 'actualizarRol'){
		$id= $_GET["id"];
        RolController::getInstance()->actualizarRol($id);
	}
	else if ($_GET["action"] == 'listadoPorCriterio'){
		AtencionController::getInstance()->listadoPorCriterio();
	}
	else if ($_GET["action"] == 'listadoPDF'){
		AtencionController::getInstance()->listadoPDF();
	}
	else if ($_GET["action"] == 'altaPermiso'){
				if (!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else{
			if(UsuarioController::getInstance()->checkPermiso('usuario_new', $_SESSION['id'])){
	    		PermisoController::getInstance()->agregar_permiso();
			}
			else{
				UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
			}	
		}
	}
	else if ($_GET["action"] == 'alta_permiso'){
		PermisoController:: getInstance()->alta_permiso();
	}
	else if ($_GET["action"] == 'eliminarPermiso'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('configuracion_show', $_SESSION['id'])){
			$id = $_GET["id"];
			PermisoController::getInstance()->eliminarPermiso($id);
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}
	else if ($_GET["action"] == 'editarPermiso'){
		if(!isset($_SESSION['id'])){
			UsuarioController::getInstance()->home(null);
		}
		else if(UsuarioController::getInstance()->checkPermiso('configuracion_show', $_SESSION['id'])){
			$id = $_GET["id"];
			PermisoController:: getInstance()->editar_permiso($id);
		}
		else{
			UsuarioController::getInstance()->accesoNoAutorizado($_SESSION['id']);
		}
	}		
	else if ($_GET["action"] == 'actualizarPermiso'){
		$id= $_GET["id"];
        PermisoController::getInstance()->actualizarPermiso($id);
	}																											
}	
else{
	if(empty($_SESSION['id'])){
	    UsuarioController::getInstance()->home(null);
	}
	else{
       UsuarioController::getInstance()->home($_SESSION['id']);

	}

}

//}
<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campues_digital";

// Obtener el ID del alumno a eliminar desde la solicitud
$numcontrol = isset($_REQUEST['codigo']) ? intval($_REQUEST['codigo']) : 0;

// Establecer conexión con la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión falló
if ($conexion->connect_error) {
	die("Connection failed: " . $conexion->connect_error);
}

// Verificar si el ID del alumno es válido
if ($numcontrol <= 0) {
	// Cerrar conexión y redirigir si el ID no es válido
	$conexion->close();
	header('Location: ver_alumnos.php');
	exit;
}

// Preparar consulta para verificar si el alumno existe
$stmt = $conexion->prepare("SELECT ID_Alumno FROM alumnos WHERE ID_Alumno = ?");
if (!$stmt) {
	// Registrar error si la preparación falla
	error_log('Error en la preparación de la consulta (SELECT ID_Alumno): ' . $conexion->error);
	$conexion->close();
	header('Location: ver_alumnos.php');
	exit;
}
$stmt->bind_param('i', $numcontrol);
$stmt->execute();
$stmt->store_result();

// Verificar si el alumno existe
if ($stmt->num_rows < 1) {
	$stmt->close();
	$conexion->close();
	header('Location: ver_alumnos.php');
	exit;
}
$stmt->close();

// Preparar consulta para eliminar el alumno
$del = $conexion->prepare("DELETE FROM alumnos WHERE ID_Alumno = ?");
if (!$del) {
	// Registrar error si la preparación falla
	error_log('Error en la preparación de la eliminación (DELETE): ' . $conexion->error);
	$conexion->close();
	header('Location: ver_alumnos.php');
	exit;
}
$del->bind_param('i', $numcontrol);
$success = $del->execute();

// Cerrar consultas y conexión
$del->close();
$conexion->close();

// Registrar error si la eliminación falló
if (!$success) {
	error_log('Error al eliminar alumno ID ' . $numcontrol . ': ' . $conexion->error);
}

// Redirigir a la página de ver alumnos
header('Location: ver_alumnos.php');
exit;

?>

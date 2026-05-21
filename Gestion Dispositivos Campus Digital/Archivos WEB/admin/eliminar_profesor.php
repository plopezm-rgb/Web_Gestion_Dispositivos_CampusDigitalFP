<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campues_digital";

// Obtener el ID del profesor a eliminar desde la solicitud
$numcontrol = isset($_REQUEST['codigo']) ? intval($_REQUEST['codigo']) : 0;

// Establecer conexión con la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión falló
if ($conexion->connect_error) {
	die("Connection failed: " . $conexion->connect_error);
}

// Verificar si el ID del profesor es válido
if ($numcontrol <= 0) {
	// Cerrar conexión y redirigir si el ID no es válido
	$conexion->close();
	header('Location: ver_profesores.php');
	exit;
}

// Preparar consulta para verificar si el profesor existe
$stmt = $conexion->prepare("SELECT id FROM profesores WHERE id = ?");
if (!$stmt) {
	// Registrar error si la preparación falla
	error_log('Error en la preparación de la consulta (SELECT id): ' . $conexion->error);
	$conexion->close();
	header('Location: ver_profesores.php');
	exit;
}
$stmt->bind_param('i', $numcontrol);
$stmt->execute();
$stmt->store_result();

// Verificar si el profesor existe
if ($stmt->num_rows < 1) {
	// Cerrar consulta y conexión, redirigir
	$stmt->close();
	$conexion->close();
	header('Location: ../profesor/ver_profesores.php');
	exit;
}
$stmt->close();

// Preparar consulta para eliminar el profesor
$del = $conexion->prepare("DELETE FROM profesores WHERE id = ?");
if (!$del) {
	// Registrar error si la preparación falla
	error_log('Error en la preparación de la eliminación (DELETE): ' . $conexion->error);
	$conexion->close();
	header('Location: ver_profesores.php');
	exit;
}
$del->bind_param('i', $numcontrol);
$success = $del->execute();

// Registrar error si la eliminación falló
if (!$success) {
	error_log('Error al eliminar profesor ID ' . $numcontrol . ': ' . $conexion->error);
}

// Redirigir a la página de ver profesores
header('Location: ver_profesores.php');
exit;

// Cerrar consulta y conexión
$del->close();
$conexion->close();

?>

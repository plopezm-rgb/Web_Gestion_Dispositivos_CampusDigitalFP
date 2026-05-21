<?php
// Este script elimina un equipo de la base de datos basado en el ID proporcionado en la solicitud.

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campues_digital";

// Obtener el ID del equipo desde la solicitud y convertirlo a entero
$numcontrol = isset($_REQUEST['codigo']) ? intval($_REQUEST['codigo']) : 0;

// Establecer conexión con la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión falló
if ($conexion->connect_error) {
	die("Connection failed: " . $conexion->connect_error);
}

// Validar que el ID sea válido (mayor que 0)
if ($numcontrol <= 0) {
	// Cerrar conexión y redirigir si el ID no es válido
	$conexion->close();
	header('Location: ver_equipos.php');
	exit;
}

// Preparar consulta para verificar si el equipo existe
$stmt = $conexion->prepare("SELECT ID_Equipo FROM equipos WHERE ID_Equipo = ?");
if (!$stmt) {
	// Registrar error si la preparación falla
	error_log('Error en la preparación de la consulta (SELECT ID_Equipo): ' . $conexion->error);
	$conexion->close();
	header('Location: ver_equipos.php');
	exit;
}
$stmt->bind_param('i', $numcontrol);
$stmt->execute();
$stmt->store_result();

// Verificar si el equipo existe
if ($stmt->num_rows < 1) {
	// Cerrar recursos y redirigir si no existe
	$stmt->close();
	$conexion->close();
	header('Location: ../profesor/ver_equipos.php');
	exit;
}
$stmt->close();

// Preparar consulta para eliminar el equipo
$del = $conexion->prepare("DELETE FROM equipos WHERE ID_Equipo = ?");
// Nota: La línea anterior se repite, pero se mantiene como en el código original
if (!$del) {
	// Registrar error si la preparación falla
	error_log('Error en la preparación de la eliminación (DELETE): ' . $conexion->error);
	$conexion->close();
	header('Location: ver_equipos.php');
	exit;
}
$del->bind_param('i', $numcontrol);
$success = $del->execute();
if (!$success) {
	// Registrar error si la eliminación falla
	error_log('Error al eliminar equipo ID ' . $numcontrol . ': ' . $conexion->error);
}

// Redirigir a la página de ver equipos después de la operación
header('Location: ver_equipos.php');
exit;

// Cerrar recursos
$del->close();
$conexion->close();

?>

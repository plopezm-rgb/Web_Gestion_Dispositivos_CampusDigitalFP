<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campues_digital";

// Obtener el ID de la avería a eliminar desde la solicitud
$numcontrol = isset($_REQUEST['codigo']) ? intval($_REQUEST['codigo']) : 0;

// Establecer conexión con la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión falló
if ($conexion->connect_error) {
	die("Connection failed: " . $conexion->connect_error);
}

// Verificar si el ID de la avería es válido
if ($numcontrol <= 0) {
	// Cerrar conexión y redirigir si el ID no es válido
	$conexion->close();
	header('Location: ver_informe.php');
	exit;
}

// Preparar consulta para verificar si la avería existe
$stmt = $conexion->prepare("SELECT ID_Averia FROM averias WHERE ID_Averia = ?");
if (!$stmt) {
	// Registrar error si la preparación falla
	error_log('Error en la preparación de la consulta (SELECT ID_Averia): ' . $conexion->error);
	$conexion->close();
	header('Location: ver_informe.php');
	exit;
}
$stmt->bind_param('i', $numcontrol);
$stmt->execute();
$stmt->store_result();

// Verificar si la avería existe
if ($stmt->num_rows < 1) {
	// Cerrar consulta y conexión, redirigir
	$stmt->close();
	$conexion->close();
	header('Location: ../profesor/ver_informe.php');
	exit;
}
$stmt->close();

// Preparar consulta para eliminar la avería
$del = $conexion->prepare("DELETE FROM averias WHERE ID_Averia = ?");
if (!$del) {
	// Registrar error si la preparación falla
	error_log('Error en la preparación de la eliminación (DELETE): ' . $conexion->error);
	$conexion->close();
	header('Location: ver_informe.php');
	exit;
}
$del->bind_param('i', $numcontrol);
$success = $del->execute();

// Registrar error si la eliminación falló
if (!$success) {
	error_log('Error al eliminar avería ID ' . $numcontrol . ': ' . $conexion->error);
}

// Redirigir a la página de ver informes
header('Location: ver_informe.php');
exit;

// Cerrar consulta y conexión
$del->close();
$conexion->close();

?>

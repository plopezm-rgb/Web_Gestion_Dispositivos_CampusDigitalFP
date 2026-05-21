<?php
// Iniciar sesión para verificar autenticación
session_start();

// Verificar si hay sesión activa y si el usuario es un profesor
if (!isset($_SESSION['usuario']) || $_SESSION['rango'] !== 'profesor') {
    // Redirigir al login si no está autenticado o no es profesor
    header('Location: ../index.php');
    exit();
}

// Verificar si se envió el formulario por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y validar la nueva contraseña
    $nueva_contrasena = trim($_POST['nueva_contrasena'] ?? '');

    if (empty($nueva_contrasena)) {
        die("Error: La contraseña no puede estar vacía.");
    }

    // Configuración de la conexión a la base de datos
    $servidor = "localhost";
    $usuario_bd = "root";
    $clave_bd = "";
    $nombre_bd = "campues_digital";

    // Establecer conexión con la base de datos
    $conexion = new mysqli($servidor, $usuario_bd, $clave_bd, $nombre_bd);

    // Verificar si la conexión falló
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Actualizar contraseña del profesor logueado
    $consulta = $conexion->prepare("UPDATE profesores SET contraseña = ? WHERE nombre_usuario = ?");
    $consulta->bind_param("ss", $nueva_contrasena, $_SESSION['usuario']);

    if ($consulta->execute()) {
        // Mostrar mensaje de éxito y redirigir
        echo "<script>
                alert('Contraseña actualizada correctamente.');
                window.location.href = 'profesor.php';
              </script>";
    } else {
        // Mostrar mensaje de error y volver atrás
        echo "<script>
                alert('Error al actualizar la contraseña.');
                window.history.back();
              </script>";
    }

    // Cerrar recursos de la base de datos
    $consulta->close();
    $conexion->close();

} else {
    // Si se accede directamente sin POST, redirigir al perfil
    header('Location: profesor.php');
    exit();
}
?>

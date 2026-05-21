$<?php
/*
 * Archivo: php/login.php
 * Descripción: Procesa el formulario de login (POST). Valida las credenciales
 *              contra la base de datos y crea la sesión correspondiente.
 * Entradas esperadas (POST): username, password, rango
 * Salidas: Redirección a la página de perfil según rol o al login en caso de fallo.
 * Notas de seguridad: Actualmente las contraseñas se comparan en claro.
 *               Se recomienda usar password_hash/password_verify y consultas preparadas.
 */
session_start();

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campues_digital";

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
} 

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['username'];
    $contrasena = $_POST['password'];
    $rango = $_POST['rango'];
    
    // Preparar la consulta según el rango seleccionado
    switch($rango) {
        case 'admin':
            $tabla = 'administrador';
            break;
        case 'profesor':
            $tabla = 'profesores';
            break;
        case 'alumno':
            $tabla = 'alumnos';
            break;
        default:
            die("Rango no válido");
    }   

    // Preparar la consulta SQL
    $consulta = $conexion->prepare("SELECT * FROM $tabla WHERE nombre_usuario = ? AND contraseña = ?");
    $consulta->bind_param("ss", $nombre_usuario, $contrasena);
    $consulta->execute();
    $result = $consulta->get_result();
    
    if ($result->num_rows > 0) {
        // Login exitoso
        $_SESSION['usuario'] = $nombre_usuario;
        $_SESSION['rango'] = $rango;
        
        // Redirigir según el rango
        switch($rango) {
            case 'admin':
                header("Location: ../admin/admin.php");
                break;
            case 'profesor':
                header("Location: ../profesor/profesor.php");
                break;
            case 'alumno':
                header("Location: ../alumno/alumno.php");
                break;
        }
        exit();
    } else {
        header("location: ../index.php");
        exit();
    }
    
    $consulta->close();
}

$conexion->close();


?>  
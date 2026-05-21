<?php
// Iniciar sesión para verificar autenticación
session_start();

// Verificar si hay sesión activa y si el usuario es un profesor
if (!isset($_SESSION['usuario']) || $_SESSION['rango'] !== 'profesor') {
    // Redirigir al login si no está autenticado o no es profesor
    header('Location: ../index.php');
    exit();
}

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campues_digital";

// Establecer conexión con la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión falló
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

// Obtener detalles del profesor logueado
$stmt = $conexion->prepare("SELECT * FROM profesores WHERE nombre_usuario = ?");
$stmt->bind_param("s", $_SESSION['usuario']);
$stmt->execute();
$resultado = $stmt->get_result();
$profesor = $resultado->fetch_assoc();
$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">           
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor Panel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body> 
    <header>
        <img src="../img/logo_completo_negativp.png" alt="Logo" class="logo">
        <h1 style="color: aliceblue;" id="admin-text">Profesor: <?php echo htmlspecialchars($profesor['nombre'] ?? $_SESSION['usuario']); ?></h1>
        <button onclick="location.href='../index.php'" class="Btn"><div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div><div class="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Logout</div></button>
    </header> 

    <nav>
        <div class="admin-menu">
            <a href="ver_alumnos.php" class="menu-item">Alumnos</a>
            <a href="ver_equipos.php" class="menu-item">Equipos</a>
            <a href="ver_informe.php" class="menu-item">Informe</a>
        </div>
    </nav>
        <div class="user-info">
            <h3>Información del Profesor</h3>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($profesor['nombre'] ?? 'No disponible'); ?></p>
            <p><strong>Usuario:</strong> <?php echo htmlspecialchars($profesor['nombre_usuario'] ?? 'No disponible'); ?></p>
            <p>
                <button onclick="document.getElementById('formularioContrasena').style.display='block'">
                    Cambiar contraseña
                </button>
            </p>

            <!-- Formulario oculto -->
            <div id="formularioContrasena" style="display:none; margin-top:15px;">
                <form action="cambiar_contrasena.php" method="POST">
                    <label>Nueva contraseña:</label><br>
                    <input type="password" name="nueva_contrasena" required><br><br>
                    <button type="submit">Guardar nueva contraseña</button>
                </form>
            </div>

        </div>
</body>
</html>
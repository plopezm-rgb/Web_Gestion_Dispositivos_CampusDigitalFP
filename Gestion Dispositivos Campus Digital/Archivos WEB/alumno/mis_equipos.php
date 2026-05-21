<?php
// Iniciar sesión para verificar autenticación
session_start();

// Verificar si hay sesión activa y si el usuario es un alumno
if (!isset($_SESSION['usuario']) || $_SESSION['rango'] !== 'alumno') {
    // Redirigir al login si no está autenticado o no es alumno
    header('Location: ../index.php');
    exit();
}

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campues_digital";

// Establecer conexión con la base de datos
$connexion = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión falló
if ($connexion->connect_error) {
    die("Error de conexión: " . $connexion->connect_error);
}

// Obtener ID del alumno logueado
$stmt_alumno = $connexion->prepare("SELECT ID_Alumno FROM alumnos WHERE nombre_usuario = ?");
$stmt_alumno->bind_param("s", $_SESSION['usuario']);
$stmt_alumno->execute();
$result_alumno = $stmt_alumno->get_result();
$alumno = $result_alumno->fetch_assoc();
$id_alumno = $alumno['ID_Alumno'];
$stmt_alumno->close();

// Consultar equipos asignados al alumno, uniendo con aulas para obtener el nombre del aula
$sql_equipos = "SELECT e.ID_Equipo, e.Nombre, e.Tipo, a.Nombre AS Aula_Nombre FROM equipos e LEFT JOIN aulas a ON e.ID_Aula = a.ID_Aula WHERE e.ID_Alumno = ?";
$stmt_equipos = $connexion->prepare($sql_equipos);
$stmt_equipos->bind_param("i", $id_alumno);
$stmt_equipos->execute();
$result_equipos = $stmt_equipos->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Equipos - Alumno</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body> 
    <header>
        <img src="../img/logo_completo_negativp.png" alt="Logo" class="logo">
        <h1 style="color: aliceblue;" id="admin-text">Alumno</h1>
        <button onclick="location.href='../index.php'" class="Btn"><div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div><div class="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Logout</div></button>
    </header> 

    <nav>
        <div class="admin-menu">
            <a href="alumno.php" class="menu-item" style="text-align: center;">VOLVER A PERFIL</a>
        </div>
    </nav>
    <br>

    <table class="tabla">
        <tr>
            <td>ID Equipo</td>
            <td>Nombre</td>
            <td>Tipo</td>
            <td>Aula</td>
            </tr>

        <?php
        // Mostrar cada equipo en una fila de la tabla
        while($mostrar = $result_equipos->fetch_assoc()){
        ?>

        <tr>
            <td><?php echo $mostrar['ID_Equipo'] ?></td>
            <td><?php echo $mostrar['Nombre'] ?></td>
            <td><?php echo $mostrar['Tipo'] ?></td>
            <td><?php echo $mostrar['Aula_Nombre'] ?></td>
        </tr>

        <?php
        }
        ?>
    </table>

    <?php
        $stmt_equipos->close();
        $connexion->close();
    ?>

</body>
</html>
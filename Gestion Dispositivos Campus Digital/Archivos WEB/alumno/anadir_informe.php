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
$conexion = new mysqli($servername, $username, $password, $dbname);

// Obtener ID del alumno actual para filtrar equipos
$stmt = $conexion->prepare("SELECT ID_Alumno FROM alumnos WHERE nombre_usuario = ?");
$stmt->bind_param("s", $_SESSION['usuario']);
$stmt->execute();
$result = $stmt->get_result();
$alumno = $result->fetch_assoc();
$id_alumno = $alumno['ID_Alumno'];
$stmt->close();

?>

<!DOCTYPE html>
<html>           
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Campus Digital FP</title>
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


        <form action="#" name="campues_digital" method="post">

        <select id="seleccion" name="ID_Equipo" required>
            <?php
            // Consultar solo los equipos asignados al alumno actual
            $stmt = $conexion->prepare("SELECT ID_Equipo, Nombre FROM equipos WHERE ID_Alumno = ?");
            $stmt->bind_param("i", $id_alumno);
            $stmt->execute();
            $equipos_result = $stmt->get_result();
            
            if ($equipos_result && $equipos_result->num_rows > 0) {
                while ($equipo = $equipos_result->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($equipo['ID_Equipo']) . '">' . 
                         htmlspecialchars($equipo['Nombre']) . '</option>';
                }
            } else {
                echo '<option value="">No tienes equipos asignados</option>';
            }
            $stmt->close();
            ?>
        </select><br><br>
        <textarea name="descripcion" placeholder="Descripcion" ></textarea><br><br>
        <input type="date" name="Fecha" ><br><br>
        <select id="seleccion" name="Estado" required>
            <option value="Pendiente">Pendiente</option>
            <option value="Reparado">Reparado</option>
            <option value="En revisión">En revisión</option>
        </select><br><br>



        <input type="submit" name="registrar" >
        <input type="reset" value="cancelar">
        </form>



    </body>

<?php
// Procesar el formulario cuando se envía
if (isset($_POST['registrar'])){

    // Obtener datos del formulario
    $ID_Equipo = $_POST ['ID_Equipo'];
    $descripcion = $_POST['descripcion'];
    $Fecha = $_POST['Fecha'];
    $Estado = $_POST['Estado'];

    // Insertar la avería en la base de datos
    $meterdatos = "INSERT INTO averias (ID_Equipo ,Descripcion,Fecha, Estado) VALUES ('$ID_Equipo ', '$descripcion','$Fecha', '$Estado')";

    $resultado = mysqli_query($conexion, $meterdatos);

    // Mostrar mensaje según el resultado
    if($resultado){
        echo "<script>alert('Usuario registrado correctamente');</script>";
    } else {
        echo "<script>alert('Error al registrar el usuario');</script>";
    }
}



?>










</html>
<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campues_digital";

// Establecer conexión con la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);

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
            <h1 style="color: aliceblue;" id="admin-text">Admin</h1>
            <button onclick="location.href='../index.php'" class="Btn"><div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div><div class="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Logout</div></button>
        </header>
        <nav>
            <div class="admin-menu">
                <a href="admin.php" class="menu-item" style="text-align: center;">VOLVER A PERFIL</a>
                <a href="ver_informe.php" class="menu-item" style="text-align: center;">Ver informes</a>
            </div>
        </nav>


        <!-- Formulario para añadir un nuevo informe de avería -->
        <form action="#" name="campues_digital" method="post">

        <!-- Seleccionar equipo afectado -->
        <select id="seleccion" name="ID_Equipo" required>
            <?php
            // Consultar equipos disponibles
            $equipos_resultados = $conexion->query("SELECT ID_Equipo, Nombre FROM equipos");
            if ($equipos_resultados && $equipos_resultados->num_rows > 0) {
                while ($equipos = $equipos_resultados->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($equipos['ID_Equipo']) . '">' . htmlspecialchars($equipos['Nombre']) . '</option>';
                }
            } else {
                echo '<option value="">No hay equipos disponibles</option>';
            }
        ?></select><br><br>
        <textarea name="descripcion" placeholder="Descripcion" ></textarea><br><br>
        <input type="date" name="Fecha" ><br><br>
        <!-- Seleccionar estado de la avería -->
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

// Procesar el formulario si se ha enviado
if (isset($_POST['registrar'])){

    // Obtener datos del formulario
    $ID_Equipo = $_POST ['ID_Equipo'];
    $descripcion = $_POST['descripcion'];
    $Fecha = $_POST['Fecha'];
    $Estado = $_POST['Estado'];

    // Consulta para insertar la nueva avería
    $meterdatos = "INSERT INTO averias (ID_Equipo ,Descripcion,Fecha, Estado) VALUES ('$ID_Equipo ', '$descripcion','$Fecha', '$Estado')";

    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $meterdatos);

    // Mostrar mensaje según el resultado
    if($resultado){
        echo "<script>alert('Informe registrado correctamente');</script>";
    } else {
        echo "<script>alert('Error al registrar el informe');</script>";
    }
}



?>










</html>
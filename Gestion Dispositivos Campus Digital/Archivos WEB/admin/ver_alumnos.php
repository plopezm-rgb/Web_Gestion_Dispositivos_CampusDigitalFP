<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campues_digital";

// Establecer conexión con la base de datos
$connexion = new mysqli($servername, $username, $password, $dbname);

?>

<!DOCTYPE html>
<html lang="en">           
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
            <a href="anadir_alumnos.php" class="menu-item" style="text-align: center;">Añadir alumnos</a>
        </div>
        <form action="eliminar_alumno.php" method="POST">
			<label for=""></label><br>
			<select name="codigo" id="codigo" required>
            <option value="">-- Selecciona un alumno --</option>
            <?php
            // Obtener la lista de alumnos para el select de eliminación
            $sql = "SELECT ID_Alumno, Nombre, Apellido FROM alumnos ORDER BY Nombre ASC";
            $resultado = $connexion->query($sql);

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo '<option value="' . $fila['ID_Alumno'] . '">' . $fila['Nombre'] . ' ' . $fila['Apellido'] . '</option>';
                }
            } else {
                echo '<option value="">No hay alumnos disponibles</option>';
            }

            ?>
        </select><input type="submit" value="Eliminar" name="eliminado" id="boton" style="background-color:#FF6666">
	    </form>
    </nav>
    <br>

    <table class="tabla">
        <tr>

            <td>Nombre</td>
            <td>Apellido</td>
            <td>Aula</td>
            <td>Usuario</td>
        </tr>

        <?php
        // Consultar todos los alumnos para mostrar en la tabla, uniendo con aulas para obtener el nombre del aula
        $sql = "SELECT al.Nombre, al.Apellido, a.Nombre AS Aula_Nombre, al.nombre_usuario
                FROM alumnos al
                LEFT JOIN aulas a ON al.ID_Aula = a.ID_Aula";
        $alumnos = mysqli_query($connexion, $sql);

        while ($alumno = mysqli_fetch_array($alumnos)) {
        ?>

        <tr>

            <td><?php echo $alumno['Nombre'] ?></td>
            <td><?php echo $alumno['Apellido'] ?></td>
            <td><?php echo $alumno['Aula_Nombre'] ?></td>
            <td><?php echo $alumno['nombre_usuario'] ?></td>
        </tr>

        <?php
        }
        ?>
    </table>

</body>
</html>

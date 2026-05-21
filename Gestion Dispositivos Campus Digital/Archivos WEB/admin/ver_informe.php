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
            <a href="anadir_informe.php" class="menu-item" style="text-align: center;">Añadir informe</a>
        </div>
        <form action="eliminar_averias.php" method="POST">
			<label for="">Ingresa ID para eliminar:</label><br>
			<input type="text" name="codigo"><input type="submit" value="Eliminar" name="eliminado" id="boton" style="background-color: #FF6666">
	    </form>
    </nav>
    <br>

    <table class="tabla">
        <tr>
            <td>ID</td>
            <td>Equipo</td>
            <td>Descripcion</td>
            <td>Fecha</td>
            <td>Estado</td>
        </tr>

        <?php
        // Consultar todas las averías para mostrar en la tabla, uniendo con equipos para obtener el nombre del equipo
        $sql = "SELECT av.ID_Averia, e.Nombre AS Equipo_Nombre, av.Descripcion, av.Fecha, av.Estado
                FROM averias av
                LEFT JOIN equipos e ON av.ID_Equipo = e.ID_Equipo";
        $result = mysqli_query($connexion, $sql);

        while ($mostrar = mysqli_fetch_array($result)) {
        ?>

        <tr>
            <td><?php echo $mostrar['ID_Averia'] ?></td>
            <td><?php echo $mostrar['Equipo_Nombre'] ?></td>
            <td><?php echo $mostrar['Descripcion'] ?></td>
            <td><?php echo $mostrar['Fecha'] ?></td>
            <td><?php echo $mostrar['Estado'] ?></td>
        </tr>

        <?php
        }
        ?>
    </table>

</body>
</html>

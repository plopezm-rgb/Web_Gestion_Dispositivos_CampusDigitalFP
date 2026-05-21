<?php
/*
 * Archivo: index.php
 * Descripción: Página de login pública. Muestra el formulario de acceso y
 *              mensajes de error recibidos por GET.
 * Entradas esperadas (GET): error - mensaje de error para mostrar al usuario
 * Salidas: HTML del formulario de login
 * Notas: El formulario envía sus datos a "php/login.php" mediante POST.
 */
// Mostrar mensaje de error si viene por GET
$mensaje_error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestor de dispositivos</title>
    <link rel="stylesheet" href="css/style.css">   
</head>
<body>
<div class="login-container">
    <div class="logo-section">
        <center><img src="img/campus_loco.png" alt="Campus Digital FP Logo" style="width: 75%; height: auto; " ></center><br>
    </div>
    <div class="login-box">
        <?php if ($mensaje_error): ?>
            <div class="error-message"><?php echo htmlspecialchars($mensaje_error); ?></div>
        <?php endif; ?>

        <!-- Enviar el formulario al php que procesa el login -->
        <form method="POST" action="php/login.php">
            <h3>Log-in</h3><br>
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <!--  -->
                <input type="text" id="usuario" name="username" required>
                <span style="color: red; margin-left: -15px;">*</span>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <center>
                <select id="rango" name="rango">
                    <option value="admin">Administrador</option>
                    <option value="profesor">Profesor</option>
                    <option value="alumno">Alumno</option>
                </select>
                </center>
            </div>
            <div class="remember-me">
                <label>
                    <input type="checkbox" name="remember_me" value="1">
                    Remember Me
                </label>
            </div>

            <div style="margin-bottom: 20px;">
                <button type="submit" class="login-button">Login</button>
            </div>

            <div class="separator">OR</div>

            <div>
                <a href="https://campusdigitalfp.com/contacto/">Contactanos</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
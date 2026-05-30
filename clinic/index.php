<?php 
include 'db.php'; 

$error_login = ""; // Variable para guardar el mensaje

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // --- VULNERABILIDAD SQL INJECTION (Para tu laboratorio) ---
    // Esta consulta es vulnerable porque las variables se meten directamente
    $sql = "SELECT * FROM usuarios WHERE username = '$user' AND password = '$pass'";
    
    try {
        $stmt = $db->query($sql);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $_SESSION['username'] = $usuario['username'];
            $_SESSION['rol'] = $usuario['rol'];
            header("Location: menu.php");
            exit();
        } else {
            // Si no hay resultados, las credenciales están mal
            $error_login = "❌ Usuario o contraseña incorrectos.";
        }
    } catch (Exception $e) {
        // En auditoría, esto revelaría errores de sintaxis SQL
        $error_login = "⚠️ Error en el sistema: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Seguro | Clínica Plus</title>
    <link rel="stylesheet" href="static/estilos.css">
    <link href="https://googleapis.com" rel="stylesheet">
</head>
<body class="login-body">

    <div class="login-card">
        <div style="font-size: 3rem; margin-bottom: 10px;">🛡️</div>
        <h2>SISTEMA CLÍNICA</h2>
        <p>IDENTIFICACIÓN DE PERSONAL REQUERIDA</p>

        <!-- MOSTRAR ERROR SI EXISTE -->
        <?php if ($error_login != ""): ?>
            <div style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem; border: 1px solid #e74c3c; font-family: 'JetBrains Mono', monospace;">
                <?php echo $error_login; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="login-input-group">
                <label>Identificador de Usuario</label>
                <input type="text" name="username" placeholder="Ingrese su ID" required autofocus>
            </div>
            
            <div class="login-input-group">
                <label>Código de Acceso</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">Verificar Acceso</button>
        </form>

        <div style="margin-top: 25px; font-size: 0.6rem; color: #475569; font-family: 'JetBrains Mono', monospace;">
            ESTE SISTEMA ESTÁ MONITOREADO. ACCESOS NO AUTORIZADOS SERÁN REGISTRADOS.
        </div>
    </div>

</body>
</html>

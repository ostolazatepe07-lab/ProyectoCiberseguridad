<?php include 'db.php'; 

// Verificación de sesión
if (!isset($_SESSION['rol'])) {
    header("Location: index.php");
    exit();
}

// Procesar el formulario cuando se hace POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $diagnostico = $_POST['diagnostico'];
    $fecha = $_POST['fecha_cita'];
    
    // Procesar Archivo
    $nombre_archivo = $_FILES['file']['name'];
    $ruta_destino = "static/uploads/" . $nombre_archivo;

    // VULNERABILIDAD: No hay filtros de extensión (Permite subir .php maliciosos)
    if (move_uploaded_file($_FILES['file']['tmp_name'], $ruta_destino)) {
        
        // Insertar en la Base de Datos
        $stmt = $db->prepare("INSERT INTO pacientes (nombre, apellido, diagnostico, fecha_cita, foto) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $diagnostico, $fecha, $nombre_archivo]);

        // Redirigir con éxito
        header("Location: subir.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Expedientes | Clínica Plus</title>
    <link rel="stylesheet" href="static/estilos.css">
    <link href="https://googleapis.com" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <h1>CLÍNICA PLUS <span>SISTEMA MÉDICO</span></h1>
    </header>

    <nav class="navbar">
        <div class="nav-links">
            <a href="menu.php">🏠 Inicio</a>
            <a href="pacientes.php">👥 Pacientes</a>
            <a href="subir.php" class="active">📁 Subir Archivo</a>
        </div>
        <a href="logout.php" class="logout-btn">🚪 Salir del Sistema</a>
    </nav>

    <div id="mensajeExito" class="aviso-flotante">
        ✅ Registro y archivo procesados correctamente.
    </div>

    <div class="main-content">
        <div class="dashboard-grid">
            <div class="hero-banner" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <h2>Terminal de Carga de Expedientes</h2>
                <p>Ingrese los datos del nuevo paciente y adjunte la documentación digital correspondiente.</p>
                <div style="margin-top: 15px;">
                    <span style="background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 20px; font-size: 0.8rem;">
                        ⚡ Sistema de Carga Activo
                    </span>
                </div>
            </div>

            <div class="card">
                <!-- IMPORTANTE: El action debe ser vacío o al mismo archivo .php -->
                <form action="subir.php" method="POST" enctype="multipart/form-data">
                    
                    <h3 style="color: #2c3e50; border-bottom: 2px solid #f1f1f1; padding-bottom: 10px; margin-bottom: 20px;">
                        📝 Ficha de Identificación
                    </h3>
                    
                    <div class="form-grid">
                        <div class="input-group">
                            <label>Nombre(s):</label>
                            <input type="text" name="nombre" placeholder="Nombre completo" required>
                        </div>
                        <div class="input-group">
                            <label>Apellidos:</label>
                            <input type="text" name="apellido" placeholder="Apellidos" required>
                        </div>
                    </div>

                    <h3 style="color: #2c3e50; border-bottom: 2px solid #f1f1f1; padding-bottom: 10px; margin-top: 30px; margin-bottom: 20px;">
                        🩺 Información del Diagnóstico
                    </h3>
                    
                    <div class="form-grid">
                        <div class="input-group" style="grid-column: span 2;">
                            <label>Descripción Clínica:</label>
                            <textarea name="diagnostico" rows="3" placeholder="Redacte el diagnóstico detallado..." required></textarea>
                        </div>
                        <div class="input-group">
                            <label>Fecha de Consulta:</label>
                            <input type="date" name="fecha_cita" required>
                        </div>
                    </div>

                    <h3 style="color: #2c3e50; border-bottom: 2px solid #f1f1f1; padding-bottom: 10px; margin-top: 30px; margin-bottom: 20px;">
                        📁 Archivos Adjuntos
                    </h3>
                    
                    <div class="file-drop-area">
                        <span class="fake-btn">Examinar</span>
                        <span class="file-msg" id="file-name">Seleccionar informe médico</span>
                        <input class="file-input" type="file" name="file" id="file-input" required>
                    </div>
                    
                    <div style="text-align: right; margin-top: 30px;">
                        <button type="submit" class="btn-upload" style="width: 100%; max-width: 300px;">
                            💾 Finalizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('file-input');
        const fileName = document.getElementById('file-name');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileName.textContent = "Listo para subir: " + this.files[0].name;
                fileName.style.color = "#27ae60";
                fileName.style.fontWeight = "bold";
            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success')) {
            const aviso = document.getElementById('mensajeExito');
            aviso.style.display = 'block';
            setTimeout(() => { 
                aviso.style.opacity = '0';
                setTimeout(() => { aviso.style.display = 'none'; }, 500); 
            }, 3000);
        }
    </script>
</body>
</html>

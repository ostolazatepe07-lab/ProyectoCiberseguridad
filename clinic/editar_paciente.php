<?php 
include 'db.php'; 

// 1. Verificación de sesión y rol (Seguridad básica)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: pacientes.php"); // Si no es admin, fuera
    exit();
}

// 2. Obtener el ID del paciente desde la URL (editar.php?id=X)
$id_paciente = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_paciente) {
    header("Location: pacientes.php");
    exit();
}

// 3. Si se envía el formulario (Guardar cambios)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'guardar') {
    $nuevo_diag = $_POST['diagnostico'];
    $nueva_fecha = $_POST['fecha_cita'];

    $stmt = $db->prepare("UPDATE pacientes SET diagnostico = ?, fecha_cita = ? WHERE id = ?");
    $stmt->execute([$nuevo_diag, $nueva_fecha, $id_paciente]);
    
    header("Location: pacientes.php?edit_success=1");
    exit();
}

// 4. Si se envía el formulario de eliminar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $stmt = $db->prepare("DELETE FROM pacientes WHERE id = ?");
    $stmt->execute([$id_paciente]);
    
    header("Location: pacientes.php?delete_success=1");
    exit();
}

// 5. Cargar datos actuales del paciente para el formulario
$stmt = $db->prepare("SELECT * FROM pacientes WHERE id = ?");
$stmt->execute([$id_paciente]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
    die("Error: El expediente no existe.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Edición de Expediente | Clínica Plus</title>
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
            <a href="subir.php">📁 Subir Archivo</a>
        </div>
        <a href="logout.php" class="logout-btn">🚪 Salir del Sistema</a>
    </nav>

    <div class="main-content">
        <div class="dashboard-grid">
            
            <div class="hero-banner" style="background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);">
                <h2>Consola de Modificación de Datos</h2>
                <p>Estás editando el expediente de <strong><?php echo $paciente['nombre'] . " " . $paciente['apellido']; ?></strong>.</p>
                <div style="margin-top: 15px;">
                    <span style="background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 20px; font-size: 0.8rem;">
                        🆔 Registro ID: <?php echo $paciente['id']; ?>
                    </span>
                </div>
            </div>

            <div class="card">
                <!-- FORMULARIO ÚNICO DE EDICIÓN -->
                <form action="editar_paciente.php?id=<?php echo $id_paciente; ?>" method="POST">
                    
                    <h3 style="color: #2c3e50; border-bottom: 2px solid #f1f1f1; padding-bottom: 10px; margin-bottom: 20px;">
                        🔒 Datos de Identificación (Bloqueados)
                    </h3>
                    
                    <div class="form-grid">
                        <div class="input-group">
                            <label>Nombre:</label>
                            <input type="text" value="<?php echo $paciente['nombre']; ?>" disabled style="background-color: #f9f9f9; cursor: not-allowed;"> 
                        </div>
                        <div class="input-group">
                            <label>Apellido:</label>
                            <input type="text" value="<?php echo $paciente['apellido']; ?>" disabled style="background-color: #f9f9f9; cursor: not-allowed;">
                        </div>
                    </div>

                    <h3 style="color: #2c3e50; border-bottom: 2px solid #f1f1f1; padding-bottom: 10px; margin-top: 30px; margin-bottom: 20px;">
                        ✍️ Campos Editables
                    </h3>
                    
                    <div class="form-grid">
                        <div class="input-group" style="grid-column: span 2;">
                            <label>Diagnóstico Actualizado:</label>
                            <textarea name="diagnostico" rows="4" required><?php echo $paciente['diagnostico']; ?></textarea>
                        </div>
                        <div class="input-group">
                            <label>Nueva Fecha de Cita:</label>
                            <input type="date" name="fecha_cita" value="<?php echo $paciente['fecha_cita']; ?>" required>
                        </div>
                    </div>

                    <div style="margin-top: 30px; display: flex; gap: 15px; justify-content: flex-end; align-items: center;">
                        
                        <!-- BOTÓN DE ELIMINAR (Usando el campo hidden 'accion') -->
                        <button type="submit" name="accion" value="eliminar" 
                                onclick="return confirm('⚠️ ¿Estás seguro de borrar permanentemente este registro?');"
                                class="btn-eliminar" style="background-color: #c0392b; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">
                            🗑️ Eliminar Registro
                        </button>

                        <a href="pacientes.php" class="btn-ver" style="text-decoration: none; display: flex; align-items: center; background-color: #95a5a6; padding: 10px 20px; border-radius: 5px; color: white; font-weight: bold; height: 40px;">
                            ❌ Cancelar
                        </a>

                        <!-- BOTÓN DE GUARDAR -->
                        <button type="submit" name="accion" value="guardar" class="btn-upload" style="background-color: #e67e22; width: auto; padding: 10px 30px; height: 40px; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                            💾 Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

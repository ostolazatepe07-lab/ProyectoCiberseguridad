<?php 
include 'db.php'; 

// Verificación de sesión (Seguridad básica)
if (!isset($_SESSION['rol'])) {
    header("Location: index.php");
    exit();
}

// Obtenemos el total de pacientes para el banner
$res_count = $db->query("SELECT COUNT(*) as total FROM pacientes");
$total_data = $res_count->fetch(PDO::FETCH_ASSOC);
$total = $total_data['total'];

// Obtenemos la lista de pacientes
$pacientes_query = $db->query("SELECT * FROM pacientes");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pacientes | Clínica Plus</title>
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
            <a href="pacientes.php" class="active">👥 Pacientes</a>
            <a href="subir.php">📁 Subir Archivo</a>
        </div>
        <a href="logout.php" class="logout-btn">🚪 Salir del Sistema</a>
    </nav>

    <div class="main-content">
        <div class="dashboard-grid">
            
            <div class="hero-banner" style="background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);">
                <h2>Panel de Gestión de Expedientes</h2>
                <p>Monitorización en tiempo real de registros médicos y diagnósticos actualizados.</p>
                <div style="margin-top: 15px; display: flex; gap: 10px;">
                    <span style="background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 20px; font-size: 0.8rem;">
                        📁 Total: <?php echo $total; ?> expedientes.
                    </span>
                    <span style="background: rgba(46, 204, 113, 0.3); padding: 5px 15px; border-radius: 20px; font-size: 0.8rem;">
                        🟢 Base de Datos: Sincronizada
                    </span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 30px;">
                
                <section>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h2 style="color: #2c3e50;">Expedientes Activos</h2>
                    </div>

                    <div class="news-feed">
                        <?php 
                        $hay_pacientes = false;
                        while ($p = $pacientes_query->fetch(PDO::FETCH_ASSOC)): 
                            $hay_pacientes = true;
                        ?>
                        <div class="news-item" style="border-top: 4px solid #3498db;">
                            <span class="news-tag tag-blue">ID: <?php echo $p['id']; ?></span>
                            <h3>👤 <?php echo $p['nombre'] . " " . $p['apellido']; ?></h3>
                            <p><strong>Diagnóstico:</strong> <?php echo $p['diagnostico']; ?></p>
                            <div class="news-footer">
                                <span>📅 Cita: <?php echo $p['fecha_cita']; ?></span>
                                <div class="acciones-celda">
                                    <?php if (!empty($p['foto'])): ?>
                                    <button class="btn-ver btn-abrir-modal" 
                                            data-url="static/uploads/<?php echo $p['foto']; ?>"
                                            data-nombre="<?php echo $p['nombre'] . ' ' . $p['apellido']; ?>">
                                        👁️ Ver
                                    </button>
                                    <?php else: ?>
                                    <button class="btn-ver" style="background: #95a5a6; cursor: not-allowed;" disabled>🚫 Sin archivo</button>
                                    <?php endif; ?>

                                    <?php if ($_SESSION['rol'] == 'admin'): ?>
                                        <a href="editar_paciente.php?id=<?php echo $p['id']; ?>" class="btn-editar">✏️ Editar</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; 
                        
                        if (!$hay_pacientes): ?>
                        <div class="news-item">
                            <p>No hay expedientes registrados actualmente.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>

                <aside style="display: flex; flex-direction: column; gap: 30px;">
                    <section>
                        <h2 style="color: #2c3e50; margin-bottom: 20px;">📌 Resumen</h2>
                        <div class="activity-feed">
                            <div class="activity-item">
                                <div class="icon-circle" style="background: #3498db;">📈</div>
                                <div><strong>Nuevos:</strong> 0 en las últimas 24h.</div>
                            </div>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>

    <!-- MODAL PARA VER IMÁGENES -->
    <div id="miModal" class="modal" style="display:none;">
        <div class="modal-marco">
            <span class="cerrar-modal" style="cursor:pointer; color:white; float:right; font-size:30px;">&times;</span>
            <h2 id="modal-titulo" style="color: white; text-align: center; margin-bottom: 15px;"></h2>
            <img class="modal-img" id="imgModal" style="width:100%; border-radius:10px;">
        </div>
    </div>

    <script>
    const modal = document.getElementById("miModal");
    const imgModal = document.getElementById("imgModal");
    const tituloModal = document.getElementById("modal-titulo");

    document.querySelectorAll('.btn-abrir-modal').forEach(boton => {
        boton.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const nombre = this.getAttribute('data-nombre');

            modal.style.display = "flex"; 
            modal.style.position = "fixed";
            modal.style.top = "0";
            modal.style.left = "0";
            modal.style.width = "100%";
            modal.style.height = "100%";
            modal.style.backgroundColor = "rgba(0,0,0,0.8)";
            modal.style.justifyContent = "center";
            modal.style.alignItems = "center";
            modal.style.zIndex = "2000";

            imgModal.src = url;
            tituloModal.innerText = "Expediente: " + nombre;
        });
    });

    document.querySelector(".cerrar-modal").onclick = () => modal.style.display = "none";
    window.onclick = (event) => { if (event.target == modal) modal.style.display = "none"; }
    </script>
</body>
</html>

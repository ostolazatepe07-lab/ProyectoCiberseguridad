<?php 
include 'db.php'; 

// Verificamos si el usuario está logueado. Si no existe la sesión, al login.
if (!isset($_SESSION['rol'])) {
    header("Location: index.php");
    exit();
}

// Opcional: Obtener el nombre del archivo actual para marcar el menú activo
$pagina_actual = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Clínica - Dashboard Informativo</title>
    <link rel="stylesheet" href="static/estilos.css">
    <link href="https://googleapis.com" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <h1>CLÍNICA PLUS <span>SISTEMA MÉDICO</span></h1>
    </header>

    <nav class="navbar">
        <div class="nav-links">
            <a href="menu.php" class="<?php echo ($pagina_actual == 'menu.php') ? 'active' : ''; ?>">🏠 Inicio</a>
            <a href="pacientes.php" class="<?php echo ($pagina_actual == 'pacientes.php') ? 'active' : ''; ?>">👥 Pacientes</a>
            <a href="subir.php" class="<?php echo ($pagina_actual == 'subir.php') ? 'active' : ''; ?>">📁 Subir Archivo</a>
        </div>
        <a href="logout.php" class="logout-btn">🚪 Salir del Sistema</a>
    </nav>

    <div class="main-content">
        <div class="dashboard-grid">
            
            <div class="hero-banner">
                <h2>Centro de Comunicaciones Médicas</h2>
                <p>Bienvenido, <strong><?php echo $_SESSION['username']; ?></strong>al portal de noticias internas. Mantente al día con las circulares del sistema.</p>
                <div style="margin-top: 20px;">
                    <span style="background: #27ae60; padding: 8px 15px; border-radius: 5px; font-size: 0.9rem;">
                        🏢 Sede Central: Operativa (Turno de Tarde)
                    </span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
                
                <div style="display: flex; flex-direction: column; gap: 30px;">
                    <section>
                        <h2 style="color: #2c3e50; margin-bottom: 20px;">📢 Últimos Anuncios</h2>
                        <div class="news-feed">
                            <div class="news-item">
                                <span class="news-tag tag-blue">SISTEMA</span>
                                <h3>🔐 Nueva Política de Contraseñas</h3>
                                <p>A partir del próximo mes, las contraseñas deberán tener al menos 12 caracteres y un símbolo especial para cumplir con la normativa de protección de datos.</p>
                                <div class="news-footer"><span>Depto. Ciberseguridad</span><span>Hoy</span></div>
                            </div>

                            <div class="news-item" style="border-top-color: #9b59b6;">
                                <span class="news-tag" style="background: #f3e5f5; color: #7b1fa2;">MÉDICO</span>
                                <h3>🩺 Protocolo COVID-26</h3>
                                <p>Se actualiza el manual de triaje para pacientes con síntomas respiratorios. Descarguen el PDF en la sección de archivos.</p>
                                <div class="news-footer"><span>Dirección Médica</span><span>Ayer</span></div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <h2 style="color: #2c3e50; margin-bottom: 20px;">🌐 Circulares Generales</h2>
                        <div class="news-feed">
                            <!-- Anuncio 3 -->
                            <div class="news-item" style="border-top-color: #2ecc71;">
                                <span class="news-tag tag-green">RECURSOS</span>
                                <h3>🏢 Reforma en el Área de Cafetería</h3>
                                <p>Las obras de remodelación en la planta baja finalizarán el próximo viernes. Agradecemos su paciencia.</p>
                                <div class="news-footer"><span>Mantenimiento</span><span>15/04/2026</span></div>
                            </div>
                            <!-- Anuncio 4 -->
                            <div class="news-item" style="border-top-color: #e67e22;">
                                <span class="news-tag" style="background: #fff3e0; color: #e65100;">AVISO</span>
                                <h3>📧 Alerta de Phishing</h3>
                                <p>Se ha detectado una campaña de correos falsos simulando ser de RRHH. No abran enlaces sospechosos sobre "ajustes de nómina".</p>
                                <div class="news-footer"><span>Seguridad TI</span><span>14/04/2026</span></div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Columna Derecha: Agenda y Recordatorios -->
                <aside style="display: flex; flex-direction: column; gap: 30px;">
                    <section>
                        <h2 style="color: #2c3e50; margin-bottom: 20px;">📅 Próximos Eventos</h2>
                        <div class="activity-feed">
                            <div class="activity-item">
                                <div class="icon-circle" style="background: #3498db;">📅</div>
                                <div><strong>25 Abr:</strong> Conferencia sobre Ética Médica.</div>
                            </div>
                            <div class="activity-item">
                                <div class="icon-circle" style="background: #2ecc71;">🩺</div>
                                <div><strong>28 Abr:</strong> Revisión semestral de rayos X.</div>
                            </div>
                            <div class="activity-item">
                                <div class="icon-circle" style="background: #e67e22;">💊</div>
                                <div><strong>02 May:</strong> Inventario de farmacia.</div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h2 style="color: #2c3e50; margin-bottom: 20px;">📌 Recordatorios de Turno</h2>
                        <div class="activity-feed">
                            <div class="activity-item">
                                <div class="icon-circle" style="background: #607d8b;">📝</div>
                                <div>Entregar reportes de guardia antes de las 20:00h.</div>
                            </div>
                            <div class="activity-item">
                                <div class="icon-circle" style="background: #607d8b;">🧼</div>
                                <div>Limpieza de estaciones de trabajo al finalizar.</div>
                            </div>
                            <div class="activity-item">
                                <div class="icon-circle" style="background: #607d8b;">🔑</div>
                                <div>Devolver llaves de suministros a recepción.</div>
                            </div>
                        </div>
                    </section>
                </aside>
            </div> 
        </div>
    </div>
</body>
</html>

<?php 
require_once __DIR__ . '/layout/navbar.php'; 
// por si el enrutado tiene problemas
if (!isset($esAdmin)) {
    $esAdmin = isset($_SESSION['username']) || (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true);
}

?>

<style>

.estudios-layout {
    display: grid; 
    grid-template-columns: 200px 1fr; 
    gap: 24px; 
    align-items: start; }
.sidebar-menu { 
    display: flex; 
    flex-direction: column; 
    gap: 16px; }
.menu-btn { 
    padding: 14px 20px;
    border: none; 
    background-color: #ffffff;
    color: #2b2b2b; 
    border-radius: 12px; cursor: 
    pointer; font-weight: 600; 
    font-size: 0.95rem; 
    text-align: left;
    outline: none; 
    transition: all 0.3s ease; }
.menu-btn:hover, .menu-btn.active {
    background-color: #ffffff; 
    color: #000;
    font-weight: 700; 
    box-shadow: 0 0 9px rgba(167, 165, 168, 0.8); 
}
.main-section { 
    display: none; 
}
.main-section.active-section { 
    display: block; }
.iden-ban { 
    display: flex; 
    gap: 8px; 
    border-bottom: 3px solid #8a2be2; 
    padding-left: 10px; 
    flex-wrap: wrap; }
.tab-btn { 
    padding: 12px 20px; 
    border: none; 
    background-color: #ffffff; 
    color: #4a4a4a; 
    font-weight: 600; 
    cursor: pointer; 
    clip-path: polygon(12px 0, calc(100% - 12px) 0, 100% 100%, 0 100%); 
    border-radius: 8px 8px 0 0; 
    transition: all 0.3s ease; }
.tab-btn.active-tab { 
    background: linear-gradient(135deg, #8a2be2, #00bfff); 
    color: #ffffff; 
    font-weight: 700; }
.folder-content { 
    background-color: #ffffff; 
    border-radius: 0 0 16px 16px; 
    padding: 28px; 
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08); 
    border: 1px solid rgba(138, 43, 226, 0.2);
    border-top: none; }
.career-sheet { 
    display: none; }
.career-sheet.active-sheet { 
    display: block; }
.career-header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 18px; }

.table-responsive { 
    width: 100%; 
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; }
.materias-table { 
    width: 100%; 
    border-collapse: collapse; 
    text-align: left; 
    min-width: 500px;}
.materias-table th, .materias-table td { 
    padding: 12px 16px; 
    border-bottom: 1px solid rgba(0, 0, 0, 0.08); }
.status-pill { 
    display: inline-block; 
    padding: 4px 10px; 
    border-radius: 20px; 
    font-size: 0.85rem; 
    font-weight: 600;
    background: rgba(138, 43, 226, 0.1); 
    color: #8a2be2; }
.admin-badge { 
    background: #8a2be2; 
    color: #fff;
    padding: 3px 8px; 
    border-radius: 4px; 
    font-size: 0.75rem; 
    font-weight: bold; 
    margin-left: 10px; }
.card-admin-form {
     background: #f8f9fa; 
     border: 1px dashed #8a2be2; 
     border-radius: 10px; 
     padding: 15px;
      margin-bottom: 20px; }
.form-linea {
    display: flex; 
    gap: 10px; 
    flex-wrap: wrap; 
    align-items: center; }
.form-linea input, .form-linea select { 
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 6px; }
.btn-admin { 
    background: #8a2be2; 
    color: #fff; 
    border: none; 
    padding: 8px 14px; 
    border-radius: 6px; 
    cursor: pointer; 
    font-weight: 600; }
.btn-action { 
    color: #8a2be2; 
    text-decoration: none; 
    font-size: 0.85rem; 
    margin-right: 6px; }
.btn-action.delete { color: #dc3545; }
.btn-action.toggle { color: #fd7e14; }


@media (max-width: 768px) {
    .estudios-layout {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .sidebar-menu {
        flex-direction: row;
        overflow-x: auto; 
        padding-bottom: 5px; 
    }
    .menu-btn {
        text-align: center;
        flex: 1; 
        min-width: 120px; 
    }
    .folder-content {
        padding: 16px; 
    }
    .career-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .form-linea {
        flex-direction: column;
        align-items: stretch;
    }
    
    .form-linea input, 
    .form-linea select, 
    .form-linea button {
        width: 100%;
        flex: none !important; 
    }
}
.cursos-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
    width: 100%;
}
.cou-card {
    display: flex;
    align-items: center;
    gap: 18px;
    background: rgba(255, 255, 255, 0.03); 
    border: 1px solid rgba(138, 43, 226, 0.3);
    border-radius: 12px;
    padding: 16px;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.cou-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(138, 43, 226, 0.25);
    border-color: rgba(168, 85, 247, 0.5);
}
.cou-img{
    width: 90px;
    height: 90px;
    flex-shrink: 0;
    border-radius: 8px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.05);
}
.co-img {
    width: 100%;
    height: 100%;
    object-fit: cover; 
}
.cou-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.cou-titulo {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.15rem;
    font-weight: 700;
    margin: 0;
    color: #151515;
}

.cou-meta {
    display: flex;
    align-items: center;
    gap: 10px;
}
.cou-badge {
    background: linear-gradient(135deg, #8a2be2 0%, #a855f7 100%);
    color: #ffffff;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
}
.cou-institution {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    font-weight: 500;
}

/* Adaptación para pantallas chicas */
@media (max-width: 480px) {
    .cou-card {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .cou-img {
        width: 100%;
        height: 160px; 
    }
}
</style>


<div class="wrap">
    <main class="main-glass-container">
        <h1>Educación <?= $esAdmin ? '<span class="admin-badge">Modo Admin</span>' : '' ?></h1>

        <div class="estudios-layout">
            <aside class="sidebar-menu">
                <button class="menu-btn active" onclick="switchMainSection('carrera', this)">🏛️ Carrera</button>
                <button class="menu-btn" onclick="switchMainSection('cursos', this)">🎓 Cursos</button>
            </aside>

            <div class="content-display">
                <section id="section-carrera" class="main-section active-section">
                    
                    <?php if ($esAdmin): ?>
                
                        <div class="card-admin-form">
                            <h4><?= !empty($carreraEditar) ? '✏️ Editar Carrera' : '➕ Agregar Nueva Carrera' ?></h4>
                            <form method="POST" action="index.php?action=estudios" class="form-linea">
                                <input type="hidden" name="accion" value="guardar_carrera">
                                <input type="hidden" name="carrera_id" value="<?= $carreraEditar['id'] ?? 0 ?>">
                                <input type="text" name="nombre_carrera" value="<?= htmlspecialchars($carreraEditar['nombre'] ?? '') ?>" placeholder="Nombre de la Carrera" required style="flex: 2;">
                                <button type="submit" class="btn-admin"><?= !empty($carreraEditar) ? 'Actualizar Carrera' : 'Guardar Carrera' ?></button>
                                <?php if (!empty($carreraEditar)): ?>
                                    <a href="index.php?action=estudios" style="color:#6c757d; font-size:0.85rem; text-decoration:none;">Cancelar</a>
                                <?php endif; ?>
                            </form>
                        </div>

                        <div class="card-admin-form">
                            <h4><?= !empty($materiaEditar) ? '✏️ Editar Materia' : '➕ Agregar Nueva Materia' ?></h4>
                            <form method="POST" action="index.php?action=estudios" class="form-linea">
                                <input type="hidden" name="accion" value="guardar_materia">
                                <input type="hidden" name="id" value="<?= $materiaEditar['id'] ?? 0 ?>">
                                <input type="text" name="nombre" value="<?= htmlspecialchars($materiaEditar['nombre'] ?? '') ?>" placeholder="Nombre de materia" required style="flex: 2;">
                    
                                <select name="anio" required>
                                    <option value="">-- Año --</option>
                                      <?php for ($i = 1; $i <= 6; $i++): ?>
                                        <option value="<?= $i ?>" <?= (isset($materiaEditar['anio']) && $materiaEditar['anio'] == $i) ? 'selected' : '' ?>>
                                           <?= $i ?>° Año
                                         </option>
                                      <?php endfor; ?>
                                </select>

                                <select name="cuatrimestre" required>
                                    <option value="">-- Cuatrimestre --</option>
                                    <option value="1" <?= (isset($materiaEditar['cuatrimestre']) && $materiaEditar['cuatrimestre'] == 1) ? 'selected' : '' ?>>1° Cuatrimestre</option>
                                    <option value="2" <?= (isset($materiaEditar['cuatrimestre']) && $materiaEditar['cuatrimestre'] == 2) ? 'selected' : '' ?>>2° Cuatrimestre</option>
                                </select>

                                <select name="carrera_id" required>
                                    <?php foreach ($carreras as $c): ?>
                                        <option value="<?= $c['id'] ?>" <?= (isset($materiaEditar['carrera_id']) && $materiaEditar['carrera_id'] == $c['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($c['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <select name="estado_id" required>
                                    <option value="">-- Estado --</option>
                                    <?php foreach ($estados as $est): ?>
                                        <option value="<?= $est['id'] ?>" <?= (isset($materiaEditar['estado_id']) && $materiaEditar['estado_id'] == $est['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($est['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <button type="submit" class="btn-admin"><?= !empty($materiaEditar) ? 'Actualizar Materia' : 'Guardar Materia' ?></button>
                                <?php if (!empty($materiaEditar)): ?>
                                    <a href="index.php?action=estudios" style="color:#6c757d; font-size:0.85rem; text-decoration:none;">Cancelar</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    <?php endif; ?>

                    <div class="iden-ban">
                        <?php foreach ($carreras as $index => $c): ?>
                            <button class="tab-btn <?= $index === 0 ? 'active-tab' : '' ?>" onclick="switchCareerTab(<?= $c['id'] ?>, this)">
                                📖 <?= htmlspecialchars($c['nombre']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
  
                    <div class="folder-content">
                        <?php foreach ($carreras as $index => $c): ?>
                            <div id="career-tab-<?= $c['id'] ?>" class="career-sheet <?= $index === 0 ? 'active-sheet' : '' ?>">
                                <div class="career-header">
                                    <h3 class="career-title" style="margin:0;"><?= htmlspecialchars($c['nombre']) ?></h3>
                                    <?php if ($esAdmin): ?>
                                        <div>
                                            <a href="index.php?action=estudios&action_carrera=edit&carrera_id=<?= $c['id'] ?>" class="btn-action">✏️ Editar Carrera</a>
                                            <a href="index.php?action=estudios&action_carrera=delete&carrera_id=<?= $c['id'] ?>" class="btn-action delete" onclick="return confirm('¿Eliminar esta carrera y sus materias?');">🗑️ Eliminar Carrera</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="materias-table">
                                        <thead>
                                            <tr>
                                                <th>Materia</th>
                                                <th> Año </th>
                                                <th>Cuatrimestre</th>
                                                <th>Estado</th>
                                                <?php if ($esAdmin): ?><th>Acciones</th><?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $materiasCarrera = array_filter($materias, fn($m) => $m['carrera_id'] == $c['id']); ?>
                                            <?php if (!empty($materiasCarrera)): ?>
                                                <?php foreach ($materiasCarrera as $m): ?>
                                                    <tr style="<?= ($esAdmin && isset($m['activo']) && !$m['activo']) ? 'opacity: 0.4;' : '' ?>">
                                                        <td><strong><?= htmlspecialchars($m['nombre']) ?></strong></td>
                                                        <td><?= htmlspecialchars($m['anio'] ?? '1') ?>° Año</td>
                                                        <td><?= htmlspecialchars($m['cuatrimestre'] ?? '-') ?>°</td>
                                                        <td>
                                                            <?php if ($esAdmin): ?>
                                                                <form action="index.php?action=estudios" method="POST" style="margin:0;">
                                                                    <input type="hidden" name="accion" value="cambiar_estado_materia">
                                                                    <input type="hidden" name="materia_id" value="<?= $m['id'] ?>">
                                                                    <select name="estado_id" onchange="this.form.submit()" style="padding: 4px 8px; border-radius: 4px; border: 1px solid #ccc; cursor: pointer;">
                                                                        <?php foreach ($estados as $est): ?>
                                                                            <option value="<?= $est['id'] ?>" <?= ($m['estado_id'] == $est['id']) ? 'selected' : '' ?>>
                                                                                <?= htmlspecialchars($est['nombre']) ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </form>
                                                            <?php else: ?>
                                                                <span class="status-pill"><?= htmlspecialchars($m['estado_nombre'] ?? 'Sin estado') ?></span>
                                                            <?php endif; ?>
                                                        </td>

                                                        <?php if ($esAdmin): ?>
                                                            <td>
                                                                <a href="index.php?action=estudios&action_type=edit&id=<?= $m['id'] ?>" class="btn-action">✏️ Editar </a>
                                                                <a href="index.php?action=estudios&toggle_materia=<?= $m['id'] ?>" class="btn-action toggle"><?= ($m['activo'] ?? 1) ? '👁️ Ocultar' : '🙈 Mostrar' ?></a>
                                                                <a href="index.php?action=estudios&action_type=delete&id=<?= $m['id'] ?>" class="btn-action delete" onclick="return confirm('¿Desactivar esta materia?');">🗑️</a>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="<?= $esAdmin ? 4 : 3 ?>" class="empty-msg">No hay materias registradas en esta carrera.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section id="section-cursos" class="main-section">
                    <h2>Cursos</h2>
                    <div class="cursos-container">
                         <div class="cou-card">
                            <div class="cou-img">
                                <img src="/img/images.png" alt="1000 Programadores Salteños" class="co-img">
                            </div>
                            <div class="cou-info">
                                <h3 class="cou-titulo"> Programación Web Full Stack</h3>
                                <div class="cou-meta">
                                    <span class="cou-badge">2023</span>
                                    <span class="cou-instituto">Fundación Pescar - Educacion IT</span>
                                </div>
                            </div>
                        </div>
                         <div class="cou-card">
                            <div class="cou-img">
                                <img src="/img/java.jpg" alt="1000 Programadores Salteños" class="co-img">
                            </div>
                            <div class="cou-info">
                                <h3 class="cou-titulo"> Introduccion a la Programación en Java</h3>
                                <div class="cou-meta">
                                    <span class="cou-badge">2022</span>
                                    <span class="cou-instituto">1000 Programadores Salteños Universidad Nacional de Salta</span>
                                </div>
                            </div>
                        </div>
                         <div class="cou-card">
                            <div class="cou-img">
                                <img src="/img/ministerio.jpeg" alt="1000 Programadores Salteños" class="co-img">
                            </div>
                            <div class="cou-info">
                                <h3 class="cou-titulo"> Operador Informatico para Administración y gestión</h3>
                                <div class="cou-meta">
                                    <span class="cou-badge">2021-2022</span>
                                    <span class="cou-instituto">Ministerio de Educación, Cultura, Ciencias y Tecnologias</span>
                                </div>
                            </div>
                        </div>
                        <div class="cou-card">
                            <div class="cou-img">
                                <img src="/img/1657553541685.jpg" alt="1000 Programadores Salteños" class="co-img">
                            </div>
                            <div class="cou-info">
                                <h3 class="cou-titulo"> Introduccion a la Programacion en Python</h3>
                                <div class="cou-meta">
                                    <span class="cou-badge">202</span>
                                    <span class="cou-instituto">1000 Programadores Salteños Universidad Nacional de Salta </span>
                                </div>
                            </div>
                        </div>
            
                    </div>
                </section>
            </div>
        </div>
    </main>
</div>

<script>
function switchMainSection(sectionName, btnElement) {
    document.querySelectorAll('.sidebar-menu .menu-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.main-section').forEach(sec => sec.classList.remove('active-section'));

    btnElement.classList.add('active');
    const selectedSection = document.getElementById('section-' + sectionName);
    if (selectedSection) selectedSection.classList.add('active-section');
}

function switchCareerTab(carreraId, tabElement) {
    document.querySelectorAll('.iden-ban .tab-btn').forEach(tab => tab.classList.remove('active-tab'));
    document.querySelectorAll('.folder-content .career-sheet').forEach(sheet => sheet.classList.remove('active-sheet'));

    tabElement.classList.add('active-tab');
    const selectedSheet = document.getElementById('career-tab-' + carreraId);
    if (selectedSheet) selectedSheet.classList.add('active-sheet');
}
</script>
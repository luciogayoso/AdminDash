<?php
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

// Métricas KPI
$totalUsers = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
$totalAdmins = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'Admin'")->fetchColumn();
$totalStandard = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'Usuario'")->fetchColumn();

// Obtener registros
$stmt = $pdo->prepare("SELECT * FROM usuarios ORDER BY id DESC");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
            color: #334155;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .card-kpi {
            border: none;
            border-radius: 0.75rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-kpi:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        }
        .card-main {
            border: none;
            border-radius: 0.75rem;
        }
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #475569;
        }
        .table > :not(caption) > * > * {
            padding: 0.85rem 1rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand text-white d-flex align-items-center" href="#">
            <i class="fa-solid fa-cubes text-primary me-2 fa-lg"></i>
            <span>AdminDash</span>
        </a>
        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-md-flex align-items-center text-white-50 small">
                <i class="fa-regular fa-user me-2"></i>
                <span class="text-white fw-semibold me-1"><?= htmlspecialchars($_SESSION['nombre_completo']) ?></span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill"><?= $_SESSION['rol'] ?></span>
            </div>
            <a href="logout.php" class="btn btn-outline-light btn-sm rounded-2">
                <i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Salir
            </a>
        </div>
    </div>
</nav>

<div class="container py-4">

    <!-- KPI Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-kpi bg-white shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-semibold mb-1">TOTAL USUARIOS</p>
                        <h3 class="fw-bold mb-0 text-dark"><?= $totalUsers ?></h3>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-3">
                        <i class="fa-solid fa-users fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-kpi bg-white shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-semibold mb-1">ADMINISTRADORES</p>
                        <h3 class="fw-bold mb-0 text-dark"><?= $totalAdmins ?></h3>
                    </div>
                    <div class="bg-danger-subtle text-danger p-3 rounded-3">
                        <i class="fa-solid fa-user-shield fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-kpi bg-white shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small fw-semibold mb-1">USUARIOS ESTÁNDAR</p>
                        <h3 class="fw-bold mb-0 text-dark"><?= $totalStandard ?></h3>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-3">
                        <i class="fa-solid fa-user-check fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Formulario Registro -->
        <div class="col-lg-4">
            <div class="card card-main shadow-sm bg-white">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-user-plus text-primary me-2"></i>Registrar Usuario
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="guardar.php" method="POST">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-semibold">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required placeholder="Juan">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold">Apellido</label>
                                <input type="text" name="apellido" class="form-control" required placeholder="Pérez">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nombre de Usuario</label>
                            <input type="text" name="usuario" class="form-control" required placeholder="jperez">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Contraseña</label>
                            <input type="password" name="clave" class="form-control" required placeholder="••••••••">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Rol asignado</label>
                            <select name="rol" class="form-select">
                                <option value="Usuario">Usuario Estándar</option>
                                <option value="Admin">Administrador</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                            <i class="fa-solid fa-check me-1"></i> Guardar Usuario
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabla Registros -->
        <div class="col-lg-8">
            <div class="card card-main shadow-sm bg-white">
                <div class="card-header bg-white py-3 border-bottom border-light d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-list text-primary me-2"></i>Directorio de Usuarios
                    </h6>
                    <div class="input-group" style="max-width: 260px;">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" id="inputBuscar" class="form-control border-start-0 bg-light" placeholder="Buscar registros...">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tablaUsuarios">
                            <thead class="table-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-3">Usuario</th>
                                    <th>Username</th>
                                    <th>Rol</th>
                                    <th class="text-end pe-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($usuarios) > 0): ?>
                                    <?php foreach ($usuarios as $u): ?>
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-3">
                                                    <?= strtoupper(substr($u['nombre'], 0, 1) . substr($u['apellido'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0"><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></div>
                                                    <small class="text-muted">ID: #<?= $u['id'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-medium text-secondary">
                                            @<?= htmlspecialchars($u['usuario']) ?>
                                        </td>
                                        <td>
                                            <?php if ($u['rol'] === 'Admin'): ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Admin</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Usuario</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="editar.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-light border text-warning-emphasis me-1" title="Editar">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button onclick="confirmarEliminacion(<?= $u['id'] ?>)" class="btn btn-sm btn-light border text-danger" title="Eliminar">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr id="sinResultados">
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fa-regular fa-folder-open fa-2x mb-2 d-block"></i>
                                            No hay usuarios registrados
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Filtro dinámico en tiempo real
document.getElementById('inputBuscar').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase().trim();
    let filas = document.querySelectorAll('#tablaUsuarios tbody tr:not(#sinResultados)');
    let visibles = 0;

    filas.forEach(fila => {
        let texto = fila.textContent.toLowerCase();
        if (texto.includes(filtro)) {
            fila.style.display = '';
            visibles++;
        } else {
            fila.style.display = 'none';
        }
    });
});

// Confirmación de eliminación
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Confirmas la eliminación?',
        text: "El registro será eliminado permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmColor: '#dc3545',
        cancelColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        customClass: { confirmButton: 'btn btn-danger me-2', cancelButton: 'btn btn-secondary' },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `eliminar.php?id=${id}`;
        }
    });
}

// Alertas Toast interactivas
const urlParams = new URLSearchParams(window.location.search);
const msg = urlParams.get('msg');

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true
});

if (msg === 'created') Toast.fire({ icon: 'success', title: 'Usuario registrado con éxito' });
if (msg === 'updated') Toast.fire({ icon: 'success', title: 'Usuario actualizado con éxito' });
if (msg === 'deleted') Toast.fire({ icon: 'success', title: 'Usuario eliminado del sistema' });
if (msg === 'error_user_exists') Toast.fire({ icon: 'error', title: 'El nombre de usuario ya existe' });
if (msg === 'welcome') Toast.fire({ icon: 'info', title: '¡Sesión iniciada correctamente!' });
</script>
</body>
</html>
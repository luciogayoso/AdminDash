<?php
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $rol = $_POST['rol'] ?? 'Usuario';

    if (!empty($nombre) && !empty($apellido)) {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, rol = ? WHERE id = ?");
        $stmt->execute([$nombre, $apellido, $rol, $id]);

        header('Location: index.php?msg=updated');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario | AdminDash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100 p-3">
    <div class="card border-0 shadow-sm bg-white" style="max-width: 450px; width: 100%;">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <h6 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-user-pen text-primary me-2"></i>Editar Usuario #<?= $usuario['id'] ?>
            </h6>
        </div>
        <div class="card-body p-4">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nombre</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Apellido</label>
                    <input type="text" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Usuario (no modificable)</label>
                    <input type="text" value="<?= htmlspecialchars($usuario['usuario']) ?>" class="form-control bg-light" disabled>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold">Rol</label>
                    <select name="rol" class="form-select">
                        <option value="Usuario" <?= $usuario['rol'] === 'Usuario' ? 'selected' : '' ?>>Usuario Estándar</option>
                        <option value="Admin" <?= $usuario['rol'] === 'Admin' ? 'selected' : '' ?>>Administrador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-semibold mb-2 py-2">Actualizar Datos</button>
                <a href="index.php" class="btn btn-light border w-100 fw-semibold py-2">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>
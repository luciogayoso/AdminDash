<?php
require_once 'conexion.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['usuario'] ?? '');
    $pass = trim($_POST['clave'] ?? '');

    if (!empty($user) && !empty($pass)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$user]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($pass, $usuario['clave'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre_completo'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
            $_SESSION['rol'] = $usuario['rol'];
            header('Location: index.php?msg=welcome');
            exit;
        } else {
            $error = 'Credenciales inválidas. Verifica usuario y contraseña.';
        }
    } else {
        $error = 'Por favor completa todos los campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .card-login {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">
    <div class="container" style="max-width: 420px;">
        <div class="card card-login bg-white p-4">
            <div class="text-center mb-4">
                <div class="bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-user-shield fa-xl"></i>
                </div>
                <h4 class="fw-bold mb-1">Bienvenido</h4>
                <p class="text-muted small">Acceda al panel de administración</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger d-flex align-items-center py-2 px-3 small border-0 mb-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    <div><?= htmlspecialchars($error) ?></div>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-user"></i></span>
                        <input type="text" name="usuario" class="form-control border-start-0 bg-light" placeholder="admin" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small text-secondary">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="clave" class="form-control border-start-0 bg-light" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-2 shadow-sm">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Ingresar al Sistema
                </button>
            </form>

            <div class="mt-4 pt-3 border-top text-center">
                <span class="badge bg-light text-dark border fw-normal py-2 px-3">
                    <i class="fa-solid fa-key me-1 text-primary"></i> Demo: <b>admin</b> / <b>admin123</b>
                </span>
            </div>
        </div>
    </div>
</body>
</html>
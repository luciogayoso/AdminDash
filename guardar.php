<?php
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = $_POST['clave'] ?? '';
    $rol = $_POST['rol'] ?? 'Usuario';

    if (!empty($nombre) && !empty($apellido) && !empty($usuario) && !empty($clave)) {
        // Verificar si el usuario ya existe
        $check = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $check->execute([$usuario]);
        
        if ($check->rowCount() > 0) {
            header('Location: index.php?msg=error_user_exists');
            exit;
        }

        $hashClave = password_hash($clave, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, usuario, clave, rol) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $usuario, $hashClave, $rol]);

        header('Location: index.php?msg=created');
        exit;
    }
}
header('Location: index.php');
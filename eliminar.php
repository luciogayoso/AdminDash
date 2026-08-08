<?php
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    // Evitar que un usuario se elimine a sí mismo
    if ($id == $_SESSION['usuario_id']) {
        header('Location: index.php?msg=error_self_delete');
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: index.php?msg=deleted');
    exit;
}

header('Location: index.php');
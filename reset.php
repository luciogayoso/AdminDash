<?php
require_once 'conexion.php';

$usuario = 'admin';
$clave_plana = 'admin123';
$clave_hash = password_hash($clave_plana, PASSWORD_BCRYPT);

// Verificar si existe el admin
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
$stmt->execute([$usuario]);

if ($stmt->fetch()) {
    // Actualizar contraseña
    $update = $pdo->prepare("UPDATE usuarios SET clave = ? WHERE usuario = ?");
    $update->execute([$clave_hash, $usuario]);
    echo "¡Contraseña de 'admin' actualizada correctamente a 'admin123'!";
} else {
    // Crear admin desde cero
    $insert = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, usuario, clave, rol) VALUES (?, ?, ?, ?, ?)");
    $insert->execute(['Administrador', 'Sistema', $usuario, $clave_hash, 'Admin']);
    echo "¡Usuario 'admin' creado correctamente!";
}
?>
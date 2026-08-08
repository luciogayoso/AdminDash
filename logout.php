<?php
require_once 'conexion.php';
session_destroy();
header('Location: login.php');
exit;
?>
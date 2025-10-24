<?php
require_once 'db.php';
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM pouvoir WHERE id = ?');
    $stmt->execute([$id]);
}
header('Location: listePouvoir.php');
exit;

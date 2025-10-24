<?php
require_once 'db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM heros WHERE id = ?');
    $stmt->execute([$id]);
}
header('Location: listeHero.php');
exit;

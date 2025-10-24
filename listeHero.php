<?php
require_once 'db.php';

// Récupérer tous les héros avec leur pouvoir et équipe
$sql = 'SELECT h.id, h.nom, h.prenom, h.alias, p.nom AS pouvoir, e.nom AS equipe
        FROM heros h
        JOIN pouvoir p ON h.pouvoir_id = p.id
        JOIN equipe e ON h.equipe_id = e.id
        ORDER BY h.nom, h.prenom';
$stmt = $pdo->query($sql);
$heros = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des héros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Liste des super héros</h1>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Alias</th>
                <th>Pouvoir</th>
                <th>Équipe</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($heros as $hero): ?>
            <tr>
                <td><?= htmlspecialchars($hero['nom']) ?></td>
                <td><?= htmlspecialchars($hero['prenom']) ?></td>
                <td><?= htmlspecialchars($hero['alias']) ?></td>
                <td><?= htmlspecialchars($hero['pouvoir']) ?></td>
                <td><?= htmlspecialchars($hero['equipe']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="creationhero.php" class="btn btn-primary">Ajouter un héros</a>
</div>
</body>
</html>

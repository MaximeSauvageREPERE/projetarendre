<?php
require_once __DIR__ . '/../includes/db.php';

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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Super Héros</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="listeHero.php">Liste des héros</a></li>
        <li class="nav-item"><a class="nav-link" href="listePouvoir.php">Liste des pouvoirs</a></li>
        <li class="nav-item"><a class="nav-link" href="listeEquipe.php">Liste des équipes</a></li>
        <li class="nav-item"><a class="nav-link" href="creationhero.php">Ajouter un héros</a></li>
        <li class="nav-item"><a class="nav-link" href="creationpouvoir.php">Ajouter un pouvoir</a></li>
        <li class="nav-item"><a class="nav-link" href="creationequipe.php">Ajouter une équipe</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-3">
    <h1>Liste des super héros</h1>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Alias</th>
                <th>Pouvoir</th>
                <th>Équipe</th>
                <th>Actions</th>
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
                <td>
                    <a href="editHero.php?id=<?= $hero['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="deleteHero.php?id=<?= $hero['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce héros ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="creationhero.php" class="btn btn-primary">Ajouter un héros</a>
</div>
</body>
</html>

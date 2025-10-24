<?php
require_once __DIR__ . '/../includes/db.php';
$equipes = $pdo->query('SELECT * FROM equipe ORDER BY nom')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des équipes</title>
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
        <li class="nav-item"><a class="nav-link" href="../heros/listeHero.php">Liste des héros</a></li>
        <li class="nav-item"><a class="nav-link" href="../pouvoirs/listePouvoir.php">Liste des pouvoirs</a></li>
        <li class="nav-item"><a class="nav-link" href="listeEquipe.php">Liste des équipes</a></li>
        <li class="nav-item"><a class="nav-link" href="../heros/creationhero.php">Ajouter un héros</a></li>
        <li class="nav-item"><a class="nav-link" href="../pouvoirs/creationpouvoir.php">Ajouter un pouvoir</a></li>
        <li class="nav-item"><a class="nav-link" href="creationequipe.php">Ajouter une équipe</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-3">
    <h1>Liste des équipes</h1>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($equipes as $equipe): ?>
            <tr>
                <td><?= htmlspecialchars($equipe['nom']) ?></td>
                <td>
                    <a href="editEquipe.php?id=<?= $equipe['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="deleteEquipe.php?id=<?= $equipe['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette équipe ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="creationequipe.php" class="btn btn-primary">Ajouter une équipe</a>
</div>
</body>
</html>

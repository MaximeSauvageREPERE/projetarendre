<?php
require_once __DIR__ . '/../includes/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    if ($nom) {
        $sql = 'INSERT INTO pouvoir (nom) VALUES (?)';
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$nom]);
            $message = '<div class="alert alert-success">Pouvoir ajouté avec succès !</div>';
        } catch (PDOException $e) {
            $message = '<div class="alert alert-danger">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Veuillez saisir un nom de pouvoir.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un pouvoir</title>
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
        <li class="nav-item"><a class="nav-link" href="listePouvoir.php">Liste des pouvoirs</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/listeEquipe.php">Liste des équipes</a></li>
        <li class="nav-item"><a class="nav-link" href="../heros/creationhero.php">Ajouter un héros</a></li>
        <li class="nav-item"><a class="nav-link" href="creationpouvoir.php">Ajouter un pouvoir</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/creationequipe.php">Ajouter une équipe</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-3">
    <h1>Ajouter un nouveau pouvoir</h1>
    <?= $message ?>
    <form method="post" action="">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du pouvoir</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="creationhero.php" class="btn btn-secondary">Retour</a>
    </form>
</div>
</body>
</html>

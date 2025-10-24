<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Pouvoir.php';

$message = '';
// ...existing code...
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom = trim($_POST['nom'] ?? '');
  if ($nom) {
    $pouvoir = new Pouvoir($nom);
    $sql = 'INSERT INTO pouvoir (nom) VALUES (?)';
    $stmt = $pdo->prepare($sql);
    try {
      $stmt->execute([$pouvoir->nom]);
      $message = '<div class="alert alert-success">Pouvoir ajouté avec succès !</div>';
    } catch (PDOException $e) {
      $message = '<div class="alert alert-danger">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
  } else {
    $message = '<div class="alert alert-warning">Veuillez saisir un nom de pouvoir.</div>';
  }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un pouvoir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2eafc 100%);
            min-height: 100vh;
        }
        .main-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 2rem 2.5rem;
            margin-top: 2rem;
            max-width: 500px;
        }
        .btn {
            border-radius: 0.5rem;
        }
        h1 {
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 2rem;
        }
        .navbar {
            border-radius: 0 0 1rem 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
    </style>
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
        <li class="nav-item"><a class="nav-link active" href="creationpouvoir.php">Ajouter un pouvoir</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/creationequipe.php">Ajouter une équipe</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container d-flex justify-content-center">
  <div class="main-card w-100">
    <h1 class="text-center text-primary">Ajouter un pouvoir</h1>
    <?= $message ?>
    <form method="post" action="">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du pouvoir</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-success">Ajouter</button>
          <a href="listePouvoir.php" class="btn btn-secondary ms-2">Retour</a>
        </div>
    </form>
  </div>
</div>
</body>
</html>

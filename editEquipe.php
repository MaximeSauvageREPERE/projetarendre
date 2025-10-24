<?php
require_once 'db.php';
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: listeEquipe.php'); exit; }
$stmt = $pdo->prepare('SELECT * FROM equipe WHERE id = ?');
$stmt->execute([$id]);
$equipe = $stmt->fetch();
if (!$equipe) { header('Location: listeEquipe.php'); exit; }
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    if ($nom) {
        $sql = 'UPDATE equipe SET nom=? WHERE id=?';
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$nom, $id]);
            $message = '<div class="alert alert-success">Équipe modifiée avec succès !</div>';
            $equipe['nom'] = $nom;
        } catch (PDOException $e) {
            $message = '<div class="alert alert-danger">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Veuillez saisir un nom d\'équipe.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une équipe</title>
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
    <h1>Modifier une équipe</h1>
    <?= $message ?>
    <form method="post" action="">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l'équipe</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($equipe['nom']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="listeEquipe.php" class="btn btn-secondary">Retour</a>
    </form>
</div>
</body>
</html>

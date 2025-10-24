<?php
require_once 'db.php';

// Récupérer l'ID du héros
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: listeHero.php');
    exit;
}

// Récupérer les pouvoirs et équipes
$pouvoirs = $pdo->query('SELECT id, nom FROM pouvoir')->fetchAll();
$equipes = $pdo->query('SELECT id, nom FROM equipe')->fetchAll();

// Récupérer le héros
$stmt = $pdo->prepare('SELECT * FROM heros WHERE id = ?');
$stmt->execute([$id]);
$hero = $stmt->fetch();
if (!$hero) {
    header('Location: listeHero.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $alias = $_POST['alias'] ?? '';
    $pouvoir_id = $_POST['pouvoir_id'] ?? '';
    $equipe_id = $_POST['equipe_id'] ?? '';
    if ($nom && $prenom && $alias && $pouvoir_id && $equipe_id) {
        $sql = 'UPDATE heros SET nom=?, prenom=?, alias=?, pouvoir_id=?, equipe_id=? WHERE id=?';
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$nom, $prenom, $alias, $pouvoir_id, $equipe_id, $id]);
            $message = '<div class="alert alert-success">Héros modifié avec succès !</div>';
            // Rafraîchir les données
            $stmt = $pdo->prepare('SELECT * FROM heros WHERE id = ?');
            $stmt->execute([$id]);
            $hero = $stmt->fetch();
        } catch (PDOException $e) {
            $message = '<div class="alert alert-danger">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Veuillez remplir tous les champs.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un héros</title>
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
    <h1>Modifier un super héros</h1>
    <?= $message ?>
    <form method="post" action="">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($hero['nom']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($hero['prenom']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="alias" class="form-label">Alias</label>
            <input type="text" class="form-control" id="alias" name="alias" value="<?= htmlspecialchars($hero['alias']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="pouvoir" class="form-label">Pouvoir</label>
            <select class="form-select" id="pouvoir" name="pouvoir_id" required>
                <option value="">Sélectionner un pouvoir</option>
                <?php foreach ($pouvoirs as $pouvoir): ?>
                    <option value="<?= $pouvoir['id'] ?>" <?= $hero['pouvoir_id'] == $pouvoir['id'] ? 'selected' : '' ?>><?= htmlspecialchars($pouvoir['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="equipe" class="form-label">Équipe</label>
            <select class="form-select" id="equipe" name="equipe_id" required>
                <option value="">Sélectionner une équipe</option>
                <?php foreach ($equipes as $equipe): ?>
                    <option value="<?= $equipe['id'] ?>" <?= $hero['equipe_id'] == $equipe['id'] ? 'selected' : '' ?>><?= htmlspecialchars($equipe['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="listeHero.php" class="btn btn-secondary">Retour</a>
    </form>
</div>
</body>
</html>

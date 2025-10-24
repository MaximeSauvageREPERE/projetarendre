<?php
// Connexion à la base de données et inclusion du modèle Hero
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Hero.php';

// Récupérer l'ID du héros à modifier
$id = $_GET['id'] ?? null;
if (!$id) {
    // Redirection si l'ID n'est pas fourni
    header('Location: listeHero.php');
    exit;
}
// Récupérer les pouvoirs et équipes pour les listes déroulantes
$pouvoirs = $pdo->query('SELECT id, nom FROM pouvoir')->fetchAll();
$equipes = $pdo->query('SELECT id, nom FROM equipe')->fetchAll();
// Récupérer le héros à modifier
$stmt = $pdo->prepare('SELECT * FROM heros WHERE id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    // Redirection si le héros n'existe pas
    header('Location: listeHero.php');
    exit;
}
$hero = Hero::fromArray($row);

// Message d'information
$message = '';
// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des champs du formulaire
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $alias = $_POST['alias'] ?? '';
    $pouvoir_id = $_POST['pouvoir_id'] ?? '';
    $equipe_id = $_POST['equipe_id'] ?? '';
    if ($nom && $prenom && $alias && $pouvoir_id && $equipe_id) {
        // Mise à jour de l'objet Hero
        $hero->nom = $nom;
        $hero->prenom = $prenom;
        $hero->alias = $alias;
        $hero->pouvoir_id = $pouvoir_id;
        $hero->equipe_id = $equipe_id;
        // Mise à jour en base
        $sql = 'UPDATE heros SET nom=?, prenom=?, alias=?, pouvoir_id=?, equipe_id=? WHERE id=?';
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$hero->nom, $hero->prenom, $hero->alias, $hero->pouvoir_id, $hero->equipe_id, $hero->id]);
            $message = '<div class="alert alert-success">Héros modifié avec succès !</div>';
            // Rafraîchir les données de l'objet
            $stmt = $pdo->prepare('SELECT * FROM heros WHERE id = ?');
            $stmt->execute([$hero->id]);
            $hero = Hero::fromArray($stmt->fetch(PDO::FETCH_ASSOC));
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
            max-width: 600px;
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
<!-- Barre de navigation Bootstrap -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Super Héros</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="listeHero.php">Liste des héros</a></li>
        <li class="nav-item"><a class="nav-link" href="../pouvoirs/listePouvoir.php">Liste des pouvoirs</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/listeEquipe.php">Liste des équipes</a></li>
        <li class="nav-item"><a class="nav-link active" href="editHero.php?id=<?= $hero->id ?>">Modifier un héros</a></li>
        <li class="nav-item"><a class="nav-link" href="creationhero.php">Ajouter un héros</a></li>
        <li class="nav-item"><a class="nav-link" href="../pouvoirs/creationpouvoir.php">Ajouter un pouvoir</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/creationequipe.php">Ajouter une équipe</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- Carte centrale contenant le formulaire -->
<div class="container d-flex justify-content-center">
  <div class="main-card w-100">
    <h1 class="text-center text-primary">Modifier un super héros</h1>
    <!-- Affichage du message d'information -->
    <?= $message ?>
    <!-- Formulaire de modification de héros -->
    <form method="post" action="">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($hero->nom) ?>" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($hero->prenom) ?>" required>
        </div>
        <div class="mb-3">
            <label for="alias" class="form-label">Alias</label>
            <input type="text" class="form-control" id="alias" name="alias" value="<?= htmlspecialchars($hero->alias) ?>" required>
        </div>
        <div class="mb-3">
            <label for="pouvoir" class="form-label">Pouvoir</label>
            <select class="form-select" id="pouvoir" name="pouvoir_id" required>
                <option value="">Sélectionner un pouvoir</option>
                <?php foreach ($pouvoirs as $pouvoir): ?>
                    <option value="<?= $pouvoir['id'] ?>" <?= $hero->pouvoir_id == $pouvoir['id'] ? 'selected' : '' ?>><?= htmlspecialchars($pouvoir['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="equipe" class="form-label">Équipe</label>
            <select class="form-select" id="equipe" name="equipe_id" required>
                <option value="">Sélectionner une équipe</option>
                <?php foreach ($equipes as $equipe): ?>
                    <option value="<?= $equipe['id'] ?>" <?= $hero->equipe_id == $equipe['id'] ? 'selected' : '' ?>><?= htmlspecialchars($equipe['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
          <a href="listeHero.php" class="btn btn-secondary ms-2">Retour</a>
        </div>
    </form>
  </div>
</div>
</body>
</html>

<?php
// Connexion à la base de données et inclusion du modèle Hero
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Hero.php';

// Message d'information
$message = '';
// Traitement du formulaire d'ajout de héros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des champs du formulaire
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $alias = $_POST['alias'] ?? '';
    $pouvoir_id = $_POST['pouvoir_id'] ?? '';
    $equipe_id = $_POST['equipe_id'] ?? '';

    // Vérification des champs obligatoires
    if ($nom && $prenom && $alias && $pouvoir_id && $equipe_id) {
        // Création d'un objet Hero
        $hero = new Hero($nom, $prenom, $alias, $pouvoir_id, $equipe_id);
        // Insertion en base
        $sql = 'INSERT INTO hero (nom, prenom, alias, pouvoir_id, equipe_id) VALUES (?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$hero->nom, $hero->prenom, $hero->alias, $hero->pouvoir_id, $hero->equipe_id]);
            $message = '<div class="alert alert-success">Héros créé avec succès !</div>';
        } catch (PDOException $e) {
            $message = '<div class="alert alert-danger">Erreur lors de la création : ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Veuillez remplir tous les champs.</div>';
    }
}
// Récupération des pouvoirs
$stmt = $pdo->query('SELECT id, nom FROM pouvoir');
$pouvoirs = $stmt->fetchAll();
// Récupération des équipes
$stmt = $pdo->query('SELECT id, nom FROM equipe');
$equipes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un héros</title>
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
        <li class="nav-item"><a class="nav-link active" href="creationhero.php">Ajouter un héros</a></li>
        <li class="nav-item"><a class="nav-link" href="../pouvoirs/creationpouvoir.php">Ajouter un pouvoir</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/creationequipe.php">Ajouter une équipe</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- Carte centrale contenant le formulaire -->
<div class="container d-flex justify-content-center">
  <div class="main-card w-100">
    <h1 class="text-center text-primary">Créer un super héros</h1>
    <!-- Affichage du message d'information -->
    <?= $message ?>
    <!-- Formulaire d'ajout de héros -->
    <form method="post" action="">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="mb-3">
            <label for="alias" class="form-label">Alias</label>
            <input type="text" class="form-control" id="alias" name="alias" required>
        </div>
        <div class="mb-3">
            <label for="pouvoir" class="form-label">Pouvoir</label>
            <select class="form-select" id="pouvoir" name="pouvoir_id" required>
                <option value="">Sélectionner un pouvoir</option>
                <?php foreach ($pouvoirs as $pouvoir): ?>
                    <option value="<?= $pouvoir['id'] ?>"><?= htmlspecialchars($pouvoir['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="equipe" class="form-label">Équipe</label>
            <select class="form-select" id="equipe" name="equipe_id" required>
                <option value="">Sélectionner une équipe</option>
                <?php foreach ($equipes as $equipe): ?>
                    <option value="<?= $equipe['id'] ?>"><?= htmlspecialchars($equipe['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">Créer le héros</button>
        </div>
    </form>
  </div>
</div>
</body>
</html>

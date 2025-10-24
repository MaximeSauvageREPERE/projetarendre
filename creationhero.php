<?php
require_once 'db.php';

// Traitement du formulaire
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $alias = $_POST['alias'] ?? '';
    $pouvoir_id = $_POST['pouvoir_id'] ?? '';
    $equipe_id = $_POST['equipe_id'] ?? '';

    if ($nom && $prenom && $alias && $pouvoir_id && $equipe_id) {
        $sql = 'INSERT INTO heros (nom, prenom, alias, pouvoir_id, equipe_id) VALUES (?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$nom, $prenom, $alias, $pouvoir_id, $equipe_id]);
            $message = '<div class="alert alert-success">Héros créé avec succès !</div>';
        } catch (PDOException $e) {
            $message = '<div class="alert alert-danger">Erreur lors de la création : ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Veuillez remplir tous les champs.</div>';
    }
}

// Récupérer les pouvoirs
$stmt = $pdo->query('SELECT id, nom FROM pouvoir');
$pouvoirs = $stmt->fetchAll();

// Récupérer les équipes
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
</head>
<body>
<div class="container mt-5">
    <h1>Créer un super héros</h1>
    <?= $message ?>
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
        <button type="submit" class="btn btn-primary">Créer le héros</button>
    </form>
</div>
</body>
</html>

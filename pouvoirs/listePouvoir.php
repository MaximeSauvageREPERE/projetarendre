<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Pouvoir.php';
$stmt = $pdo->query('SELECT * FROM pouvoir ORDER BY nom');
$pouvoirs = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pouvoirs[] = Pouvoir::fromArray($row);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des pouvoirs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
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
        }
        .table {
            border-radius: 0.75rem;
            overflow: hidden;
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
        <li class="nav-item"><a class="nav-link active" href="listePouvoir.php">Liste des pouvoirs</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/listeEquipe.php">Liste des équipes</a></li>
        <li class="nav-item"><a class="nav-link" href="../heros/creationhero.php">Ajouter un héros</a></li>
        <li class="nav-item"><a class="nav-link" href="creationpouvoir.php">Ajouter un pouvoir</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/creationequipe.php">Ajouter une équipe</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container d-flex justify-content-center">
  <div class="main-card w-100">
    <h1 class="text-center text-primary">Liste des pouvoirs</h1>
    <table id="table-pouvoirs" class="table table-striped table-bordered shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pouvoirs as $pouvoir): ?>
            <tr>
                <td><?= htmlspecialchars($pouvoir->nom) ?></td>
                <td>
                    <a href="editPouvoir.php?id=<?= $pouvoir->id ?>" class="btn btn-warning btn-sm me-2">Modifier</a>
                    <a href="deletePouvoir.php?id=<?= $pouvoir->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce pouvoir ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
      <a href="creationpouvoir.php" class="btn btn-primary">Ajouter un pouvoir</a>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#table-pouvoirs').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json"
        }
    });
});
</script>
</body>
</html>

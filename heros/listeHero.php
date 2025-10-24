<?php
// Connexion à la base de données et inclusion du modèle Hero
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Hero.php';

// Récupérer tous les héros avec leurs pouvoirs et équipes associés
$sql = 'SELECT h.*, p.nom AS pouvoir_nom, e.nom AS equipe_nom FROM hero h
        LEFT JOIN pouvoir p ON h.pouvoir_id = p.id
        LEFT JOIN equipe e ON h.equipe_id = e.id';
$rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
// Transformation des résultats en objets Hero
$heros = array_map(function($row) {
    return Hero::fromArray($row);
}, $rows);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des héros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
            max-width: 1100px;
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
        thead th {
            background-color: #212529 !important;
            color: #fff !important;
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
        <li class="nav-item"><a class="nav-link active" href="listeHero.php">Liste des héros</a></li>
        <li class="nav-item"><a class="nav-link" href="../pouvoirs/listePouvoir.php">Liste des pouvoirs</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/listeEquipe.php">Liste des équipes</a></li>
        <li class="nav-item"><a class="nav-link" href="creationhero.php">Ajouter un héros</a></li>
        <li class="nav-item"><a class="nav-link" href="../pouvoirs/creationpouvoir.php">Ajouter un pouvoir</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/creationequipe.php">Ajouter une équipe</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- Carte centrale contenant la table -->
<div class="container d-flex justify-content-center">
  <div class="main-card w-100">
    <h1 class="text-center text-primary">Liste des super héros</h1>
    <div class="table-responsive">
      <table id="herosTable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
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
              <td><?= $hero->id ?></td>
              <td><?= htmlspecialchars($hero->nom) ?></td>
              <td><?= htmlspecialchars($hero->prenom) ?></td>
              <td><?= htmlspecialchars($hero->alias) ?></td>
              <td><?= htmlspecialchars($hero->pouvoir_nom ?? '') ?></td>
              <td><?= htmlspecialchars($hero->equipe_nom ?? '') ?></td>
              <td>
                <a href="editHero.php?id=<?= $hero->id ?>" class="btn btn-sm btn-warning">Modifier</a>
                <a href="deleteHero.php?id=<?= $hero->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce héros ?');">Supprimer</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- Bouton pour ajouter un héros -->
    <div class="d-flex justify-content-end mt-3">
      <a href="creationhero.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Ajouter un héros
      </a>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
  // Initialisation de DataTables
  $(document).ready(function() {
    $('#herosTable').DataTable({
      language: {
        search: "Recherche :",
        lengthMenu: "Afficher _MENU_ entrées",
        info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
        infoEmpty: "Aucune entrée à afficher",
        infoFiltered: "(filtré de _MAX_ entrées au total)",
        zeroRecords: "Aucun résultat trouvé",
        paginate: {
          first: "Premier",
          last: "Dernier",
          next: "Suivant",
          previous: "Précédent"
        }
      }
    });
  });
</script>
</body>
</html>

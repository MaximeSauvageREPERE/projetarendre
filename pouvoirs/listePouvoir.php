<?php
// Connexion à la base de données et inclusion du modèle Pouvoir
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Pouvoir.php';

// Récupérer tous les pouvoirs
$sql = 'SELECT * FROM pouvoir';
$rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
// Transformation des résultats en objets Pouvoir
$pouvoirs = array_map(function($row) {
    return Pouvoir::fromArray($row);
}, $rows);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des pouvoirs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
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
            max-width: 800px;
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
<!-- Carte centrale contenant la table -->
<div class="container d-flex justify-content-center">
  <div class="main-card w-100">
    <h1 class="text-center text-primary">Liste des pouvoirs</h1>
    <div class="table-responsive">
      <table id="pouvoirsTable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pouvoirs as $pouvoir): ?>
            <tr>
              <td><?= $pouvoir->id ?></td>
              <td><?= htmlspecialchars($pouvoir->nom) ?></td>
              <td>
                <a href="editPouvoir.php?id=<?= $pouvoir->id ?>" class="btn btn-sm btn-warning">Modifier</a>
                <a href="deletePouvoir.php?id=<?= $pouvoir->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce pouvoir ?');">Supprimer</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- Boutons d'export à gauche et bouton Ajouter un pouvoir à droite -->
    <div class="d-flex justify-content-between align-items-center mt-3">
      <div id="exportButtons"></div>
      <a href="creationpouvoir.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Ajouter un pouvoir
      </a>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script>
  // Initialisation de DataTables
  $(document).ready(function() {
    $('#pouvoirsTable').DataTable({
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
      },
      dom: '<"d-flex justify-content-between align-items-center mt-3"Bf>rtip',
      buttons: [
        { extend: 'csv', text: 'Exporter CSV', className: 'btn btn-primary me-2 rounded' },
        { extend: 'excel', text: 'Exporter Excel', className: 'btn btn-primary me-2 rounded' },
        { extend: 'pdf', text: 'Exporter PDF', className: 'btn btn-primary rounded' }
      ]
    });
  });
</script>
</body>
</html>

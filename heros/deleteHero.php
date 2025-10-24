<?php
// Connexion à la base de données et inclusion du modèle Hero
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Hero.php';

// Récupérer l'ID du héros à supprimer
$id = $_GET['id'] ?? null;
if (!$id) {
    // Redirection si l'ID n'est pas fourni
    header('Location: listeHero.php');
    exit;
}
// Préparation de la requête de suppression
$sql = 'DELETE FROM hero WHERE id = ?';
$stmt = $pdo->prepare($sql);
try {
    // Exécution de la suppression
    $stmt->execute([$id]);
    // Message de succès (optionnel, ici redirection directe)
} catch (PDOException $e) {
    // Gestion de l'erreur (optionnel, ici redirection directe)
}
// Redirection vers la liste après suppression
header('Location: listeHero.php');
exit;
?>

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
        <li class="nav-item"><a class="nav-link" href="creationhero.php">Ajouter un héros</a></li>
        <li class="nav-item"><a class="nav-link" href="../pouvoirs/creationpouvoir.php">Ajouter un pouvoir</a></li>
        <li class="nav-item"><a class="nav-link" href="../equipes/creationequipe.php">Ajouter une équipe</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-3">
    <!-- ...le reste du contenu... -->
</div>

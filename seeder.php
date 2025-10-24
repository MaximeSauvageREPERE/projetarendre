<?php
// Seeder pour remplir la base de données avec des exemples
require_once __DIR__ . '/includes/db.php';

// Exemples d'équipes
$equipes = [
    'Avengers',
    'Justice League',
    'X-Men',
    'Gardiens de la Galaxie'
];
// Exemples de pouvoirs
$pouvoirs = [
    'Vol',
    'Force surhumaine',
    'Télépathie',
    'Invisibilité',
    'Vitesse',
    'Contrôle du feu'
];
// Exemples de héros (nom, prénom, alias, pouvoir_id, equipe_id)
$heros = [
    ['Stark', 'Tony', 'Iron Man', 2, 1],
    ['Wayne', 'Bruce', 'Batman', 2, 2],
    ['Grey', 'Jean', 'Phoenix', 3, 3],
    ['Quill', 'Peter', 'Star-Lord', 1, 4],
    ['Kent', 'Clark', 'Superman', 1, 2],
    ['Logan', 'James', 'Wolverine', 2, 3],
];

// Vider les tables (attention, supprime toutes les données existantes !)
$pdo->exec('SET FOREIGN_KEY_CHECKS=0');
$pdo->exec('TRUNCATE TABLE hero');
$pdo->exec('TRUNCATE TABLE equipe');
$pdo->exec('TRUNCATE TABLE pouvoir');
$pdo->exec('SET FOREIGN_KEY_CHECKS=1');

// Insérer les équipes
$stmt = $pdo->prepare('INSERT INTO equipe (nom) VALUES (?)');
foreach ($equipes as $nom) {
    $stmt->execute([$nom]);
}
// Insérer les pouvoirs
$stmt = $pdo->prepare('INSERT INTO pouvoir (nom) VALUES (?)');
foreach ($pouvoirs as $nom) {
    $stmt->execute([$nom]);
}
// Insérer les héros
$stmt = $pdo->prepare('INSERT INTO hero (nom, prenom, alias, pouvoir_id, equipe_id) VALUES (?, ?, ?, ?, ?)');
foreach ($heros as $h) {
    $stmt->execute($h);
}
echo "Seed terminé !";

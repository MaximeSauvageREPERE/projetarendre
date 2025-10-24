<?php
// Paramètres de connexion à la base de données
$host = 'localhost'; // Adresse du serveur MySQL
$db   = 'nom_de_la_base'; // Nom de la base de données à adapter
$user = 'root'; // Nom d'utilisateur MySQL
$pass = ''; // Mot de passe MySQL
$charset = 'utf8mb4'; // Encodage des caractères

// Construction du DSN (Data Source Name) pour PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active les exceptions en cas d'erreur SQL
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Mode de récupération par défaut : tableau associatif
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation des requêtes préparées
];

try {
    // Création de l'objet PDO pour la connexion à la base
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Gestion de l'erreur de connexion
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

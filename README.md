# Super Héros CRUD - Projet PHP

## Présentation
Ce projet est une application web de gestion de super-héros, de leurs équipes et de leurs pouvoirs. Il permet d’ajouter, modifier, supprimer et lister ces entités via une interface moderne et professionnelle (Bootstrap 5, DataTables).

## Fonctionnalités principales
- CRUD complet (Créer, Lire, Mettre à jour, Supprimer) pour :
  - Héros
  - Équipes
  - Pouvoirs
- Interface responsive et ergonomique (Bootstrap 5)
- Tableaux dynamiques avec recherche, tri, pagination et export (CSV, Excel, PDF)
- Architecture orientée objet (POO) avec modèles PHP
- Séparation du code (includes, modèles, vues)

## Structure du projet
```
projetarendre/
├── includes/         # Connexion PDO à la base de données
├── models/           # Modèles PHP (Hero, Equipe, Pouvoir)
├── heros/            # CRUD Héros (création, édition, suppression, liste)
├── equipes/          # CRUD Équipes
├── pouvoirs/         # CRUD Pouvoirs
├── README.md         # Ce fichier
```

## Installation
1. Cloner le dépôt ou copier les fichiers dans `www` de WAMP/XAMPP.
2. Créer la base de données MySQL et importer le schéma (voir ci-dessous).
3. Adapter les paramètres de connexion dans `includes/db.php`.
4. Démarrer le serveur local et accéder à `http://localhost/projetarendre/heros/listeHero.php`.

## Schéma de base de données (exemple)
```sql
CREATE TABLE equipe (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL
);

CREATE TABLE pouvoir (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL
);

CREATE TABLE hero (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100) NOT NULL,
  alias VARCHAR(100) NOT NULL,
  pouvoir_id INT,
  equipe_id INT,
  FOREIGN KEY (pouvoir_id) REFERENCES pouvoir(id),
  FOREIGN KEY (equipe_id) REFERENCES equipe(id)
);
```

## Technologies utilisées
- PHP 8+
- MySQL
- Bootstrap 5
- DataTables (+ extensions Buttons)
- JSZip, pdfmake (pour l’export)

## Sécurité
- Requêtes préparées PDO (anti-injection SQL)
- Échappement des sorties HTML (anti-XSS)
- Pas de gestion d’authentification (projet local)

## Auteurs
- Maxime Sauvage (propriétaire du dépôt)
- Généré et documenté avec l’aide de GitHub Copilot

---
N’hésitez pas à adapter ce projet pour vos besoins ou à demander des améliorations !
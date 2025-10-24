-- Création de la table equipe
CREATE TABLE equipe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

-- Création de la table pouvoir
CREATE TABLE pouvoir (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(20) NOT NULL UNIQUE
);

-- Création de la table heros
CREATE TABLE heros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    alias VARCHAR(50) NOT NULL,
    pouvoir_id INT NOT NULL,
    equipe_id INT NOT NULL,
    FOREIGN KEY (pouvoir_id) REFERENCES pouvoir(id),
    FOREIGN KEY (equipe_id) REFERENCES equipe(id)
);

-- Insertion des équipes
INSERT INTO equipe (nom) VALUES
('Justice League'),
('Marvel'),
('Les 4 Fantastiques');

-- Insertion des pouvoirs
INSERT INTO pouvoir (nom) VALUES
('FEU'),
('EAU'),
('FOUDRE'),
('VENT');

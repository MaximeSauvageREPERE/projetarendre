<?php
// Classe représentant un super héros
class Hero {
    // Propriétés du héros (correspondent aux colonnes de la table heros)
    public $id;
    public $nom;
    public $prenom;
    public $alias;
    public $pouvoir_id;
    public $equipe_id;
    // Propriétés additionnelles pour affichage (jointures)
    public $pouvoir_nom;
    public $equipe_nom;

    // Constructeur pour initialiser un objet Hero
    public function __construct($nom, $prenom = '', $alias = '', $pouvoir_id = null, $equipe_id = null, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->alias = $alias;
        $this->pouvoir_id = $pouvoir_id;
        $this->equipe_id = $equipe_id;
    }

    // Méthode utilitaire pour créer un objet Hero à partir d'un tableau associatif (ex : résultat SQL)
    public static function fromArray(array $data) {
        $hero = new self(
            $data['nom'] ?? '',
            $data['prenom'] ?? '',
            $data['alias'] ?? '',
            $data['pouvoir_id'] ?? null,
            $data['equipe_id'] ?? null,
            $data['id'] ?? null
        );
        // Récupération des noms de pouvoir et d'équipe si présents (jointures)
        $hero->pouvoir_nom = $data['pouvoir_nom'] ?? null;
        $hero->equipe_nom = $data['equipe_nom'] ?? null;
        return $hero;
    }
}

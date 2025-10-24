<?php
// Classe représentant une équipe de super héros
class Equipe {
    // Propriétés de l'équipe (correspondent aux colonnes de la table equipe)
    public $id;
    public $nom;

    // Constructeur pour initialiser un objet Equipe
    public function __construct($nom, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
    }

    // Méthode utilitaire pour créer un objet Equipe à partir d'un tableau associatif (ex : résultat SQL)
    public static function fromArray(array $data) {
        return new self(
            $data['nom'] ?? '',
            $data['id'] ?? null
        );
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'nom' => $this->nom
        ];
    }
}

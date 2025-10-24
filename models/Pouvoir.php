<?php
// Classe représentant un pouvoir de super héros
class Pouvoir {
    // Propriétés du pouvoir (correspondent aux colonnes de la table pouvoir)
    public $id;
    public $nom;

    // Constructeur pour initialiser un objet Pouvoir
    public function __construct($nom, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
    }

    // Méthode utilitaire pour créer un objet Pouvoir à partir d'un tableau associatif (ex : résultat SQL)
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

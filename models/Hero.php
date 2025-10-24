<?php
class Hero {
    public $id;
    public $nom;
    public $prenom;
    public $alias;
    public $pouvoir_id;
    public $equipe_id;
    // Ajout pour compatibilité affichage
    public $pouvoir;
    public $equipe;

    public function __construct($nom, $prenom, $alias, $pouvoir_id, $equipe_id, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->alias = $alias;
        $this->pouvoir_id = $pouvoir_id;
        $this->equipe_id = $equipe_id;
    }

    public static function fromArray($data) {
        return new self(
            $data['nom'],
            $data['prenom'],
            $data['alias'],
            $data['pouvoir_id'],
            $data['equipe_id'],
            isset($data['id']) ? $data['id'] : null
        );
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'alias' => $this->alias,
            'pouvoir_id' => $this->pouvoir_id,
            'equipe_id' => $this->equipe_id
        ];
    }
}

<?php
class Equipe {
    public $id;
    public $nom;

    public function __construct($nom, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
    }

    public static function fromArray($data) {
        return new self(
            $data['nom'],
            isset($data['id']) ? $data['id'] : null
        );
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'nom' => $this->nom
        ];
    }
}

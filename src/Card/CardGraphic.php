<?php

namespace App\Card;

class CardGraphic extends Card {
    private $imagePath;

    public function __construct($suit, $value, $imagePath) {
        parent::__construct($suit, $value);
        $this->imagePath = $imagePath;
    }

    public function getImagePath() {
        return $this->imagePath;
    }
}

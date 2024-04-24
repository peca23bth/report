<?php

namespace App\Card;

class CardHand {
    private $cards = [];

    public function addCard($card) {
        $this->cards[] = $card;
    }

    public function showHand() {
        $hand = [];
        foreach ($this->cards as $card) {
            $hand[] = "{$card->getValue()} of {$card->getSuit()}";
        }
        return $hand;
    }
}

<?php

namespace App\Card;

class DeckOfCards {
    private $cards = [];

    public function __construct() {
        $suits = ['Hearts', 'Spades', 'Diamonds', 'Clubs'];
        $values = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new Card($suit, $value);
            }
        }
    }

    public function toArray() {
        $result = [];
        foreach ($this->cards as $card) {
            $result[] = [
                'suit' => $card->getSuit(),
                'value' => $card->getValue()
            ];
        }
        return $result;
    }    

    public function shuffle() {
        shuffle($this->cards);
    }

    public function drawCard() {
        return array_pop($this->cards);
    }

    public function getCards() {
        return $this->cards;
    }

    public function setCards(array $cards) {
      $this->cards = $cards;
    }

    public function countCards() {
      return count($this->cards);
    }
}

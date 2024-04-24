<?php

namespace App\Card;

class Card {
    private $suit; // Hjärter, Spader, Ruter, Klöver
    private $value; // Ess, 2, 3

    private static $unicodeMap = [
        'Hearts' => [
            'Ace' => '🂱', '2' => '🂲', '3' => '🂳', '4' => '🂴', '5' => '🂵',
            '6' => '🂶', '7' => '🂷', '8' => '🂸', '9' => '🂹', '10' => '🂺',
            'Jack' => '🂻', 'Queen' => '🂽', 'King' => '🂾'
        ],
        'Spades' => [
            'Ace' => '🂡', '2' => '🂢', '3' => '🂣', '4' => '🂤', '5' => '🂥',
            '6' => '🂦', '7' => '🂧', '8' => '🂨', '9' => '🂩', '10' => '🂪',
            'Jack' => '🂫', 'Queen' => '🂭', 'King' => '🂮'
        ],
        'Diamonds' => [
            'Ace' => '🃁', '2' => '🃂', '3' => '🃃', '4' => '🃄', '5' => '🃅',
            '6' => '🃆', '7' => '🃇', '8' => '🃈', '9' => '🃉', '10' => '🃊',
            'Jack' => '🃋', 'Queen' => '🃍', 'King' => '🃎'
        ],
        'Clubs' => [
            'Ace' => '🃑', '2' => '🃒', '3' => '🃓', '4' => '🃔', '5' => '🃕',
            '6' => '🃖', '7' => '🃗', '8' => '🃘', '9' => '🃙', '10' => '🃚',
            'Jack' => '🃛', 'Queen' => '🃝', 'King' => '🃞'
        ]
    ];

    public function __construct($suit, $value) {
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getUnicode() {
        return self::$unicodeMap[$this->suit][$this->value];
    }

    public function getSuit() {
        return $this->suit;
    }

    public function getValue() {
        return $this->value;
    }
}

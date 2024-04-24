<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\DeckOfCards;

class CardController extends AbstractController
{
    #[Route("/card/home", name: "card_home")]
    public function index(): Response
    {
        return $this->render('card/index.html.twig');
    }

    #[Route("/session", name: "session_show")]
    public function showSession(SessionInterface $session): Response {
        $sessionData = [];
        foreach ($session->all() as $key => $value) {
            if (is_object($value) && get_class($value) === 'App\Card\DeckOfCards') {
                $sessionData[$key] = $value->toArray();
            } else {
                $sessionData[$key] = $value;
            }
        }
    
        return $this->render('card/session.html.twig', [
            'sessionData' => $sessionData
        ]);
    }    

    #[Route("/session/delete", name: "session_delete")]
    public function deleteSession(SessionInterface $session): Response
    {
        $session->clear();
        $this->addFlash('success', 'Sessionen är raderad');
        return $this->redirectToRoute('card_home');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(SessionInterface $session): Response
    {
        $deck = $session->get('deck', new DeckOfCards());
        $deck->shuffle();
    
        $cards = $deck->getCards();
    
        usort($cards, function($a, $b) {
            $order = ['Clubs' => 0, 'Diamonds' => 1, 'Hearts' => 2, 'Spades' => 3];
            $valueOrder = [
                '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6,
                '7' => 7, '8' => 8, '9' => 9, '10' => 10,
                'Jack' => 11, 'Queen' => 12, 'King' => 13, 'Ace' => 1
            ];

            if ($order[$a->getSuit()] === $order[$b->getSuit()]) {
                return ($valueOrder[$a->getValue()] < $valueOrder[$b->getValue()]) ? -1 : 1;
            }
            return ($order[$a->getSuit()] < $order[$b->getSuit()]) ? -1 : 1;
        });

        return $this->render('card/deck.html.twig', [
            'deck' => $cards
        ]);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = $session->get('deck', new DeckOfCards());
        $deck->shuffle();
        $session->set('deck', $deck);  // Spara den blandade kortleken i sessionen

        return $this->render('card/shuffle.html.twig', [
            'deck' => $deck->getCards()  // Skicka korten till vyn
        ]);
    }


    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function draw(SessionInterface $session): Response
    {
        $deck = $session->get('deck', new DeckOfCards());
        if ($deck->countCards() > 0) {
            $card = $deck->drawCard();
            $session->set('deck', $deck); // Uppdatera kortleken i sessionen
        } else {
            $card = null;
            $this->addFlash('notice', 'Inga fler kort att dra.');
        }

        return $this->render('card/draw.html.twig', [
            'card' => $card,
            'remaining' => $deck->countCards() // Antalet återstående kort
        ]);
    }


    #[Route("/card/deck/draw/{number}", name: "card_deck_draw_multiple")]
    public function drawMultiple(SessionInterface $session, int $number): Response
    {
        $deck = $session->get('deck', new DeckOfCards());
        $cards = [];
        for ($i = 0; $i < $number; $i++) {
            if ($deck->countCards() > 0) {
                $cards[] = $deck->drawCard();
            } else {
                break;
            }
        }
        $session->set('deck', $deck);
    
        return $this->render('card/draw_multiple.html.twig', [
            'cards' => $cards,
            'remaining' => $deck->countCards()
        ]);
    }
    
}

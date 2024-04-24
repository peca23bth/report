<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Card\DeckOfCards;
use Symfony\Component\Routing\RouterInterface;

class ApiController extends AbstractController
{
    #[Route("/api/", name: "api_index")]
    public function index(RouterInterface $router)
    {
        $routes = [];
        foreach ($router->getRouteCollection()->all() as $name => $route) {
            if (strpos($route->getPath(), '/api/') === 0) {
                $description = $this->getRouteDescription($name);
                $routes[$name] = [
                    'path' => $route->getPath(),
                    'methods' => $route->getMethods() ?: ['ANY'],
                    'description' => $description
                ];
            }
        }
    
        return $this->render('api/index.html.twig', [
            'routes' => $routes
        ]);
    }
    
    private function getRouteDescription(string $routeName): string
    {
        $descriptions = [
            'api_index' => 'Visar alla API-routes.',
            'api_deck' => 'Visar JSON-struktur med sorterad kortlek.',
            'api_deck_shuffle' => 'Blandar kortleken och returnerar den som en JSON-struktur.',
            'api_deck_draw' => 'Drar ett kort från kortleken och visar antalet kort som är kvar.',
            'api_deck_draw_multiple' => 'Drar ett specificerat antal kort visar antalet kvarvarande kort som en JSON-struktur.'
        ];
    
        return $descriptions[$routeName] ?? 'Ingen beskrivning tillgänglig.';
    }

    #[Route('/api/deck', name: 'api_deck', methods: ['GET'])]
    public function getDeck(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck', new DeckOfCards());
        $deck->sort();
        return $this->json([
            'deck' => $deck->toArray()
        ]);
    }

    #[Route('/api/deck/shuffle', name: 'api_deck_shuffle', methods: ['POST'])]
    public function shuffleDeck(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck', new DeckOfCards());
        $deck->shuffle();
        $session->set('deck', $deck);
        return $this->json([
            'deck' => $deck->toArray()
        ]);
    }

    #[Route('/api/deck/draw', name: 'api_deck_draw', methods: ['POST'])]
    public function drawCard(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck', new DeckOfCards());
        $card = $deck->drawCard();
        $session->set('deck', $deck);
        return $this->json([
            'card' => $card ? $card->toArray() : null,
            'remaining' => $deck->countCards()
        ]);
    }

    #[Route('/api/deck/draw/{number}', name: 'api_deck_draw_multiple', methods: ['POST'])]
    public function drawMultipleCards(SessionInterface $session, int $number): JsonResponse
    {
        $deck = $session->get('deck', new DeckOfCards());
        $cards = [];
        for ($i = 0; $i < $number && $deck->countCards() > 0; $i++) {
            $cards[] = $deck->drawCard();
        }
        $session->set('deck', $deck);
        return $this->json([
            'cards' => array_map(function ($card) { return $card->toArray(); }, $cards),
            'remaining' => $deck->countCards()
        ]);
    }
}

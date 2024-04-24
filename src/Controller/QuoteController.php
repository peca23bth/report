<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    #[Route("/api/quote", name: "api_quote")]
    public function quote(): JsonResponse
    {

        $quotes = [
            "Life is to important to take it seriously.",
            "Dont wait for tomorrow",
            "Work hard, play hard"
        ];


        $randomQuote = $quotes[array_rand($quotes)];


        $date = new \DateTime("now", new \DateTimeZone('Europe/Stockholm'));
        $dateFormat = $date->format('Y-m-d');
        $timeStamp = $date->format('c');


        $data = [
            'citat' => $randomQuote,
            'datum' => $dateFormat,
            'tidstampel' => $timeStamp
        ];


        return new JsonResponse($data);
    }
}

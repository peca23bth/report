<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController
{
    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Här är ditt lyckonummer (just nu iaf), du kommer få ett nytt varje gång :): '.$number.'</body></html>'
        );
    }

    #[Route("/lucky/hi")]
    public function hi(): Response
    {
        return new Response(
            '<html><body>Hi to you!</body></html>'
        );
    }

    #[Route("/api/lucky/number")]
    public function jsonNnumber(): Response
    {
        $this->number = random_int(0, 100);

        $data = [
            'lucky-number' => $this->number,
            'lucky-message' => 'Hi there!',
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        //return new JsonResponse($data);

        // return new JsonResponse;

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}

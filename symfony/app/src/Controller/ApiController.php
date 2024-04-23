<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class ApiController extends AbstractController
{
    #[Route("/api/", name: "api_index")]
    public function index(RouterInterface $router)
    {
        $routes = [];

        foreach ($router->getRouteCollection()->all() as $name => $route) {
            if (strpos($route->getPath(), '/api/lucky/number') === 0) {
                $routes[$name] = [
                    'path' => $route->getPath(),
                    'methods' => $route->getMethods() ?: ['ANY']
                ];
            }
        }

        return $this->render('api/index.html.twig', [
            'routes' => $routes
        ]);
    }
}

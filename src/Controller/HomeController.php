<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController // Controller interface extends AbstractController class 
{

    // "/" => le chemin de cette route
    // "app_home" => le nom de la route qui nous servira au moment de l'appelle des routes dans twig
    #[Route('/', name: 'app_home')] // Route annotation to map the route to the controller method 
    public function index(): Response
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'Islem FOURATI',
        ]);
    }
}

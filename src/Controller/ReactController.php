<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReactController extends AbstractController
{
    #[Route('/react', name: 'app_react')]
    public function index(): Response
    {
        return $this->render('react/reactCategories.html.twig', [
            'cookie' => isset($_COOKIE['theme']) ? $_COOKIE['theme'] : null,
        ]);
    }
}

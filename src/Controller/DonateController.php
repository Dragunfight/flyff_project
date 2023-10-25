<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DonateController extends AbstractController
{
    #[Route('/donate', name: 'app_donate')]
    public function index(): Response
    {
        return $this->render('donate/donate.html.twig', [
            'controller_name' => 'DonateController',
        ]);
    }
}

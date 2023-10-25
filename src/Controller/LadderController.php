<?php

namespace App\Controller;

use App\Repository\CharacterRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LadderController extends AbstractController
{
    #[Route('/ladder', name: 'app_ladder')]
    public function showRanking(CharacterRepository $characRepo): Response
    {

        $characters = $characRepo->findBy([], ['xp' => 'DESC']);

        return $this->render('ladder/ladder.html.twig', [
            'characters' => $characters,
        ]);
    }
}

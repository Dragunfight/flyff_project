<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/profile', name: 'app_profile')]
    public function showProfile(): Response
    {
        $user = $this->getUser();
        
        return $this->render('profile/profile.html.twig', [
            'user' => $user,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\GameAccount;
use App\Form\GameAccountFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GameAccountController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/game_account', name: 'app_game_account')]
    public function index(): Response
    {
        $user = $this->getUser();
  
        return $this->render('game_account/game_account.html.twig', [
            'user' => $user,
        ]);
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/game_account/create', name: 'app_game_account_create')]
    public function create(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {

        $account = new GameAccount();
        $form = $this->createForm(GameAccountFormType::class, $account);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $account->setUser($user);
            $account->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($account);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('game_account/create.html.twig', [
            'accountcreateform' => $form->createView(),
        ]);
    }
}

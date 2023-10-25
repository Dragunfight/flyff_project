<?php

namespace App\Controller;

use App\Services\CartService;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(OrderRepository $orderRepo, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {

        $orderId = $session->get("orderId");
        $order = $orderRepo->find($orderId);

        if (!$order) {
            // Gérez le cas où la commande n'a pas été trouvée
            // Redirigez l'utilisateur vers une page d'erreur ou une autre page appropriée
            // ...
        }

        $orderPrice = $order->getTotalPrice();
        $user = $this->getUser();
        $userPoints = $user->getCashpoints();

        if ($userPoints >= $orderPrice) {

            $user->setCashpoints($userPoints - $orderPrice);

            $entityManager->persist($user);
            $entityManager->flush();

            $session->remove('cart');

            return $this->render('checkout/success.html.twig', [
                'order' => $order,
            ]);
        } else {

                $entityManager->remove($order);
                $entityManager->flush();
                
            return $this->render('checkout/error.html.twig', [
                'message' => 'Vous n\'avez pas suffisamment de points pour effectuer ce paiement.',
            ]);
        }
    }
}

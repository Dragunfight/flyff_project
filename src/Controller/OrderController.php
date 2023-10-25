<?php

namespace App\Controller;

use DateTime;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Services\CartService;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    // #[Route('/order', name: 'app_order')]
    // public function index(): Response
    // {
    //     return $this->render('order/index.html.twig', [
    //         'controller_name' => 'OrderController',
    //     ]);
    // }

    #[IsGranted("ROLE_USER")]
    #[Route('/order/validation', name: 'app_order_validation')]
    public function validate(CartService $cartService, OrderRepository $orderRepo, SessionInterface $session): Response
    {

        $order = new Order();
        $cart = $cartService->getCartProducts();
        $productLine = $cart[0][0];

        foreach($cart[0] as $productLine){
            $orderDetail = new OrderDetail();
            
            $orderDetail->setProduct($productLine['product']);
            $orderDetail->setQuantity($productLine['quantity']);
            $orderDetail->setPrice($productLine['price']);

            $order->addOrderDetail($orderDetail);
        }

        $order->setUser($this->getUser());
        $order->setTotalPrice($cart[1]);
        $order->setCreatedAt(new DateTime());
        $order->setUpdatedAt(new DateTime());

        $orderRepo->save($order, true);

        $ValidatedOrder = $order->getId();
        $session->set("orderId", $ValidatedOrder);

        return $this->redirectToRoute('app_checkout');
    }
}

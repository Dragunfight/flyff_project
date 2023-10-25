<?php

namespace App\Controller;

use App\Services\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
 
    #[IsGranted("ROLE_USER")]
    #[Route('/cart', name: 'app_cart')]
    public function show(CartService $cartService, ProductRepository $productRepo): Response
    {
        $cart = $cartService->getCart();
        $cartproducts = [];

        foreach ($cart as $id => $quantity) {
            $cartproduct = $productRepo->find($id);
            $cartproducts[] = $cartproduct;
        }

        return $this->render('cart/cart.html.twig', [
            'cartproducts' => $cartproducts,
        ]);
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/cart/add/{id}', name: 'app_add_cart')]
    public function add(int $id, CartService $cartService, Request $request): Response
    {

        $quantity = $request->query->getInt('quantity', 1);
        $cartService->add($id, $quantity);

        return $this->redirectToRoute('app_shop');
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/cart/delete/{id}', name: 'app_delete_cart')]
    public function delete(int $id, CartService $cartService): Response
    {
        
        $cartService->delete($id);

        return $this->redirectToRoute('app_shop');
    }
}

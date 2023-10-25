<?php

namespace App\Controller;

use App\Services\CartService;
use App\Repository\ProductRepository;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/shop', name: 'app_shop')]
    public function showAll(CartService $cartService, Request $request, ProductRepository $productRepo, ProductCategoryRepository $productCatRepo): Response
    {

        $categories = $productCatRepo->findAll();
        $cart = $cartService->getCart();
        $cartproducts = [];

        $selectedCategory = null;
        if ($request->query->has('category')) {
            $categoryId = $request->query->get('category');
            $selectedCategory = $productCatRepo->find($categoryId);
        }
        if ($selectedCategory === null) {
            $products = $productRepo->findAll();
        } else {
            $products = $productRepo->findByCategory($selectedCategory);
        }

        foreach ($cart as $id => $quantity) {
            $cartproduct = $productRepo->find($id);
            $cartproducts[] = $cartproduct;
        }

        return $this->render('shop/shop.html.twig', [
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'products' => $products,
            'cartproducts' => $cartproducts,
        ]);
    }
}

<?php

namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService 
{
    private SessionInterface $session;
    private array $cart;

    public function __construct(RequestStack $requestStack, private ProductRepository $productRepo)
    {
        $this->session = $requestStack->getSession();
        $this->cart = $this->getCart();
    }

    public function getCart()
    {
        return $this->session->get("cart", []);
    }

    public function add(int $id, int $quantity)
    {
        $cart = $this->getCart();

        if (array_key_exists($id, $cart)) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }

        $this->session->set('cart', $cart);
    }

    public function delete(int $id)
    {
        $cart = $this->getCart();

        if (array_key_exists($id, $cart)) {
            if ($cart[$id] > 1) {
                $cart[$id]--; 
            } else {
                unset($cart[$id]);
            }
            $this->session->set('cart', $cart);
        }

    }

    public function getCartProducts()
    {
        $results = [];
        $priceTab = 0;

        foreach ($this->cart as $id => $quantity) 
        {
            
            $product = $this->productRepo->find($id);
            $productLine = [
                "product" => $product,
                "quantity" => $quantity,
                "price" => $product->getPrice() * $quantity,
            ];
            $priceTab += $product->getPrice() * $quantity;

            array_push($results, $productLine);
        }

        return [$results,$priceTab] ;
    }

    public function getProductsToStripe()
    {
        foreach ($this->cart as $id => $quantity) 
        {
            $product = $this->productRepo->find($id);
            $productLine[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                  'name' => $product->getName(),
                ],
                'unit_amount' => $product->getPrice(),
              ],
              'quantity' => $quantity,
            ];
        }
        
        return $productLine;
    }
}
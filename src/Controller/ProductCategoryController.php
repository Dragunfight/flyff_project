<?php

namespace App\Controller;

use App\Entity\ProductCategory;
use App\Form\ProductCategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductCategoryController extends AbstractController
{
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/product/category/create', name: 'app_product_category_create')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $productCategory = new ProductCategory();

        $form = $this->createForm(ProductCategoryFormType::class, $productCategory);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $productCategory = $form->getData();
            $entityManager->persist($productCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_category_create');
        }

        return $this->render('product_category/create.html.twig', [
            'productCategoryForm' => $form,
        ]);
    }

    public function getProductCategories(ProductCategoryRepository $productCatRepo): Response
    { 
        return $this->render('home/home.html.twig', [
            'categories' => $productCatRepo->findAll(),
        ]);
    }
}

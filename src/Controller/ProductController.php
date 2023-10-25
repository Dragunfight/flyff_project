<?php

namespace App\Controller;

use DateTime;
use App\Entity\Product;
use App\Form\ProductFromType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/product/create', name: 'app_product_create')]
    public function create(SluggerInterface $slugger, Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductFromType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('upload_directory') . '/shop',
                    $newFilename
                );

                $product->setImage($newFilename);
            }

            $product->setCreatedAt(new DateTime());
            $product->setUpdatedAt(new DateTime());

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_create');
        }

        return $this->render('product/create.html.twig', [
            'productform' => $form,
        ]);
    }
}

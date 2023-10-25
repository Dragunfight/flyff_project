<?php

namespace App\Controller;


use App\Repository\PostCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostCategoryController extends AbstractController
{
    // #[Route('/post/category', name: 'app_post_category')]
    // public function index(): Response
    // {
    //     return $this->render('post_category/index.html.twig', [
    //         'controller_name' => 'PostCategoryController',
    //     ]);
    // }

    public function getPostCategories(PostCategoryRepository $postCatRepo): Response
    { 
        return $this->render('home/home.html.twig', [
            'categories' => $postCatRepo->findAll(),
        ]);
    }
}

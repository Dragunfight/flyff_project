<?php

namespace App\Controller;


use App\Repository\PostCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostCategoryController extends AbstractController
{
    public function getPostCategories(PostCategoryRepository $postCatRepo): Response
    { 
        return $this->render('home/home.html.twig', [
            'categories' => $postCatRepo->findAll(),
        ]);
    }
}

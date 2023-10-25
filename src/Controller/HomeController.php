<?php

namespace App\Controller;

use App\Repository\PostCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]

    public function showNewsPosts(PostCategoryRepository $categoryRepo): Response
    {  
        $user = $this->getUser();
        $newsCategory = $categoryRepo->findOneByName("news");
        $newsPosts = $newsCategory->getPosts();

        return $this->render('home/home.html.twig', [
            'posts' => $newsPosts,
            'user' => $user
        ]);
    } 
}

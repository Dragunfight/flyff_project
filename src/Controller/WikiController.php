<?php

namespace App\Controller;

use App\Repository\PostCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WikiController extends AbstractController
{
    #[Route('/wiki', name: 'app_wiki')]
    public function showWikiPosts(PostCategoryRepository $categoryRepo): Response
    {  
        $wikiCategory = $categoryRepo->findOneByName("wiki");
        $wikiPosts = $wikiCategory->getPosts();

        return $this->render('wiki/wiki.html.twig', [
            'posts' => $wikiPosts,
        ]);
    }
}

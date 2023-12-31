<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    #[Route('/download', name: 'app_download')]
    public function index(): Response
    {
        return $this->render('download/download.html.twig', [
            'controller_name' => 'DownloadController',
        ]);
    }
}

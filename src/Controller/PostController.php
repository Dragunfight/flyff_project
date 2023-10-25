<?php

namespace App\Controller;

use DateTime;
use App\Entity\Post;
use App\Form\PostFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/post/create', name: 'app_post_create')]
    public function create(SluggerInterface $slugger, Request $request, EntityManagerInterface $entityManager): Response
    {

        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $post->setSlug($slugger->slug($form->get("title")->getData()));
            $post->setUser($this->getUser());
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('upload_directory') . '/posts',
                    $newFilename
                );

                $post->setImage($newFilename);
            }

            $post->setCreatedAt(new DateTime());
            $post->setUpdatedAt(new DateTime());

            $entityManager->persist($post);
            $entityManager->flush();

            $category = $post->getCategories()->getName();
            
            if($category === 'new') {
                return $this->redirectToRoute('app_home');
            } elseif ($category === 'wiki') {
                return $this->redirectToRoute('app_wiki');
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('post/create.html.twig', [
            'createpostform' => $form->createView(),
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/post/update/{id}', name: 'app_post_update')]
    public function update(int $id, SluggerInterface $slugger, Request $request, EntityManagerInterface $entityManager): Response
    {

        $post = $entityManager->find(Post::class, $id);
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $post->setSlug($slugger->slug($form->get("title")->getData()));
          
            $post->setUser($this->getUser());
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('upload_directory') . '/posts',
                    $newFilename
                );

                $post->setImage($newFilename);
            }

            $post->setUpdatedAt(new DateTime());


            $entityManager->flush();


            $category = $post->getCategories()->getName();
            
            if($category === 'new') {
                return $this->redirectToRoute('app_home');
            } elseif ($category === 'wiki') {
                return $this->redirectToRoute('app_wiki');
            }

            return $this->redirectToRoute('app_home', ['id' => $post->getId()]);
        }

        return $this->render('post/create.html.twig', [
            'createpostform' => $form->createView(),
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/post/delete/{id}', name: 'app_post_delete')]
    public function delete(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {

        $post = $entityManager->find(Post::class, $id);

        $entityManager->remove($post);
        $entityManager->flush();

        $previousUrl = $request->headers->get("referer");

        return $this->redirect($previousUrl);
    }  
}

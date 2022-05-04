<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\AddFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdatePostController extends AbstractController
{
    /**
     * @Route("/update/{id}", name="app_update_post")
     */
    public function index(int $id, ManagerRegistry $doctrine, Request $request): Response
    {

        $entityManager = $doctrine->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for id ' . $id
            );
        }

        $form = $this->createForm(AddFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();
        }

        return $this->render('update_post/index.html.twig', [
            'controller_name' => 'UpdatePostController',
            'form' => $form->createView()
        ]);
    }
}

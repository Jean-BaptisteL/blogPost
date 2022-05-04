<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\AddFormType;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddPostController extends AbstractController
{
    /**
     * @Route("/", name="app_add_post")
     */
    public function index(PostRepository $postRepository, Request $request, ManagerRegistry $doctrine): Response
    {

        $post = new Post;
        $form = $this->createForm(AddFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prout = $doctrine->getManager();
            $prout->persist($form->getData());
            $prout->flush();
            $this->addFlash('success', 'Le post a été posté WALHA');
        }

        return $this->render('add_post/index.html.twig', [
            'form' => $form->createView(),
            'post' => $post
        ]);
    }
}

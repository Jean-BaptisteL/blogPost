<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReadPostController extends AbstractController
{
    /**
     * @Route("/list-posts", name="app_read_post")
     */
    public function index(PostRepository $repository): Response
    {
        $listPost = $repository->findAll();
        return $this->render('read_post/index.html.twig', [
            'listPost' => $listPost,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_delete_post")
     */
    public function delete(Request $request, Post $post, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), (string) $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager -> remove($post);
            $entityManager -> flush();

            $this->addFlash('success', 'Le post a bien été supprimé!');
        }   
        return $this->redirectToRoute('app_read_post');
    }
}

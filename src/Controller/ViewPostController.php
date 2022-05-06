<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ViewPostController extends AbstractController
{
    /**
     * @Route("/post/{id}", name="app_view_post")
     */
    public function index(PostRepository $repo, int $id): Response
    {
        $post = $repo->find($id);
        return $this->render('view_post/index.html.twig', [
            'post' => $post
        ]);
    }
}

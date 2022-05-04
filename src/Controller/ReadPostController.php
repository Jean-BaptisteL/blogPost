<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
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
            'controller_name' => 'ReadPostController',
            'listPost' => $listPost,
        ]);
    }
}
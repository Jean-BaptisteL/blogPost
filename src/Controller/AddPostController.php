<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddPostController extends AbstractController
{
    /**
     * @Route("/add/post", name="app_add_post")
     */
    public function index(): Response
    {
        return $this->render('add_post/index.html.twig', [
            'controller_name' => 'AddPostController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReadCategoryController extends AbstractController
{
    /**
     * @Route("/read/category", name="app_read_category")
     */
    public function index(CategoryRepository $repository): Response
    {
        $listCategory = $repository->findAll();
        return $this->render('read_category/index.html.twig', [
            'listCategory' => $listCategory,
        ]);
    }
}

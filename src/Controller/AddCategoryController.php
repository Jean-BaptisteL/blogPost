<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\AddCategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddCategoryController extends AbstractController
{
    /**
     * @Route("/add/category", name="app_add_category")
     */
    public function index(CategoryRepository $categoryRepository, Request $request, ManagerRegistry $doctrine): Response
    {
        $category = new Category;
        $form = $this->createForm(AddCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prout = $doctrine->getManager();
            $prout->persist($form->getData());
            $prout->flush();
            $this->addFlash('success', 'La catégorie a été enregistrée Wesh');
        }

        return $this->render('add_category/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

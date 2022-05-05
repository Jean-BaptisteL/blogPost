<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\AddCategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateCategoryController extends AbstractController
{
    /**
     * @Route("/update/category/{id}", name="app_update_category")
     */
    public function index(int $id, ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $category = $entityManager->getRepository(Category::class)->find($id); 

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id ' . $id
            );
        }

        $form = $this->createForm(AddCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();
        }
        return $this->render('update_category/index.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

      /**
     * @Route("/delete-category/{id}", name="app_delete_category")
     */
    public function delete(Request $request, Category $category, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), (string) $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager -> remove($category);
            $entityManager -> flush();

            $this->addFlash('success', 'La catégorie a bien été supprimée! Prout ! ');
        }   
        return $this->redirectToRoute('app_read_category');
    }
}

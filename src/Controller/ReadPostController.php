<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReadPostController extends AbstractController
{
    /**
     * @Route("/", name="app_read_post")
     */
    public function index(PostRepository $repository): Response
    {

        $user = $this->getUser();
        $listPost = [];

        if ($user) {
            $listPost = $repository->findPostByUser($user);
            return $this->render('read_post/index.html.twig', [
                'listPost' => $listPost,
                'user' => $user
            ]);
        }

        $listPost = $repository->findVisiblePosts();
        return $this->render('read_post/index.html.twig', [
            'listPost' => $listPost,
        ]);
    }

    /**
     * @Route("/posts/{category}", name="app_read_post_category")
     */
    public function postsByCategory(PostRepository $repository, CategoryRepository $cateRepo, string $category): Response
    {

        $user = $this->getUser();
        $listPost = [];
        $categoryFinded = $cateRepo->findOneBySlug($category);

        if ($user) {
            $listPost = $repository->findPostByCategory($categoryFinded);
            return $this->render('read_post/index.html.twig', [
                'listPost' => $listPost,
                'user' => $user
            ]);
        }

        $listPost = $repository->findPostByCategory($categoryFinded);
        return $this->render('read_post/index.html.twig', [
            'listPost' => $listPost,
        ]);
    }

        /**
     * @Route("/postByAuthor/{id}", name="app_read_post_user")
     */
    public function postsByUser(PostRepository $repository, int $id): Response
    {

        $user = $this->getUser();
        $listPost = [];

        if ($user) {
            $listPost = $repository->findAuthorPosts($id);
            return $this->render('read_post/index.html.twig', [
                'listPost' => $listPost,
                'user' => $user
            ]);
        }

        $listPost = $repository->findAuthorPosts($id);
        return $this->render('read_post/index.html.twig', [
            'listPost' => $listPost,
        ]);
    }

    /**
     * @Route("/delete/{id}/admin", name="app_delete_post")
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

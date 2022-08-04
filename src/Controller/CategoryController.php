<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="app_category")
     */
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("categories", name="categories_list")
     */                                 // autowire
    public function listCategories(CategoryRepository $categoryRepository)
    {
        // la méthode findAll récupère toutes les catégories enregistrées dans la base de données.
        $categories = $categoryRepository->findAll();

        return $this->render("categories_list.html.twig", ['categories' => $categories]);
    }

    // Exercice : faire une méthode qui affiche les tags (nom, description) 
    // et une méthode qui va afficher les articles (titre, contenu)

    /**
     * @Route("category/{id}", name="category_show")
     */
    public function showCategory($id, CategoryRepository $categoryRepository)
    {
        // la méthode find permet de récupérer une catégorie en fonction de son id.
        $category = $categoryRepository->find($id);

        return $this->render("category_show.html.twig", ['category' => $category]);
    }

    /**
     * @Route("update/category/{id}", name="update_category")
     */
    public function updateCategory(
        $id,
        CategoryRepository $categoryRepository,
        EntityManagerInterface $entityManagerInterface
    ) {
        $category = $categoryRepository->find($id);

        $category->setName("Nouveau Nom de la Category");

        $entityManagerInterface->persist($category);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("categories_list");
    }
}

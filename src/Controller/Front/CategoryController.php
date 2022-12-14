<?php

namespace App\Controller\Front;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories/", name="front_category_list")
     */
    //////////////////////////////////// autowire
    public function listCategories(CategoryRepository $categoryRepository)
    {
        // la méthode findAll récupère toutes les catégories enregistrées dans la base de données.
        $categories = $categoryRepository->findAll();

        return $this->render("front/categories_list.html.twig", ['categories' => $categories]);
    }

    // Exercice : faire une méthode qui affiche les tags (nom, description) 
    // et une méthode qui va afficher les articles (titre, contenu)

    /**
     * @Route("/category/{id}", name="front_category_show")
     */
    public function showCategory($id, CategoryRepository $categoryRepository)
    {
        // la méthode find permet de récupérer une catégorie en fonction de son id.
        $category = $categoryRepository->find($id);

        return $this->render("front/category_show.html.twig", ['category' => $category]);
    }
}

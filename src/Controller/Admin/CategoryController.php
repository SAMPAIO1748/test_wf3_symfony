<?php

namespace App\Controller\Admin;

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

    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
    //////////////////////////////////// autowire
    public function listCategories(CategoryRepository $categoryRepository)
    {
        // la méthode findAll récupère toutes les catégories enregistrées dans la base de données.
        $categories = $categoryRepository->findAll();

        return $this->render("admin/categories_list.html.twig", ['categories' => $categories]);
    }

    // Exercice : faire une méthode qui affiche les tags (nom, description) 
    // et une méthode qui va afficher les articles (titre, contenu)

    public function showCategory($id, CategoryRepository $categoryRepository)
    {
        // la méthode find permet de récupérer une catégorie en fonction de son id.
        $category = $categoryRepository->find($id);

        return $this->render("admin/category_show.html.twig", ['category' => $category]);
    }

    public function updateCategory(
        $id,
        CategoryRepository $categoryRepository,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {
        $category = $categoryRepository->find($id);

        // on crée le formualire en spécifiant quel type de form on utilise
        // et à quel objet on l'applique
        $categoryForm = $this->createForm(CategoryType::class, $category);

        // On spécifie à notre formualire qu'il récupère toutes les informations
        // rentrées dans le formaulire et il doit les traiter.
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            $entityManagerInterface->persist($category);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_categories_list");
        }


        return $this->render("admin/category_form.html.twig", ['categoryForm' => $categoryForm->createView()]);
    }

    public function createCategory(EntityManagerInterface $entityManagerInterface, Request $request)
    {
        $category = new Category();

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            // $category->setName("Nouvelle catégorie");
            // $category->setDescription("Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus voluptate sed, sit dolores delectus est maiores vel fugiat enim perspiciatis, odio voluptas ab optio facilis adipisci repellendus, ex distinctio. Amet.");

            $entityManagerInterface->persist($category);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_categories_list");
        }

        return $this->render('admin/category_form.html.twig', ['categoryForm' => $categoryForm->createView()]);
    }

    public function deleteCategory(
        $id,
        CategoryRepository $categoryRepository,
        EntityManagerInterface $entityManagerInterface
    ) {
        $category = $categoryRepository->find($id);

        $entityManagerInterface->remove($category);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_categories_list");
    }

    // Exercices : supprimer les routes du CategoryController pour les coder dans routes.yaml
}

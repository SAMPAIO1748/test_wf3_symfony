<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    public function listPosts(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render("admin/posts_list.html.twig", ['articles' => $articles]);
    }

    /**
     * @Route("/admin/post/{id}", name="admin_post_show")
     */
    public function showPost($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);

        return $this->render("admin/post_show.html.twig", ['article' => $article]);
    }

    // Exercice :  céer les routes qui vont afficher une catégorie
    // et un tag sélectionné grâce à leurs id.
    // Sur la vue il faudra afficher toutes les informations
    // càd name, description, et le title des articles pour 
    // category et name, description, color et le title des articles
    // pour tag

    /**
     * @Route("/admin/update/post/{id}", name="admin_update_post")
     */
    public function update(
        $id,
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {
        // J'ai sélectionné l'article que je souhaite modifié
        $article = $articleRepository->find($id);

        // Je modifie le titre de mon article sélectionné
        // cet article est un objet PHP.
        // $article->setTitle("Nouveau titre");

        $articleForm = $this->createForm(ArticleType::class, $article);
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            // persist a pour mission de regarder l'origine de $article
            // et en fonction de l'origine, il va appliquer soit 
            // un update soit un create en SQL 
            $entityManagerInterface->persist($article);

            // flush va enregistrer le changement dans la bdd.
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_posts_list");
        }

        return $this->render("admin/article_form.html.twig", ['articleForm' => $articleForm->createView()]);
    }

    // Exercice : créer une méthode update_tag qui va changer le nom du tag et faire de même pour category

    /**
     * @Route("/admin/create/post", name="admin_create_post")
     */
    public function createPost(EntityManagerInterface $entityManagerInterface, Request $request)
    {
        // création du nouvel article
        $article = new Article();

        $articleForm = $this->createForm(ArticleType::class, $article);

        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            //$article->setTitle("Nouvel Article");
            //$article->setContent("Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, eius illum //accusantium suscipit ea ut, rem unde commodi esse minus ratione voluptas adipisci sed voluptates officiis magni aperiam corrupti pariatur.");

            $entityManagerInterface->persist($article);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_posts_list");
        }

        return $this->render("admin/article_form.html.twig", ['articleForm' => $articleForm->createView()]);
    }

    // Exercice : créer des routes pour créer un nouveau tag et une nouvelle category.
    // Exercice : refaire les méthodes create_tag et create_category pour utiliser les formulaires.

    /**
     * @Route("/admin/delete/post/{id}", name="admin_delete_post")
     */
    public function deletePost(
        $id,
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManagerInterface
    ) {
        $article = $articleRepository->find($id);

        $entityManagerInterface->remove($article);
        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_posts_list");
    }

    // Exercice : créer les routes qui vont supprimer des tags et des categories.


    /**
     * TP : créer un nouveau projet Symfony: library
     * Ce projet aura une base de données qu'il faudra créer.
     * Il aura 3 entités :
     *  - book (title, string, 255, non nullable), (resume, text, non nullable), (year, integer, non nullable)
     *  - genre (name, string, 255, non nullable), (description, text, non nullable)
     *  - writer (name, string, 255, non nullable), (bio, text, non nullable)
     * La table book sera relié à genre et writer. Un book aura un genre et un writer mais un writer et un genre
     * peuvent avoir plusieyrs books. (book aura les clés étrangères).
     * Il faudra faire le CRUD pour chaque entité.
     * Créer des pages fonctionnelles avec du css pour rendre cela facile à utiliser
     */
}

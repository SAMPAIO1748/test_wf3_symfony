<?php

namespace App\Controller;

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
    /**
     * @Route("/article", name="app_article")
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("posts", name="posts_list")
     */
    public function listPosts(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render("posts_list.html.twig", ['articles' => $articles]);
    }

    /**
     * @Route("post/{id}", name="post_show")
     */
    public function showPost($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);

        return $this->render("post_show.html.twig", ['article' => $article]);
    }

    // Exercice :  céer les routes qui vont afficher une catégorie
    // et un tag sélectionné grâce à leurs id.
    // Sur la vue il faudra afficher toutes les informations
    // càd name, description, et le title des articles pour 
    // category et name, description, color et le title des articles
    // pour tag

    /**
     * @Route("update/post/{id}", name="update_post")
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

            return $this->redirectToRoute("posts_list");
        }

        return $this->render("article_form.html.twig", ['articleForm' => $articleForm->createView()]);
    }

    // Exercice : créer une méthode update_tag qui va changer le nom du tag et faire de même pour category

    /**
     * @Route("create/post", name="create_post")
     */
    public function createPost(EntityManagerInterface $entityManagerInterface)
    {
        // création du nouvel article
        $article = new Article();

        $article->setTitle("Nouvel Article");
        $article->setContent("Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, eius illum accusantium suscipit ea ut, rem unde commodi esse minus ratione voluptas adipisci sed voluptates officiis magni aperiam corrupti pariatur.");

        $entityManagerInterface->persist($article);
        $entityManagerInterface->flush();

        return $this->redirectToRoute("posts_list");
    }

    // Exercice : créer des routes pour créer un nouveau tag et une nouvelle category.
}

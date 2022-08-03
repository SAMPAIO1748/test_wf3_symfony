<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}

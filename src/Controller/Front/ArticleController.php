<?php

namespace App\Controller\Front;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\Mime\Email;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{

    /**
     * @Route("/posts", name="front_post_list")
     */
    public function listPosts(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render("front/posts_list.html.twig", ['articles' => $articles]);
    }

    /**
     * @Route("/post/{id}", name="front_post_show")
     */
    public function showPost($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);

        return $this->render("front/post_show.html.twig", ['article' => $article]);
    }
}

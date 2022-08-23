<?php

namespace App\Controller\Front;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("search/", name="search")
     */
    public function search(Request $request, ArticleRepository $articleRepository)
    {
        // $requet permet de récupérer le contenu du champs du formulaire
        // On utilise query car c'est un formulaire en get
        // Si c'était un formaulire en post on utiliserai request, cela donnerai ceci :
        // $term = $request->request->get('search');
        $term = $request->query->get('search');

        // utilisation de la méthode créée dans ArticleRepository
        $articles = $articleRepository->searchByTerm($term);

        return $this->render('front/search.html.twig', ['articles' => $articles, 'term' => $term]);
    }

    /**
     * @Route("contact", name="contact")
     */
    public function contact()
    {
        return $this->render("front/contact.html.twig");
    }
}

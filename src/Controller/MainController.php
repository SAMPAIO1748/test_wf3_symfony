<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/main", name="main")
     */
    public function main()
    {
        var_dump("page principale");
        die;
    }

    // Exercice : créer un route qui va afficher "Bienvenue sur notre super site".

    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        // dd est la focntion dump and die qui permet de débugger sans avoir à utiliser die.
        dd("Bienvenue sur notre site");
    }

    /**
     * @Route("legal", name="legal")
     */
    public function legal()
    {
        // return est ce qu'attendent toutes les méthodes du Controller à la fin de leur traitement
        return new Response("Voici les mentions légales du site");
    }

    // Exercice : faire une page à propos à l'aide d'une réponse pour afficher "Nous sommes les meilleurs du monde !!"

    /**
     * @Route("about", name="about")
     */
    public function about()
    {
        return new Response("Nous sommes les meilleurs du monde !!");
    }

    /**
     * @Route("number/{id}", name="number")
     */
    public function number($id)
    {
        return new Response($id);
    }
}

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
        return new Response("Voici les mentions légales du site");
    }
}

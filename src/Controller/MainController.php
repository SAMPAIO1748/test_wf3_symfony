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

    // Exercice : créer une route qui va afficher "Mon âge est de : {valeur de l'âge} ans". 
    // La valeur de l'âge est donnée par la wildcard

    /**
     * @Route("age/{id}", name="age")
     */
    public function age($id)
    {
        if (is_numeric($id)) {
            return new Response("Mon âge est de : " . $id . " ans.");
        } else {
            return new Response("Il faut donner un âge.");
        }
    }

    // Exercice : créer une route poker qui aura une wildcard, 
    // si l'âge est inférieur à 18 alors on répond : "Vous n'êtes pas autorisé à jouer"
    // Si l'âge est supérieur ou égale à 18 on répond : "Vous êtes autorisé à jouer".

    /**
     * @Route("poker/{age}", name="poker")
     */
    public function poker($age)
    {
        if (!is_numeric($age) || $age < 0) {
            return new Response("Vous devez rentrer un âge");
        } elseif ($age >= 18) {
            return new Response("Vous êtes autorisé à jouer");
        } else {
            return new Response("Vous n'êtes pas autorisé à jouer");
        }
    }
}

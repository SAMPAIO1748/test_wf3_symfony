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

    /**
     */

    // Exercice : créer une route qui va afficher le titre de l'article qui sera sélectionné par la wildcard

    /**
     * @Route("array/article/{id}", name="array_article")
     */
    public function arrayArticle($id)
    {
        $tableau_articles = [
            1 => [
                "titre" => "Vive la Bretagne",
                'contenu' => "La Bretagne, c'est fantastique",
                "id" => 1
            ],
            2 => [
                "titre" => "Vive l'Occitanie",
                "contenu" => "L'Occitanie, c'est magnifique",
                "id" => 2
            ],
            3 => [
                "titre" => "Vive la Guyane",
                "contenu" => "La Guyane, c'est merveilleux",
                "id" => 3
            ]
        ];

        if (array_key_exists($id, $tableau_articles)) {
            return new Response("Le titre de l'article est : '" . $tableau_articles[$id]["titre"] . "'.");
        } else {
            return new Response("L'article n'existe pas !");
        }
    }

    /**
     * @Route("bienvenue", name="bienvenue")
     */
    public function bienvenue()
    {
        // la méthode redirectToRoute est une méthode qui vient de l'AbstractController qui redirige vers une route déjà créer dans le controller.
        return $this->redirectToRoute("home");
    }

    // Exercice : Créer une route play qui en fonction de l'âge donné par la wildcard va rediriger vers la route enfant ou la route adulte
    // ou la route bad (la route qui va demander de donner un âge)
    // (routes qu'il faudra créer)

    /**
     * @Route("enfant", name="enfant")
     */
    public function enfant()
    {
        return new Response("Vous êtes trop jeune pour jouer.");
    }

    /**
     * @Route("adulte", name="adulte")
     */
    public function adulte()
    {
        return new Response("Vous avez l'âge requis, vous pouvez jouer.");
    }

    /**
     * @Route("bad", name="bad")
     */
    public function bad()
    {
        return new Response("Vous avez donné une mauvaise réponse. Vous devez donner un âge.");
    }

    /**
     * @Route("play/{age}", name="play")
     */
    public function play($age)
    {
        if (!is_numeric($age) || $age < 0) {
            return $this->redirectToRoute("bad");
        } elseif ($age >= 18) {
            return $this->redirectToRoute("adulte");
        } else {
            return $this->redirectToRoute("enfant");
        }
    }

    /**
     * @Route("view", name="view")
     */
    public function view()
    {
        return $this->render("vue.html.twig");
    }

    // Exercice : céer une route qui va afficher une vue qui
    // contiendra un h1, un h2, un p, un table, une image.

    /**
     * @Route("super/view", name="super_view")
     */
    public function superView()
    {
        return $this->render("super_view.html.twig");
    }

    // créer une route jeu avec wildcar qui va renvoyé un vue en fonction de la wildcard que l'on donne
    // les vues devront avoir un message dans un h1 et une image.

    /**
     * @Route("jeu/{age}", name="jeu")
     */
    public function jeu($age)
    {
        if (!is_numeric($age) || $age < 0) {
            return $this->render("bad.html.twig");
        } elseif ($age >= 18) {
            return $this->render("adulte.html.twig");
        } else {
            return $this->render("enfant.html.twig");
        }
    }
}

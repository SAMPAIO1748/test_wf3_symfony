<?php

namespace App\Controller\Front;

use App\Repository\ArticleRepository;
use Container55pacsH\getZenstruckMailerTest_MailerService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
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

    /**
     * @Route("email/", name="email")
     */
    public function email(
        MailerInterface $mailerInterface,
        Request $request
    ) {

        $message = $request->request->get('message');

        // création de l'email
        $email = (new Email())
            ->from("test@test.com") // adresse d'envoie
            ->to("toto@email.com") // adresse de réception
            ->subject("message") // sujet du mail
            ->html("<p>Bonjour</p>"); // contenu html du mail

        // envoie du mail
        $mailerInterface->send($email);

        return $this->redirectToRoute("front_post_list");
    }

    /**
     * @Route("email/bis", name="email_bis")
     */
    public function emailBis(MailerInterface $mailerInterface)
    {

        $toto = "TOTO";

        $email = (new TemplatedEmail())
            ->from("test@test.com")
            ->to("user@mail.com")
            ->subject('sujet')
            ->htmlTemplate('front/email.html.twig')
            ->context(
                [
                    'toto' => $toto
                ]
            );

        $mailerInterface->send($email);

        return $this->redirectToRoute("front_post_list");
    }

    // Exercice : dans UserController dans la méthode userInsert après l'enregistrement du nouveau user
    // envoyer un mail au nouvel inscrit.
}

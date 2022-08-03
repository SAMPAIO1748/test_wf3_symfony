<?php

namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route("/tag", name="app_tag")
     */
    public function index(): Response
    {
        return $this->render('tag/index.html.twig', [
            'controller_name' => 'TagController',
        ]);
    }

    /**
     * @Route("tags", name="tags_list")
     */
    public function listTags(TagRepository $tagRepository)
    {
        $tags = $tagRepository->findAll();

        return $this->render("tags_list.html.twig", ['tags' => $tags]);
    }

    /**
     * @Route("tag/{id}", name="tag_show")
     */
    public function showTag($id, TagRepository $tagRepository)
    {
        $tag = $tagRepository->find($id);

        return $this->render("tag_show.html.twig", ['tag' => $tag]);
    }

    // Exercice : dans les pages vues de tags_list, categories_list et posts_list: 
    // mettre des liens vers le post, le tag et la category sélectionnés 
    // lorsque l'on clique sur le name ou le title 
}

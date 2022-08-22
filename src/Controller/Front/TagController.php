<?php

namespace App\Controller\Front;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route("/tags", name="front_tags_list")
     */
    public function listTags(TagRepository $tagRepository)
    {
        $tags = $tagRepository->findAll();

        return $this->render("front/tags_list.html.twig", ['tags' => $tags]);
    }

    /**
     * @Route("/tag/{id}", name="front_tag_show")
     */
    public function showTag($id, TagRepository $tagRepository)
    {
        $tag = $tagRepository->find($id);

        return $this->render("front/tag_show.html.twig", ['tag' => $tag]);
    }

    // Exercice : dans les pages vues de tags_list, categories_list et posts_list: 
    // mettre des liens vers le post, le tag et la category sélectionnés 
    // lorsque l'on clique sur le name ou le title

}

<?php

namespace App\Controller\Admin;

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
     * @Route("admin/tag", name="admin_app_tag")
     */
    public function index(): Response
    {
        return $this->render('tag/index.html.twig', [
            'controller_name' => 'TagController',
        ]);
    }

    /**
     * @Route("admin/tags", name="admin_tags_list")
     */
    public function listTags(TagRepository $tagRepository)
    {
        $tags = $tagRepository->findAll();

        return $this->render("admin/tags_list.html.twig", ['tags' => $tags]);
    }

    /**
     * @Route("admin/tag/{id}", name="admin_tag_show")
     */
    public function showTag($id, TagRepository $tagRepository)
    {
        $tag = $tagRepository->find($id);

        return $this->render("admin/tag_show.html.twig", ['tag' => $tag]);
    }

    // Exercice : dans les pages vues de tags_list, categories_list et posts_list: 
    // mettre des liens vers le post, le tag et la category sélectionnés 
    // lorsque l'on clique sur le name ou le title

    /**
     * @Route("admin/update/tag/{id}", name="admin_udate_tag")
     */
    public function updateTag(
        $id,
        TagRepository $tagRepository,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {
        $tag = $tagRepository->find($id);

        $tagForm = $this->createForm(TagType::class, $tag);

        $tagForm->handleRequest($request);


        if ($tagForm->isSubmitted() && $tagForm->isValid()) {
            //$tag->setName("Nouveau Nom du Tag");

            $entityManagerInterface->persist($tag);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_tags_list");
        }

        return $this->render("admin/tag_form.html.twig", ['tagForm' => $tagForm->createView()]);
    }

    /**
     * @Route("admin/create/tag", name="admin_create_tag")
     */
    public function createTag(EntityManagerInterface $entityManagerInterface, Request $request)
    {
        $tag = new Tag();

        $tagForm = $this->createForm(TagType::class, $tag);

        $tagForm->handleRequest($request);

        if ($tagForm->isSubmitted() && $tagForm->isValid()) {
            //$tag->setName("Nouveau Tag 2, la revange");
            //$tag->setDescription("Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa et similique itaque cum ullam id consectetur voluptatibus animi maiores repellat eius, architecto accusamus illum rem veniam reprehenderit tenetur earum quis.");
            // $tag->setColor("black");

            $entityManagerInterface->persist($tag);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_tags_list");
        }

        return $this->render("admin/tag_form.html.twig", ['tagForm' => $tagForm->createView()]);
    }

    /**
     * @Route("admin/delete/tag/{id}", name="admin_delete_tag")
     */
    public function deleteTag(
        $id,
        EntityManagerInterface $entityManagerInterface,
        TagRepository $tagRepository
    ) {

        $tag = $tagRepository->find($id);

        $entityManagerInterface->remove($tag);
        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_tags_list");
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use SYmfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MediaController extends AbstractController
{
    /**
     * @Route("/admin/create/media", name="admin_create_media")
     */
    public function adminCreateMedia(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface
    ) {

        $media = new Media();

        $mediaForm = $this->createForm(MediaType::class, $media);

        $mediaForm->handleRequest($request);

        if ($mediaForm->isSubmitted() && $mediaForm->isValid()) {

            // On récupère le fichier que l'on veut enregistrer
            $mediaFile = $mediaForm->get('src')->getData();

            if ($mediaFile) {

                // On va créer un nom unique et valide à notre fichier à partir du nom original
                // pour éviter tout problème lors de l'enregistrement

                // On récupère le nom original du ficher
                $originalFilename = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);

                // On utilise le slug pour être sûr d'avoir un nom valide de notre fichier
                $safeFilename = $sluggerInterface->slug($originalFilename);

                // On ajoute un id unique au nom du fichier pour que le nom soit unique
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mediaFile->guessExtension();

                // On enregistre le fichier dans le dossier public\medias
                // la destination du fichier est définie dans 'images_directory'
                // qui est défini dans le fichier config\services.yaml

                $mediaFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $media->setSrc($newFilename);
            }

            $entityManagerInterface->persist($media);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_posts_list");
        }

        return $this->render("admin/media_form.html.twig", ['mediaForm' => $mediaForm->createView()]);
    }

    // Exercice : Faire le CRUD complet sur MediaController

    /**
     * @Route("admin/medias", name="admin_list_media")
     */
    public function adminListMedia(MediaRepository $mediaRepository)
    {
        $medias = $mediaRepository->findAll();

        return $this->render("admin/media_list.html.twig", ['medias' => $medias]);
    }

    /**
     * @Route("admin/media/{id}", name="admin_show_media")
     */
    public function adminShowMedia($id, MediaRepository $mediaRepository)
    {
        $media = $mediaRepository->find($id);

        return $this->render("admin/media_show.html.twig", ['media' => $media]);
    }

    /**
     * @Route("admin/update/media/{id}", name="admin_update_media")
     */
    public function adminUpdateMedia(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface,
        $id,
        MediaRepository $mediaRepository
    ) {

        $media = $mediaRepository->find($id);

        $mediaForm = $this->createForm(MediaType::class, $media);

        $mediaForm->handleRequest($request);

        if ($mediaForm->isSubmitted() && $mediaForm->isValid()) {

            // On récupère le fichier que l'on veut enregistrer
            $mediaFile = $mediaForm->get('src')->getData();

            if ($mediaFile) {

                // On va créer un nom unique et valide à notre fichier à partir du nom original
                // pour éviter tout problème lors de l'enregistrement

                // On récupère le nom original du ficher
                $originalFilename = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);

                // On utilise le slug pour être sûr d'avoir un nom valide de notre fichier
                $safeFilename = $sluggerInterface->slug($originalFilename);

                // On ajoute un id unique au nom du fichier pour que le nom soit unique
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mediaFile->guessExtension();

                // On enregistre le fichier dans le dossier public\medias
                // la destination du fichier est définie dans 'images_directory'
                // qui est défini dans le fichier config\services.yaml

                $mediaFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $media->setSrc($newFilename);
            }

            $entityManagerInterface->persist($media);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_posts_list");
        }

        return $this->render("admin/media_form.html.twig", ['mediaForm' => $mediaForm->createView()]);
    }

    /**
     * @Route("admin/delete/media/{id}", name="admin_delete_media")
     */
    public function adminDeleteMedia(
        $id,
        EntityManagerInterface $entityManagerInterface,
        MediaRepository $mediaRepository
    ) {
        $media = $mediaRepository->find($id);

        $entityManagerInterface->remove($media);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_list_media");
    }
}

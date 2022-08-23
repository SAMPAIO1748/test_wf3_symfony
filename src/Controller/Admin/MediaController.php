<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use App\Form\MediaType;
use Doctrine\ORM\EntityManagerInterface;
use PDO;
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
}

<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use SYmfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{
    /**
     * @Route("/admin/create/media", name="admin_create_media")
     */
    public function adminCreateMedia(
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {
    }
}

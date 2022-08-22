<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("user/add", name="insert_user")
     */
    public function userInsert(
        EntityManagerInterface $entityManagerInterface,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasherInterface
    ) {

        $user = new User();

        $userForm = $this->createForm(UserType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $user->setRoles(["ROLE_USER"]);

            // Récupérer le mot de passe
            $plainPassword = $userForm->get('password')->getData();

            // Hasher le mot de passe
            $hashedPassword = $userPasswordHasherInterface->hashPassword($user, $plainPassword);

            // Attribution du mpot de passe au user
            $user->setPassword($hashedPassword);

            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_login');
        }


        return $this->render('front/user_add.html.twig', ['userForm' => $userForm->createView()]);
    }
}

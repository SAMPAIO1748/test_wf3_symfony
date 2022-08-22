<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
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

            // Attribution du mot de passe au user
            $user->setPassword($hashedPassword);

            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_login');
        }


        return $this->render('front/user_add.html.twig', ['userForm' => $userForm->createView()]);
    }

    // Exercice : créer un méthode qui va permettre à l'utilisateur connecté de modifié son compte.

    /**
     * @Route("update/user", name="front_update_user")
     */
    public function updateUser(
        EntityManagerInterface $entityManagerInterface,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasherInterface,
        UserRepository $userRepository
    ) {

        // Récupération du user connecté
        $user_connect = $this->getUser();

        // Récupération de l'identifieur du user car il n'a pas accées au méthode de l'entité User.php
        // il faut donc retrouver ce user avec le UserRepository
        $user_email = $user_connect->getUserIdentifier();

        // Récupération du user qui vient de l'entité User.php
        $user = $userRepository->findOneBy(['email' => $user_email]);

        $userForm = $this->createForm(UserType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $plainPassword = $userForm->get('password')->getData();

            $hashedPassword = $userPasswordHasherInterface->hashPassword($user, $plainPassword);

            $user->setPassword($hashedPassword);

            $entityManagerInterface->persist($user);

            $entityManagerInterface->flush();

            return $this->redirectToRoute("app_login");
        }

        return $this->render("front/user_add.html.twig", ['userForm' => $userForm->createView()]);
    }
}

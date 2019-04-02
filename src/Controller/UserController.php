<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Services\UserHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_list")
     */
    public function listAction(UserRepository $userRepository)
    {
        $users = $userRepository
            ->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/users/create", name="user_create")
     */
    public function createAction(EntityManagerInterface $manager,
                                 Request $request,
                                 UserPasswordEncoderInterface $passwordEncoder,
                                 UserHandler $formHandler)
    {
        $addUserForm = $this->createForm(UserType::class);

        if ($formHandler->handleNew($addUserForm, $request, $passwordEncoder, $manager)) {
            $this->addFlash(
                'success',
                "L'utilisateur a bien été ajouté."
            );

            return $this->redirectToRoute('homepage');
        }

            return $this->render('user/create.html.twig', [
                'form' => $addUserForm->createView()
            ]);
    }

    /**
     * @Route("/admin/users/{id}/edit", name="user_edit")
     */
    public function editAction(EntityManagerInterface $manager,
                               User $user,
                               Request $request,
                               UserPasswordEncoderInterface $passwordEncoder,
                               UserHandler $formHandler)
    {
        $editUserForm = $this->createForm(UserType::class, $user);

        if ($formHandler->handleEdit($editUserForm, $request, $passwordEncoder, $manager))
        {
            $this->addFlash(
                'success',
                "L'utilisateur a bien été modifié"
            );

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $editUserForm->createView(),
            'user' => $user
        ]);
    }
}

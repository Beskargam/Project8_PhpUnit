<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
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
                                 UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $addUserForm = $this->createForm(UserType::class, $user);
        $addUserForm->handleRequest($request);

        if ($addUserForm->isSubmitted() && $addUserForm->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'utilisateur a bien été ajouté."
            );

            return $this->redirectToRoute('user_list');
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
                               UserPasswordEncoderInterface $passwordEncoder)
    {
        $editUserForm = $this->createForm(UserType::class, $user);
        $editUserForm->handleRequest($request);

        if ($editUserForm->isSubmitted() && $editUserForm->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $role = array($editUserForm->get('roleList')->getData());
            $user->setRoles(array('roles' => $role));

            $manager->flush();

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

<?php


namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserHandler
{
    public function handleNew(FormInterface $form,
                           Request $request,
                           UserPasswordEncoderInterface $passwordEncoder,
                           EntityManagerInterface $manager)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var User $user
             */
            $user = $form->getData();

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();

            return true;
        }

        return false;
    }
    public function handleEdit(FormInterface $form,
                           Request $request,
                           UserPasswordEncoderInterface $passwordEncoder,
                           EntityManagerInterface $manager)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var User $user
             */
            $user = $form->getData();

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $manager->flush();

            return true;
        }

        return false;
    }
}
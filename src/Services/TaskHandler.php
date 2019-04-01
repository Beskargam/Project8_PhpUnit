<?php


namespace App\Services;


use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class TaskHandler
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function handleNew(FormInterface $form,
                              Request $request,
                              EntityManagerInterface $manager)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Task $task
             */
            $task = $form->getData();

            $user = $this->security->getUser();
            $task->setUser($user);

            $manager->persist($task);
            $manager->flush();

            return true;
        }

        return false;
    }

    public function handleEdit(FormInterface $form,
                              Request $request,
                              EntityManagerInterface $manager)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Task $task
             */
            $task = $form->getData();

            $manager->persist($task);
            $manager->flush();

            return true;
        }

        return false;
    }
}
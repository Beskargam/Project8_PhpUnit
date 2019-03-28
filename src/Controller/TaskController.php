<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository
            ->findAll();
        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(EntityManagerInterface $manager,
                                 Request $request)
    {
        $task = new Task();
        $addTaskForm = $this->createForm(TaskType::class, $task);
        $addTaskForm->handleRequest($request);

        if ($addTaskForm->isSubmitted() && $addTaskForm->isValid()) {
            $task = $addTaskForm->getData();

            $user = $this->getUser();
            $task->setUser($user);

            $manager->persist($task);
            $manager->flush();

            $this->addFlash(
                'success',
                'La tâche a été bien été ajoutée.'
            );

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $addTaskForm->createView()
        ]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(EntityManagerInterface $manager,
                               Task $task,
                               Request $request)
    {
        $editForm = $this->createForm(TaskType::class, $task);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $manager->flush();

            $this->addFlash(
                'success',
                'La tâche a bien été modifiée.'
            );

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $editForm->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(EntityManagerInterface $manager,
                                     Task $task)
    {
        $task->toggle(!$task->isDone());
        $manager->flush();

        $this->addFlash(
            'success',
            sprintf(
                'La tâche %s a bien été marquée comme faite.',
                $task->getTitle()
            )
        );

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(EntityManagerInterface $manager,
                                     Task $task)
    {
        $manager->remove($task);
        $manager->flush();

        $this->addFlash(
            'success',
            'La tâche a bien été supprimée.'
        );

        return $this->redirectToRoute('task_list');
    }
}

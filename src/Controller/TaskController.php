<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Services\TaskHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks/todo", name="todo_task_list")
     */
    public function todoListAction(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository
            ->getTodoTasks();
        return $this->render('task/todolist.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/tasks/finish", name="finish_task_list")
     */
    public function finishListAction(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository
            ->getFinishTasks();
        return $this->render('task/finishlist.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(EntityManagerInterface $manager,
                                 Request $request,
                                 TaskHandler $formHandler)
    {
        $addTaskForm = $this->createForm(TaskType::class);

        if ($formHandler->handleNew($addTaskForm, $request, $manager)) {
            $this->addFlash(
                'success',
                'La tâche a été bien été ajoutée.'
            );

            return $this->redirectToRoute('todo_task_list');
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
                               Request $request,
                               TaskHandler $formHandler)
    {
        $this->denyAccessUnlessGranted('EDIT', $task);

        $editForm = $this->createForm(TaskType::class, $task);

        if ($formHandler->handleEdit($editForm, $request, $manager)) {
            $this->addFlash(
                'success',
                'La tâche a bien été modifiée.'
            );

            return $this->redirectToRoute('todo_task_list');
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
                'Le statut de la tâche %s a bien été modifié.',
                $task->getTitle()
            )
        );

        return $this->redirectToRoute('todo_task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(EntityManagerInterface $manager,
                                     Task $task)
    {
        $this->denyAccessUnlessGranted('DELETE', $task);

        $manager->remove($task);
        $manager->flush();

        $this->addFlash(
            'success',
            'La tâche a bien été supprimée.'
        );

        return $this->redirectToRoute('todo_task_list');
    }
}

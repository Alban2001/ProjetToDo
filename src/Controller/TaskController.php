<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TaskController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }
    #[Route('/tasks', name: 'task_list')]
    public function listAction()
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->entityManager->getRepository(Task::class)->findAll()]);
    }

    #[IsGranted('ROLE_USER', statusCode: 403, message: 'Vous n\'avez pas les droits pour ajouter une tâche')]
    #[Route('/tasks/create', name: 'task_create')]
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setOneUser($this->getUser());
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[IsGranted('ROLE_USER', statusCode: 403, message: 'Vous n\'avez pas les droits pour modifier une tâche')]
    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[IsGranted('ROLE_USER', statusCode: 403, message: 'Vous n\'avez pas les droits pour marquer une tâche')]
    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->entityManager->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[IsGranted('ROLE_USER', statusCode: 403, message: 'Vous n\'avez pas les droits pour supprimer une tâche')]
    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    public function deleteTaskAction(Task $task)
    {
        // Seul les administrateurs peuvent supprimer une tâche d'un utilisateur anonyme
        // Les utilisateurs peuvent supprimer leurs propres tâches
        if (($task->getOneUser() == null && $this->getUser()->getRoles() == 'ROLE_ADMIN') || ($task->getOneUser()->getId() == $this->getUser()->getId())) {
            $this->entityManager->remove($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée.');
        } else {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer cette tâche.');
        }

        return $this->redirectToRoute('task_list');
    }
}

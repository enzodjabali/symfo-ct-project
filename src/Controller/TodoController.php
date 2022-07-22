<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use App\Service\MailerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('', name: 'app_todo_index', methods: ['GET'])]
    public function index(TodoRepository $todoRepository): Response
    {
        return $this->render('todo/index.html.twig', [
            'todos' => $todoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_todo_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, TodoRepository $todoRepository, MailerService $mailer): Response
    {
        $todo = new Todo();
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoRepository->add($todo, true);

            // Send email
            $subject = 'New task added';
            $content = 'Hi, a new task has been added in your todo list.';
            $mailer->sendEmail(
                from: 'sender@myapp.lan',
                to: 'receiver@myapp.lan',
                subject: $subject,
                htmlTemplate: 'email/todo/new.html.twig',
                
                // Context
                todoTodo: $todo->getTodo(),
                todoEmail: $todo->getBy(),
                todoCurrentEmail: $this->getUser()->getEmail()
            );
            // dd($mailer->sendEmail(subject: $subject, content: $content));


            return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo/new.html.twig', [
            'todo' => $todo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_todo_show', methods: ['GET'])]
    public function show(Todo $todo): Response
    {
        return $this->render('todo/show.html.twig', [
            'todo' => $todo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_todo_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Todo $todo, TodoRepository $todoRepository): Response
    {
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoRepository->add($todo, true);
            return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo/edit.html.twig', [
            'todo' => $todo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_todo_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Todo $todo, TodoRepository $todoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$todo->getId(), $request->request->get('_token'))) {
            $todoRepository->remove($todo, true);
        }

        return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
    }
}

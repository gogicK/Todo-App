<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TodoAppController extends AbstractController
{
    #[Route('/todo-app', name: 'todo_app')]
    public function index(): Response
    {
        return $this->render('todo_app/index.html.twig', [
            'controller_name' => 'TodoAppController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    /**
     * @Route("/to/do", name="todo")
     */
    public function index()
    {
        return $this->render('todo/index.html.twig', [
            'controller_name' => 'ToDoController',
        ]);
    }
}

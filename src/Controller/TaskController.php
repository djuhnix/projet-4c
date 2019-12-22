<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController.
 *
 * @Route("/task", name="task")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/{id}", name="_details", requirements={"id" = "\d+"})
     *
     * @param Task $task
     * @return Response
     */
    public function details(Task $task)
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'ListController',
            'task' => $task,
        ]);
    }
}

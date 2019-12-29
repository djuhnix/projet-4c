<?php

namespace App\Controller;

use App\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController.
 *
 * @Route("/member/task", name="task")
 * @IsGranted("ROLE_USER")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/{id}", name="_details", requirements={"id" = "\d+"})
     *
     * @return Response
     */
    public function details(Task $task)
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'ListController',
            'task' => $task,
        ]);
    }

    /**
     * @Route("/create", name="_create")
     *
     * @return Response
     */
    public function create(Task $task)
    {

        return $this->render('task/index.html.twig', [
            'controller_name' => 'ListController',
            'task' => $task,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="_edit", requirements={"id" = "\d+"})
     *
     * @return Response
     */
    public function edit(Task $task)
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'ListController',
            'task' => $task,
        ]);
    }
}

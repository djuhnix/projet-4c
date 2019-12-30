<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\TodoList;
use App\Entity\User;
use App\Form\TaskType;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        //TODO
        return $this->render('task/index.html.twig', [
            'controller_name' => 'ListController',
            'task' => $task,
        ]);
    }

    /**
     * @Route("/create/{id}", name="_create", requirements={"id" = "\d+"})
     *
     * @return Response
     *
     * @throws Exception
     */
    public function create(Request $request, TodoList $list)
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Task $task */
            $task = $form->getData();
            $task
                ->setCreatedate(new \DateTime())
                ->setUser($this->getUser())
                ->setTodoList($list);
            $list->addTask($task);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($task);
            $manager->persist($list);
            $manager->flush();

            $this->addFlash(
                'notice',
                'New task added'
            );

            return  $this->render('include/element.html.twig', [
                'todo' => $task,
                'i' => $list->getTasks()->count(),
            ]);
        }

        return $this->render('include/form.html.twig', [
            'form' => $form->createView(),
            'button' => 'Add new',
        ]);
    }

    /**
     * @Route("/edit/{id}", name="_edit", requirements={"id" = "\d+"})
     *
     * @return Response
     */
    public function edit(Task $task)
    {
        //TODO
        return $this->render('task/index.html.twig', [
            'controller_name' => 'ListController',
            'task' => $task,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="_delete", requirements={"id" = "\d+"})
     *
     * @param Task $task
     * @return Response
     */
    public function delete(Task $task)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($task);
        $manager->flush();

        $this->addFlash(
            'notice',
            'Todo Removed'
        );

        return $this->redirectToRoute('list_details', ['id' => $task->getTodoList()->getId()]);
    }
}

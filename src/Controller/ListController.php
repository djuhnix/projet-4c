<?php

namespace App\Controller;

use App\Entity\TodoList;
use App\Entity\User;
use App\Form\ListType;
use App\Form\TodoType;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListController.
 *
 * @Route("/member/list", name="list")
 * @IsGranted("ROLE_USER")
 */
class ListController extends AbstractController
{
    /**
     * @Route("/", name="_home")
     */
    public function listAll()
    {
        $todos = $this->getDoctrine()
            ->getRepository(TodoList::class)
            ->findBy(
                ['user' => $this->getUser()->getIdUser()],
                ['duedate' => 'ASC']);

        return $this->render('list/index.html.twig', [
            'controller_name' => 'ListController',
            'todos' => $todos,
        ]);
    }

    /**
     * @Route("/create", name="_create")
     *
     * @return RedirectResponse|Response
     *
     * @throws Exception
     */
    public function create(Request $request)
    {
        $now = new\DateTime('now');

        $todo = new TodoList();
        $todo->setCreateDate($now);

        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$category = $form['category']->getData();
            $description = $form['description']->getData();
            $dueDate = $form['duedate']->getData();
            $name = $form['name']->getData();


            /** @var User $user */
            $user = $this->getUser();
            $todo
                ->setName($name)
                ->setDescription($description)
                ->setDuedate($dueDate)
                ->setUser($user);

            $manager = $this->getDoctrine()->getManager();
            $manager->getMetadataFactory()->setMetadataFor(TodoList::class, $manager->getClassMetadata(TodoList::class));
            $manager->persist($todo);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Todo list added'
            );

            return $this->redirectToRoute('list_home');
        }

        return $this->render('list/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/details/{id}", name="_details", requirements={"id" = "\d+"})
     *
     * @return Response
     */
    public function details(TodoList $todoList)
    {
        return $this->render('list/details.html.twig', [
            'todolist' => $todoList,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="_edit", requirements={"id" = "\d+"})
     *
     * @param TodoList $todoList
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(TodoList $todoList, Request $request)
    {

        $form = $this->createForm(ListType::class, $todoList);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $todoList->setName($form['name']->getData());
            $todoList->setDescription($form['description']->getData());
            $todoList->setDuedate($form['duedate']->getData());

            $manager->flush();

            $this->addFlash(
                'notice',
                'Todo Updated'
            );

            return $this->redirectToRoute('list_details', ['id' => $todoList->getId()]);
        }

        return $this->render('list/edit.html.twig', [
            'todo' => $todoList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="_delete", requirements={"id" = "\d+"})
     *
     * @return RedirectResponse
     */
    public function delete(TodoList $todoList)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($todoList);
        $manager->flush();

        $this->addFlash(
            'notice',
            'Todo Removed'
        );

        return $this->redirectToRoute('list_home');
    }
}

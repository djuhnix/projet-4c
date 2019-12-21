<?php

namespace App\Controller;

use App\Entity\TodoList;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function listAll()
    {
        $todos = $this->getDoctrine()
            ->getRepository(TodoList::class)
            ->findAll();

        return $this->render('list/index.html.twig', [
            'controller_name' => 'ToDoController',
            'todos' => $todos,
        ]);
    }

    /**
     * @Route("/list/create", name="create")
     *
     * @return RedirectResponse|Response
     *
     * @throws Exception
     */
    public function create(Request $request)
    {
        $todo = new TodoList();

        $form = $this->createFormBuilder($todo)
            ->add(
                'listname',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'style' => 'margin-bottom:15px',
                    ],
                ])
            //->add('category', TextType::class, ['attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px']])
            ->add(
                'description',
                TextareaType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'style' => 'margin-bottom:15px',
                    ],
                ])
            // ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal' => 'Normal', 'High'=>'High'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add(
                'due_date',
                DateTimeType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'style' => 'margin-bottom:15px',
                    ],
                ])
            ->add(
                'Save',
                SubmitType::class,
                [
                    'label' => 'Create Todo',
                    'attr' => [
                        'class' => 'btn btn-primary',
                        'style' => 'margin-bottom:15px',
                    ],
                ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$category = $form['category']->getData();
            $description = $form['description']->getData();
            $dueDate = $form['due_date']->getData();
            $name = $form['listname']->getData();

            $now = new\DateTime('now');

            $todo->setListname($name);
            //$todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setDuedate($dueDate);
            $todo->setCreateDate($now);

            $manager = $this->getDoctrine()->getManager();
            $manager->getMetadataFactory()->setMetadataFor(TodoList::class, $manager->getClassMetadata(TodoList::class));
            $manager->persist($todo);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Todo list added'
            );

            return $this->redirectToRoute('list');
        }

        return $this->render('list/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list/details/{id}", name="details", requirements={"id" = "\d+"})
     *
     * @param int $id
     * @return Response
     */
    public function details(int $id)
    {
        $todoList = $this->getDoctrine()
            ->getRepository(TodoList::class)
            ->findBy([
                'idList' => $id,
            ]);

        return $this->render('list/details.html.twig', [
            'todolist' => $todoList,
        ]);
    }
}

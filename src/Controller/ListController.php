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

/**
 * Class ListController.
 *
 * @Route("/list", name="list")
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
            ->findAll();

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
                        'class' => '',
                        'style' => 'margin-bottom:15px',
                    ],
                ])
            ->add(
                'Save',
                SubmitType::class,
                [
                    'label' => 'Create Todo',
                    'attr' => [
                        'class' => 'btn btn-succes',
                        'style' => 'margin-bottom:25px',
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
     * @Route("/details/{id}", name="_details", requirements={"id" = "\d+"})
     *
     * @param TodoList $todoList
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
     * @return RedirectResponse|Response
     *
     * @throws Exception
     */
    public function edit(TodoList $todoList, Request $request)
    {
        $now = new\DateTime('now');
        $idList = $todoList->getIdList();
        $todoList->setListname($todoList->getListname());
        //$todoList->setCategory($todoList->getCategory());
        $todoList->setDescription($todoList->getDescription());
        $todoList->setDuedate($todoList->getDueDate());
        $todoList->setCreateDate($now);

        $form = $this->createFormBuilder($todoList)
            ->add(
                'listname',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'style' => 'margin-bottom:15px',
                    ],
                ])
            /*->add(
                'category',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'style' => 'margin-bottom:15px',
                    ],
                ])
            */
            ->add(
                'description',
                TextareaType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'style' => 'margin-bottom:15px',
                    ],
                ])
            ->add(
                'due_date',
                DateTimeType::class,
                [
                    'attr' => [
                        'class' => '',
                        'style' => 'margin-bottom:25px',
                    ],
                ])
            ->add(
                'Save',
                SubmitType::class,
                [
                    'label' => 'Update Todo',
                    'attr' => [
                        'class' => 'btn btn-success',
                        'style' => 'margin-bottom:15px',
                    ],
                ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['listname']->getData();
            //$category = $form['category']->getData();
            $description = $form['description']->getData();
            $dueDate = $form['due_date']->getData();

            $manager = $this->getDoctrine()->getManager();
            $todoList = $manager->getRepository(TodoList::class)->find($idList);

            $todoList->setListName($name);
            //$todoList->setCategory($category);
            $todoList->setDescription($description);
            $todoList->setDuedate($dueDate);
            $todoList->setCreateDate($now);

            $manager->flush();

            $this->addFlash(
                'notice',
                'Todo Updated'
            );

            return $this->redirectToRoute('list_details', ['id' => $idList]);
        }

        return $this->render('list/edit.html.twig', [
            'todo' => $todoList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="_delete", requirements={"id" = "\d+"})
     *
     * @param TodoList $todoList
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

        return $this->redirectToRoute('list');
    }
}

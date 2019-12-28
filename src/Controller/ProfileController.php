<?php

namespace App\Controller;

use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ProfileController.
 *
 * @Route("/member", name="member")
 * @IsGranted("ROLE_USER")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="_profile")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();

        $form = $this
            ->createForm(UserType::class, $user)
            ->remove('plainPassword');

        $passwordForm = $this
            ->get('form.factory')
            ->createNamed('password', UserType::class, $user)
            ->remove('firstname')
            ->remove('lastname')
            ->remove('email');

        $passwordForm->handleRequest($request);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user
                ->setEmail($form->get('email')->getData())
                ->setFirstname($form->get('firstname')->getData())
                ->setLastname($form->get('lastname')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Info Updated'
            );
        }
        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            // encode the plain password
            $user
                ->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $passwordForm->get('plainPassword')->getData()
                    )
                );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Password Updated'
            );
        }

        return $this->render('profile/index.html.twig', [
            'form' => $form->createView(),
            'passwordForm' => $passwordForm->createView(),
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Form\BookFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * Dedicated controller for admin actions
 *
 * @Route("/admin")
 * @package AppBundle\Controller
 */
class AdminController extends Controller
{
    /**
     * @Route("/new", name="book_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(BookFormType::class);

        $sm = $this->get('AppBundle\Service\StatusManager');
        $sm->setAvailableStatuses($form);

        // process POST request
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('admin/new.html.twig', [
            'bookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="book_edit")
     */
    public function editAction(Request $request, Book $book)
    {
        $form = $this->createForm(BookFormType::class, $book);

        $sm = $this->get('AppBundle\Service\StatusManager');
        $sm->setAvailableStatuses($form, $book);

        // process POST request
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('admin/edit.html.twig', [
            'bookForm' => $form->createView()
        ]);
    }
}
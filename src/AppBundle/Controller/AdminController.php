<?php

namespace AppBundle\Controller;

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

        // process POST request
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/new.html.twig', [
            'bookForm' => $form->createView()
        ]);
    }
}
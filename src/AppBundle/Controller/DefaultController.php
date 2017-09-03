<?php

namespace AppBundle\Controller;

use AppBundle\Form\BookFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $books = $manager
            ->getRepository('AppBundle:Book')
            ->findAll();

        return $this->render('default/index.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/new", name="new")
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

        // replace this example code with whatever you need
        return $this->render('default/new.html.twig', [
            'bookForm' => $form->createView()
        ]);
    }
}

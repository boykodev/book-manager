<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Route("/books/{id}", name="book_show")
     */
    public function showAction(Book $book)
    {
        return $this->render('default/show.html.twig', [
            'book' => $book
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * Dedicated controller for API requests
 *
 * @Route("/api")
 * @package AppBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * API endpoint for status update
     *
     * @Route("/books/{id}")
     * @Method("POST")
     */
    public function updateAction(Book $book, Request $request)
    {
        $status = $request->request->get('status');

        // first we check if the status was passed
        if (!$status) {
            return new Response('Please provide status', Response::HTTP_BAD_REQUEST);
        }

        // then we check is such status exists
        $sm = $this->get('AppBundle\Service\StatusManager');
        if (!$sm->statusIsAllowed($status)) {
            $valid_statuses = implode(', ', Book::getStatuses());

            return new Response(
                sprintf('Please provide valid status (%s)', $valid_statuses),
                Response::HTTP_BAD_REQUEST
            );
        }

        // next we check if the status is allowed for the book
        if (!$sm->statusIsAllowed($status, $book)) {
            return new Response(
                'Provided status is not allowed for this book',
                Response::HTTP_METHOD_NOT_ALLOWED
            );
        }

        // and finally we check if the status is the same
        if ($status === $book->getStatus()) {
            return new Response(
                'The book already has provided status',
                Response::HTTP_OK
            );
        }

        $book->setStatus($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        return new Response("Status was changed to $status", Response::HTTP_OK);
    }
}
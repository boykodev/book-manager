<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @Route("/book/{book_id}", name="book_show")
     */
    public function showAction($book_id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $book = $manager// get the book by id
        ->getRepository('AppBundle:Book')
            ->find($book_id);

        // get available transitions with Workflow
        $workflow = $this->container->get('workflow.book_status');
        $transitions = $workflow->getEnabledTransitions($book);

        $form = $this->createFormBuilder(); // start form create

        foreach ($transitions as $transition) {
            $available_status = $transition->getTos()[0];
            // add available status as form submit button
            $form->add($available_status, SubmitType::class, array(
                    'label' => "Change status to $available_status",
                    'attr' => array('class' => 'btn btn-primary')
                )
            );
        }

        $form = $form->getForm(); // finish form create

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // set new book status
            $status = $form->getClickedButton()->getName();
            $book->setStatus($status);

            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/show.html.twig', [
            'book' => $book,
            'statusForm' => $form->createView()
        ]);
    }
}

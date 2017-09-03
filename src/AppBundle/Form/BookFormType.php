<?php

namespace AppBundle\Form;

use AppBundle\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BookFormType
 * This class handles the form for 'new book' page
 *
 * @package AppBundle\Form
 */
class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $statuses = Book::getStatuses();

        $builder
            ->add('title')
            ->add('year')
            ->add('authors')
            ->add('status', ChoiceType::class, [
                'choices' => array_combine($statuses, $statuses),
            ])
            ->add('add', SubmitType::class, [
                'label' => "Add",
                'attr' => array('class' => 'btn btn-primary')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Book'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_book_form_type';
    }
}

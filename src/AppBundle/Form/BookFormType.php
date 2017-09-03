<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $places = $options['workflow']->getDefinition()->getPlaces();

        $builder
            ->add('title')
            ->add('year')
            ->add('authors')
            ->add('status', ChoiceType::class, [
                'choices'  => $places,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Book'
        ]);

        $resolver->setRequired('workflow');
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_book_form_type';
    }
}

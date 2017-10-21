<?php

namespace AppBundle\Service;

use AppBundle\Entity\Book;
use Symfony\Component\Form\Form;
use Symfony\Component\Workflow\StateMachine;

class StatusManager
{
    private $field;
    private $workflow;

    function __construct(StateMachine $workflow)
    {
        $this->field = 'status';
        $this->workflow = $workflow;
    }

    public function getAvailableStatuses(Book $book = null)
    {
        if (!$book) {
            $statuses = Book::getStatuses();
        } else {
            $statuses = [$book->getStatus()];

            if ($this->workflow->can($book, 'to_free')) {
                $statuses[] = 'free';
            }

            if ($this->workflow->can($book, 'to_reserved')) {
                $statuses[] = 'reserved';
            }

            if ($this->workflow->can($book, 'to_taken')) {
                $statuses[] = 'taken';
            }
        }

        return array_combine($statuses, $statuses);
    }

    public function setAvailableStatuses(Form $form, Book $book = null)
    {
        $field = $form->get($this->field);
        $config = $field->getConfig();

        $options = $config->getOptions();
        $fieldType = get_class($config->getType()->getInnerType());

        $options['choices'] = $this->getAvailableStatuses($book);

        $form->add($this->field, $fieldType, $options);
    }

    public function statusIsAllowed(string $status, Book $book = null)
    {
        return in_array($status, $this->getAvailableStatuses($book));
    }
}
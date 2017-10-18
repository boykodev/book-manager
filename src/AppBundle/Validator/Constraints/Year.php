<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ConstrainsYear
 * @Annotation
 *
 * @package AppBundle\Validator
 */
class Year extends Constraint
{
    public $message = 'Please provide a valid year.';
}
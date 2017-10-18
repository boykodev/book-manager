<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class YearValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        // super simple year validation :)
        // TODO fix when the year is > 2100
        $year = (int)$value;
        if (!($year > 1 && $year < 2100)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
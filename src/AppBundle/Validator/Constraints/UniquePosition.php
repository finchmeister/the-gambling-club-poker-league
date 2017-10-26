<?php


namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniquePosition extends Constraint
{
    public $message = "Position must be unique per game";
}
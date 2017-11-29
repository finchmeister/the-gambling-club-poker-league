<?php


namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniquePlayer extends Constraint
{
    public $message = "Player(s) {{ player }} cannot have more than 1 result per game";
}
<?php


namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class WinningsMatchPot extends Constraint
{
    public $message = "Winnings {{ winnings }} does not match pot {{ pot }}";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
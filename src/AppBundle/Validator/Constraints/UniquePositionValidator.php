<?php


namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Result;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class UniquePositionValidator
 * @package AppBundle\Validator\Constraints
 */
class UniquePositionValidator extends ConstraintValidator
{
    public function validate($results, Constraint $constraint)
    {
        if ($results instanceof Collection) {
            $positions = $results->map(function (Result $result) {
                return $result->getPosition();
            })->toArray();
            $uniquePositions = array_unique($positions);

            if (count($uniquePositions) !== $results->count()) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
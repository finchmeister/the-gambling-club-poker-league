<?php


namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Result;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class UniquePlayerValidator
 * @package AppBundle\Validator\Constraints
 */
class UniquePlayerValidator extends ConstraintValidator
{
    public function validate($results, Constraint $constraint)
    {
        if ($results instanceof Collection) {
            $players = $results->map(function (Result $result) {
                return $result->getPlayer()->getId();
            })->toArray();
            $duplicatePlayers = [];
            foreach (array_count_values($players) as $player => $value) {
                if ($value > 1) {
                    $duplicatePlayers[] = $player;
                }
            }

            if ($duplicatePlayers) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ player }}', implode(", ", $duplicatePlayers))
                    ->addViolation();
            }
        }
    }
}
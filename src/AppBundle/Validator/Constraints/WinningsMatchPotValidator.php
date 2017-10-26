<?php


namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Game;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class WinningsMatchPotValidator
 * @package AppBundle\Validator\Constraints
 */
class WinningsMatchPotValidator extends ConstraintValidator
{
    public function validate($game, Constraint $constraint)
    {
        if ($game instanceof Game) {
            if ($pot = $game->getPot()) {
                $winnings = 0;
                foreach ($game->getResults() as $result) {
                    $winnings += $result->getWinnings();
                }
                if ($winnings !== $pot) {
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ winnings }}', $winnings)
                        ->setParameter('{{ pot }}', $pot)
                        ->addViolation();
                }
            }
        }
    }
}
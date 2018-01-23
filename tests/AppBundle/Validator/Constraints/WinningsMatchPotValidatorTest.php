<?php

namespace Tests\AppBundle\Validator\Constraints;


use AppBundle\Entity\Game;
use AppBundle\Validator\Constraints\WinningsMatchPot;
use AppBundle\Validator\Constraints\WinningsMatchPotValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContext;

class WinningsMatchPotValidatorTest extends TestCase
{

    public function testEmptyResultsIsValid()
    {
        $games = new Game();

        $validator  = new WinningsMatchPotValidator();
        $constraint = new WinningsMatchPot();
        $context = $this->createMock(ExecutionContext::class);

        $context->expects($this->never())
            ->method('addViolation');

        $validator->initialize($context);

        $validator->validate($games, $constraint);
    }

    //TODO mocking to method
}
<?php

namespace AppBundle\PokerStats;

use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class ResultRepositoryTest extends TestCase
{

    protected function getResultRepository(): ResultRepository
    {
        return new ResultRepository();
    }

    /**
     * @dataProvider maxWinnerCorrectDataProvider
     * @param Collection $results
     * @param $expectedResult
     */
    public function testMaxWinnerCorrectResult(
        Collection $results,
        $expectedResult
    ) {
        $resultRepository = $this->getResultRepository();

        $maxWinner = $resultRepository->getMaxCountWinsPlayer($results);

        $this->assertSame($expectedResult, $maxWinner);
    }

    public function maxWinnerCorrectDataProvider()
    {
        $winningPlayer1 = new Player();
        $winningPlayer1->setId(1);
        $player2 = new Player();
        $player2->setId(2);

        $result1 = new Result();
        $result1->setPlayer($winningPlayer1)->setPosition(1);

        $result2 = new Result();
        $result2->setPlayer($winningPlayer1)->setPosition(1);

        $result3 = new Result();
        $result3->setPlayer($player2)->setPosition(1);

        $resultsSet1 = new ArrayCollection([$result1, $result2, $result3]);
        $resultsSet2 = new ArrayCollection([$result1, $result3]);

        return [
            [$resultsSet1, $winningPlayer1],
            [$resultsSet2, null],
            [new ArrayCollection(), null],
        ];
    }

}

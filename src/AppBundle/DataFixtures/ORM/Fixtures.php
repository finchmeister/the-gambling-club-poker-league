<?php


namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Fixtures extends Fixture
{
    const PLAYER_DATA = [
        1 => ['Steve', 'Readng', true,],
        2 => ['Mike', 'Tadley', false,],
        3 => ['Bob', 'Basingstoke', true,],
        4 => ['Shaun', 'London', true,],
        5 => ['Bruce', 'Basingstoke', false,],
        6 => ['Nigel', 'Tadley', true,],
        7 => ['Gary', 'Reading', true,],
        8 => ['George', 'Ascot', false,],
        9 => ['Dean', 'Basingstoke', true,],
    ];

    const GAME_DATA = [
        [
            'host' => 1,
            'buyIn' => 10,
            'isLeague' => true,
            'results' => [
                1 => [
                    'player' => 1,
                    'winnings' => 70,
                    'noOfRebuys' => 1,
                ],
                2 => [
                    'player' => 3,
                    'winnings' => 40,
                    'noOfRebuys' => 0,
                ],
                3 => [
                    'player' => 7,
                    'winnings' => 0,
                    'noOfRebuys' => 2,
                ],
                4 => [
                    'player' => 4,
                    'winnings' => 0,
                    'noOfRebuys' => 0,
                ],
                5 => [
                    'player' => 9,
                    'winnings' => 0,
                    'noOfRebuys' => 0,
                ],
                6 => [
                    'player' => 6,
                    'winnings' => 0,
                    'noOfRebuys' => 2,
                ],
            ]
        ],
    ];


    public function load(ObjectManager $manager)
    {
        // Create Players
        $players = $games = $results = [];
        foreach (self::PLAYER_DATA as $id => $playerDatum) {
            $player = new Player();
            $player
                ->setName($playerDatum[0])
                ->setLocation($playerDatum[1])
                ->setLeaguePlayer($playerDatum[2]);
            $players[$id] = $player;
            $manager->persist($player);
        }

        // Create Games
        $date = new \DateTime("-4 months");
        foreach (self::GAME_DATA as $gameDatum) {
            $this->isWinningsValid($gameDatum);

            $game = new Game();
            $game
                ->setHost($players[$gameDatum['host']])
                ->setDate($date)
                ->setBuyIn($gameDatum['buyIn'])
                ->setIsLeague($gameDatum['isLeague']);
            $manager->persist($game);
            $games[] = $game;

            foreach ($gameDatum['results'] as $position => $resultDatum) {
                $result = new Result();
                $result
                    ->setGame($game)
                    ->setPlayer($players[$resultDatum['player']])
                    ->setPosition($position)
                    ->setWinnings($resultDatum['winnings'])
                    ->setNoOfRebuys($resultDatum['noOfRebuys']);
                $manager->persist($result);
            }

            $date = clone $date->add(new \DateInterval("P6W"));
        }


        $manager->flush();
    }

    /**
     * Verifies no money goes a stray
     * @param array $game
     * @throws \Exception
     */
    private function isWinningsValid(array $game): void
    {
        // buy in x no. players + Sum of noOfRebys * buy in = sum winnings
        $initalBuyIn = $game['buyIn'] * count($game['results']);
        $rebuys = array_sum(array_column($game['results'], 'noOfRebuys')) * $game['buyIn'];
        $putIn = $initalBuyIn + $rebuys;
        $won = array_sum(array_column($game['results'], 'winnings'));
        if ($putIn !== $won) {
            throw new \Exception(sprintf(
                "Winnings %s does not match input %s",
                $won,
                $putIn
            ));
        }
    }

}
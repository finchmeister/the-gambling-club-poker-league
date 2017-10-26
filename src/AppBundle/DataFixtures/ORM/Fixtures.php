<?php


namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

class Fixtures extends Fixture
{
    /**
     * @var Generator
     */
    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create('en_UK');

        // Create Players
        $players = $games = $results = [];
        foreach ($this->getPlayerData() as $id => $playerDatum) {
            $player = new Player();
            $player
                ->setName($playerDatum[0])
                ->setLocation($playerDatum[1])
                ->setLeaguePlayer($playerDatum[2]);
            $players[$id] = $player;
            $manager->persist($player);
        }

        $validator = $this->container->get('validator');

        // Create Games
        $date = new \DateTime("-4 months");
        foreach ($this->getGameData() as $gameDatum) {
            $this->isWinningsValid($gameDatum);

            $game = new Game();
            $game
                ->setHost($players[$gameDatum['host']])
                ->setDate($date)
                ->setBuyIn($gameDatum['buyIn'])
                ->setIsLeague($gameDatum['isLeague']);
            $games[] = $game;

            foreach ($gameDatum['results'] as $position => $resultDatum) {
                $result = new Result();
                $result
                    ->setPlayer($players[$resultDatum['player']])
                    ->setPosition($position)
                    ->setWinnings($resultDatum['winnings'])
                    ->setNoOfRebuys($resultDatum['noOfRebuys']);
                $game->addResult($result);
            }

            $errors = $validator->validate($game);

            // TODO not working
            if (count($errors) > 0) {
                throw new \Exception((string) $errors);
            }
            $manager->persist($game);

            $date = clone $date->add(new \DateInterval("P6W"));
        }

        $manager->flush();
    }

    /**
     * @todo: move to validation class on game
     * Verifies no money goes a stray
     * @param array $game
     * @throws \Exception
     */
    protected function isWinningsValid(array $game): void
    {
        // buy in * no. players + Sum of noOfRebys * buy in = sum winnings
        $initalBuyIn = $game['buyIn'] * count($game['results']);
        $rebuys = array_sum(array_column($game['results'], 'noOfRebuys')) * $game['buyIn'];
        $putIn = $initalBuyIn + $rebuys;
        $won = array_sum(array_column($game['results'], 'winnings'));
        if ($putIn !== $won) {
            throw new \Exception(sprintf(
                "Winnings %s does not match input %s (Host %s)",
                $won,
                $putIn,
                $game['host']
            ));
        }
    }

    protected function getPlayerData(): array
    {
        $playerData = [
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
        // TODO refactor
        foreach ($playerData as &$playerDatum) {
            $playerDatum[0] = $this->faker->firstNameMale;
            $playerDatum[1] = $this->faker->city;

        }
        return $playerData;
    }

    protected function getGameData(): array
    {
        return [
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
                ],
            ],
            [
                'host' => 2,
                'buyIn' => 10,
                'isLeague' => true,
                'results' => [
                    1 => [
                        'player' => 2,
                        'winnings' => 90,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => 3,
                        'winnings' => 40,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => 8,
                        'winnings' => 10,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => 4,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => 9,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    6 => [
                        'player' => 1,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    7 => [
                        'player' => 7,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    8 => [
                        'player' => 5,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                ],
            ],
            [
                'host' => 3,
                'buyIn' => 10,
                'isLeague' => true,
                'results' => [
                    1 => [
                        'player' => 1,
                        'winnings' => 70,
                        'noOfRebuys' => 1,
                    ],
                    2 => [
                        'player' => 1, // TODO, make validation work
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
                ],
            ],
            [
                'host' => 4,
                'buyIn' => 10,
                'isLeague' => false,
                'results' => [
                    1 => [
                        'player' => 1,
                        'winnings' => 70,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => 3,
                        'winnings' => 30,
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
                        'noOfRebuys' => 3,
                    ],
                ],
            ],
            [
                'host' => 5,
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
                ],
            ],
            [
                'host' => 6,
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
                ],
            ],
            [
                'host' => 7,
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
                ],
            ],
            [
                'host' => 8,
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
                ],
            ],
        ];

    }

}

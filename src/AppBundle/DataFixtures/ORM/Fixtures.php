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
        $this->faker = Factory::create('en_GB');

        // Create Players
        $players = $games = $results = [];
        foreach ($this->getPlayerData() as $id => $playerDatum) {
            $player = new Player();
            $player
                ->setName($playerDatum['name'])
                ->setLocation($playerDatum['location'])
                ->setLeaguePlayer($playerDatum['isLeague'])
                ->setBio($this->faker->paragraph(4))
            ;
            $players[$id] = $player;
            $manager->persist($player);
        }
        $manager->flush();

        $validator = $this->container->get('validator');

        // Create Games
        $date = new \DateTime("-4 months");
        foreach ($this->getGameData() as $gameDatum) {
            $game = new Game();
            $game
                ->setHost($players[$gameDatum['host']])
                ->setDate($date)
                ->setBuyIn($gameDatum['buyIn'])
                ->setSpotifyPlaylistUri($gameDatum['spotifyPlaylist'] ?? null)
                ->setIsLeague($gameDatum['isLeague'])
                ->setSnacks($gameDatum['snacks'] ?? null)
                ->setSnacksProvider(
                    isset($gameDatum['snacksProvider'])
                        ? $players[$gameDatum['snacksProvider']]
                        : null
                )
            ;
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
            $manager->persist($game);

            if (count($errors) > 0) {
                throw new \Exception((string) $errors);
            }

            $date = clone $date->add(new \DateInterval("P6W"));
        }

        $manager->flush();
    }



    protected function getPlayerData(): array
    {
        $playerData = [
            1 => ['isLeague' => true,],
            2 => ['isLeague' => true,],
            3 => ['isLeague' => true,],
            4 => ['isLeague' => true,],
            5 => ['isLeague' => true,],
            6 => ['isLeague' => true,],
            7 => ['isLeague' => false,],
            8 => ['isLeague' => false,],
            9 => ['isLeague' => false,],
        ];
        foreach ($playerData as &$playerDatum) {
            $playerDatum['name'] = $this->faker->firstNameMale;
            $playerDatum['location'] = $this->faker->city;
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
                'spotifyPlaylist' => 'spotify:user:jaybeattie92:playlist:0yi5B3TPFokw02DdXrIJLW',
                'results' => [
                    1 => [
                        'player' => 1,
                        'winnings' => 80,
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
                    7 => [
                        'player' => 2,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ],
            ],
            [
                'host' => 2,
                'buyIn' => 10,
                'isLeague' => true,
                'snacks' => 'Homemade cookies',
                'snacksProvider' => 2,
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
                        'player' => 6,
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
                'host' => 8,
                'buyIn' => 10,
                'isLeague' => false,
                'spotifyPlaylist' => 'spotify:user:jaybeattie92:playlist:0v1jakgHVEsdIDpVmKsyBB',
                'results' => [
                    1 => [
                        'player' => 9,
                        'winnings' => 60,
                        'noOfRebuys' => 1,
                    ],
                    2 => [
                        'player' => 5,
                        'winnings' => 20,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => 7,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    4 => [
                        'player' => 2,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => 1,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ],
            ],
            [
                'host' => 3,
                'buyIn' => 10,
                'isLeague' => true,
                'snacks' => 'Crisps',
                'snacksProvider' => 1,
                'results' => [
                    1 => [
                        'player' => 3,
                        'winnings' => 70,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => 5,
                        'winnings' => 40,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => 1,
                        'winnings' => 0,
                        'noOfRebuys' => 3,
                    ],
                    4 => [
                        'player' => 6,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    5 => [
                        'player' => 4,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => 2,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                ],
            ],
            [
                'host' => 4,
                'buyIn' => 10,
                'isLeague' => true,
                'spotifyPlaylist' => 'spotify:user:jaybeattie92:playlist:5J6kZw3HkJZj80zVZrg852',
                'snacks' => 'Ice cream',
                'snacksProvider' => 2,
                'results' => [
                    1 => [
                        'player' => 3,
                        'winnings' => 80,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => 5,
                        'winnings' => 40,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => 6,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => 2,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => 1,
                        'winnings' => 0,
                        'noOfRebuys' => 3,
                    ],
                    6 => [
                        'player' => 4,
                        'winnings' => 0,
                        'noOfRebuys' => 3,
                    ],
                ]
            ],[
                'host' => 5,
                'buyIn' => 10,
                'isLeague' => true,
                'spotifyPlaylist' => 'spotify:user:jaybeattie92:playlist:0XCfukhc7boJoOOtaS3WOm',
                'snacks' => 'Cheese and biscuits',
                'snacksProvider' => 4,
                'results' => [
                    1 => [
                        'player' => 1,
                        'winnings' => 100,
                        'noOfRebuys' => 1,
                    ],
                    2 => [
                        'player' => 5,
                        'winnings' => 50,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => 6,
                        'winnings' => 20,
                        'noOfRebuys' => 1,
                    ],
                    4 => [
                        'player' => 3,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => 2,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    6 => [
                        'player' => 9,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    7 => [
                        'player' => 4,
                        'winnings' => 0,
                        'noOfRebuys' => 3,
                    ],
                    8 => [
                        'player' => 7,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                ],
            ],
            [
                'host' => 9,
                'buyIn' => 10,
                'isLeague' => false,
                'results' => [
                    1 => [
                        'player' => 4,
                        'winnings' => 50,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => 1,
                        'winnings' => 20,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => 8,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    4 => [
                        'player' => 6,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => 3,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ],
            ],
            [
                'host' => 6,
                'buyIn' => 20,
                'isLeague' => true,
                'snacks' => 'Nuts',
                'snacksProvider' => 3,
                'results' => [
                    1 => [
                        'player' => 4,
                        'winnings' => 140,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => 3,
                        'winnings' => 80,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => 5,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    4 => [
                        'player' => 1,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => 6,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    6 => [
                        'player' => 2,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                ],
            ],
            [
                'host' => 7,
                'buyIn' => 10,
                'isLeague' => false,
                'spotifyPlaylist' => 'spotify:user:jaybeattie92:playlist:21TMF11wv7Ap0ZMcUXtVch',
                'results' => [
                    1 => [
                        'player' => 9,
                        'winnings' => 70,
                        'noOfRebuys' => 2,
                    ],
                    2 => [
                        'player' => 3,
                        'winnings' => 40,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => 6,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    4 => [
                        'player' => 2,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => 1,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => 4,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                ],
            ],
        ];
    }
}

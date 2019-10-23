<?php

namespace AppBundle\Command;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportLegacyResultsCommand extends Command
{
    const PLAYER_BODIN = 4;
    const PLAYER_CHARLIE = 13;
    const PLAYER_CIAN = 5;
    const PLAYER_JACK = 3;
    const PLAYER_JAY = 2;
    const PLAYER_JO = 1;
    const PLAYER_LUKE = 9;
    const PLAYER_ROLFE = 6;
    const PLAYER_MARK = 7;
    const PLAYER_MATTY = 11;
    const PLAYER_LEDGER = 10;
    const PLAYER_RICKY = 18;
    const PLAYER_HASLAM = 19;
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        ObjectManager $manager,
        ValidatorInterface $validator
    ) {
        $this->manager = $manager;
        $this->validator = $validator;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:import-legacy-results');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Create Games
        foreach ($this->getGameData() as $gameDatum) {
            if (($game = $this->getGame($gameDatum['date'])) !== null) {
                $output->writeln('Deleting '.$gameDatum['date']);
                $this->manager->remove($game);
            }

            $game = new Game();
            $game
                ->setHost($this->getPlayer($gameDatum['host']))
                ->setDate(new \DateTime($gameDatum['date']))
                ->setBuyIn($gameDatum['buyIn'])
                ->setIsLeague(true)
            ;
            $games[] = $game;

            foreach ($gameDatum['results'] as $position => $resultDatum) {
                $result = new Result();
                $result
                    ->setPlayer($this->getPlayer($resultDatum['player']))
                    ->setPosition($position)
                    ->setWinnings($resultDatum['winnings'])
                    ->setNoOfRebuys($resultDatum['noOfRebuys'])
                ;
                $game->addResult($result);
            }

            $uniquePlayersResults = array_unique(array_map(function ($result) {
                return $result['player'];
            }, $gameDatum['results']));

            if (count($uniquePlayersResults) !== count($gameDatum['results'])) {
                throw new \Exception((string) $gameDatum['date'] . " bad data entry");
            }

            $errors = $this->validator->validate($game);

            if (count($errors) > 0) {
                throw new \Exception((string) $errors);
            }
            $this->manager->persist($game);
            $output->writeln('Saving game '.$gameDatum['date']);
        }
        $this->manager->flush();
    }

    private function getGameData()
    {
        return [
            [
                'date' => '2015-01-22',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 40,
                        'noOfRebuys' => 1,
                        'isLeaguePlayer' => true,
                    ],
                    2 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 10,
                        'noOfRebuys' => 1,
                        'isLeaguePlayer' => true,
                    ],
                    3 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                        'isLeaguePlayer' => true,
                    ],
                    4 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                        'isLeaguePlayer' => true,
                    ],
                    5 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                        'isLeaguePlayer' => true,
                    ],
                    6 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                        'isLeaguePlayer' => true,
                    ],
                    7 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                        'isLeaguePlayer' => true,
                    ],
                ]
            ],
            [
                'date' => '2015-01-29',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 50,
                        'noOfRebuys' => 1,
                    ],
                    2 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 20,
                        'noOfRebuys' => 1,
                    ],
                    3 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    6 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    7 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    8 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                ]
            ],[
                'date' => '2015-02-05',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 60,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 20,
                        'noOfRebuys' => 1,
                    ],
                    3 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    4 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    5 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    7 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    8 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    9 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ],[
                'date' => '2015-02-10',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 40,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 10,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    5 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    8 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ],[
                'date' => '2015-02-18',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 50,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 20,
                        'noOfRebuys' => 1,
                    ],
                    3 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    6 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    8 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    9 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                ]
            ],[
                'date' => '2015-02-25',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 45,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 15,
                        'noOfRebuys' => 2,
                    ],
                    3 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    5 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    7 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    8 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ],[
                'date' => '2015-03-12',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 50,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 15,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    4 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    7 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    8 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                ]
            ],[
                'date' => '2015-03-19',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 55,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 20,
                        'noOfRebuys' => 1,
                    ],
                    3 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    5 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    8 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    9 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                ]
            ],[
                'date' => '2015-04-02',
                'buyIn' => 10,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 80,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_MATTY,
                        'winnings' => 40,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 20,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    6 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    8 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    9 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    10 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                ]
            ],[
                'date' => '2015-04-06',
                'buyIn' => 20,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 140,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 60,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 20,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    5 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    6 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    8 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ],
            // LEAGUE 2
            [
                'date' => '2015-04-16',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 50,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 20,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 10,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    6 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    8 => [
                        'player' => self::PLAYER_LEDGER,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    9 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    10 => [
                        'player' => self::PLAYER_RICKY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    11 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                ]
            ], [
                'date' => '2015-04-23',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 50,
                        'noOfRebuys' => 1,
                    ],
                    2 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 10,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 5,
                        'noOfRebuys' => 1,
                    ],
                    4 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    5 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_RICKY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    8 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    9 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ], [
                'date' => '2015-04-30',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 50,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 10,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_RICKY,
                        'winnings' => 5,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    8 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    9 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 3,
                    ],
                    10 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ], [
                'date' => '2015-05-07',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 50,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_RICKY,
                        'winnings' => 10,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 5,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    8 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    9 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    10 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                ]
            ],[
                'date' => '2015-05-21',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 50,
                        'noOfRebuys' => 2,
                    ],
                    2 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 20,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 5,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    7 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    8 => [
                        'player' => self::PLAYER_RICKY,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    9 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    10 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ],[
                'date' => '2015-05-28',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 50,
                        'noOfRebuys' => 1,
                    ],
                    2 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 15,
                        'noOfRebuys' => 1,
                    ],
                    3 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 5,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_RICKY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    6 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    7 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    8 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    9 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ], [
                'date' => '2015-06-05',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 60,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 20,
                        'noOfRebuys' => 2,
                    ],
                    3 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 10,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_RICKY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    6 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    7 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    8 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    9 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    10 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ], [
                'date' => '2015-08-05',
                'buyIn' => 5,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 50,
                        'noOfRebuys' => 1,
                    ],
                    2 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 20,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 10,
                        'noOfRebuys' => 1,
                    ],
                    4 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_RICKY,
                        'winnings' => 0,
                        'noOfRebuys' => 2,
                    ],
                    8 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    9 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    10 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                ]
            ],[
                'date' => '2015-08-13',
                'buyIn' => 10,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 90,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 40,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 20,
                        'noOfRebuys' => 2,
                    ],
                    4 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    6 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_RICKY,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    8 => [
                        'player' => self::PLAYER_HASLAM,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    9 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    10 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ],[
                'date' => '2015-09-23',
                'buyIn' => 20,
                'host' => self::PLAYER_JO,
                'results' => [
                    1 => [
                        'player' => self::PLAYER_JACK,
                        'winnings' => 95,
                        'noOfRebuys' => 0,
                    ],
                    2 => [
                        'player' => self::PLAYER_LUKE,
                        'winnings' => 95,
                        'noOfRebuys' => 0,
                    ],
                    3 => [
                        'player' => self::PLAYER_ROLFE,
                        'winnings' => 30,
                        'noOfRebuys' => 0,
                    ],
                    4 => [
                        'player' => self::PLAYER_CHARLIE,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    5 => [
                        'player' => self::PLAYER_JO,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    6 => [
                        'player' => self::PLAYER_BODIN,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    7 => [
                        'player' => self::PLAYER_RICKY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    8 => [
                        'player' => self::PLAYER_MARK,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                    9 => [
                        'player' => self::PLAYER_CIAN,
                        'winnings' => 0,
                        'noOfRebuys' => 1,
                    ],
                    10 => [
                        'player' => self::PLAYER_JAY,
                        'winnings' => 0,
                        'noOfRebuys' => 0,
                    ],
                ]
            ],




        ];
    }

    private function getPlayer(int $id): Player
    {
        return $this->manager->find(Player::class, $id);
    }

    private function getGame(string $date): ?Game
    {
        return $this->manager->getRepository(Game::class)
            ->findOneBy(['date' => new \DateTime($date)]);
    }
}

<?php


namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Player;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Fixtures extends Fixture
{
    const PLAYER_DATA = [
        ['Steve', 'Readng', true,],
        ['Mike', 'Tadley', true,],
        ['Bob', 'Basingstoke', true,],
        ['Shaun', 'London', true,],
        ['Nigel', 'Tadley', true,],
        ['Gary', 'Reading', true,],
        ['Dean', 'Basingstoke', true,],
        ['Bruce', 'Basingstoke', false,],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PLAYER_DATA as $playerDatum) {
            $player = new Player();
            $player
                ->setName($playerDatum[0])
                ->setLocation($playerDatum[1])
                ->setLeaguePlayer($playerDatum[2]);
            $manager->persist($player);
        }

        $manager->flush();
    }

}
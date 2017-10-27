<?php


namespace AppBundle\Command;

use AppBundle\Entity\Game;
use AppBundle\League\LeagueGame;
use AppBundle\League\SimpleOnePointPerPosition;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class UpdateLeaguePointsCommand
 * @package AppBundle\Command
 */
class UpdateLeaguePointsCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('app:update-league-points');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Updating The League Points');

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $leaguePoints = new LeagueGame(new SimpleOnePointPerPosition()); // TODO dependency inject

        $leagueGames = $em->getRepository(Game::class)
            ->findBy(['isLeague' => true]);

        $i = 0;
        foreach ($leagueGames as $leagueGame) {
            $leaguePoints->getLeagueGame($leagueGame);
            $i = $leaguePoints->isUpdated() ? $i + 1 : $i;
        }

        $em->flush();
        $io->success("Updated $i games");
    }

}
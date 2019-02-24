<?php


namespace AppBundle\Command;

use AppBundle\Entity\Result;
use AppBundle\Repository\ResultRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateResultsCommand extends Command
{
    /**
     * @var ResultRepository
     */
    private $resultRepository;

    public function __construct(ResultRepository $resultRepository)
    {
        $this->resultRepository = $resultRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:update-results');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Updating Results');

        /** @var Result[] $results */
        $results = $this->resultRepository->findAll();

        foreach ($results as $result) {
            $result->setUpdatedAt();
            $this->resultRepository->save($result);
        }

        $io->success(sprintf('Updated %s results', \count($results)));
    }

}
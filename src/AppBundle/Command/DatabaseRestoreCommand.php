<?php

namespace AppBundle\Command;

use AppBundle\DatabaseBackup\AbstractDatabaseBackup;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DatabaseRestoreCommand extends Command
{
    /**
     * @var AbstractDatabaseBackup
     */
    private $databaseBackup;

    public function __construct(
        AbstractDatabaseBackup $databaseBackup
    ) {
        $this->databaseBackup = $databaseBackup;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:database-restore')
            ->setDescription('Restore database');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $databaseNames = $this->databaseBackup->listDatabases();
        $databaseToRestore = $io->choice(
            'Select which database to restore',
            $databaseNames
        );
        $this->databaseBackup->restoreDatabase(['name' => $databaseToRestore]);

        $io->success(sprintf(
            "Database %s successfully restored",
            $databaseToRestore
        ));
    }
}

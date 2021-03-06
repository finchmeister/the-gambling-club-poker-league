<?php

namespace AppBundle\Command;

use AppBundle\DatabaseBackup\AbstractDatabaseBackup;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DatabaseBackupCommand extends Command
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
            ->setName('app:database-backup')
            ->setDescription('Exports database')
            ->addArgument('env', InputArgument::OPTIONAL, 'environment')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $env = $input->getArgument('env');
        $name = $this->databaseBackup->getDatabaseBackupName($env);
        $this->databaseBackup->backupDatabase(['name' => $name]);
        $io->success('Database successfully backed up');
    }
}

<?php

namespace AppBundle\Command;

use AppBundle\DatabaseBackup\DatabaseBackupInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DatabaseBackupCommand extends Command
{
    /**
     * @var DatabaseBackupInterface
     */
    private $databaseBackup;

    public function __construct(
        DatabaseBackupInterface $databaseBackup
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
            ->setDescription('Exports database');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->databaseBackup->backupDatabase();
        $io->success('Database successfully backed up');
    }
}

<?php


namespace AppBundle\DatabaseBackup;

abstract class AbstractDatabaseBackup
{
    abstract public function backupDatabase($config);

    abstract public function restoreDatabase($config);

    abstract public function listDatabases();

    public function getDatabaseBackupName(string $env = null)
    {
        return sprintf(
            "poker-db-%s-%s.sqlite",
            $env ?? 'dev',
            (new \DateTime())->format('Y-m-d-Hi')
        );
    }
}
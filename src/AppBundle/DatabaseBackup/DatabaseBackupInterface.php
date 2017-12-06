<?php


namespace AppBundle\DatabaseBackup;

interface DatabaseBackupInterface
{
    public function backupDatabase();

    public function restoreDatabase($config);
}
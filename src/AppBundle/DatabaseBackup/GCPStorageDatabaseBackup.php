<?php


namespace AppBundle\DatabaseBackup;

use AppBundle\CloudStorage\GCPStorage;

/**
 * Class GCPStorageDatabaseBackup
 * @package AppBundle\DatabaseBackup
 */
class GCPStorageDatabaseBackup implements DatabaseBackupInterface
{

    /**
     * @var GCPStorage
     */
    private $gcpStorage;
    /**
     * @var string
     */
    private $databasePath;

    public function __construct(
        GCPStorage $gcpStorage,
        string $databasePath
    ) {
        $this->gcpStorage = $gcpStorage;
        $this->databasePath = $databasePath;
    }

    public function backupDatabase()
    {
        $objectName = $this->getDatabaseBackupName();
        $this->gcpStorage->uploadObject($objectName, $this->databasePath);
    }

    public function restoreDatabase($config)
    {
    }

    public function getDatabaseBackupName()
    {
        return sprintf(
            "poker-db%s.sqlite",
            (new \DateTime())->format('Y-m-d-Hi')
        );
    }

}

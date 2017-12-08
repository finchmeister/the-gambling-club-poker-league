<?php


namespace AppBundle\DatabaseBackup;

use AppBundle\CloudStorage\GCPStorage;

/**
 * Class GCPStorageDatabaseBackup
 * @package AppBundle\DatabaseBackup
 */
class GCPStorageDatabaseBackup extends AbstractDatabaseBackup
{
    const FOLDER_NAME = 'database-backup';

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

    public function backupDatabase($config)
    {
        $objectName = self::FOLDER_NAME . '/' . $config['name'];
        $this->gcpStorage->uploadObject($objectName, $this->databasePath);
    }

    public function restoreDatabase($config)
    {
        $this->gcpStorage->downloadObject($config['name'], $this->databasePath);
    }

    public function listDatabases()
    {
        $prefix = self::FOLDER_NAME . "/poker";
        $objects = $this->gcpStorage->listObjects(['prefix' => $prefix]);
        $databaseNames = [];
        foreach ($objects as $object) {
            $databaseNames[] = $object->name();
        }
        return $databaseNames;
    }

}

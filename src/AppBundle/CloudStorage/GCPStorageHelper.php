<?php


namespace AppBundle\CloudStorage;

/**
 * Class GCPStorageHelper
 * @package AppBundle\CloudStorage
 */
class GCPStorageHelper
{

    /**
     * @var string
     */
    private $projectId;
    /**
     * @var string
     */
    private $bucketName;
    /**
     * @var string
     */
    private $keyFilePath;

    /**
     * GCPStorageHelper constructor.
     * @param string $projectId
     * @param string $bucketName
     * @param string|null $keyFilePath
     */
    public function __construct(
        string $projectId,
        string $bucketName,
        string $keyFilePath = null
    ) {
        $this->projectId = $projectId;
        $this->bucketName = $bucketName;
        $this->keyFilePath = $keyFilePath;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getPublicUrl(string $filename)
    {
        return sprintf(
            '%s/%s/%s',
            'https://storage.googleapis.com',
            $this->bucketName,
            $filename
        );
    }
}
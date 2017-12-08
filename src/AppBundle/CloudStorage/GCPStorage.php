<?php


namespace AppBundle\CloudStorage;

use Google\Cloud\Storage\ObjectIterator;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;

/**
 * Class GCPStorage
 * @package AppBundle\CloudStorage
 */
class GCPStorage
{
    /**
     * @var StorageClient
     */
    protected $storage;
    /**
     * @var \Google\Cloud\Storage\Bucket
     */
    protected $bucket;
    /**
     * @var string
     */
    protected $bucketName;

    public function __construct(
        $gcpKeyFilePath,
        $bucketName
    ) {
        $this->storage = new StorageClient(
            ['keyFilePath' => $gcpKeyFilePath]
        );
        $this->bucket = $this->storage->bucket($bucketName);
        $this->bucketName = $bucketName;
    }

    public function uploadObject($objectName, $source): StorageObject
    {
        $file = fopen($source, 'r');
        $object = $this->bucket->upload($file, [
            'name' => $objectName
        ]);
        return $object;
    }

    public function listObjects($options): ObjectIterator
    {
        return $this->bucket->objects($options);
    }

    public function downloadObject($objectName, $destination)
    {
        $object = $this->bucket->object($objectName);
        $object->downloadToFile($destination);
    }

}

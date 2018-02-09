<?php


namespace AppBundle\CloudStorage;

use Google\Cloud\Storage\ObjectIterator;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;

/**
 * Class GCPStorage
 * @package AppBundle\CloudStorage
 * @deprecated now using flysystem
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

    /**
     * GCPStorage constructor.
     * @param $gcpKeyFilePath
     * @param $defaultBucketName
     */
    public function __construct(
        $gcpKeyFilePath,
        $defaultBucketName
    ) {
        $this->storage = new StorageClient(
            ['keyFilePath' => $gcpKeyFilePath]
        );
        $this->bucket = $this->storage->bucket($defaultBucketName);
        $this->bucketName = $defaultBucketName;
    }

    /**
     * @param string $bucketName
     */
    public function setBucket(string $bucketName)
    {
        $this->bucket = $this->storage->bucket($bucketName);
    }

    /**
     * @param $objectName
     * @param $source
     * @param array $options
     * @return StorageObject
     */
    public function uploadObject($objectName, $source, array $options = [])
    {
        $options['name'] = $objectName;
        $file = fopen($source, 'r');
        $object = $this->bucket->upload($file, $options);
        return $object;
    }

    /**
     * @param $options
     * @return ObjectIterator
     */
    public function listObjects($options): ObjectIterator
    {
        return $this->bucket->objects($options);
    }

    /**
     * @param $objectName
     * @param $destination
     */
    public function downloadObject($objectName, $destination)
    {
        $object = $this->bucket->object($objectName);
        $object->downloadToFile($destination);
    }

    public function getPublicUrl($objectName)
    {
        return sprintf(
            "https://storage.googleapis.com/%s/%s",
            $this->bucketName,
            $objectName
        );
    }

}

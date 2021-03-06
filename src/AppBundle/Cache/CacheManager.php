<?php declare(strict_types=1);

namespace AppBundle\Cache;

class CacheManager
{
    public const DB_LAST_UPDATED_KEY = 'dbUpdated';
    /**
     * @var string
     */
    private $databasePath;
    private $redisClient;
    /**
     * @var bool
     */
    private $cacheEnabled;

    public function __construct(
        RedisClient $redisClient,
        string $databasePath,
        bool $cacheEnabled = true
    ) {
        $this->redisClient = $redisClient;
        $this->databasePath = $databasePath;
        $this->cacheEnabled = $cacheEnabled;
    }

    public function getCachedOrCompute(string $key, \Closure $callback)
    {
        if ($this->cacheEnabled === false) {
            return $callback();
        }

        if ($this->isDbDataNewerThanCache() === false) {
            $data = $this->redisClient->get($key);
            if ($data !== null) {
                return unserialize($data);
            }
        }

        $data = $callback();
        $this->redisClient->set($key, serialize($data));

        return $data;
    }

    public function isDbDataNewerThanCache(): bool
    {
        $dbLastModified = filemtime($this->databasePath);
        $cachedTime = $this->redisClient->get(self::DB_LAST_UPDATED_KEY);
        if ($cachedTime === null || $dbLastModified > $cachedTime) {
            $this->redisClient->set(self::DB_LAST_UPDATED_KEY, (string)time());

            return true;
        }

        return false;
    }
}

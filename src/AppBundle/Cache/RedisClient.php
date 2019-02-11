<?php declare(strict_types=1);

namespace AppBundle\Cache;

use Predis;

class RedisClient
{
    /** @var Predis\Client */
    private $client;

    public function __construct(string $host)
    {
        $this->client = new Predis\Client([
            'host'   => $host,
        ]);
    }

    public function get($key): ?string
    {
        return $this->client->get($key);
    }

    public function set(string $key, string $data)
    {
        return $this->client->set($key, $data);
    }

    public function getCachedOrCompute(string $key, \Closure $callback)
    {
        $data = $this->get($key);
        if ($data !== null) {
            return unserialize($data);
        }
        $data = $callback();
        $this->set($key, serialize($data));

        return $data;
    }


}

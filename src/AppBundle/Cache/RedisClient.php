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

    public function flushAll()
    {
        return $this->client->flushall();
    }
}

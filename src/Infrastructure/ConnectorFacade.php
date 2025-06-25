<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure;

use Redis;
use RedisException;

class ConnectorFacade
{
    public string $host;
    public int $port = 6379;
    public ?string $password = null;
    public ?int $dbindex = null;

    /** @var Connector $connector */
    public Connector $connector;

    public function __construct($host, $port, $password, $dbindex)
    {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->dbindex = $dbindex;
    }

    protected function build(): void
    {
        $redis = new Redis();

        try {
            $connect = $redis->connect($this->host, $this->port);
            if ($connect && $redis->ping('Pong')) {
                $redis->auth($this->password);
                $redis->select($this->dbindex);
                $this->connector = new Connector($redis);
            }
        } catch (RedisException) {
            throw new RedisException('Failed to connect to Redis server.');
        }
    }
}

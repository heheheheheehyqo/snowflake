<?php

namespace Hyqo\Snowflake\Resolver;

class MemcachedSequenceResolver implements SequenceResolverInterface
{
    /**
     * @var \Memcached
     */
    protected $connection;

    public function __construct(string $address)
    {
        if (!preg_match('/^(?P<host>[\w.]+):(?P<port>[\d]+)$/', $address, $matches)) {
            throw new \InvalidArgumentException('Address must be "ip:port"');
        }

        if (!class_exists('Memcached')) {
            throw new \RuntimeException("ext-memcached doesn't not exist");
        }

        $this->connection = new \Memcached('hyqo.snowflake');

        if (!count($this->connection->getServerList())) {
            $this->connection->addServer($matches['host'], $matches['port']);
        }

        $this->connection->setOptions([
            \Memcached::OPT_PREFIX_KEY => 'hyqo.snowflake:',
            \Memcached::OPT_NO_BLOCK => true,
            \Memcached::OPT_BINARY_PROTOCOL => true,
            \Memcached::OPT_TCP_NODELAY => true,
            \Memcached::OPT_LIBKETAMA_COMPATIBLE => true,
        ]);
    }

    public function sequence(int $time): int
    {
        return $this->connection->increment($time, 1, 0, 1);
    }
}

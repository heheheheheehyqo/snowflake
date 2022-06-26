<?php

use Hyqo\Snowflake;

include_once __DIR__ . '/vendor/autoload.php';

function t()
{
    return microtime(true) * 1000;
}

$address = sprintf('%s:11211', getenv('MEMCACHED_HOST') ?: 'memcached');

$localSnowflake = new Snowflake\Snowflake(new Snowflake\Resolver\LocalSequenceResolver());
$sharedSnowflake = new Snowflake\Snowflake(new Snowflake\Resolver\SharedSequenceResolver());
$memcachedSnowflake = new Snowflake\Snowflake(new Snowflake\Resolver\MemcachedSequenceResolver($address));

$amount = 10000;

$i = 0;
$t = t();
while ($i++ < $amount) {
    $localSnowflake->generate();
}

echo "local: " . (t() - $t) . "ms\n";

$i = 0;
$t = t();
while ($i++ < $amount) {
    $sharedSnowflake->generate();
}

echo "shared: " . (t() - $t) . "ms\n";

$i = 0;
$t = t();
while ($i++ < $amount) {
    $memcachedSnowflake->generate();
}

echo "memcached: " . (t() - $t) . "ms\n";

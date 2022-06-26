<?php

namespace Hyqo\Snowflake\Resolver;

interface SequenceResolverInterface
{
    public function sequence(int $time): int;
}

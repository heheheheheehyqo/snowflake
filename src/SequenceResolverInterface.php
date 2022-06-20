<?php

namespace Hyqo\Snowflake;

interface SequenceResolverInterface
{
    public function sequence(int $time): int;
}

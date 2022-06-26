<?php

namespace Hyqo\Snowflake\Resolver;

class LocalSequenceResolver implements SequenceResolverInterface
{
    private $lastTime;

    private $index;

    public function sequence(int $time): int
    {
        if ($this->lastTime === $time) {
            return ++$this->index;
        }

        $this->lastTime = $time;
        return $this->index = 0;
    }
}

<?php

namespace Hyqo\Snowflake\Resolver;

class SharedSequenceResolver implements SequenceResolverInterface
{
    protected $filename;

    public function __construct()
    {
        $this->filename = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'hyqo.snowflake.sequence';
    }

    public function sequence(int $time): int
    {
        $stream = fopen($this->filename, 'cb+');
        flock($stream, LOCK_EX);

        $lastTime = (int)fgets($stream);
        $sequence = (int)fgets($stream);

        if ($lastTime === $time) {
            $sequence++;
        } else {
            $sequence = 0;
        }

        ftruncate($stream, 0);
        rewind($stream);
        fwrite($stream, $time . PHP_EOL . $sequence);

        fclose($stream);

        return $sequence;
    }
}

<?php

namespace Hyqo\Snowflake\Test;

use Hyqo\Snowflake\SequenceResolverInterface;
use Hyqo\Snowflake\Snowflake;
use PHPUnit\Framework\TestCase;

class SnowflakeTest extends TestCase
{

    private function createResolver(): SequenceResolverInterface
    {
        return new class() implements SequenceResolverInterface {
            private $lastTime;

            private $index;

            public function sequence(int $time): int
            {
                if ($this->lastTime === $time) {
                    return ++$this->index;
                }

                $this->lastTime = $time;
                return $this->index = 1;
            }
        };
    }

    public function test_generate()
    {
        $snowflake = new Snowflake($this->createResolver());

        $firstId = $snowflake->generate();
        $secondId = $snowflake->generate();

        $firstData = $snowflake->parse($firstId);
        $secondData = $snowflake->parse($secondId);

        $this->assertEquals($firstData['timestamp'], $secondData['timestamp']);
        $this->assertEquals(1, $firstData['sequence']);
        $this->assertEquals(2, $secondData['sequence']);
    }

    public function test_generate_for_date_time()
    {
        $snowflake = new Snowflake($this->createResolver());

        $firstId = $snowflake->generateForDateTime(new \DateTimeImmutable('2022-01-01'));
        $secondId = $snowflake->generateForDateTime(new \DateTimeImmutable('2022-01-01'));

        $firstData = $snowflake->parse($firstId);
        $secondData = $snowflake->parse($secondId);

        $this->assertEquals($firstData['timestamp'], $secondData['timestamp']);
        $this->assertEquals(1, $firstData['sequence']);
        $this->assertEquals(2, $secondData['sequence']);
    }
}

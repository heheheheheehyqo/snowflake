<?php

namespace Hyqo\Snowflake\Test;

use Hyqo\Snowflake\SequenceResolverInterface;
use Hyqo\Snowflake\Snowflake;
use PHPUnit\Framework\TestCase;

class SnowflakeTest extends TestCase
{
    public function test_generate(): void
    {
        $snowflake = new Snowflake();

        $firstId = $snowflake->generate();
        $secondId = $snowflake->generate();

        $firstData = $snowflake->parse($firstId);
        $secondData = $snowflake->parse($secondId);

        $this->assertEquals($firstData['timestamp'], $secondData['timestamp']);
        $this->assertEquals(1, $firstData['sequence']);
        $this->assertEquals(2, $secondData['sequence']);
    }

    public function test_generate_for_date_time(): void
    {
        $snowflake = new Snowflake();

        $firstId = $snowflake->generateForDateTime(new \DateTimeImmutable('2022-01-01'));
        $secondId = $snowflake->generateForDateTime(new \DateTimeImmutable('2022-01-01'));

        $firstData = $snowflake->parse($firstId);
        $secondData = $snowflake->parse($secondId);

        $this->assertEquals($firstData['timestamp'], $secondData['timestamp']);
        $this->assertEquals(1, $firstData['sequence']);
        $this->assertEquals(2, $secondData['sequence']);
    }

    public function test_sequence_resolver(): void
    {
        $resolver = new class() implements SequenceResolverInterface {
            public function sequence(int $time): int
            {
                return 1;
            }
        };

        $snowflake = new Snowflake($resolver);

        $firstId = $snowflake->generate();
        $secondId = $snowflake->generate();

        $firstData = $snowflake->parse($firstId);
        $secondData = $snowflake->parse($secondId);

        $this->assertEquals($firstData['timestamp'], $secondData['timestamp']);
        $this->assertEquals(1, $firstData['sequence']);
        $this->assertEquals(1, $secondData['sequence']);
    }
}

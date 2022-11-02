<?php

declare(strict_types=1);

namespace MtsDependencyInjection\Tests\unit;

use MtsProject\Example;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-suppress UnusedClass
 * @psalm-suppress MissingThrowsDocblock
 */
final class ExampleTest extends TestCase
{
    public function testExample(): void
    {
        self::assertTrue(true);
    }

    public function testRun(): void
    {
        $fixture = new Example();
        $expected = 'Hello, world!';

        $actual = $fixture->run();

        self::assertSame($expected, $actual);
    }
}

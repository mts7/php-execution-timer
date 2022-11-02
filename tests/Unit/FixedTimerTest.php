<?php

declare(strict_types=1);

namespace MtsTimer\Tests\Unit;

use MtsTimer\FixedTimer;
use PHPUnit\Framework\TestCase;

/**
 * @group timer
 */
final class FixedTimerTest extends TestCase
{
    private FixedTimer $fixture;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new FixedTimer();
    }

    public function testSetDuration(): void
    {
        $duration = 1.7;

        $this->fixture->setDuration($duration);
        $total = $this->fixture->getTotalDuration();

        $this->assertSame($duration, $total);
    }

    public function testSetDurationEmpty(): void
    {
        $duration = $this->fixture->getTotalDuration();

        $this->assertSame(0.0, $duration);
    }

    public function testGetDuration(): void
    {
        $duration = $this->fixture->getDuration();

        $this->assertSame(0.0, $duration);
    }
}

<?php

declare(strict_types=1);

namespace MtsTimer\Tests\Unit;

use MtsTimer\FixedTimer;
use MtsTimer\Tests\TimerTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * This tests all of the base functionality using FixedTimer.
 *
 * @group timer
 */
final class FixedTimerTest extends TestCase
{
    use TimerTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new FixedTimer();
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testGetDurationFixed(): void
    {
        $this->initializeTimer();

        $duration = $this->fixture->getDuration();
        $total = $this->fixture->getTotalDuration();

        $this->assertSame(FixedTimer::DURATION, round($duration, 1));
        $this->assertSame(FixedTimer::DURATION, round($total, 1));
    }
}

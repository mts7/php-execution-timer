<?php

declare(strict_types=1);

namespace MtsTimer\Tests\Unit;

use MtsTimer\Exception\IncompleteTimingException;
use MtsTimer\Timer;
use PHPUnit\Framework\TestCase;

/**
 * @group timer
 */
final class TimerTest extends TestCase
{
    private Timer $fixture;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new Timer();
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testResetDuration(): void
    {
        $this->initializeTimer();
        $duration = $this->fixture->getDuration();

        $this->fixture->reset();

        $this->assertGreaterThan(0.0, $duration);
        $this->expectException(IncompleteTimingException::class);
        $this->expectErrorMessage('Call $timer->start() before computing duration.');
        $this->fixture->getDuration();
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testResetTotalDuration(): void
    {
        $this->initializeTimer();
        $duration = $this->fixture->getDuration();

        $this->fixture->reset();

        $this->assertGreaterThan(0.0, $duration);
        $this->expectException(IncompleteTimingException::class);
        $this->expectErrorMessage(
            'Call $timer->start(); followed by $timer->stop(); before getting the total duration.'
        );
        $this->fixture->getTotalDuration();
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testResetStop(): void
    {
        $this->initializeTimer();
        $duration = $this->fixture->getDuration();

        $this->fixture->reset();

        $this->assertGreaterThan(0.0, $duration);
        $this->expectException(IncompleteTimingException::class);
        $this->expectErrorMessage('Call $timer->start() before computing duration.');
        $this->fixture->stop();
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testStart(): void
    {
        $this->initializeTimer();
        $duration = $this->fixture->getDuration();

        $this->fixture->start();

        $this->assertGreaterThan(0.0, $duration);
        $this->expectException(IncompleteTimingException::class);
        $this->expectErrorMessage('Call $timer->stop() before computing duration.');
        $this->fixture->getDuration();
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testStopDouble(): void
    {
        $this->initializeTimer();

        $this->expectException(IncompleteTimingException::class);
        $this->expectErrorMessage('Call $timer->start() prior to calling $timer->stop().');
        $this->fixture->stop();
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testStopResult(): void
    {
        $this->initializeTimer();

        $duration = $this->fixture->getDuration();
        $total = $this->fixture->getTotalDuration();

        $this->assertSame($duration, $total);
    }

    public function testGetTotalDuration(): void
    {
        $this->expectException(IncompleteTimingException::class);
        $this->expectErrorMessage(
            'Call $timer->start(); followed by $timer->stop(); before getting the total duration.'
        );
        $this->fixture->getTotalDuration();
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testGetTotalDurationMultiple(): void
    {
        $duration = 0;
        $this->initializeTimer();
        $duration += $this->fixture->getDuration();
        $this->initializeTimer();
        $duration += $this->fixture->getDuration();
        $this->initializeTimer();
        $duration += $this->fixture->getDuration();

        $this->assertSame($duration, $this->fixture->getTotalDuration());
        $this->assertLessThan(microtime(true), $duration);
    }

    private function doStuff(): void
    {
        $array = array_fill(0, 100, 'apple');
        $copy = array_reverse($array);
        sort($copy);
    }

    /**
     * Calls both start and stop to initialize those values.
     *
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    private function initializeTimer(): void
    {
        $this->fixture->start();
        $this->doStuff();
        $this->fixture->stop();
    }
}

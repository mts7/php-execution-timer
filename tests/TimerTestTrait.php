<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace MtsTimer\Tests;

use MtsTimer\Exception\IncompleteTimingException;
use MtsTimer\TimerInterface;

/**
 * Common methods for testing AbstractTimer
 *
 * This introduces planned redundancy since each implementor of AbstractTimer
 * should include this trait, which then tests all the common methods within
 * AbstractTimer. Each child TimerInterface class may test its own methods that
 * differ from those in AbstractTimer. In general, all TimerInterface objects
 * should have the same logic for timing.
 */
trait TimerTestTrait
{
    private TimerInterface $fixture;

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
            'Call $timer->sumDuration() after stopping the timer before getting the total duration.'
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
        $this->expectErrorMessage('Call $timer->start() prior to calling $timer->stop().');

        $this->fixture->stop();
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testStart(): void
    {
        $this->initializeTimer();
        $duration = $this->fixture->getDuration();
        $this->fixture->reset();

        $this->fixture->start();

        $this->assertGreaterThan(0.0, $duration);
        $this->expectException(IncompleteTimingException::class);
        $this->expectErrorMessage('Call $timer->stop() before computing duration.');

        $this->fixture->getDuration();
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testStop(): void
    {
        $this->expectException(IncompleteTimingException::class);
        $this->expectErrorMessage('Call $timer->start() prior to calling $timer->stop().');

        $this->fixture->stop();
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

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function testGetTotalDuration(): void
    {
        $this->expectException(IncompleteTimingException::class);
        $this->expectErrorMessage(
            'Call $timer->sumDuration() after stopping the timer before getting the total duration.'
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
    protected function initializeTimer(): void
    {
        $this->fixture->start();
        $this->doStuff();
        $this->fixture->stop();
        $this->fixture->addDuration();
    }
}

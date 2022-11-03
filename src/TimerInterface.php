<?php

declare(strict_types=1);

namespace MtsTimer;

/**
 * All timers should be based on this interface.
 */
interface TimerInterface
{
    /**
     * Resets the timer.
     */
    public function reset(): void;

    /**
     * Starts the timer.
     */
    public function start(): void;

    /**
     * Stops the timer.
     *
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function stop(): void;

    /**
     * Gets the duration of the last timer.
     *
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function getDuration(): float;

    /**
     * Gets the total duration from all timers.
     *
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function getTotalDuration(): float;

    /**
     * Adds the last duration to the existing duration value for a running total
     *
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function addDuration(): void;
}

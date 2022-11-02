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
     * Ends the timer.
     */
    public function stop(): void;

    /**
     * Gets the duration of the last timer.
     */
    public function getDuration(): float;

    /**
     * Gets the total duration from all timers.
     */
    public function getTotalDuration(): float;
}

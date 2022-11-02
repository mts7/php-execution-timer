<?php

declare(strict_types=1);

namespace MtsTimer;

/**
 * Use a timer with fixed values for testing classes implementing TimerInterface.
 */
class FixedTimer implements TimerInterface
{
    private float $duration = 0.0;

    public function setDuration(float $duration): void
    {
        $this->duration = $duration;
    }

    public function reset(): void
    {
        // there is no need to reset since the values are pre-configured
    }

    public function start(): void
    {
        // the start value should be set by configure() method
    }

    public function stop(): void
    {
        // the end value should be set by configure() method
    }

    public function getDuration(): float
    {
        // this is unused
        return 0.0;
    }

    public function getTotalDuration(): float
    {
        return $this->duration;
    }
}

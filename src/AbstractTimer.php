<?php

declare(strict_types=1);

namespace MtsTimer;

use MtsTimer\Exception\IncompleteTimingException;

/**
 * Base class for common timer logic
 */
abstract class AbstractTimer implements TimerInterface
{
    protected float $duration = 0.0;

    protected float $timeStop = 0.0;

    protected float $timeStart = 0.0;

    public function reset(): void
    {
        $this->duration = 0.0;
        $this->timeStart = 0.0;
        $this->timeStop = 0.0;
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function stop(): void
    {
        // save the time prior to executing additional statements
        $now = $this->getNow();
        if ($this->timeStop > $this->timeStart || $this->timeStart === 0.0) {
            throw new IncompleteTimingException('Call $timer->start() prior to calling $timer->stop().');
        }
        $this->timeStop = $now;
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function getDuration(): float
    {
        if ($this->timeStart === 0.0) {
            throw new IncompleteTimingException('Call $timer->start() before computing duration.');
        }
        if ($this->timeStop === 0.0) {
            throw new IncompleteTimingException('Call $timer->stop() before computing duration.');
        }

        return $this->timeStop - $this->timeStart;
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function getTotalDuration(): float
    {
        if ($this->duration === 0.0) {
            throw new IncompleteTimingException(
                'Call $timer->sumDuration() after stopping the timer before getting the total duration.'
            );
        }

        return $this->duration;
    }

    /**
     * Adds the last duration to the existing duration value for a running total
     *
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function addDuration(): void
    {
        $this->duration += $this->getDuration();
    }

    protected function getNow(): float
    {
        return microtime(true);
    }

    protected function setStart(float $time): void
    {
        $this->timeStart = $time;
    }
}

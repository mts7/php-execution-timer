<?php

declare(strict_types=1);

namespace MtsTimer;

use MtsTimer\Exception\IncompleteTimingException;

/**
 * Timer for handling timing of events/processes.
 */
final class Timer implements TimerInterface
{
    private float $duration = 0.0;

    private float $timeStop = 0.0;

    private float $timeStart = 0.0;

    public function reset(): void
    {
        $this->duration = 0.0;
        $this->timeStart = 0.0;
        $this->timeStop = 0.0;
    }

    public function start(): void
    {
        $this->timeStop = 0.0;
        $this->timeStart = microtime(true);
    }

    /**
     * @throws \MtsTimer\Exception\IncompleteTimingException
     */
    public function stop(): void
    {
        // save the time prior to executing additional statements
        $now = microtime(true);
        if ($this->timeStop !== 0.0) {
            throw new IncompleteTimingException('Call $timer->start() prior to calling $timer->stop().');
        }
        $this->timeStop = $now;
        $this->duration += $this->getDuration();
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
                'Call $timer->start(); followed by $timer->stop(); before getting the total duration.'
            );
        }

        return $this->duration;
    }
}

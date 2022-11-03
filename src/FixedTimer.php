<?php

declare(strict_types=1);

namespace MtsTimer;

/**
 * Use a timer with fixed values for testing classes implementing TimerInterface.
 */
class FixedTimer extends AbstractTimer
{
    public const DURATION = 1.7;

    /**
     * Sets the start value to an arbitrary value to avoid getting the time.
     */
    public function start(): void
    {
        // this allows multiple fixed calls to work
        $this->timeStop = 0;

        $this->setStart(1.0);
    }

    /**
     * Gets the sum of the start time and the fixed duration.
     *
     * The final calculation for stop will be start + duration - start, so the
     * fixed duration set in setDuration() will be the result.
     *
     * @see start()
     * @see stop()
     *
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected function getNow(): float
    {
        return $this->timeStart + self::DURATION;
    }
}

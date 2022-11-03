<?php

declare(strict_types=1);

namespace MtsTimer;

/**
 * Timer for handling timing of events/processes.
 */
final class Timer extends AbstractTimer
{
    public function start(): void
    {
        $this->setStart($this->getNow());
    }
}

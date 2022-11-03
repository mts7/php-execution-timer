<?php

declare(strict_types=1);

namespace MtsTimer\Tests\Unit;

use MtsTimer\Tests\TimerTestTrait;
use MtsTimer\Timer;
use PHPUnit\Framework\TestCase;

/**
 * This tests all the base functionality using Timer.
 *
 * @group timer
 */
final class TimerTest extends TestCase
{
    use TimerTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new Timer();
    }
}

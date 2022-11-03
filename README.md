# PHP Execution Timer

PHP timer for tracking and accumulating timings

## Installation

```shell
composer require mts7/php-execution-timer
```

## Usage

### Single measurement

When measuring the time for a single event, use `getDuration` to find the amount
of time spent on that specific functionality.

```php
$timer = new \MtsTimer\Timer();
$timer->start();
doSomething();
$timer->stop();
echo 'Duration: ' . $timer->getDuration() . PHP_EOL;
```

### Multiple measurements

When measuring the time for multiple events, use `getTotalDuration` to find the
total durations of all the included functionalities.

```php
$timer = new \MtsTimer\Timer();
for ($i = 0; $i < 5; $i++) {
    $timer->start();
    doSomething();
    $timer->stop();
    echo 'Something took ' . $timer->getDuration() . ' seconds.' . PHP_EOL;
}
echo 'Total duration: ' . $timer->getTotalDuration() . PHP_EOL;
```

### Resetting between measurements

Some situations require having multiple accumulations that are tracked
independently. For these, use `reset` to clear the timers and reset all internal
values to `0.0.`.

```php
$timer = new \MtsTimer\Timer();
$timings = [];
for ($i = 0; $i < 3; $i++) {
    $timer->reset();
    for ($j = 0; $j < 5; $j++) {
        $timer->start();
        doSomething();
        $timer->stop();    
    }
    $timings[] = $timer->getTotalDuration();
}
```

## Testing with FixedTimer

The usual timer in the code is `Timer` while the tests would use `FixedTimer`
without changing the code. Having `TimerInterface` is a benefit of using
composition. Since both `Timer` and `FixedTimer` have similar functionality, the
base functionalities are contained in `AbstractTimer` with overriding methods as
necessary.

`FixedTimer` uses two constant (fixed) values (instead of the time): One for
start, and another for stop.

### Examples

These are very simple examples of having a class that uses the timer as well as
a class that uses the class and a class that tests the class. In real-world
scenarios, use a [container](https://github.com/mts7/php-dependency-injection)
for dependency injection and a callable that takes time.

```php
class Benchmark
{
    public function __construct(private \MtsTimer\TimerInterface $timer)
    {
    }

    public function run(callable $callable): float
    {
        $this->timer->start();
        $callable();
        $this->timer->stop();
        
        return $this->timer->getDuration();
    }
}

class RunTheBenchmark
{
    public function execute(): float
    {
        $timer = new \MtsTimer\Timer();
        $benchmark = new Benchmark($timer);
        return $benchmark->run([self::class, 'doNothing']);
    }
    
    public static function doNothing(): void
    {
    }
}

class BenchmarkTest
{
    public function testRun(): void
    {
        $timer = new \MtsTimer\FixedTimer();
        $benchmark = new Benchmark($timer);

        $duration = $benchmark->run([RunTheBenchmark::class, 'doNothing']);
        
        $this->assertSame($timer::DURATION, $duration);
    }
}
```

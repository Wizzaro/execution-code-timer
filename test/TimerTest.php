<?php
/**
 * Copyright © Wizzaro. All rights reserved.
 */
namespace WizzaroTest\ExecutionCodeTimer;

use PHPUnit\Framework\TestCase;
use Wizzaro\ExecutionCodeTimer\Timer;

use ReflectionClass;
use ReflectionProperty;
use DateTimeInterface;

class TimerTest extends TestCase
{
    public function testStartedMeasurementOnConstructor()
    {
        $timer = new Timer(true);
        $this->assertInstanceOf(DateTimeInterface::class, $this->getStartDateTimeProperty()->getValue($timer));
    }

    public function testNotStartedMeasurementOnConstructor()
    {
        $timer = new Timer();
        $this->assertNull($this->getStartDateTimeProperty()->getValue($timer));
    }

    public function testStartedMeasurementOnFunction()
    {
        $timer = new Timer();
        $timer->startMeasurement();
        $this->assertInstanceOf(DateTimeInterface::class, $this->getStartDateTimeProperty()->getValue($timer));
    }

    /**
     * @expectedException Exception
     */
    public function testStartMeasurementAgain()
    {
        $timer = new Timer(true);
        $timer->startMeasurement();
    }

    public function testHasMeasurementWasStartedFalse() {
        $timer = new Timer();
        $this->assertFalse($timer->hasMeasurementWasStarted());
    }

    public function testHasMeasurementWasStartedTrue() {
        $timer = new Timer(true);
        $this->assertTrue($timer->hasMeasurementWasStarted());
    }

    /**
     * @expectedException Exception
     */
    public function testGetNotStartedMeasurementTime()
    {
        $timer = new Timer();
        $startTime = $timer->getStartTime();
    }

    public function testCorrectExecutionTime()
    {
        $timer = new Timer(true);
        sleep(1);
        $executionTime = $timer->getExecutionTime();

        $this->assertEquals([
            'y' => 0,
            'm' => 0,
            'd' => 0,
            'h' => 0,
            'i' => 0,
            's' => 1
        ], [
            'y' => $executionTime->y,
            'm' => $executionTime->m,
            'd' => $executionTime->d,
            'h' => $executionTime->h,
            'i' => $executionTime->i,
            's' => $executionTime->s
        ]);
    }

    public function testSetExecutionInfoFormat()
    {
        $timer = new Timer();
        $newFormat = 'This is test execution info format';
        $timer->setExecutionInfoFormat($newFormat);

        $this->assertEquals($newFormat, $timer->getExecutionInfoFormat());
    }

    public function testSetExecutionInfoFormatWhenGetExecutionInfo()
    {
        $timer = new Timer(true);
        $newFormat = 'This is test execution info format';

        $this->assertEquals($newFormat, $timer->getExecutionInfo($newFormat));
    }

    public function testSetExecutionInfoFormatInGetExecutionInfo()
    {
        $timer = new Timer(true);
        $newFormat = 'This is test execution info format';
        $timer->setExecutionInfoFormat($newFormat);

        $this->assertEquals($newFormat, $timer->getExecutionInfo());
    }

    public function testExecutionInfo()
    {
        $timer = new Timer();
        $timer->setExecutionInfoFormat('%y years, %m months, %a days, %h hours, %i minutes and %s seconds, %f microsecunds');
        $timer->startMeasurement();
        sleep(1);
        
        $this->assertRegExp('/^(0 years, 0 months, 0 days, 0 hours, 0 minutes and 1 seconds, ){1}([0-9])+( microsecunds){1}$/i', $timer->getExecutionInfo());
    }

    public function testToString()
    {
        $timer = new Timer(true);
        $newFormat = 'This is test execution info format';
        $timer->setExecutionInfoFormat($newFormat);

        $this->assertEquals($newFormat, (string) $timer);
    }

    private function getStartDateTimeProperty(): ReflectionProperty
    {
        $timerReflection = new ReflectionClass(Timer::class);
        $startDateTimeProperty = $timerReflection->getProperty('startDateTime');
        $startDateTimeProperty->setAccessible(true);

        return $startDateTimeProperty;
    }
}
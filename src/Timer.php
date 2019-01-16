<?php
/**
 * Copyright © Wizzaro. All rights reserved.
 */
namespace Wizzaro\ExecutionCodeTimer;

use DateTime;
use DateTimeInterface;
use DateInterval;
use Exception;

/**
 * The class providing an easy way to measure the execution time of the code
 */
class Timer
{
    /**
     * @var DateTime|null
     */
    private $startDateTime;

    /**
     * @var string
     */
    private $executionInfoFormat = '%y years, %m months, %a days, %h hours, %i minutes and %s seconds, %f microsecunds';


    /**
     * Constructor
     *
     * @param bool $startMeasurement start measurement while creating the object
     */
    public function __construct(bool $startMeasurement = false)
    {
        if ($startMeasurement) {
            $this->startMeasurement();
        }
    }

    /**
     * __toString magic method
     * 
     * @return sting
     */
    public function __toString(): string
    {
        return $this->getExecutionInfo();
    }

    /**
     * Return information about the execution time of the code
     * 
     * @param string $format OPTIONAL execution information format - more information about format structure find on: http://php.net/manual/en/dateinterval.format.php
     * @return string
     */
    public function getExecutionInfo(string $format = ''): string
    {
        $format = mb_strlen($format) > 0 ? $format : $this->getExecutionInfoFormat();
        return $this->getExecutionTime()->format($format);
    }

    /**
     * Set default format for information about the execution time of the code
     * 
     * @param string $format execution information format - more information about format structure find on: http://php.net/manual/en/dateinterval.format.php
     */
    public function setExecutionInfoFormat(string $format): void
    {
        $this->executionInfoFormat = $format;
    }

    /**
     * Get default format for information about the execution time of the code
     * 
     * @return string
     */
    public function getExecutionInfoFormat(): string
    {
        return $this->executionInfoFormat;
    }

    /**
     * Get interval between start measurement time and current time
     * 
     * @return DateInterval
     */
    public function getExecutionTime(): DateInterval
    {
        return $this->getStartTime()->diff($this->getCurrentTime());
    }

    /**
     * Start measurement
     * 
     * @throws Exception Throws Exception if try started measurement again
     */
    public function startMeasurement(): void
    {
        if (!$this->hasMeasurementWasStarted()) {
            $this->startDateTime = $this->getCurrentTime();
        } else {
            throw new Exception('Measurement has already been started. Measurement can not be started again.');
        }
    }

    /**
     * Check is measurement has already started
     * 
     * @return bool
     */
    public function hasMeasurementWasStarted(): bool
    {
        return $this->startDateTime instanceof DateTimeInterface;
    }

    /**
     * Return start measurement time 
     * 
     * @return DateTimeInterface
     * @throws Exception Throws Exception if measurement has not started
     */
    public function getStartTime(): DateTimeInterface
    {
        if (!$this->hasMeasurementWasStarted()) {
            throw new Exception('Measurement has not started.');
        }

        return $this->startDateTime;
    }

    /**
     * Return current time bassed on microtime
     * 
     * @return DateTimeInterface
     */
    public function getCurrentTime(): DateTimeInterface
    {
        $time = microtime(true);
        $timeMicro = sprintf("%06d",($time - floor($time)) * 1000000);
        return new DateTime( date('Y-m-d H:i:s.' . $timeMicro, $time) );
    }
}
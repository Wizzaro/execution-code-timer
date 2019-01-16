# Wizzaro Execution Code Timer

The library provides an easy way to measure the execution time of the code

## Sample Usage

```
$timer = new Wizzaro\ExecutionCodeTimer\Timer(true);
sleep(2);
echo $timer->getExecutionInfo();
```

## Api

### Constructor

```
public Timer::__construct(bool $startMeasurement = false)
```

#### Parameters:
* startMeasurement - start measurement while creating the object

### startMeasurement

Start measurement

```
public function startMeasurement(): void
```

#### Exceptions:
* Throws `Exception` if try started measurement again

### hasMeasurementWasStarted

Check is measurement has already started

```
public function hasMeasurementWasStarted(): bool
```

### getExecutionInfo

```
public function getExecutionInfo(string $format = ''): string
```

Parameters:
* format - (OPTIONAL) - execution information format - more information about format structure find on: http://php.net/manual/en/dateinterval.format.php

#### Return:
* Return information about the execution time of the code based on format

### setExecutionInfoFormat

Set default format for information about the execution time of the code

```
public function setExecutionInfoFormat(string $format): void
```

#### Parameters:
* format - execution information format - more information about format structure find on: http://php.net/manual/en/dateinterval.format.php

### getExecutionInfoFormat

```
public function getExecutionInfoFormat(): string
```

#### Return:
* Return default format for information about the execution time of the code

### getExecutionTime

```
public function getExecutionTime(): DateInterval
```

#### Return:
* Return interval between start measurement time and current time

### getStartTime

```
public function getStartTime(): DateTimeInterface
```

#### Return:
* Return start measurement time

#### Exceptions:
* Throws `Exception` if measurement has not started

### getCurrentTime

```
public function getCurrentTime(): DateTimeInterface
```

#### Return:
* Return current time bassed on microtime

## Runing Tests

To run tests:

1. Clone the repository:

```
$ git clone https://github.com/Wizzaro/execution-code-timer.git
$ cd execution-code-timer
```
2. Install dependencies via composer:

```
$ composer install
```

If you don't have composer installed, please download it from https://getcomposer.org/download/

3. Run the tests using the "test" command shipped in the composer.json:

```
$ composer test
```

You can turn on conditional tests with the phpunit.xml file. To do so:

Copy `phpunit.xml.dist` file to `phpunit.xml`
Edit `phpunit.xml` to enable any specific functionality you want to test, as well as to provide test values to utilize.
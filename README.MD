## Requirements

The following versions of PHP are supported.

* PHP 7.1+

## Installation

To install, use composer:

```
php composer.phar require pe/component-cronos-expression
```

## Usage

```php
<?php

namespace PE\Component\Cronos;

use PE\Component\Cronos\Expression\ExpressionFactory;
use PE\Component\Cronos\Expression\Field\DayOfMonthFieldFactory;
use PE\Component\Cronos\Expression\Field\DayOfWeekFieldFactory;
use PE\Component\Cronos\Expression\Field\HourFieldFactory;
use PE\Component\Cronos\Expression\Field\MinuteFieldFactory;
use PE\Component\Cronos\Expression\Field\MonthFieldFactory;

// Create factory instance with specific fields factories
$factory = new ExpressionFactory([
    new MinuteFieldFactory(),
    new HourFieldFactory(),
    new DayOfMonthFieldFactory(),
    new MonthFieldFactory(),
    new DayOfWeekFieldFactory(),
]);

// Or use default (equivalent above)
$factory = new ExpressionFactory();

// Now you can parse expression
// Argument must be valid crontab expression
$expression = $factory->create('* * * * *');

// You can check if expression is for current timestamp
$expression->isDue();// --> boolean

// You can resolve nearest due run time
$expression->getDueRunDate();// --> \DateTime

// You can resolve prev/next run date
$expression->getPrevRunDate();// --> \DateTime
$expression->getNextRunDate();// --> \DateTime

// Each of above expression methods can accept: null|string|\DateTime
```

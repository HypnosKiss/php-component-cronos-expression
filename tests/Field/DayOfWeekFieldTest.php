<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\DayOfWeekField;
use PHPUnit\Framework\TestCase;

class DayOfWeekFieldTest extends TestCase
{
    public function testMatch()
    {
        $field = new DayOfWeekField([0, 2], false, '0,2');

        $date1 = new \DateTime('2000-01-01');
        $date1->modify('first monday of january this year');
        $date2 = clone $date1;
        $date2->modify('+1 day');

        self::assertTrue($field->match($date1));
        self::assertFalse($field->match($date2));
    }

    public function testDecrement()
    {
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->modify('-1 day');
        $date2->setTime(23, 59, 0);

        (new DayOfWeekField([], true, '*'))->decrement($date1);

        static::assertEquals($date1, $date2);
    }

    public function testIncrement()
    {
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->modify('+1 day');
        $date2->setTime(0, 0, 0);

        (new DayOfWeekField([], true, '*'))->increment($date1);

        static::assertEquals($date1, $date2);
    }
}

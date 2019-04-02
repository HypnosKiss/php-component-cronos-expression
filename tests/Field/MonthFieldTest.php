<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\MonthField;
use PHPUnit\Framework\TestCase;

class MonthFieldTest extends TestCase
{
    public function testMatch()
    {
        $field = new MonthField([1, 3], false, '1,3');

        $date1 = new \DateTime('2000-01-01');
        $date2 = new \DateTime('2000-02-01');

        self::assertTrue($field->match($date1));
        self::assertFalse($field->match($date2));
    }

    public function testDecrement()
    {
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->modify('last day of previous month');
        $date2->setTime(23, 59);

        (new MonthField([], true, '*'))->decrement($date1);

        static::assertEquals($date1, $date2);
    }

    public function testIncrement()
    {
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->modify('first day of next month');
        $date2->setTime(0, 0);

        (new MonthField([], true, '*'))->increment($date1);

        static::assertEquals($date1, $date2);
    }
}

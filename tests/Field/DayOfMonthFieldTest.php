<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\DayOfMonthField;
use PHPUnit\Framework\TestCase;

class DayOfMonthFieldTest extends TestCase
{
    public function testMatch()
    {
        $field = new DayOfMonthField([1, 3], false, '1,3');

        $date1 = new \DateTime('1970-01-01');
        $date2 = new \DateTime('1970-01-02');

        self::assertTrue($field->match($date1));
        self::assertFalse($field->match($date2));
    }

    public function testDecrement()
    {
        $date1 = new \DateTime();
        $date1->modify('previous day');
        $date1->setTime(23, 59);

        (new DayOfMonthField([], true, '*'))->decrement($date2 = new \DateTime());

        static::assertEquals($date1, $date2);
    }

    public function testIncrement()
    {
        $date1 = new \DateTime();
        $date1->modify('next day');
        $date1->setTime(0, 0);

        (new DayOfMonthField([], true, '*'))->increment($date2 = new \DateTime());

        static::assertEquals($date1, $date2);
    }
}

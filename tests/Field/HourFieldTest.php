<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\HourField;
use PHPUnit\Framework\TestCase;

class HourFieldTest extends TestCase
{
    public function testMatch()
    {
        $field = new HourField([1, 3], false, '1,3');

        $date1 = new \DateTime('1970-01-01 01:00:00');
        $date2 = new \DateTime('1970-01-01 02:00:00');

        self::assertTrue($field->match($date1));
        self::assertFalse($field->match($date2));
    }

    public function testDecrement()
    {
        $date1 = new \DateTime('2000-01-01 00:00:00', new \DateTimeZone('UTC'));
        $date2 = clone $date1;
        $date2->modify('-1 hour');
        $date2->setTime($date2->format('H'), 59);

        (new HourField([], true, '*'))->decrement($date1);

        static::assertEquals($date1, $date2);
    }

    public function testIncrement()
    {
        $date1 = new \DateTime('2000-01-01 00:00:00', new \DateTimeZone('UTC'));
        $date2 = clone $date1;
        $date2->modify('+1 hour');
        $date2->setTime($date2->format('H'), 0);

        (new HourField([], true, '*'))->increment($date1);

        static::assertEquals($date1, $date2);
    }
}

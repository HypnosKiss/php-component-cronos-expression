<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\YearField;
use PHPUnit\Framework\TestCase;

class YearFieldTest extends TestCase
{
    public function testMatch()
    {
        $field = new YearField([1999, 2000], false, '1999,2000');

        $date1 = new \DateTime('1999-01-01');
        $date2 = new \DateTime('1998-01-02');

        self::assertTrue($field->match($date1));
        self::assertFalse($field->match($date2));
    }

    public function testIncrement()
    {
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->modify('+1 year');
        $date2->setDate($date2->format('Y'), 1, 1);
        $date2->setTime(0, 0, 0);

        (new YearField([], true, '*'))->increment($date1);

        static::assertEquals($date1, $date2);
    }

    public function testDecrement()
    {
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->modify('-1 year');
        $date2->setDate($date2->format('Y'), 12, 31);
        $date2->setTime(23, 59, 0);

        (new YearField([], true, '*'))->decrement($date1);

        static::assertEquals($date1, $date2);
    }
}

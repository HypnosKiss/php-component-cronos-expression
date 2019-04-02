<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\SecondField;
use PHPUnit\Framework\TestCase;

class SecondFieldTest extends TestCase
{
    public function testMatch()
    {
        $field = new SecondField([1, 3], false, '1,3');

        $date1 = new \DateTime('1970-01-01 00:00:01');
        $date2 = new \DateTime('1970-01-01 00:00:02');

        self::assertTrue($field->match($date1));
        self::assertFalse($field->match($date2));
    }

    public function testDecrement()
    {
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->modify('-1 second');

        (new SecondField([], true, '*'))->decrement($date1);

        static::assertEquals($date1, $date2);
    }

    public function testIncrement()
    {
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->modify('+1 second');

        (new SecondField([], true, '*'))->increment($date1);

        static::assertEquals($date1, $date2);
    }
}

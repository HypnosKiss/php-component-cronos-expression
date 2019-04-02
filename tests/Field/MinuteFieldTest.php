<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\MinuteField;
use PHPUnit\Framework\TestCase;

class MinuteFieldTest extends TestCase
{
    public function testMatch()
    {
        $field = new MinuteField([1, 3], false, '1,3');

        $date1 = new \DateTime('1970-01-01 00:01:00');
        $date2 = new \DateTime('1970-01-01 00:02:00');

        self::assertTrue($field->match($date1));
        self::assertFalse($field->match($date2));
    }

    public function testDecrement()
    {
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->modify('-1 minute');

        (new MinuteField([], true, '*'))->decrement($date1);

        static::assertEquals($date1, $date2);
    }

    public function testIncrement()
    {
        $date1 = new \DateTime();
        $date2 = clone $date1;
        $date2->modify('+1 minute');

        (new MinuteField([], true, '*'))->increment($date1);

        static::assertEquals($date1, $date2);
    }
}

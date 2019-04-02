<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\DayOfMonthField;
use PE\Component\Cronos\Expression\Field\DayOfMonthFieldFactory;
use PHPUnit\Framework\TestCase;

class DayOfMonthFieldFactoryTest extends TestCase
{
    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMin()
    {
        (new DayOfMonthFieldFactory())->resolveRangeValues(0, 1);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMax()
    {
        (new DayOfMonthFieldFactory())->resolveRangeValues(1, 100);
    }

    public function testResolveRangeValues()
    {
        static::assertEquals(range(1, 31), (new DayOfMonthFieldFactory())->resolveRangeValues(1, 31));
    }

    public function testCreateField()
    {
        static::assertInstanceOf(
            DayOfMonthField::class,
            (new DayOfMonthFieldFactory())->createField([1, 2], false, '1,2')
        );
    }
}

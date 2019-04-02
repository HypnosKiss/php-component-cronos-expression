<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\DayOfWeekField;
use PE\Component\Cronos\Expression\Field\DayOfWeekFieldFactory;
use PHPUnit\Framework\TestCase;

class DayOfWeekFieldFactoryTest extends TestCase
{
    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMin()
    {
        (new DayOfWeekFieldFactory())->resolveRangeValues(-1, 1);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMax()
    {
        (new DayOfWeekFieldFactory())->resolveRangeValues(1, 100);
    }

    public function testResolveRangeValues()
    {
        static::assertEquals(range(0, 6), (new DayOfWeekFieldFactory())->resolveRangeValues(0, 6));
    }

    public function testCreateField()
    {
        static::assertInstanceOf(
            DayOfWeekField::class,
            (new DayOfWeekFieldFactory())->createField([0, 1], false, '0,1')
        );
    }
}

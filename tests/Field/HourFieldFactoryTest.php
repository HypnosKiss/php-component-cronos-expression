<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\HourField;
use PE\Component\Cronos\Expression\Field\HourFieldFactory;
use PHPUnit\Framework\TestCase;

class HourFieldFactoryTest extends TestCase
{
    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMin()
    {
        (new HourFieldFactory())->resolveRangeValues(-1, 1);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMax()
    {
        (new HourFieldFactory())->resolveRangeValues(1, 100);
    }

    public function testResolveRangeValues()
    {
        static::assertEquals(range(0, 23), (new HourFieldFactory())->resolveRangeValues(0, 23));
    }

    public function testCreateField()
    {
        static::assertInstanceOf(
            HourField::class,
            (new HourFieldFactory())->createField([0, 1], false, '0,1')
        );
    }
}

<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\MonthField;
use PE\Component\Cronos\Expression\Field\MonthFieldFactory;
use PHPUnit\Framework\TestCase;

class MonthFieldFactoryTest extends TestCase
{
    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMin()
    {
        (new MonthFieldFactory())->resolveRangeValues(0, 1);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMax()
    {
        (new MonthFieldFactory())->resolveRangeValues(1, 100);
    }

    public function testResolveRangeValues()
    {
        static::assertEquals(range(1, 12), (new MonthFieldFactory())->resolveRangeValues(1, 12));
    }

    public function testCreateField()
    {
        static::assertInstanceOf(
            MonthField::class,
            (new MonthFieldFactory())->createField([1, 2], false, '1,2')
        );
    }
}

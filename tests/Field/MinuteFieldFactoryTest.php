<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\MinuteField;
use PE\Component\Cronos\Expression\Field\MinuteFieldFactory;
use PHPUnit\Framework\TestCase;

class MinuteFieldFactoryTest extends TestCase
{
    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMin()
    {
        (new MinuteFieldFactory())->resolveRangeValues(-1, 1);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMax()
    {
        (new MinuteFieldFactory())->resolveRangeValues(1, 100);
    }

    public function testResolveRangeValues()
    {
        static::assertEquals(range(0, 59), (new MinuteFieldFactory())->resolveRangeValues(0, 59));
    }

    public function testCreateField()
    {
        static::assertInstanceOf(
            MinuteField::class,
            (new MinuteFieldFactory())->createField([1, 2], false, '1,2')
        );
    }
}
